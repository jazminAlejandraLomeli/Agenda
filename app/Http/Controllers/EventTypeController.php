<?php

namespace App\Http\Controllers;

use App\Models\Event_type;
use App\Models\Group;
use App\Models\User;
use App\Http\Requests\EventTypeEditRequest;
use App\Http\Requests\EventTypeAddRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $group_name = Auth::user()->group->type;   // Nombre del grupo al que pertenece 
        $group = Auth::user()->group_id;   // id del grupo 
        $title_nav = ($group_name === "CTA" || $group_name === "Laboratorio") ? "Programa académico" : "Dependencia";


        $Groups = [];
        // Super admin
        if ($group_name == "Superadmin") {
            $Groups = Group::where('type', '!=', 'Superadmin')->get();
        }
        return view('manage.event-types', compact('Groups', 'group', 'title_nav'));
    }

    public function getEventTypes(Request $request)
    {

        $offset = intval($request->input('offset', 0));
        $limit = intval($request->input('limit', 10));
        $search = $request->input('search', '');

        try {
            $group = Auth::user()->group->type; // Nombre del grupo al que pertenece 

            if ($group != 'Superadmin') {
                // Consulta para usuarios que no son Superadmin
                $query = Event_type::with('group')
                ->whereHas('group', function ($q) use ($group) {
                    $q->where('type', '=', $group);
                });

                if (!empty($search)) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            } else {
                // Consulta para Superadmin
                $query = Event_type::with('group');

                if (!empty($search)) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhereHas('group', function ($q) use ($search) {
                            $q->where('type', 'like', "%$search%");
                        });
                }
            }

            // Contar el total de registros antes de paginar
            $total = $query->count();

            // Aplicar paginación
            $events_types = $query
                ->orderBy('name', 'asc')
                ->offset($offset)
                ->limit($limit)
                ->get();


          //  return response()->json([$Nutri, $consul]);

            return response()->json([
                'total' => $total,
                'data' => $events_types,
                'user' => $group
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al obtener los tipos de eventos, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventTypeAddRequest $request)
    {
        $validated = $request->validated();
        try {
            $event_type = event_type::where('name', $validated['Nombre'])->where('group_id', $validated['Grupo'])->first();

            if ($event_type) {
                return redirect()->back()->with('error', 'Parace que deseas agregar un tipo de evento que ya existe.');
            }

            $group = "";

            if (Auth::user()->group->type == "Superadmin") {  // Tomar grupo que viene del JS
                $group = $validated['Grupo'];
            } else {
                $group = Auth::user()->group_id;   // Tomar el grupo al que pertenece el usuario
            }

            DB::transaction(function () use ($validated, $group) {
                $event_type = new event_type;
                $event_type->name = $validated['Nombre'];
                $event_type->group_id = $group;
                $event_type->created_by = Auth::user()->id;
                $event_type->updated_at = now();
                $event_type->save();
            });

            return response()->json(['status' => 200]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al guardar el dato, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);        }
    }


    /**
     * Display the specified resource.
     */
    public function show(event_type $event_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit() {}

    /**
     * Update the specified resource in storage.
     */
    public function update(EventTypeEditRequest $event_type)
    {
        $validated = $event_type->validated();

        try {
            $tipe = event_type::where('id',  $validated['Id'])->first();

            $group = "";

            if (Auth::user()->group->type == "Superadmin") {  // Tomar grupo que viene del JS
                $group = $validated['Grupo'];
            } else {
                $group = Auth::user()->group_id;   // Tomar el grupo al que pertenece el usuario
            } 

            DB::transaction(function () use ($validated, $tipe, $group) {
                $tipe->update([
                    'name' => $validated['Nombre'],
                    'group_id' => $group,
                    'updated_at' => now(),
                ]);
            });

            return response()->noContent();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al editar el tipo de evento, por favor intente de nuevo.');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(event_type $event_type)
    {
        //
    }
}
