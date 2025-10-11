<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventCTARequest;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\EditClassroomRequest;
use App\Http\Requests\GetEventsGuestRequest;
use App\Http\Requests\GetEventsRequest;
use App\Models\Cta;
use App\Models\Date;
use App\Models\Dependency_program;
use App\Models\Event;
use App\Models\Event_type;
use App\Models\Group;
use App\Models\Place;
use App\Models\Protocolo;
use App\Models\RecursiveEvent;
use App\Models\Responsible;
use App\Models\Semester;
use App\Models\TitleEvent;
use App\Services\DatesFoundService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(
        protected DatesFoundService $datesFoundService
    ) {}

    public function index()
    {

        if (!auth()->check()) {
            return redirect()->route('agenda.guest.index', ['type_events' => 'events']);
        }

        // Get all groups except SuperAdmin
        $groups = Group::whereNot('type', 'SuperAdmin')
            ->get();

        $role = Auth::user()->group->type ?? null;

        if ($role == 'Superadmin' || $role = 'CTA') {
            $places = Place::with(['group'])
                ->whereHas('group', function ($query) use ($role) {
                    $query->where('type', 'CTA');
                })
                ->orderBy('name', 'asc')
                ->get();

            $events = Event::with(['cta'])
                ->whereHas('cta', function ($q) use ($role) {
                    $q->where('published', '=', 0);
                })->count();


            if ($role == 'Superadmin') {
                return view('agenda.agenda', compact('groups', 'places', 'events'));
            }

            return view('agenda.agenda', compact('places', 'events'));
        }

        return view('agenda.agenda');
    }





    public function indexGuest($type_events)
    {
        if (auth()->check()) {
            return redirect()->route('agenda.index');
        }

        if ($type_events != 'events' && $type_events != 'classrooms') {
            abort(404);
        }

        $typeGroup = $type_events == 'events' ? 'Protocolo' : 'CTA';
        $group = Group::where('type', $typeGroup)->select('id', 'type')->first();
        $guest = true;

        if ($typeGroup == 'CTA') {
            $places = Place::with(['group'])
                ->whereHas('group', function ($query) {
                    $query->where('type', 'CTA');
                })
                ->orderBy('name', 'asc')
                ->get();

            return view('agenda.agenda', compact('places', 'guest', 'group'));
        }

        return view('agenda.agenda', compact('guest', 'group'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $user = Auth::user();
        $name_group = $user->group->type;


        $currentHour = Carbon::now()->format('H:i');
        $hourLater = Carbon::now()->addHour()->format('H:i');

        $notesDefault = "Sin notas en el correo";

        $countTitles = TitleEvent::where('group_id', $user->group_id)->count();

        $manageHour = (object)[
            'currentHour' => $currentHour,
            'hourLater' => $hourLater
        ];

        if ($name_group == 'Protocolo') {

            if (!$user->hasPermissionTo('create event')) {
                abort(403, 'No tienes permiso para acceder a esta página');
            };

            $events_types = Event_type::with(['group'])
                ->whereHas('group', function ($query) use ($name_group) {
                    $query->where('type', $name_group);
                })
                ->get();

            $dependencies = Dependency_program::with(['group'])
                ->whereHas('group', function ($query) use ($name_group) {
                    $query->where('type', $name_group);
                })
                ->get();

            $places = Place::with(['group'])
                ->whereHas('group', function ($query) use ($name_group) {
                    $query->where('type', $name_group);
                })
                ->orderBy('name', 'asc')
                ->get();

            $group = Group::where('type', 'Protocolo')->first();

            $responsibles = Responsible::where('group_id', $group->id)
                ->orderBy('name', 'asc')
                ->limit(10)
                ->get();

            return view('create-protocolo-event', compact('events_types', 'dependencies', 'places', 'manageHour', 'group', 'responsibles', 'notesDefault', 'countTitles'));
        } else {



            if (!Auth::check() || !$user->hasAnyPermission(['reserve classroom', 'reserve laboratory'])) {
                abort(403, 'No tienes permiso para acceder a esta página');
            }


            $events_types = Event_type::with(['group'])
                ->whereHas('group', function ($query) use ($name_group) {
                    $query->where('type', $name_group);
                })
                ->get();

            $dependencies = Dependency_program::with(['group'])
                ->whereHas('group', function ($query) use ($name_group) {
                    $query->where('type', $name_group);
                })
                ->orderBy('name', 'asc')
                ->get();
            $places = Place::with(['group'])
                ->whereHas('group', function ($query) use ($name_group) {
                    $query->where('type', $name_group);
                })
                ->orderBy('name', 'asc')
                ->get();

            $semesters = Semester::select('id', 'name')->get();

            $group = Group::where('type', $name_group)->first();

            $responsibles = Responsible::where('group_id', $group->id)
                ->orderBy('name', 'asc')
                ->limit(10)
                ->get();


            if ($name_group == 'Laboratorio') {

                return view('create-laboratory-event', compact('events_types', 'dependencies', 'semesters', 'places', 'manageHour', 'group', 'responsibles', 'notesDefault', 'countTitles'));
            } else {

                return view('create-cta-event', compact('events_types', 'dependencies', 'semesters', 'places', 'manageHour', 'group', 'responsibles', 'notesDefault', 'countTitles'));
       
            }
        }





        // return view('create-protocolo-event', compact('events_types', 'dependencies', 'places'));

    }

    public function createSuperAdmin($group_id)
    {
        $group = Group::findOrfail($group_id);
        $group = $group->type;

        $currentHour = Carbon::now()->format('H:i');
        $hourLater = Carbon::now()->addHour()->format('H:i');

        $manageHour = (object)[
            'currentHour' => $currentHour,
            'hourLater' => $hourLater
        ];

        if ($group == 'Protocolo') {
            $events_types = Event_type::with(['group'])
                ->whereHas('group', function ($query) use ($group) {
                    $query->where('type', $group);
                })
                ->get();

            $dependencies = Dependency_program::with(['group'])
                ->whereHas('group', function ($query) use ($group) {
                    $query->where('type', $group);
                })
                ->get();

            $places = Place::with(['group'])
                ->whereHas('group', function ($query) use ($group) {
                    $query->where('type', $group);
                })
                ->orderBy('name', 'asc')
                ->get();

            $group = Group::where('type', 'Protocolo')->first();
            $responsibles = Responsible::where('group_id', $group->id)
                ->orderBy('id', 'asc')
                ->get();

            return view('create-protocolo-event', compact('events_types', 'dependencies', 'places', 'manageHour', 'group', 'responsibles'));
        } else {

            $events_types = Event_type::with(['group'])
                ->whereHas('group', function ($query) use ($group) {
                    $query->where('type', $group);
                })
                ->get();

            $dependencies = Dependency_program::with(['group'])
                ->whereHas('group', function ($query) use ($group) {
                    $query->where('type', $group);
                })
                ->orderBy('name', 'asc')
                ->get();
            $places = Place::with(['group'])
                ->whereHas('group', function ($query) use ($group) {
                    $query->where('type', $group);
                })
                ->orderBy('name', 'asc')
                ->get();

            $semesters = Semester::select('id', 'name')->get();

            $group = Group::where('type', 'CTA')->first();
            $responsibles = Responsible::where('group_id', $group->id)
                ->orderBy('id', 'asc')
                ->get();

            return view('create-cta-event', compact('events_types', 'dependencies', 'semesters', 'places', 'manageHour', 'group', 'responsibles'));
        }
    }

    public function getEvents(GetEventsRequest $request)
    {

        // Validate request data
        $validated = $request->validated();

        try {

            $filterPlace = null;
            $filterType = null;

            if (Auth::user()->group->type != 'Superadmin') {
                $filterType = Auth::user()->group_id;

                if (Auth::user()->group->type == 'CTA') {
                    $filterPlace =  $request->input('filter_place', null);
                }
            } else {
                $filterType = $request->input('filter_type', null);
                $filterPlace =  $request->input('filter_place', null);
            }

            // Get the start and end date and filter for group from the request
            $start = $request->input('start');
            $end = $request->input('end');

            // Parse dates
            $parseStartDate = Carbon::parse($start)->format('Y-m-d');
            $parseEndDate = Carbon::parse($end)->format('Y-m-d');

            // Get events
            $events = Event::with(['group', 'date', 'place', 'date', 'cta', 'protocolo'])
                // ->whereHas('group', function ($query) {
                //     $query->where('type', 'cta');
                // })
                ->whereHas('date', function ($query) use ($parseStartDate, $parseEndDate) {
                    $query->whereBetween('date_start', [$parseStartDate, $parseEndDate]);
                })
                ->where('group_id', $filterType);

            if ($filterType == 2 && $filterPlace && $filterPlace != 'all') {
                $events = $events->whereHas('place', function ($query) use ($filterPlace) {
                    $query->where('id', $filterPlace);
                });
            }

            if (Auth::user()->group->type == 'CTA') {
                $events = $events->whereHas('cta', function ($query) {
                    $query->where('published', 1);
                });
            }

            // Select only the necessary fields
            $events = $events->select('id', 'title', 'date_id', 'place_id', 'group_id')
                ->get();

            return response()->json($events);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al obtener los eventos, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEventsGuest(GetEventsGuestRequest $request)
    {

        try {

            // Get data from request
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $type_event = $request->input('type_event', 1);
            $filter_place = null;

            $group = Group::find($type_event);

            if ($group->type == 'CTA') {
                $filter_place = $request->input('filter_place', 0);
            }

            $parseStartDate = Carbon::parse($start_date)->format('Y-m-d');
            $parseEndDate = Carbon::parse($end_date)->format('Y-m-d');

            $events = Event::with(['group', 'date', 'place', 'date', 'cta', 'protocolo'])
                ->whereHas('date', function ($query) use ($parseStartDate, $parseEndDate) {
                    $query->whereBetween('date_start', [$parseStartDate, $parseEndDate]);
                })
                ->where('group_id', $group->id);

            if ($filter_place && $filter_place != 'all') {
                $events = $events->whereHas('place', function ($query) use ($filter_place) {
                    $query->where('id', $filter_place);
                });
            }

            if ($group->type == 'CTA') {
                $events = $events->whereHas('cta', function ($query) {
                    $query->where('published', 1);
                });
            }

            // Select only the necessary fields
            $events = $events->select('id', 'title', 'date_id', 'place_id', 'group_id')
                ->get();

            return response()->json($events);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al obtener los eventos, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEvent($id)
    {

        try {
            // Relationships: group, date, place, cta, protocolo, dependency_program, event_type, user, responsible
            $event = Event::with(['group', 'date', 'place', 'cta', 'protocolo', 'dependency_program', 'event_type', 'user', 'responsible'])->find($id);

            if (!$event) {
                return response()->json([
                    'title' => 'Ops...',
                    'message' => 'El evento no existe o ha sido eliminado.',
                ], 404);
            }

            // Validate if the event not created by the user
            // if (Auth::user()->group->type != 'Superadmin' && $event->group_id != Auth::user()->group_id) {
            //     return response()->json([
            //         'title' => 'Ops...',
            //         'message' => 'No tienes permiso para acceder a este evento.',
            //     ], 403);
            // }


            // Format dates and hours
            $event->date->date_start_format = ucfirst(Carbon::parse($event->date->date_start)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY'));
            $event->date->hour_start_format = Carbon::parse($event->date->date_start)->locale('es')->format('h:i a');
            $event->date->hour_end_format = Carbon::parse($event->date->date_end)->locale('es')->format('h:i a');

            $recursive_event = RecursiveEvent::where('event_group', $event->recursive_event->event_group ?? 0)->count();

            $event->recursiveEvents = $recursive_event > 1 ? 1 : 0;

            // If the event is a CTA, get the semester
            if ($event->group->type == 'CTA') {
                $event->cta->semester;
            }
            return response()->json($event);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al obtener el evento, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeProtocolo(CreateEventRequest $request)
    {
        // Validate request data
        $validated = $request->validated();

        // return response()->json($request->all());

        try {
            // $dateStart = Carbon::parse($request->input('date_start'));
            // Create the event
            $dateStart = Carbon::parse($request->input('date_start'));
            $repetition = $request->input('repetition', 0);

            // Validate hours
            if ($repetition == 1) {
                $dateEnd = Carbon::parse($request->input('date_end'));
                // Validate hours
                if ($dateStart->gt($dateEnd)) {
                    return redirect()->back()->with('error', 'La fecha de inicio no puede ser mayor a la fecha de fin.');
                }
            }

            $dateFounds = $this->datesFoundService->getDatesRangeFound($request);
            $group = Group::where('type', 'Protocolo')->first();
            $group = $group->id ?? null;

            DB::transaction(function () use ($validated, $dateFounds, $group) {

                $title = $validated['title'];
                $responsible = $validated['responsible'];
                $places = $validated['places'];

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

                foreach ($places as $placeId) {

                    $lastIdRecursiveEvent = RecursiveEvent::max('event_group') ?? 0;
                    $lastIdRecursiveEvent += 1;

                    foreach ($dateFounds as $date) {

                        $dateStore = Date::create([
                            'date_start' => $date['date_start'],
                            'date_end' => $date['date_end'],
                        ]);

                        $event = Event::create([
                            'title' => $titleData->title,
                            'type_id' => $validated['event_type'],
                            'dependency_program_id' => $validated['dependency_program'],
                            'place_id' => $placeId,
                            'group_id' => $group,
                            'date_id' => $dateStore->id,
                            'responsible_id' => $responsibleData->id,
                            'created_by' => Auth::user()->id,
                        ]);

                        Protocolo::create([
                            'event_id' => $event->id,
                            'tel_extension' => $validated['phone'],
                            'notes_cta' => $validated['notes_cta'],
                            'notes_general_service' => $validated['notes_general_services'],
                            'notes_protocolo' => $validated['notes_protocolo'],
                            'link' => 'https://meet.google.com/lookup',
                        ]);

                        if (count($dateFounds) > 1) {
                            $event->recursive_event()->create([
                                'event_group' => $lastIdRecursiveEvent
                            ]);
                        }
                    }
                }
            });

            $msg = count($dateFounds) > 1 ? 'Eventos creados correctamente.' : 'Evento creado correctamente.';

            $msgPlace = count($validated['places']) > 1 ? ' Se han creado en ' . count($validated['places']) . ' lugares diferentes con los mismos datos' : '';

            return redirect()->route('agenda.index')->with('success', $msg . $msgPlace);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('agenda.create')->with('error', 'Ha ocurrido un error al crear el evento, por favor intente de nuevo.');
        }
    }

    public function storeCTA(CreateEventCTARequest $request)
    {

        $validated = $request->validated();

        try {

            $group = Group::where('type', 'CTA')->first();
            $group = $group->id ?? null;

            $dateFounds = $this->datesFoundService->getDatesRangeFound($request);

            DB::transaction(function () use ($validated, $dateFounds, $group) {

                $title = $validated['title'];
                $responsible = $validated['responsible'];
                $places = $validated['places'];

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

                foreach ($places as $place) {

                    $lastIdRecursiveEvent = RecursiveEvent::max('event_group') ?? 0;
                    $lastIdRecursiveEvent += 1;

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
                            // return redirect()->back()->with('error','Ya existe un evento agendado en el mismo lugar y con fechas que se superponen.');
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
                            'created_by' => Auth::user()->id,
                        ]);

                        Cta::create([
                            'event_id' => $event->id,
                            'email' => $validated['email'],
                            'semester_id' => $validated['semester'],
                            'num_participants' => $validated['num_participants'],
                            'published' => auth()->check() ? 1 : 0
                        ]);


                        if (count($dateFounds) > 1) {
                            $event->recursive_event()->create([
                                'event_group' => $lastIdRecursiveEvent
                            ]);
                        }
                    }
                }
            });


            $msg = count($dateFounds) > 1 ? 'Reservaciones creadas correctamentes correctamente.' : 'Reservación creada correctamente.';
            $msgPlace = count($validated['places']) > 1 ? ' Se han creado en ' . count($validated['places']) . ' lugares diferentes con los mismos datos' : '';


            return redirect()->route('agenda.index')->with('success', $msg . $msgPlace);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('agenda.create')->with('error', 'Ha ocurrido un error al crear el evento, por favor intente de nuevo.');
        }
    }

    public function storeLAB(CreateEventCTARequest $request)
    {

        $validated = $request->validated();

        try {

            $group = Group::where('type', 'Laboratorio')->first();
            $group = $group->id ?? null;

            $dateFounds = $this->datesFoundService->getDatesRangeFound($request);

            DB::transaction(function () use ($validated, $dateFounds, $group) {

                $title = $validated['title'];
                $responsible = $validated['responsible'];
                $places = $validated['places'];

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

                foreach ($places as $place) {

                    $lastIdRecursiveEvent = RecursiveEvent::max('event_group') ?? 0;
                    $lastIdRecursiveEvent += 1;

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
                            // return redirect()->back()->with('error','Ya existe un evento agendado en el mismo lugar y con fechas que se superponen.');
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
                            'created_by' => Auth::user()->id,
                        ]);

                        Cta::create([
                            'event_id' => $event->id,
                            'email' => $validated['email'],
                            'semester_id' => $validated['semester'],
                            'num_participants' => $validated['num_participants'],
                            'published' => auth()->check() ? 1 : 0
                        ]);


                        if (count($dateFounds) > 1) {
                            $event->recursive_event()->create([
                                'event_group' => $lastIdRecursiveEvent
                            ]);
                        }
                    }
                }
            });


            $msg = count($dateFounds) > 1 ? 'Reservaciones creadas correctamentes correctamente.' : 'Reservación creada correctamente.';
            $msgPlace = count($validated['places']) > 1 ? ' Se han creado en ' . count($validated['places']) . ' lugares diferentes con los mismos datos' : '';


            return redirect()->route('agenda.index')->with('success', $msg . $msgPlace);

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('agenda.create')->with('error', 'Ha ocurrido un error al crear el evento, por favor intente de nuevo.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editProtocolo($id)
    {
        // Get event by Id
        $event = Event::with(['place', 'protocolo', 'dependency_program', 'event_type', 'user', 'responsible', 'group'])->findOrFail($id);


        $event->date->only_date_start = Carbon::parse($event->date->date_start)->format('Y-m-d');
        $event->date->only_hour_start = Carbon::parse($event->date->date_start)->format('H:i');
        $event->date->only_hour_end = Carbon::parse($event->date->date_end)->format('H:i');


        // Get group of event
        $group = $event->group;

        // Get events types filter by group
        $events_types = Event_type::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->get();

        // Get dependencies filter by group
        $dependencies = Dependency_program::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->get();

        // Get places filter by group
        $places = Place::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->orderBy('name', 'asc')
            ->get();

        // Get title
        $title = TitleEvent::where('title', $event->title)->first();

        // return response()->json([
        //     $event,
        //     $title
        // ]);

        return view('edit-protocolo-event', compact('event', 'events_types', 'dependencies', 'places', 'group', 'title'));
    }

    // Controller for edit recursive events for range dates
    public function editProtocoloAll($id)
    {
        // Get event by Id
        $event = Event::with(['place', 'protocolo', 'dependency_program', 'event_type', 'user', 'responsible', 'group', 'recursive_event'])->findOrFail($id);

        if ($event->recursive_event->count() <= 0) {
            return redirect()->route('agenda.index');
        }

        $recursive_event = $event->recursive_event->count() > 0 ? true : false;

        $eventsGroupId = $event->recursive_event->event_group;
        $eventsIds = RecursiveEvent::where('event_group', $eventsGroupId)
            ->pluck('event_id')
            ->toArray();

        $eventsGroup = Event::whereIn('id', $eventsIds)
            ->with('date')
            ->select('date_id')
            ->get();

        $event->date->date_start_format = ucfirst(Carbon::parse($event->date->date_start)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY'));
        $event->date->hour_start_format = Carbon::parse($event->date->date_start)->locale('es')->format('h:i a');
        $event->date->hour_end_format = Carbon::parse($event->date->date_end)->locale('es')->format('h:i a');

        $dates = $eventsGroup->transform(function ($dates) {
            return (object)[
                'date_format' => $dates->date->date_start_format = ucfirst(Carbon::parse($dates->date->date_start)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY'))
            ];
        });

        // Parse dates for inputs type date and time
        $event->date->only_date_start = Carbon::parse($event->date->date_start)->format('Y-m-d');
        $event->date->only_hour_start = Carbon::parse($event->date->date_start)->format('H:i');
        $event->date->only_hour_end = Carbon::parse($event->date->date_end)->format('H:i');

        // Get group of event
        $group = $event->group;

        // Get events types filter by group
        $events_types = Event_type::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->get();

        // Get dependencies filter by group
        $dependencies = Dependency_program::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->get();

        // Get places filter by group
        $places = Place::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->orderBy('name', 'asc')
            ->get();

        $group = Group::where('type', 'Protocolo')->first();

        $title = TitleEvent::where('title', $event->title)->first();

        return view('edit-protocolo-event', compact('event', 'events_types', 'dependencies', 'places', 'dates', 'recursive_event', 'group', 'title'));
    }

    // Load view for edit CTA event
    public function editCTA($id)
    {
        // Get event by Id
        $event = Event::with(['place', 'cta', 'dependency_program', 'event_type', 'user', 'responsible', 'group'])->findOrFail($id);


        $event->date->only_date_start = Carbon::parse($event->date->date_start)->format('Y-m-d');
        $event->date->only_hour_start = Carbon::parse($event->date->date_start)->format('H:i');
        $event->date->only_hour_end = Carbon::parse($event->date->date_end)->format('H:i');


        // Get group of event
        $group = $event->group;

        // Get events types filter by group
        $events_types = Event_type::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->get();

        // Get dependencies filter by group
        $dependencies = Dependency_program::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->get();

        // Get places filter by group
        $places = Place::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->orderBy('name', 'asc')
            ->get();

        $semesters = Semester::select('id', 'name')->get();

        $group = Group::where('type', 'CTA')->first();
        $responsibles = Responsible::where('group_id', $group->id)
            ->orderBy('id', 'asc')
            ->get();

        $title = TitleEvent::where('title', $event->title)->first();

        return view('edit-cta-event', compact('event', 'events_types', 'dependencies', 'places', 'semesters', 'group', 'responsibles', 'title'));
    }


    // Load view for edit all events relashionships with the same group

    public function editCTAAll($id)
    {
        // Get event by Id
        $event = Event::with(['place', 'cta', 'cta.semester', 'dependency_program', 'event_type', 'user', 'responsible', 'group', 'recursive_event'])->findOrFail($id);

        // return response()->json($event);

        $recursive_event = $event->recursive_event->count() > 0 ? true : false;

        $eventsGroupId = $event->recursive_event->event_group;
        $eventsIds = RecursiveEvent::where('event_group', $eventsGroupId)
            ->pluck('event_id')
            ->toArray();

        $eventsGroup = Event::whereIn('id', $eventsIds)
            ->with('date')
            ->select('date_id')
            ->get();

        $event->date->date_start_format = ucfirst(Carbon::parse($event->date->date_start)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY'));
        $event->date->hour_start_format = Carbon::parse($event->date->date_start)->locale('es')->format('h:i a');
        $event->date->hour_end_format = Carbon::parse($event->date->date_end)->locale('es')->format('h:i a');

        $dates = $eventsGroup->transform(function ($dates) {
            return (object)[
                'date_format' => $dates->date->date_start_format = ucfirst(Carbon::parse($dates->date->date_start)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY'))
            ];
        });

        // Parse dates for inputs type date and time
        $event->date->only_date_start = Carbon::parse($event->date->date_start)->format('Y-m-d');
        $event->date->only_hour_start = Carbon::parse($event->date->date_start)->format('H:i');
        $event->date->only_hour_end = Carbon::parse($event->date->date_end)->format('H:i');

        // Get group of event
        $group = $event->group;

        // Get events types filter by group
        $events_types = Event_type::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->get();

        // Get dependencies filter by group
        $dependencies = Dependency_program::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->get();

        // Get places filter by group
        $places = Place::with(['group'])
            ->whereHas('group', function ($query) use ($group) {
                $query->where('type', $group->type);
            })
            ->orderBy('name', 'asc')
            ->get();

        $semesters = Semester::select('id', 'name')->get();

        $group = Group::where('type', 'CTA')->first();
        $responsibles = Responsible::where('group_id', $group->id)
            ->orderBy('id', 'asc')
            ->get();

        $title = TitleEvent::where('title', $event->title)->first();


        return view('edit-cta-event', compact('event', 'events_types', 'dependencies', 'places', 'dates', 'recursive_event', 'semesters', 'group', 'responsibles', 'title'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateProtocolo(Request $request, $id)
    {
        try {

            $event = Event::findOrFail($id);
            $group = Group::where('type', 'Protocolo')->first()->id ?? null;


            DB::transaction(function () use ($request, $event, $group) {

                $title = $request->input('title');
                $responsible = $request->input('responsible');
                $places = $request->input('places');

                if (is_numeric($title)) {
                    $title = TitleEvent::find($request->input('title'));
                } else {
                    $title = TitleEvent::create([
                        'title' => $request->input('title'),
                        'group_id' => $group
                    ]);
                }

                if (is_numeric($responsible)) {
                    $responsible = Responsible::find($request->input('responsible'));
                } else {
                    $responsible = Responsible::create([
                        'name' => $request->input('responsible'),
                        'group_id' => $group
                    ]);
                }


                $idDate = $event->date->id;
                $idRecursiveGroup = $event->recursive_event->event_group ?? 0;
                $event->protocolo()->delete();
                $event->recursive_event()->delete();
                $event->delete();
                Date::find($idDate)->delete();

                $countRecursive = RecursiveEvent::where('event_group', $idRecursiveGroup)->count();

                foreach ($places as $place) {

                    $dateStore = Date::create([
                        'date_start' => Carbon::parse($request->input('date_start') . ' ' . $request->input('hour_start')),
                        'date_end' => Carbon::parse($request->input('date_start') . ' ' . $request->input('hour_end'))
                    ]);

                    $event = Event::create([
                        'title' => $title->title,
                        'type_id' => $request->input('event_type'),
                        'dependency_program_id' =>  $request->input('dependency_program'),
                        'place_id' => $place,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'group_id' => $group,
                        'date_id' => $dateStore->id,
                        'responsible_id' => $responsible->id
                    ]);


                    $event->protocolo()->create([
                        'tel_extension' => $request->input('phone'),
                        'notes_cta' => $request->input('notes_cta'),
                        'notes_general_service' => $request->input('notes_general_services'),
                        'notes_protocolo' => $request->input('notes_protocolo'),
                        'link' => 'https://meet.google.com/lookup',
                    ]);

                    if ($countRecursive) {
                        $event->recursive_event()->create([
                            'event_group' => $idRecursiveGroup
                        ]);
                    }
                }
            });

            return redirect()->route('agenda.index')->with('success', 'Se ha editado el evento correctamente...');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al actualizar el evento, por favor intente de nuevo.');
        }
    }

    // Controller for update only CTA or reserve classroom event to the agenda 
    public function updateCTA(EditClassroomRequest $request, $id)
    {

        try {
            $event = Event::findOrFail($id);

            $group = Group::where('type', 'CTA')->first()->id ?? null;

            DB::transaction(function () use ($request, $event, $group) {

                $title = $request->input('title');
                $responsible = $request->input('responsible');
                $places = $request->input('places');

                if (is_numeric($title)) {
                    $title = TitleEvent::find($request->input('title'));
                } else {
                    $title = TitleEvent::create([
                        'title' => $request->input('title'),
                        'group_id' => $group
                    ]);
                }

                if (is_numeric($responsible)) {
                    $responsible = Responsible::find($request->input('responsible'));
                } else {
                    $responsible = Responsible::create([
                        'name' => $request->input('responsible'),
                        'group_id' => $group
                    ]);
                }

                $idDate = $event->date->id;
                $idRecursiveGroup = $event->recursive_event->event_group ?? 0;
                $event->cta()->delete();
                $event->recursive_event()->delete();
                $event->delete();
                Date::find($idDate)->delete();

                $countRecursive = RecursiveEvent::where('event_group', $idRecursiveGroup)->count();


                foreach ($places as $place) {

                    $dateStore = Date::create([
                        'date_start' => Carbon::parse($request->input('date_start') . ' ' . $request->input('hour_start')),
                        'date_end' => Carbon::parse($request->input('date_start') . ' ' . $request->input('hour_end'))
                    ]);

                    $event = Event::create([
                        'title' => $title->title,
                        'type_id' => $request->input('event_type'),
                        'dependency_program_id' =>  $request->input('dependency_program'),
                        'place_id' => $place,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'group_id' => $group,
                        'date_id' => $dateStore->id,
                        'responsible_id' => $responsible->id
                    ]);


                    $event->cta()->create([
                        'email' => $request->input('email'),
                        'semester_id' => $request->input('semester'),
                        'num_participants' => $request->input('num_participants'),
                        'published' => auth()->check() ? 1 : 0
                    ]);

                    if ($countRecursive > 0) {
                        $event->recursive_event()->create([
                            'event_group' => $idRecursiveGroup
                        ]);
                    }
                }
            });

            return redirect()->route('agenda.index')->with('success', 'Se ha editado la reservación del aula correctamente...');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al actualizar la reservación del aula, por favor intente de nuevo.');
        }
    }

    public function updateProtocoloAll(CreateEventRequest $request, $id)
    {

        try {

            $event = Event::with('recursive_event')->findOrFail($id);

            $eventsGroupId = $event->recursive_event->event_group;
            $eventsIds = RecursiveEvent::where('event_group', $eventsGroupId)
                ->pluck('event_id')
                ->toArray();

            $datesIds = Event::whereIn('id', $eventsIds)
                ->with(['date'])
                ->pluck('date_id')
                ->toArray();

            $datesOlds = Date::whereIn('id', $datesIds)
                ->select('date_start', 'date_end')
                ->get();

            $dateFounds = $this->datesFoundService->getDatesRangeFound($request);
            $group = Group::where('type', 'Protocolo')->first();
            $group = $group->id ?? null;


            $title = $request->input('title');
            $responsible = $request->input('responsible');
            $places = $request->input('places');
            $repetition = $request->input('repetition');

            DB::transaction(function () use ($request, $eventsIds, $datesIds, $dateFounds, $group, $title, $responsible, $places, $repetition, $datesOlds) {

                if (is_numeric($title)) {
                    $titleData = TitleEvent::find($title) ?? 'No tiene título asignado';
                } else {
                    $titleData = TitleEvent::create([
                        'group_id' => $group,
                        'title' => $title
                    ]);
                }

                if (is_numeric($request->input('responsible'))) {
                    $responsibleData = Responsible::findOrFail($responsible);
                } else {
                    $responsibleData = Responsible::create([
                        'name' => $responsible,
                        'group_id' => $group,
                    ]);
                }



                if (intval($repetition) == "1") {

                    foreach ($places as $placeId) {

                        $lastIdRecursiveEvent = RecursiveEvent::max('event_group') ?? 0;
                        $lastIdRecursiveEvent += 1;

                        foreach ($dateFounds as $date) {

                            $dateStore = Date::create([
                                'date_start' => $date['date_start'],
                                'date_end' => $date['date_end'],
                            ]);

                            $event = Event::create([
                                'title' => $titleData->title,
                                'type_id' => $request->input('event_type'),
                                'dependency_program_id' => $request->input('dependency_program'),
                                'place_id' => $placeId,
                                'group_id' => $group,
                                'date_id' => $dateStore->id,
                                'created_by' => Auth::user()->id,
                                'responsible_id' => $responsibleData->id,
                            ]);

                            Protocolo::create([
                                'event_id' => $event->id,
                                'tel_extension' => $request->input('phone'),
                                'notes_cta' => $request->input('notes_cta'),
                                'notes_general_service' => $request->input('notes_general_services'),
                                'notes_protocolo' => $request->input('notes_protocolo'),
                                'link' => 'https://meet.google.com/lookup',
                            ]);

                            if (count($dateFounds) > 1) {
                                $event->recursive_event()->create([
                                    'event_group' => $lastIdRecursiveEvent
                                ]);
                            }
                        }
                    }
                } else {

                    $hourStart = $request->input('hour_start');
                    $hourEnd = $request->input('hour_end');

                    foreach ($places as $placeId) {

                        $lastIdRecursiveEvent = RecursiveEvent::max('event_group') ?? 0;
                        $lastIdRecursiveEvent += 1;

                        foreach ($datesOlds as $dateOld) {

                            $dateStartFormat = Carbon::parse($dateOld->date_start);
                            $dateEndFormat = Carbon::parse($dateOld->date_end);



                            $dateStore = Date::create([
                                'date_start' => $dateStartFormat->format('Y-m-d') . ' ' . $hourStart,
                                'date_end' => $dateEndFormat->format('Y-m-d') . ' ' . $hourEnd,
                            ]);

                            $event = Event::create([
                                'title' => $titleData->title,
                                'type_id' => $request->input('event_type'),
                                'dependency_program_id' => $request->input('dependency_program'),
                                'place_id' => $placeId,
                                'group_id' => $group,
                                'date_id' => $dateStore->id,
                                'created_by' => Auth::user()->id,
                                'responsible_id' => $responsibleData->id,
                            ]);

                            Protocolo::create([
                                'event_id' => $event->id,
                                'tel_extension' => $request->input('phone'),
                                'notes_cta' => $request->input('notes_cta'),
                                'notes_general_service' => $request->input('notes_general_services'),
                                'notes_protocolo' => $request->input('notes_protocolo'),
                                'link' => 'https://meet.google.com/lookup',
                            ]);

                            if (count($datesOlds) > 1) {
                                $event->recursive_event()->create([
                                    'event_group' => $lastIdRecursiveEvent
                                ]);
                            }
                        }
                    }
                }

                Protocolo::whereIn('event_id', $eventsIds)->delete();
                RecursiveEvent::whereIn('event_id', $eventsIds)->delete();
                Event::whereIn('id', $eventsIds)->delete();
                Date::whereIn('id', $datesIds)->delete();
            });

            return redirect()->route('agenda.index')->with('success', 'Se han editado los eventos correctamente...');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al actualizar los eventos, por favor intente de nuevo.');
        }
    }


    // Update reverse classroom event for range dates
    public function updateCTAAll(CreateEventCTARequest $request, $id)
    {

        try {
            $event = Event::with(['place', 'cta', 'dependency_program', 'event_type', 'user', 'responsible', 'group', 'recursive_event'])->findOrFail($id);

            if ($event->recursive_event->count() <= 0) {
                return redirect()->route('agenda.index');
            }

            $eventsGroupId = $event->recursive_event->event_group;

            $eventsIds = RecursiveEvent::where('event_group', $eventsGroupId)
                ->pluck('event_id')
                ->toArray();

            $datesIds = Event::whereIn('id', $eventsIds)
                ->with(['date'])
                ->pluck('date_id')
                ->toArray();

            $datesOlds = Date::whereIn('id', $datesIds)
                ->select('date_start', 'date_end')
                ->get();

            $dateFounds = $this->datesFoundService->getDatesRangeFound($request);
            $group = Group::where('type', 'CTA')->first();
            $group = $group->id ?? null;

            $title = $request->input('title');
            $responsible = $request->input('responsible');
            $places = $request->input('places');
            $repetition = $request->input('repetition');


            DB::transaction(function () use ($request, $eventsIds, $datesIds, $dateFounds, $group, $datesOlds, $title, $responsible, $places, $repetition) {

                if (is_numeric($title)) {
                    $titleData = TitleEvent::find($title) ?? 'No tiene título asignado';
                } else {
                    $titleData = TitleEvent::create([
                        'group_id' => $group,
                        'title' => $title
                    ]);
                }

                if (is_numeric($request->input('responsible'))) {
                    $responsibleData = Responsible::findOrFail($responsible);
                } else {
                    $responsibleData = Responsible::create([
                        'name' => $responsible,
                        'group_id' => $group,
                    ]);
                }



                if (intval($repetition) == "1") {

                    foreach ($places as $placeId) {

                        $lastIdRecursiveEvent = RecursiveEvent::max('event_group') ?? 0;
                        $lastIdRecursiveEvent += 1;

                        foreach ($dateFounds as $date) {

                            $dateStore = Date::create([
                                'date_start' => $date['date_start'],
                                'date_end' => $date['date_end'],
                            ]);

                            $event = Event::create([
                                'title' => $titleData->title,
                                'type_id' => $request->input('event_type'),
                                'dependency_program_id' => $request->input('dependency_program'),
                                'place_id' => $placeId,
                                'group_id' => $group,
                                'date_id' => $dateStore->id,
                                'created_by' => Auth::user()->id,
                                'responsible_id' => $responsibleData->id,
                            ]);

                            Cta::create([
                                'event_id' => $event->id,
                                'email' => $request->input('email'),
                                'semester_id' => $request->input('semester'),
                                'num_participants' => $request->input('num_participants'),
                                'published' => auth()->check() ? 1 : 0
                            ]);

                            if (count($dateFounds) > 1) {
                                $event->recursive_event()->create([
                                    'event_group' => $lastIdRecursiveEvent
                                ]);
                            }
                        }
                    }
                } else {

                    $hourStart = $request->input('hour_start');
                    $hourEnd = $request->input('hour_end');

                    foreach ($places as $placeId) {

                        $lastIdRecursiveEvent = RecursiveEvent::max('event_group') ?? 0;
                        $lastIdRecursiveEvent += 1;

                        foreach ($datesOlds as $dateOld) {

                            $dateStartFormat = Carbon::parse($dateOld->date_start);
                            $dateEndFormat = Carbon::parse($dateOld->date_end);



                            $dateStore = Date::create([
                                'date_start' => $dateStartFormat->format('Y-m-d') . ' ' . $hourStart,
                                'date_end' => $dateEndFormat->format('Y-m-d') . ' ' . $hourEnd,
                            ]);

                            $event = Event::create([
                                'title' => $titleData->title,
                                'type_id' => $request->input('event_type'),
                                'dependency_program_id' => $request->input('dependency_program'),
                                'place_id' => $placeId,
                                'group_id' => $group,
                                'date_id' => $dateStore->id,
                                'created_by' => Auth::user()->id,
                                'responsible_id' => $responsibleData->id,
                            ]);

                            Cta::create([
                                'event_id' => $event->id,
                                'email' => $request->input('email'),
                                'semester_id' => $request->input('semester'),
                                'num_participants' => $request->input('num_participants'),
                                'published' => auth()->check() ? 1 : 0
                            ]);

                            if (count($datesOlds) > 1) {
                                $event->recursive_event()->create([
                                    'event_group' => $lastIdRecursiveEvent
                                ]);
                            }
                        }
                    }
                }

                Cta::whereIn('event_id', $eventsIds)->delete();
                RecursiveEvent::whereIn('event_id', $eventsIds)->delete();
                Event::whereIn('id', $eventsIds)->delete();
                Date::whereIn('id', $datesIds)->delete();
            });

            return redirect()->route('agenda.index')->with('success', 'Se han editado las reservaciones de las clases...');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la reservación de la aula, por favor intente de nuevo.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        if (!auth()->user()->hasPermissionTo('delete event') && !auth()->user()->hasPermissionTo('delete reserve classroom')) {
            return abort(403, 'No tienes permiso para realizar esta acción');
        }

        $event = Event::findOrFail($id);
        $groupUser = Auth::user()->group;

        $response = null;

        // return response()->json(['event' => $event, 'groupUser' => $groupUser]);

        if ($groupUser->type == 'Protocolo' || $groupUser->type == 'Superadmin') {
            $response = $this->destroyProtocolo($event);
        } else {
            $response = $this->destroyCTA($event);
        }

        if ($response['status'] == 200) {
            return redirect()->route('agenda.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('error', $response['message']);
        }
    }

    // Handle to delete all events or reserve classrooms to db
    public function destroyAll($id)
    {

        // Check if the user autenticated have permission to delete events
        if (!auth()->user()->hasPermissionTo('delete event') && !auth()->user()->hasPermissionTo('delete reserve classroom')) {
            return abort(403, 'No tienes permiso para realizar esta acción');
        }

        // Get event to ID
        $event = Event::findOrFail($id);
        // Get group of User
        $groupUser = Auth::user()->group;

        $response = null;

        // If Protocolo group or superadmin group delete eventos to Protocolo group
        if ($groupUser->type == 'Protocolo' || $groupUser->type == 'Superadmin') {
            $response = $this->destroyAllProtocolo($event);
        } else {
            // Else to delete reserve classrooms to CTA group
            $response = $this->destroyAllCTA($event);
        }

        if ($response['status'] == 200) {
            return redirect()->route('agenda.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('error', $response['message']);
        }
    }

    private function destroyProtocolo($event)
    {
        try {
            DB::transaction(function () use ($event) {


                $event->protocolo()->delete();
                $idDate = $event->date->id;
                $event->recursive_event()->delete();
                $event->delete();

                Date::where('id', $idDate)->delete();
            });
            $response = [
                'status' => 200,
                'title' => 'Evento eliminado',
                'message' => 'Se ha eliminado el evento correctamente...'
            ];
            // return redirect()->route('agenda.index')->with('success', 'Se ha eliminado el evento correctamente...');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'status' => 500,
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al eliminar el evento, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ];
            // $msg = "Ha ocurrido un error al eliminar el evento, por favor intente de nuevo.";
            // return redirect()->back()->with('error', 'Ha ocurrido un error al eliminar el evento, por favor intente de nuevo.');
        }

        return $response;
    }

    // Delete all events with relationships
    private function destroyAllProtocolo($event)
    {
        try {

            $eventsGroupId = $event->recursive_event->event_group;
            $eventsIds = RecursiveEvent::where('event_group', $eventsGroupId)
                ->pluck('event_id')
                ->toArray();

            $datesIds = Event::whereIn('id', $eventsIds)
                ->with(['date'])
                ->pluck('date_id')
                ->toArray();

            DB::transaction(function () use ($eventsIds, $datesIds) {
                Protocolo::whereIn('event_id', $eventsIds)->delete();
                RecursiveEvent::whereIn('event_id', $eventsIds)->delete();
                Event::whereIn('id', $eventsIds)->delete();
                Date::whereIn('id', $datesIds)->delete();
            });

            $response = [
                'status' => 200,
                'title' => 'Eventos eliminados',
                'message' => 'Se ha eliminado los eventos correctamente...'
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'status' => 500,
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al eliminar el evento, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ];
        }

        return $response;
    }

    // Delete reserve classroom
    private function destroyCTA($event)
    {
        try {
            DB::transaction(function () use ($event) {
                $event->cta()->delete();
                $idDate = $event->date->id;
                $event->recursive_event()->delete();
                $event->delete();

                Date::where('id', $idDate)->delete();
            });
            $response = [
                'status' => 200,
                'title' => 'Evento eliminado',
                'message' => 'Se ha eliminado la reservación del aula correctamente...'
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'status' => 500,
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al eliminar el evento, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ];
        }

        return $response;
    }

    private function destroyAllCTA($event)
    {
        try {

            $eventsGroupId = $event->recursive_event->event_group;
            $eventsIds = RecursiveEvent::where('event_group', $eventsGroupId)
                ->pluck('event_id')
                ->toArray();

            $datesIds = Event::whereIn('id', $eventsIds)
                ->with(['date'])
                ->pluck('date_id')
                ->toArray();

            DB::transaction(function () use ($eventsIds, $datesIds) {
                Cta::whereIn('event_id', $eventsIds)->delete();
                RecursiveEvent::whereIn('event_id', $eventsIds)->delete();
                Event::whereIn('id', $eventsIds)->delete();
                Date::whereIn('id', $datesIds)->delete();
            });

            $response = [
                'status' => 200,
                'title' => 'Reservaciones eliminadas',
                'message' => 'Se ha eliminado los las reservaciones de aula correctamente...'
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response = [
                'status' => 500,
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al eliminar el evento, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ];
        }

        return $response;
    }
}
