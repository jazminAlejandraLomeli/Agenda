<?php

namespace App\Http\Controllers;

use App\Models\Dependency_program;
use App\Http\Requests\DependencyEditRequest;
use App\Models\User;
use App\Http\Requests\DependencyAddRequest;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

class DependencyProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //$user = User::with('group')->find(Auth::user()->id);
        // return response()->json($user);
        $group_name = Auth::user()->group->type;   // Nombre del grupo al que pertenece 
        $group = Auth::user()->group_id;     // grupo 

        $title_nav = ($group_name === "CTA") ? "Programa académico" : "Dependencia";
       
        $Groups = [];
        // Super admin
        if ($group_name == "Superadmin") {
            $Groups = Group::where('type', '!=', 'Superadmin')->get();
        }

        return view('manage.dependencies', compact('Groups', 'group', 'title_nav'));
    }


    public function getDependencies(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $search = $request->input('search');

        try {

            $group = Auth::user()->group->type;  // Nombre del grupo al que pertenece 
     

            if ($group != 'Superadmin') {
                // filtrar segun el filtro 
                $query = Dependency_program::with('group')
                    ->whereHas('group', function ($q) use ($group) {
                        $q->where('type', '=', $group);
                    });

                if (!empty($search)) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            } else {
                $query = Dependency_program::with('group');

                if (!empty($search)) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhereHas(
                            'group',
                            function ($q) use ($search) {
                                $q->where('type', 'like', "%$search%");
                            }
                        );
                }
            }

            $total = $query->count();

            $dependencies = $query
                ->orderBy('name','asc')
                ->offset($offset)
                ->limit($limit)
                ->get();

            return response()->json([
                'total' => $total,
                'data' => $dependencies
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al obtener los tipos de eventos, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DependencyAddRequest $request)
    {
        $validated = $request->validated();
        try {
            $event_type = Dependency_program::where('name', $validated['Nombre'])->where('group_id', $validated['Grupo'])->first();

            if ($event_type) {
                return redirect()->back()->with('error', 'Parace que deseas agregar una dependencia que ya existe.');
            }

            // Verificamos el usuario 
            $user = User::with('group')->find(Auth::user()->id);
            $group = "";

            if ($user->group->type == "Superadmin") {  // Tomar grupo que viene del JS
                $group = $validated['Grupo'];
            } else {
                $group = $user->group_id;   // Tomar el grupo al que pertenece el usuario
            }

            DB::transaction(function () use ($validated, $group) {
                $event_type = new Dependency_program;
                $event_type->name = $validated['Nombre'];
                $event_type->group_id = $group;
                $event_type->created_by = Auth::user()->id;
                $event_type->updated_at = now();
                $event_type->save();
            });

            return response()->json(['status' => 200]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error asl editar la dependencia, por favor intente de nuevo.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(dependency_program $dependency_program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DependencyEditRequest $dependency_program) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(DependencyEditRequest $dependency_program)
    {
        $validated = $dependency_program->validated();
        try {
            $type = Dependency_program::where('id',  $validated['Id'])->first();
            $group = "";

            if (Auth::user()->group->type == "Superadmin") {  // Tomar grupo que viene del JS
                $group = $validated['Grupo'];
            } else {
                $group = Auth::user()->group_id;   // Tomar el grupo al que pertenece el usuario
            }

            DB::transaction(function () use ($validated, $type, $group) {
                $type->update([
                    'name' => $validated['Nombre'],
                    'group_id' => $group,
                    'updated_at' => now(),
                ]);
            });

            return response()->noContent();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error asl editar el tipo de evento, por favor intente de nuevo.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dependency_program $dependency_program)
    {
        //
    }
}
