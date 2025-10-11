<?php

use App\Http\Controllers\ApproveReservationController;
use App\Http\Controllers\ClassromGuestController;
use App\Http\Controllers\DependencyProgramController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponsibleController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TitleEventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebServicePersonController;
use App\Http\Controllers\VerifyClassroomController;
use App\Http\Controllers\VerifyLaboratoryControlller;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use App\Models\TitleEvent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/auth.php';

// AUTHENTICATION
Route::middleware(['auth'])->group(function () {

    Route::prefix('/agenda')->group(function () { // Prefix agenda
        Route::get('/edit/protocolo/{id}', [EventController::class, 'editProtocolo'])->name('agenda.edit.protocolo')->middleware('permission:update event');
        Route::get('/edit/protocolo/all/{id}', [EventController::class, 'editProtocoloAll'])->name('agenda.edit.protocolo.all')->middleware('permission:update event');
        Route::get('/edit/cta/{id}', [EventController::class, 'editCTA'])->name('agenda.edit.cta')->middleware('permission:update reserve classroom');
        Route::get('/edit/cta/all/{id}', [EventController::class, 'editCTAAll'])->name('agenda.edit.cta.all')->middleware('permission:update reserve classroom');
        Route::put('/update/protocolo/{id}', [EventController::class, 'updateProtocolo'])->name('agenda.update.protocolo')->middleware('permission:update event');
        Route::put('/update/cta/{id}', [EventController::class, 'updateCTA'])->name('agenda.update.cta')->middleware('permission:update reserve classroom');
        Route::put('/update/protocolo/all/{id}', [EventController::class, 'updateProtocoloAll'])->name('agenda.update.protocolo.all')->middleware('permission:update event');
        Route::put('/update/cta/all/{id}', [EventController::class, 'updateCTAAll'])->name('agenda.update.cta.all')->middleware('permission:update reserve classroom');
        Route::delete('/delete/{id}', [EventController::class, 'destroy'])->name('agenda.delete');
        Route::delete('/delete/all/{id}', [EventController::class, 'destroyAll'])->name('agenda.delete.all');

        // Permission for create event and reserve classroom
        Route::get('/create/{group_id}', [EventController::class, 'createSuperAdmin'])->name('agenda.create.superadmin')->middleware('permission:reserve classroom|create event');
        Route::get('/create', [EventController::class, 'create'])->name('agenda.create');
 
        // Store events and classroms
        Route::post('/store/protocolo', [EventController::class, 'storeProtocolo'])->name('agenda.store.protocolo')->middleware('permission:create event');
        Route::post('/store/cta', [EventController::class, 'storeCTA'])->name('agenda.store.cta')->middleware('permission:reserve classroom');

        // Aprove and deny events
        // Route::get('/approve',[ApproveReservationController::class,'index'])->name('agenda.approve.index');
        // Route::get('/approve/all/get',[ApproveReservationController::class,'getReservations'])->name('agenda.approve.get.all')->middleware('permission:approve reserve');
        // Route::post('/approve/{id}', [ApproveReservationController::class, 'approveReservation'])->name('agenda.approve')->middleware('permission:approve event');

        // Get events types
        Route::group(['middleware' => ['permission:view event type']], function () {
            Route::get('/event-types', [EventTypeController::class, 'index'])->name('agenda.event-types.index');
            Route::get('/event-types/getEventTypes', [EventTypeController::class, 'getEventTypes'])->name('agenda.event-types.getEventTypes');
        });

        // Update and store events type
        Route::post('/event-types/update', [EventTypeController::class, 'update'])->name('agenda.event-types.update')->middleware('permission:update event type');
        Route::post('/event-types/store', [EventTypeController::class, 'store'])->name('agenda.event-types.store')->middleware('permission:create event type');

        // Rende view list dependencies
        Route::group(['middleware' => ['permission:view dependency']], function () {
            Route::get('/dependencies', [DependencyProgramController::class, 'index'])->name('agenda.dependencies.index');
            Route::get('/dependencies/getDependencies', [DependencyProgramController::class, 'getDependencies'])->name('agenda.dependencies.getDependencies');
        });

        // Update and store dependencies
        Route::post('/dependencies/update', [DependencyProgramController::class, 'update'])->name('agenda.dependencies.update')->middleware('permission:update dependency');
        Route::post('/dependencies/store', [DependencyProgramController::class, 'store'])->name('agenda.dependencies.store')->middleware('permission:create dependency');

        Route::prefix('/places')->group(function () {

            Route::group(['middleware' => ['permission:view place']], function () {
                Route::get('/', [PlaceController::class, 'index'])->name('agenda.places.index');
                Route::get('/getPlaces', [PlaceController::class, 'getPlaces'])->name('agenda.places.getPlaces');
            });

            Route::post('/update', [PlaceController::class, 'update'])->name('agenda.places.update')->middleware('permission:update place');
            Route::post('/store', [PlaceController::class, 'store'])->name('agenda.places.store')->middleware('permission:create place');
        });

        Route::get(
            '/confirm-classroom',
            [VerifyClassroomController::class, 'index']
        )->name('agenda.confirm-classroom.index')->middleware('permission:approve reserve');
     
        Route::get(
            '/confirm-laboratory',
            [VerifyLaboratoryControlller::class, 'index']
        )->name('agenda.confirm-laboratory.index')->middleware('permission:approve laboratory');
     

        Route::post('/allow-classroom', [VerifyClassroomController::class, 'ConfirmClassroom'])->name('agenda.confirm')->middleware('permission:approve reserve');
        Route::post('/deny-classroom', [VerifyClassroomController::class, 'denyClassroom'])->name('agenda.deny')->middleware('permission:approve reserve');
        
        Route::post('/allow-laboratory', [VerifyLaboratoryControlller::class, 'ConfirmLaboratory'])->name('agenda.confirm.lab')->middleware('permission:approve laboratory');
        Route::post('/deny-laboratory', [VerifyLaboratoryControlller::class, 'denyLaboratory'])->name('agenda.deny.lab')->middleware('permission:approve laboratory');


        // Route::get('/event-types/getEventTypes', [EventTypeController::class, 'getEventTypes'])->name('agenda.event-types.getEventTypes');
        // Route::get('/dependencies/getDependencies', [DependencyProgramController::class, 'getDependencies'])->name('agenda.dependencies.getDependencies');

        Route::get('/api/getPerson/{code}/{type}', [WebServicePersonController::class, 'getPersonWebService'])->name('agenda.api.update');
        Route::get('/api/get-permission/{role}/{group?}', [PermissionController::class, 'getPermissionByRole'])->name('agenda.api.permission.admin');


        Route::post('/responsible/store', [ResponsibleController::class, 'store'])->name('agenda.api.responsible.store');
        Route::post('/title/store', [TitleEventController::class, 'store'])->name('agenda.api.title.store');

        Route::prefix('/profile')->group(function () {

            Route::get('/', [ProfileController::class, 'index'])->name('agenda.profile.index');
            Route::post('/verify_pass', [ProfileController::class, 'check_Password'])->name('agenda.profile.passwordcheck');
            Route::post('/change_password', [ProfileController::class, 'update_password'])->name('agenda.profile.update');
        });


        Route::prefix('/statistics')->group(function () {

            Route::get('/events', [StatisticsController::class, 'eventsStatistics'])->name('agenda.statistics.events');
            Route::get('/events-get-data', [StatisticsController::class, 'getdata_protocolo'])->name('agenda.statistics.getdata');
            
            Route::get('/classrooms', [StatisticsController::class, 'classroomsStatistics'])->name('agenda.statistics.classrooms');
            Route::get('/events-get-data-cta', [StatisticsController::class, 'getdata_cta'])->name('agenda.statistics.getdata.cta');
            Route::get('/events-cta-complete', [StatisticsController::class, 'get_data_cta_complete'])->name('agenda.statistics.getdata.cta.complete');
      
            Route::get('/laboratory', [StatisticsController::class, 'laboratoryStatistics'])->name('agenda.statistics.laboratory');
             Route::get('/events-get-data-labs', [StatisticsController::class, 'getdata_labs'])->name('agenda.statistics.getdata.laboratory');
            Route::get('/events-labs-complete', [StatisticsController::class, 'get_data_labs_complete'])->name('agenda.statistics.getdata.labs.complete');
      
        });
    });

    /* Manage Users */
    Route::prefix('/users')->group(function () {

        Route::group(['middleware' => ['permission:view user']], function () {
            // Users
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            // Get users
            Route::get('/getUsers', [UserController::class, 'getUsers'])->name('users.getUsers');
        });

        Route::group(['middleware' => ['permission:create user']], function () {
            // Create user
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/store', [UserController::class, 'store'])->name('users.create.store');
        });

        Route::group(['middleware' => ['permission:update user']], function () {
            // Update users
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::patch('/update/{id}', [UserController::class, 'update'])->name('users.update');
        });

        // Reset password
        Route::get('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('users.reset-password')->middleware('permission:reset password');

        // Delete user
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.delete')->middleware('permission:delete user');
    });  // Prefix users




});





Route::get('/', function () {
    return redirect()->route('agenda.index');
});


// routes GUEST
Route::prefix('/agenda')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('agenda.index');

    Route::prefix('/guest')->group(function () {
        Route::get('/get-events', [EventController::class, 'getEventsGuest'])->name('agenda.guest.getEvents');
        Route::get('/{type_events}', [EventController::class, 'indexGuest'])->name('agenda.guest.index');

        // Create guest event
        Route::get('/{type_events}/create', [ClassromGuestController::class, 'create'])->name('agenda.guest.classrom.create');
        Route::post('/{type_events}/store', [ClassromGuestController::class, 'store'])->name('agenda.guest.classrom.store');
    });

    Route::get('/get-event/{id}', [EventController::class, 'getEvent'])->name('agenda.get-event');

    Route::middleware(['auth'])->group(function () {
        Route::get('/get-events', [EventController::class, 'getEvents'])->name('agenda.get-events');
    });

    //Route::get('/edit/{id}', [EventController::class, 'edit'])->name('agenda.edit')->middleware('permission:update event');

    // Permission for create event and reserve classroom
    Route::group(['middleware' => ['permission:create event,reserve classroom']], function () {
        Route::get('/create/{group_id}', [EventController::class, 'createSuperAdmin'])->name('agenda.create.superadmin');
    });


    // Store events and classroms
    Route::post('/store/protocolo', [EventController::class, 'storeProtocolo'])->name('agenda.store.protocolo')->middleware('permission:create event');
    Route::post('/store/cta', [EventController::class, 'storeCTA'])->name('agenda.store.cta')->middleware('permission:reserve classroom');
    Route::post('/store/laboratory', [EventController::class, 'storeLAB'])->name('agenda.store.laboratory')->middleware('permission:reserve laboratory');

    Route::get('/api/getPerson/{code}/{type}', [WebServicePersonController::class, 'getPersonWebService'])->name('agenda.api.update');
    Route::get('/api/getPerson/{code}/{type}', [WebServicePersonController::class, 'getPersonWebService'])->name('agenda.api.update');
    Route::get('/api/get-permission/{role}', [PermissionController::class, 'getPermissionByRole'])->name('agenda.api.permission');

    Route::get('/api/get-titles/search={query}&group={groupId}', [TitleEventController::class, 'getConcurrentTitles'])->name('agenda.api.titles');
    Route::get('/api/get-responsibles/search={query}&group={groupId}', [ResponsibleController::class, 'getCurrentResponsibles'])->name('agenda.api.responsibles');
});
