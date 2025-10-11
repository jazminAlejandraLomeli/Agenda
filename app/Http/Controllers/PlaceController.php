<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Http\Requests\PlaceEditRequest;
use App\Http\Requests\PlaceAddRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //$user = User::with('group')->find(Auth::user()->id);

        $group_name = Auth::user()->group->type;   // Nombre del grupo al que pertenece 
        $group = Auth::user()->group_id;   // grupo 
        $title_nav = ($group_name === "CTA") ? "Programa académico" : "Dependencia";

        $Groups = [];
        // Super admin
        if ($group_name == "Superadmin") {
            $Groups = Group::where('type', '!=', 'Superadmin')->get();
        }
        return view('manage.places', compact('Groups', 'group', 'title_nav'));
    }

    /* Funcion para mostrar los registros de los lugares en la visata de places  */
    public function getplaces(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $search = $request->input('search');

        try {

            $group = Auth::user()->group->type;

            if ($group != 'Superadmin') {
                // filtrar segun el filtro 
                $query = Place::with('group')
                    ->whereHas('group', function ($q) use ($group) {
                        $q->where('type', '=', $group);
                    });

                if (!empty($search)) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            } else {
                $query = Place::with('group');

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
                ->orderBy('name', 'asc')
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

    /* Funcion apara agregar un nuevo regsitro de un lugar a la base de datos  */
    public function store(PlaceAddRequest $place)
    {
        $validated = $place->validated();
        try {

            $text_color = $validated['Color_Texto'] === "2" ? "#ffffff" : "#000000";

            $group = "";

            if (Auth::user()->group->type == "Superadmin") {  // Tomar grupo que viene del JS
                $group = $validated['Grupo'];
            } else {
                $group = Auth::user()->group_id;   // Tomar el grupo al que pertenece el usuario
            }

            // validar que no se repita el nombre con el mismo grupo 
            $UniqueName = Place::where('name', $validated['Nombre'])->where('group_id',  $group)->first();
            if ($UniqueName) {
                return response()->json(['msg' => 'El nuevo nombre que deseas agregar ya existe en otro registro.'], 409);
            }
            // Verificar que el color no se repita en ningun registro 
            $UniqueColor = Place::where('color', $validated['Color'])->first();

            if ($UniqueColor) {
                return response()->json(['msg' => "El color que deseas agregar " . $validated['Color'] . " ya fue registrado en otro lugar."], 409);
            }


            // Hacer la insercion 
            DB::transaction(function () use ($validated,  $group, $text_color) {
                $new_place = new place();
                $new_place->name = $validated['Nombre'];
                $new_place->group_id =  $group;
                $new_place->color = $validated['Color'];
                $new_place->text_color = $text_color;
                $new_place->created_by = Auth::user()->id;   /// corregir
                $new_place->updated_at = now();
                $new_place->save();
            });

            return response()->json(['status' => 200]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error asl editar el tipo de evento, por favor intente de nuevo.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(place $place)
    {
        //
    }

    /* Funcion para hacer un update a un regsitro de la base de datos, dende se valida qyue el nombre o el color no choque con algun otro registro */
    public function update(PlaceEditRequest $Place)
    {
        $validated = $Place->validated();
        try {
            $Place = Place::where('id', $validated['Id'])->first();
            $text_color = $validated['Color_Texto'] === "2" ? "#ffffff" : "#000000";
            $group = "";

            if (Auth::user()->group->type == "Superadmin") {  // Tomar grupo que viene del JS
                $group = $validated['Grupo'];
            } else {
                $group = Auth::user()->group_id;   // Tomar el grupo al que pertenece el usuario
            }

            $UniqueColor = Place::where('color', $validated['Color'])
                ->where('id', '!=', $validated['Id']) // Ignora el que se esta editando
                ->first();

            $UniqueName = Place::where('name', $validated['Nombre'])
                ->where('group_id',  $group)
                ->where('id', '!=', $validated['Id']) // Ignora el que se esta editando
                ->first();

            if ($UniqueColor) {
                return response()->json(['msg' => "El color que deseas agregar " . $validated['Color'] . " ya fue registrado en otro lugar."], 409);
            }

            if ($UniqueName) {
                return response()->json(['msg' => 'El nuevo nombre que deseas agregar ya existe en otro registro.'], 409);
            }

            DB::transaction(function () use ($validated, $Place, $group, $text_color) {
                $Place->update([
                    'name' => $validated['Nombre'],
                    'group_id' => $group,
                    'text_color' => $text_color,
                    'color' => $validated['Color'],
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
    public function destroy(place $place)
    {
        //
    }
}
