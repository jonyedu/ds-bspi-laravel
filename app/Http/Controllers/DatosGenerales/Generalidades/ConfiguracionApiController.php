<?php

namespace App\Http\Controllers\DatosGenerales\Generalidades;

use App\DatosGenerales\Generalidades\Configuracion;
use App\Http\Controllers\Controller;
use App\Rules\CedulaValidator;
use App\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfiguracionApiController extends Controller
{
    public function cargarConfiguracion()
    {
        //Se hace select a la tabla configuracion, para traer la más reciente.
        try {
            $configuracion = Configuracion::orderBy('CICLO_INICIAL', 'desc')->first();
            return  response()->json(['configuracion' => $configuracion], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarActualizarConfiguracion(Request $request)
    {
        $request->validate([
            'ciclo_inicial' => 'required|numeric',
            'ciclo_final' => 'required|numeric',
            'ciclo_activo' => 'required|numeric',
            'email_administrador' => 'required|string|email|max:50',
            'cedula_administrador' =>  ['required', 'string', 'min:10', 'max:13', new CedulaValidator],
            'intento_fallido' => 'required|numeric',
            'tiempo_bloqueo' => 'required|numeric',
            'meses_cambio_contrasena' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Configuracion::UpdateOrCreate(
                [
                    'SISTEMA' => $request->input('sistema'),
                ],
                [
                    'CICLO_INICIAL'  => $request->input('ciclo_inicial'),
                    'CICLO_FINAL' => $request->input('ciclo_final'),
                    'CICLO_ACTIVO' => $request->input('ciclo_activo'),
                    'ADMIN_EMAIL' => $request->input('email_administrador'),
                    'ADMIN_NCED' => $request->input('cedula_administrador'),
                    'INTENTO_FALLIDO' => $request->input('intento_fallido'),
                    'TIEMPO_BLOQUEO' => $request->input('tiempo_bloqueo'),
                    'TIEMPO_ACTUALIZACION_CLAVE' => $request->input('meses_cambio_contrasena'),
                    'USUARIO' => $user->US_COD,
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
