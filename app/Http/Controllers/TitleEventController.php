<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTitleEvent;
use App\Models\TitleEvent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TitleEventController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTitleEvent $request)
    {

        try{
            
            DB::transaction(function () use ($request) {
                TitleEvent::create($request->only('title','group_id'));
            });

            return response()->json([
                'title' => '¡Operación exitosa!',
                'msg' => 'Título del evento guardado correctamente',
            ], 201);

        }catch(Exception $e){
            return response()->json([
                'title' => 'Oops...!',
                'msg' => 'Error al guardar el título del evento',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
     
    public function getConcurrentTitles ($search, $group) {

        
        $search = $search ?? '';
        $groupId = $group ?? 0;
        try{
            $titles = TitleEvent::where('group_id', $groupId);

            if(!empty($search)){
                $titles = $titles->where('title', 'like', '%'.$search.'%');                
            }

            $titles = $titles
                        ->orderBy('title', 'asc')
                        ->limit(30)
                        ->get();

            return response()->json([
                'titles' => $titles
            ],200);
        }catch(Exception $e){
            return response()->json([
                'title' => 'Oops...!',
                'msg' => 'Error al obtener los títulos del evento',
                'error' => $e->getMessage()
            ], 500);
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(TitleEvent $titleEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TitleEvent $titleEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TitleEvent $titleEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TitleEvent $titleEvent)
    {
        //
    }
}
