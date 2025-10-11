<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditClassroomRequest;
use App\Models\Cta;
use App\Models\Date;
use App\Models\Dependency_program;
use App\Models\Event;
use App\Models\Event_type;
use App\Models\Group;
use App\Models\Place;
use App\Models\Responsible;
use App\Models\Semester;
use App\Models\TitleEvent;
use App\Models\User;
use App\Services\DatesFoundService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClassromGuestController extends Controller
{
    //

    public function __construct(protected DatesFoundService $datesFoundService) {}

    public function create($type_events)
    {

        $name_grupo = $type_events == 'classrooms' ? 'CTA' : 'Laboratorio';


        $currentHour = Carbon::now()->format('H:i');
        $hourLater = Carbon::now()->addHour()->format('H:i');

        $notesDefault = "Sin notas en el correo";

        $group = Group::where('type', 'LIKE', '%' . $name_grupo . '%')->first();

        $countTitles = TitleEvent::where('group_id', $group->id)->count();

        $manageHour = (object)[
            'currentHour' => $currentHour,
            'hourLater' => $hourLater
        ];



        $events_types = Event_type::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->id);
            })
            ->get();

        $dependencies = Dependency_program::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->id);
            })
            ->orderBy('name', 'asc')
            ->get();
        $places = Place::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->id);
            })
            ->orderBy('name', 'asc')
            ->get();

        $semesters = Semester::select('id', 'name')->get();


        $responsibles = Responsible::where('group_id', $group->id)
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();

        if ($name_grupo == 'CTA') {
            return view('create-guest-cta-event', compact('events_types', 'dependencies', 'semesters', 'places', 'manageHour', 'responsibles', 'notesDefault', 'countTitles', 'group'));
        } else {
            return view('create-guest-laboratory-event', compact('events_types', 'dependencies', 'semesters', 'places', 'manageHour', 'responsibles', 'notesDefault', 'countTitles', 'group'));
        }
    }


    public function store(EditClassroomRequest $request)
    {

        // dd($request->all());

        $validated = $request->validated();
        $conflictingEventExist = null;

        $group_id = intval($validated['group_id']);

        try {

            $group = Group::where('type',  $group_id)->first();
            $group = $group->id ?? null;

            $dateFounds = $this->datesRangeFound($request);

            DB::beginTransaction();

            $title = $validated['title'];
            $responsible = $validated['responsible'];
            $place = $validated['place'];

            if (is_numeric($title)) {
                $titleData = TitleEvent::find($title) ?? 'No tiene título asignado';
            } else {
                $titleData = TitleEvent::create([
                    'group_id' => $group,
                    'title' => $title
                ]);
            }

            if (is_numeric($validated['responsible'])) {
                $responsibleData = Responsible::findOrFail($responsible);
            } else {
                $responsibleData = Responsible::create([
                    'name' => $responsible,
                    'group_id' => $group,
                ]);
            }



            foreach ($dateFounds as $date) {


                // Validate if the event not exists in the same date

                // Validar si ya existe un evento en el mismo lugar y que se superponga con las fechas
                $conflictingEvent = Event::where('place_id', $place)
                    ->whereHas('date', function ($query) use ($date) {
                        $query->where(function ($q) use ($date) {
                            $q->whereBetween('date_start', [$date['date_start'], $date['date_end']])
                                ->orWhereBetween('date_end', [$date['date_start'], $date['date_end']])
                                ->orWhere(function ($q) use ($date) {
                                    $q->where('date_start', '<', $date['date_start'])
                                        ->where('date_end', '>', $date['date_end']);
                                });
                        });
                    })
                    ->exists();

                if ($conflictingEvent) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Ya existe un evento agendado en el mismo lugar y con fechas que se superponen.');
                }



                $dateStore = Date::create([
                    'date_start' => $date['date_start'],
                    'date_end' => $date['date_end'],
                ]);


                $event = Event::create([
                    'title' => $titleData->title,
                    'type_id' => $validated['event_type'],
                    'dependency_program_id' => $validated['dependency_program'],
                    'place_id' => $place,
                    'group_id' => $group,
                    'responsible_id' => $responsibleData->id,
                    'date_id' => $dateStore->id,
                ]);

                Cta::create([
                    'event_id' => $event->id,
                    'email' => $validated['email'],
                    'semester_id' => $validated['semester'],
                    'num_participants' => $validated['num_participants'],
                    'published' => auth()->check() ? 1 : 0
                ]);
            }


            $msg = count($dateFounds) > 1 ? 'Reservaciones creadas correctamentes correctamente.' : 'Reservación guardada correctamente, está se verá reflejada en la agenda cuando sea aprobada por el administrador.';
            DB::commit();

            return redirect()->route('agenda.guest.index', ['type_events' => 'classrooms'])->with('success', $msg);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('agenda.guest.classrom.create', ['type_events' => 'classrooms'])->with('error', 'Ha ocurrido un error al crear el evento, por favor intente de nuevo.');
        }
    }

    // Found array dates in range dates
    private function datesRangeFound($request): array
    {

        $dateStart = Carbon::parse($request->input('date_start'));
        $repetition = $request->input('repetition', 0);
        $hourStart = $request->input('hour_start');
        $hourEnd = $request->input('hour_end');

        $dateFounds = [];

        if ($repetition == 1) {

            $dateEnd = Carbon::parse($request->input('date_end'));
            $daysSelected = $request->input('days', []);

            for ($dateCopy = $dateStart->copy(); $dateCopy->lte($dateEnd); $dateCopy->addDay()) {
                if (in_array($dateCopy->dayOfWeek, $daysSelected)) {
                    $dateFounds[] = [
                        'date_start' => $dateCopy->format('Y-m-d') . ' ' . $hourStart,
                        'date_end' => $dateCopy->format('Y-m-d') . ' ' . $hourEnd,
                    ];
                }
            }
        } else {

            $dateFormatStart = $dateStart->format('Y-m-d');

            $dateFounds = [
                [
                    'date_start' => $dateFormatStart  . ' ' . $hourStart,
                    'date_end' => $dateFormatStart . ' ' . $hourEnd,
                ]
            ];
        }

        return $dateFounds;
    }
}
