<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // AÑADIDOS PARA CAMBIAR CONTRASEÑAS
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $user = $this->guard()->getProvider()->retrieveByCredentials($credentials);
    
        if ($user) {
            $storedPassword = $user->getAuthPassword();
    
            // Verificar si el hash almacenado es un hash Bcrypt
            if (strlen($storedPassword) === 60) {
                // Intentar la verificación con Bcrypt
                if (Hash::check($credentials['password'], $storedPassword)) {
                    $this->guard()->login($user, $request->filled('remember'));
                    return true;
                }
            } elseif (md5($credentials['password']) === $storedPassword) {
                // Hash MD5 coincidente, actualizar a Bcrypt
                $user->password = Hash::make($credentials['password']);
                $user->save();
                $this->guard()->login($user, $request->filled('remember'));
                return true;
            }
        }
    
        // Contraseña incorrecta o usuario no encontrado
        return false;
    }
    
    
    

    /**
     * Verifica la contraseña del usuario.
     *
     * @param string $plainPassword
     * @param string $hashedPassword
     * @return bool
     */
    private function miMetodoDeVerificacion($plainPassword, $hashedPassword)
    {
        // Aquí implementas tu lógica de verificación. 
        // Por ejemplo, si las contraseñas están en MD5 (no recomendado por seguridad):
        return md5($plainPassword) === $hashedPassword;
    }
    
}
