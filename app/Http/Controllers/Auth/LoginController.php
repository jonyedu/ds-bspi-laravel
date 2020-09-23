<?php

namespace App\Http\Controllers\Auth;

use App\DatosGenerales\Generalidades\Configuracion;
use App\Http\Controllers\Controller;
use App\DatosGenerales\Generalidades\IdentificacionesYUsuario;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $maxAttempts = 0; // Default is 5, # de Intentos Fallidos
    protected $decayMinutes = 0; // Default is 1, # de Tiempo en minutos
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

    //protected $redirectTo = 'LeonBecerra/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username()
    {
        return 'US_COD';
    }
    protected function credentials(Request $request)
    {
        $identificacion = $request->{$this->username()};
        $password = $request->input('password');
        $identificacionesUsuario = IdentificacionesYUsuario::where('USID_CODIGO', $identificacion)->where('IDENTIFICACIONESUSUARIO_LOGIC_ESTADO', 'A')->first();
        $user_cod = '';
        if (isset($identificacionesUsuario)) {
            $user = User::where('US_COD', $identificacionesUsuario->US_COD)->where('USER_LOGIC_ESTADO', 'A')->first();
            $user_cod = isset($user) ? $user->US_COD : '';
        }
        // return $request->only($this->username(), 'password');
        return ['US_COD' => $user_cod, 'password' => $password];
        //return $request->only($this->username(), 'password');
    }
    public function __construct()
    {
        $this->obtenerValor();
        $this->middleware('guest')->except('logout');
    }
    protected function redirectTo()
    {
        $prefijo = config('global.router_prefix');
        return $prefijo;
    }
    public function obtenerValor()
    {
        $configuracion = Configuracion::first();
        $this->maxAttempts = $configuracion->INTENTO_FALLIDO;
        $this->decayMinutes = $configuracion->TIEMPO_BLOQUEO;
    }
}
