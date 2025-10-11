<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveReservationRequest;
use Illuminate\Http\Request;
use App\Http\Requests\DenyReservationRequest;
use App\Mail\AcceptReservationMailable;
use App\Mail\DenyReservationMailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Cta;
use App\Models\Date;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Exception;

class VerifyClassroomController extends Controller
{
  public function index()
  {

    // Get events
    $events = Event::with(['group', 'date', 'place', 'date', 'cta', 'dependency_program', 'responsible', 'event_type'])
      ->whereHas('cta', function ($q) {
        $q->where('published', '=', 0);
      })->get();


    return view('agenda.verify_classroom', compact('events'));
  }


  public function denyClassroom(DenyReservationRequest $request)
  {

    try {
      $event = Event::with(['cta', 'place', 'date', 'responsible'])->find($request->input('id'));

      DB::beginTransaction();
      $emal = $event->cta->email ?? null;

      // Mandar e correo 
      if ($emal) {
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
        'message' => 'Ha ocurrido un error al eliminar la reservación, por favor intente de nuevo.',
        'error' => $e->getMessage()
      ], 500);
    }
  }


  public function ConfirmClassroom(ApproveReservationRequest $request)
  {

    try {

      $id = $request->input('id');

      $event = Event::with(['cta', 'place', 'date', 'responsible'])->find($request->input('id'));


      DB::beginTransaction();

      $event->cta->update([
        'published' => 1,   // publicada
        'updated_at' => now(),
      ]);

      // Mandar e correo 
      Mail::to($event->cta->email)->send(new AcceptReservationMailable($event));

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

  /*
  Funcion para Extraer todos los datos de la reservaion, para enviarlas al correo 
*/
  public function getEventData($Id_Event)
  {

    $Data_email = Event::with(['group', 'date', 'place', 'cta', 'dependency_program', 'responsible', 'event_type'])
      ->find($Id_Event);

    if (!$Data_email) {
      throw new \Exception('El evento no fue encontrado.');
    }

    return [
      'Cta' => $Data_email->cta,
      'Place' => $Data_email->place,
      'Program' => $Data_email->dependency_program,
      'Responsible' => $Data_email->responsible,
      'Date' => $Data_email->date,
      'Event_type' => $Data_email->event_type,
      'email' => $Data_email->cta->email ?? null,
    ];
  }
}
