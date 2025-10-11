<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Intentar autenticar con las credenciales
        $credentials = $request->only('user_name', 'password');

        if (Auth::attempt($credentials)) {
          
            $user = Auth::user();
            // Verifica si el usuario está activo (estado == 1)
            if ($user->status != 1) {
                // No está activo, invalidamos la sesión y lanzamos un error
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'user_name' => [trans('auth.inactive_account')],  // Error 
                ]);
            }

            // Si el usuario está activo, regenera la sesión y redirige
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Si las credenciales no son correctas, llama a la función de manejo de error
        $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(LoginRequest $request)
    {
        // Si no se pudo autenticar correctamente, lanza la excepción de validación
        throw ValidationException::withMessages([
            'user_name' => [trans('auth.failed')],
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

   
}

