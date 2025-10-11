<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    public function index()
    {

        return view('profile.profile');
    }


    /*
        Funcion para verificar que la contraseña que se ingreso es la contraseña actual
    */
    function check_Password(Request $request)
    {

        try {

            // Errores en español 
            $messages = [
                'Pass.required' => 'El campo de contraseña es requerido',
                'Pass.max' => 'La contraseña excede los 13 caracteres',
            ];

            $data = Validator::make($request->all(), [
                'Pass' => 'required|string|max:13',
            ], $messages);

            // Retornar errores
            if ($data->fails()) {
                return response()->json(['type' => 0, 'errors' => $data->errors()], 404);
            }
            $pass = $request['Pass'];
            // Validamos que tengan la estructura
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=])(.{4,})$/', $pass)) {
                return response()->json(['msg' => '¡Error! La contraseña ingresada no cuenta con una estructura válida.'], 400);
            }

            // Verificamos si la contraseña coincide 
            if (Hash::check(
                $request['Pass'],
                auth()->user()->password
            )) {
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['msg' => 'La contraseña ingresada es incorrecta.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Ha ocurrido un error, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    function update_password(Request $request)
    {

        try {
            // Errores en español 
            $messages = [
                'Pass.required' => 'Hubo un error al recibir el dato en el servidor',
                'Pass.max' => 'La contraseña recibida excede los 13 caracteres',
            ];

            $data = Validator::make($request->all(), [
                'Pass' => 'required|string|max:13',
            ], $messages);
            // Retornamos errores 
            if ($data->fails()) {
                return response()->json(['type' => 0, 'errors' => $data->errors()], 404);
            }

            $pass = $request['Pass'];
            // Validamos que tengan la estructura
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=])(.{4,})$/', $pass)) {
                return response()->json(['msg' => '¡Error! La contraseña ingresada no cuenta con una estructura válida.'], 400);
            }

            // Cambiar contraseña 
            DB::transaction(
                function () use ($pass) {
                    $usuario = User::find(auth()->user()->id);
                    $usuario->password = Hash::make($pass);
                    $usuario->save();
                }
            );

            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Ha ocurrido un error, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
