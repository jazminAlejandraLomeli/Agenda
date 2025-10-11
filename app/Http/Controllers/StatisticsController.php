<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\Dependency_program;
use App\Models\Event;
use App\Models\Group;
use App\Models\Place;
use App\Models\Protocolo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class StatisticsController extends Controller
{

    /*
        Funcion para enviar la vista de de le estadistica de los eventos algunos contadores
    */
    public function eventsStatistics()
    {


        // Solo protocolo y admin puede verlos 
        if (Auth::user()->group->type == 'CTA') {
            return redirect()->route('agenda.guest.index', ['type_events' => 'events']);
        }

        $places  = Place::where('group_id', 1)->get();
        $places_count = Place::where('group_id', 1)->count();

        $today_events = Event::whereHas('protocolo')
            ->whereHas('date', function ($query) {
                $query->whereDate('date_start', today());  // solo los de hoy
            })->where('group_id', operator: 1)   // solo eventos con protocolo
            ->count();

        $now_events = Event::whereHas('protocolo')
            ->whereHas('date', function ($query) {
                $query->whereDate('date_start', today())
                    ->whereTime('date_start', '<=', now())   // ya empezó
                    ->whereTime('date_end', '>=', now());    // aún no termina
            })->with(relations: 'place')
            ->where('group_id', 1)
            ->get()
            ->map(function ($event) {
                return [
                    'name'      => $event->place->name,
                    'color'     => $event->place->color,
                ];
            });

        $now_events = [
            'count' => $now_events->count(),
            'places' => $now_events,


        ];

        return view('statistics.events', compact(['places', 'places_count', 'today_events', 'now_events']));
    }

    /*
    Funcion para enviar la data que se encuentra en en la grafica de Chart js 
*/
    public function getdata_protocolo(Request $request)
    {


        $place  = $request->input('place');
        $start  = $request->input('start');
        $end    = $request->input('end');


        $startDate = $start ? Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d') : null;
        $endDate   = $end   ? Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d') : null;

        $places = Event::whereHas('protocolo')
            ->whereHas('date', function ($query) use ($startDate, $endDate) {
                // Filtrar solo por el año actual
                $query->whereYear('date_start', now()->year);

                // Filtrar eventos que inicien dentro del rango de fechas si se proporcionan
                if ($startDate && $endDate) {
                    $query->whereBetween('date_start', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->whereDate('date_start', '>=', $startDate);
                } elseif ($endDate) {
                    $query->whereDate('date_start', '<=', $startDate);
                }
            })
            ->with('place')
            ->where('group_id', 1)
            ->when($place, function ($query, $place) {
                return $query->whereIN('place_id', $place);
            })
            ->get()
            ->groupBy(fn($event) => $event->place?->name)
            ->map(fn($events, $placeName) => [
                'place' => $placeName,
                'color' => optional($events->first()->place)->color,
                'total' => $events->count(),
            ])
            ->values();

        $data = [

            'places_chart' => $places,
        ];

        return response()->json([$data]);
    }

    public function classroomsStatistics()
    {


        // Solo CTA y admin puede verlos 
        if (Auth::user()->group->type == 'Protocolo') {
            return redirect()->route('agenda.guest.index', ['type_events' => 'events']);
        }

        $programs  = Dependency_program::where('group_id', 2)->get();
        $places_count = Place::where('group_id', 2)->count();

        $today_events = Event::whereHas('cta')
            ->whereHas('date', function ($query) {
                $query->whereDate('date_start', today());  // solo los de hoy
            })->where('group_id', 2)   // solo eventos con protocolo
            ->count();

        $now_events = Event::whereHas('cta')
            ->whereHas('date', function ($query) {
                $query->whereDate('date_start', today())
                    ->whereTime('date_start', '<=', now())   // ya empezó
                    ->whereTime('date_end', '>=', now());    // aún no termina
            })->with(relations: 'place')
            ->where('group_id', 2)
            ->get()
            ->map(function ($event) {
                return [
                    'name'      => $event->place->name,
                    'color'     => $event->place->color,
                ];
            });

        $asignaturas = Event::whereHas('cta')
            ->whereHas('date', function ($query) {
                $query->whereDate('date_start', today())
                    ->whereTime('date_start', '<=', now())   // ya empezó
                    ->whereTime('date_end', '>=', now());    // aún no termina
            })->with(relations: 'place')
            ->where('group_id', 2)
            ->get()
            // ->map(function ($event) {
            //     return [
            //         'name'      => $event->place->name,
            //         'color'     => $event->place->color,
            //     ];
            // })
        ;

        $now_events = [
            'count' => $now_events->count(),
            'places' => $now_events,
            'asignaturas' => $asignaturas ?? 0,


        ];

        return view('statistics.classrooms', compact(['programs', 'places_count', 'today_events', 'now_events']));
    }
    public function laboratoryStatistics()
    {

        // Solo laboratorio y admin puede verlos 
        if (Auth::user()->group->type == 'Protocolo' || Auth::user()->group->type == 'CTA') {
            return redirect()->route('agenda.guest.index', ['type_events' => 'events']);
        }

        $get_grupo = Group::where('type', 'Laboratorio')->first();
        $grupo_id = $get_grupo->id;

        $programs  = Dependency_program::where('group_id',   $grupo_id)->get();
        $places_count = Place::where('group_id',   $grupo_id)->count();

        $today_events = Event::whereHas('cta')
            ->whereHas('date', function ($query) {
                $query->whereDate('date_start', today());  // solo los de hoy
            })->where('group_id',   $grupo_id)   // solo eventos con protocolo
            ->count();

        $now_events = Event::whereHas('cta')
            ->whereHas('date', function ($query) {
                $query->whereDate('date_start', today())
                    ->whereTime('date_start', '<=', now())   // ya empezó
                    ->whereTime('date_end', '>=', now());    // aún no termina
            })->with(relations: 'place')
            ->where('group_id', 4)
            ->get()
            ->map(function ($event) {
                return [
                    'name'      => $event->place->name,
                    'color'     => $event->place->color,
                ];
            });

    //    $asignaturas = Event::whereHas('cta')
        //     ->whereHas('date', function ($query) {
        //         $query->whereDate('date_start', today())
        //             ->whereTime('date_start', '<=', now())   // ya empezó
        //             ->whereTime('date_end', '>=', now());    // aún no termina
        //     })->with(relations: 'place')
        //     ->where('group_id',   $grupo_id)
        //     ->get()
        // ;
        $now_events = [
            'count' => $now_events->count(),
            'places' => $now_events,
           // 'asignaturas' => $asignaturas ?? 0,
        ];


        return view('statistics.laboratory', compact(['programs', 'places_count', 'today_events', 'now_events']));
    }


    public function getdata_cta(Request $request)
    {

        $get_grupo = Group::where('type', 'CTA')->first();
        $grupo_id = $get_grupo->id;

        // $place  = $request->input('place');
        $start  = $request->input('start');
        $end    = $request->input('end');

        $startDate = $start ? Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d') : null;
        $endDate   = $end   ? Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d') : null;

        $string_date = "";

        if ($start == null) {
            $string_date = Carbon::now()->translatedFormat('Y');
        } else {
            $string_date = 
                 Carbon::parse($start)->translatedFormat('d \d\e F \d\e Y')
                . " al "
                . Carbon::parse($end)->translatedFormat('d \d\e F \d\e Y');
        }

        $places = Event::whereHas('cta')
            ->whereHas('date', function ($query) use ($startDate, $endDate) {
                // Filtrar solo por el año actual
                $query->whereYear('date_start', now()->year);

                // Filtrar eventos que inicien dentro del rango de fechas si se proporcionan
                if ($startDate && $endDate) {
                    $query->whereBetween('date_start', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->whereDate('date_start', '>=', $startDate);
                } elseif ($endDate) {
                    $query->whereDate('date_start', '<=', $startDate);
                }
            })
            ->with('place')
            ->where('group_id', $grupo_id)
            ->get()
            ->groupBy(fn($event) => $event->place?->name)
            ->map(fn($events, $placeName) => [
                'place' => $placeName,
                'color' => optional($events->first()->place)->color,
                'total' => $events->count(),
            ])
            ->values();



        $data = [
            'places_chart' => $places,
            'string_date' => $string_date,
        ];

        return response()->json([$data]);
    }
    public function getdata_labs(Request $request)
    {

        $get_grupo = Group::where('type', 'Laboratorio')->first();
        $grupo_id = $get_grupo->id;

        // $place  = $request->input('place');
        $start  = $request->input('start');
        $end    = $request->input('end');


        $startDate = $start ? Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d') : null;
        $endDate   = $end   ? Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d') : null;

        $string_date = "";

        if ($start == null) {
            $string_date = Carbon::now()->translatedFormat('Y');
        } else {
            $string_date = 
                 Carbon::parse($start)->translatedFormat('d \d\e F \d\e Y')
                . " al "
                . Carbon::parse($end)->translatedFormat('d \d\e F \d\e Y');
        }

        $places = Event::whereHas('cta')
            ->whereHas('date', function ($query) use ($startDate, $endDate) {
                // Filtrar solo por el año actual
                $query->whereYear('date_start', now()->year);

                // Filtrar eventos que inicien dentro del rango de fechas si se proporcionan
                if ($startDate && $endDate) {
                    $query->whereBetween('date_start', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->whereDate('date_start', '>=', $startDate);
                } elseif ($endDate) {
                    $query->whereDate('date_start', '<=', $startDate);
                }
            })
            ->with('place')
            ->where('group_id',   $grupo_id)
            ->get()
            ->groupBy(fn($event) => $event->place?->name)
            ->map(fn($events, $placeName) => [
                'place' => $placeName,
                'color' => optional($events->first()->place)->color,
                'total' => $events->count(),
            ])
            ->values();

        $data = [
            'places_chart' => $places,
            'string_date' => $string_date,
        ];

        return response()->json([$data]);
    }


    public function get_data_cta_complete(Request $request)
    {

        $start  = $request->input('start');
        $end    = $request->input('end');
        $id_dependency = $request->input('program') ?? 90;

        $string_date = "";

        if ($start == null) {
            $string_date = Carbon::now()->translatedFormat('Y');
        } else {
            $string_date =
                Carbon::parse($start)->translatedFormat('d \d\e F \d\e Y')
                . " al "
                . Carbon::parse($end)->translatedFormat('d \d\e F \d\e Y');
        }

        $startDate = $start ? Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d') : null;
        $endDate   = $end   ? Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d') : null;


        $places = Event::where('group_id', 2)
            ->whereHas('cta')
            ->whereHas('date', function ($query) use ($startDate, $endDate) {
                // Filtrar solo por el año actual
                $query->whereYear('date_start', now()->year);

                // Filtrar eventos que inicien dentro del rango de fechas si se proporcionan
                if ($startDate && $endDate) {
                    $query->whereBetween('date_start', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->whereDate('date_start', '>=', $startDate);
                } elseif ($endDate) {
                    $query->whereDate('date_start', '<=', $startDate);
                }
            })
            ->whereHas('dependency_program', function ($query) use ($id_dependency) {
                $query->where('id', $id_dependency);
            })
            ->with(['place', 'cta.semester', 'dependency_program'])

            ->get()
            ->groupBy(fn($event) => $event->cta?->semester?->name)
            ->map(callback: fn($events, $semesterName) => [
                'semester'  => $semesterName,
                'total'     => $events->count(),
                'programa'  => $events->first()->dependency_program?->name,
            ])
            ->sortBy(function ($item) {

                return (int) filter_var($item['semester'], FILTER_SANITIZE_NUMBER_INT);
            })
            ->values();

        $data = [
            'semesters' => $places,
            'total' => $places->count(),
            'string_date' => $string_date,
        ];

        return response()->json([$data]);
    }
    public function get_data_labs_complete(Request $request)
    {

        $get_grupo = Group::where('type', 'Laboratorio')->first();

        $grupo_id = $get_grupo->id;
        // Filtro y si no el primero de este grupo
        $id_dependency = $request->input('program') ??  Dependency_program::where('group_id',   $grupo_id)->first()->id;

        $start  = $request->input('start');
        $end    = $request->input('end');
 
        $string_date = "";

        if ($start == null) {
            $string_date = Carbon::now()->translatedFormat('Y');
        } else {
            $string_date =
                Carbon::parse($start)->translatedFormat('d \d\e F \d\e Y')
                . " al "
                . Carbon::parse($end)->translatedFormat('d \d\e F \d\e Y');
        }

        $startDate = $start ? Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d') : null;
        $endDate   = $end   ? Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d') : null;


        $places = Event::where('group_id',  $grupo_id)
            ->whereHas('cta')
            ->whereHas('date', function ($query) use ($startDate, $endDate) {
                // Filtrar solo por el año actual
                $query->whereYear('date_start', now()->year);

                // Filtrar eventos que inicien dentro del rango de fechas si se proporcionan
                if ($startDate && $endDate) {
                    $query->whereBetween('date_start', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->whereDate('date_start', '>=', $startDate);
                } elseif ($endDate) {
                    $query->whereDate('date_start', '<=', $startDate);
                }
            })
            ->whereHas('dependency_program', function ($query) use ($grupo_id, $id_dependency) {
                $query->where('group_id', $grupo_id);
                if ($id_dependency) {
                    $query->where('id', $id_dependency);
                }
            })
            ->with(['place', 'cta.semester', 'dependency_program'])

            ->get()
            ->groupBy(fn($event) => $event->cta?->semester?->name)
            ->map(callback: fn($events, $semesterName) => [
                'semester'  => $semesterName,
                'total'     => $events->count(),
                'programa'  => $events->first()->dependency_program?->name,
            ])
            ->sortBy(function ($item) {

                return (int) filter_var($item['semester'], FILTER_SANITIZE_NUMBER_INT);
            })
            ->values();

        $data = [
            'semesters' => $places,
            'total' => $places->count(),
            'string_date' => $string_date,
        ];

        return response()->json([$data]);
    }
}
