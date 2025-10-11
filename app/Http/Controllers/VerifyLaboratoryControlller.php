<?php

namespace App\Http\Controllers;


use App\Http\Requests\ApproveReservationRequest;
use Illuminate\Http\Request;
use App\Http\Requests\DenyReservationRequest;
use App\Mail\AcceptReservationMailable;
use App\Mail\DenyReservationMailable;
use App\Models\Date;
use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerifyLaboratoryControlller extends Controller
{
    public function index()
    {

        // Get events
        $events = Event::with(['group', 'date', 'place', 'date', 'cta', 'dependency_program', 'responsible', 'event_type'])
            ->whereHas('cta', function ($q) {
                $q->where('published', '=', 0);
            })->where('group_id', 4)
            ->get();


        return view('agenda.verify_laboratory', compact('events'));
    }


    public function denyLaboratory(DenyReservationRequest $request)
    {

        try {
            $event = Event::with(['cta', 'place', 'date', 'responsible'])->findOrFail($request->input('id'));

            DB::beginTransaction();
            $emal = $event->cta->email ?? null;

            // Mandar e correo 
            if($emal) {
                Mail::to($emal)->send(new DenyReservationMailable($event, $request->input('reason')));
            }

            $idDate = $event->date->id;
            $event->cta()->delete();
            $event->recursive_event()->delete();
            $event->delete();
            Date::find($idDate)->delete();

            DB::commit();

            return response()->noContent();
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json([
                'title' => '¡Error!',
                'message' => 'Ha ocurrido un error al eliminar la reservación del laboratorio, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function ConfirmLaboratory(ApproveReservationRequest $request)
    {

        try {

        
            $event = Event::with(['cta', 'place', 'date', 'responsible'])->findOrFail($request->input('id'));
            DB::beginTransaction();

            $event->cta->update([
                'published' => 1,   // publicada
                'updated_at' => now(),
            ]);
            $emal = $event->cta->email ?? null;

            // Mandar e correo 
            if ($emal) {
                Mail::to($emal)->send(new AcceptReservationMailable($event));
            }
 
            DB::commit();
            return response()->noContent();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => '¡Error!',
                'message' => 'Ha ocurrido un error al eliminar la reservación, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
