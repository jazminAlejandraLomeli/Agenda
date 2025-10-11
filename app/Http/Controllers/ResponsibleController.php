<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponsibleRequest;
use App\Models\Responsible;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResponsibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getCurrentResponsibles($search, $group)
    {
        $search = $search ?? '';
        $groupId = $group ?? 0;

        try {

            $responsibles = Responsible::where('group_id', $groupId);

            if(!empty($search)){
                $responsibles = $responsibles   
                    ->where('name', 'like','%'.$search.'%');
            }

            $responsibles = $responsibles
                            ->orderBy('name', 'asc')
                            ->limit(30)
                            ->get();

            return response()->json([
                'responsibles' => $responsibles
            ],200);


        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Oops...!',
                'msg' => 'Error al obtener los responsables almacenados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResponsibleRequest $request)
    {
        try {


            DB::transaction(function () use ($request) {
                Responsible::create([
                    'name' => $request->input('responsible_name'),
                    'group_id' => $request->input('group_id')
                ]);
            });

            $responsibles = Responsible::where('group_id', $request->input('group_id'))
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'title' => '¡Operación exitosa!',
                'msg' => 'Responsable guardado correctamente',
                'responsibles' => $responsibles
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'title' => 'Oops...!',
                'msg' => 'Error al guardar el responsable',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(responsible $responsible)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(responsible $responsible)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, responsible $responsible)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(responsible $responsible)
    {
        //
    }
}
