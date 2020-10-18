<?php

namespace App\Http\Controllers\DatosGenerales\Gestiones;

use App\DatosGenerales\Generalidades\GestionesYUsuario;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GestionesYUsuarioApiController extends Controller
{
    public function cargarGestionesYUsuario()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $gestionesYUsuarios = GestionesYUsuario::with('usuario')
                ->where('GESTIONUSUARIO_LOGIC_ESTADO', 'A')
                ->orderBy('GESTION_COD', 'asc')
                ->get();
            return  response()->json(['gestionesYUsuarios' => $gestionesYUsuarios], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarGestionYUsuario(Request $request)
    {

        $request->validate([
            'gestion' => 'required|string|max:20',
            'usuario' => 'required|string|max:10',
            'rol' => 'required|string|max:20',
            'activo' => 'required|string|max:1',
            'observacion' => 'string|nullable|max:250',
        ]);
        //SE VALIDA QUE UN USUARIO NO TENGA LA MISMA GESTION EN EL MISMO ROL GESTIONUSUARIO_LOGIC_ESTADO
        $gestionesYUsuarios = GestionesYUsuario::where('GESTION_COD', $request->input('gestion'))->where('US_COD', $request->input('usuario'))->where('USROL_COD', $request->input('rol'))->where('GESTIONUSUARIO_LOGIC_ESTADO', 'A')->first();
        if (isset($gestionesYUsuarios)) {
            return response()->json(['mensaje' => 'Se encontro un registro creado con los mismos parametros de gestión, usuario y rol'], 500);
        }
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            GestionesYUsuario::Create(
                [
                    'GESTION_COD' => $request->input('gestion'),
                    'US_COD' => $request->input('usuario'),
                    'USROL_COD' => $request->input('rol'),
                    'GESTIONUS_ACTIVO' => $request->input('activo'),
                    'GESTIONUS_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GESTIONUSUARIO_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarGestionYUsuario(Request $request)
    {
        $request->validate([
            'activo' => 'required|string|max:10',
            'observacion' => 'nullable|string|max:250',
            'ruta' => 'nullable|string|max:250'
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            GestionesYUsuario::where('GESTION_COD',  $request->input('gestion'))->where('USROL_COD',  $request->input('rol'))->where('US_COD',  $request->input('usuario'))->update([
                'GESTIONUS_ACTIVO' => $request->input('activo'),
                'GESTIONUS_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'FECHA' => $fecha,
                'HORA' => $time,
                'TIPO' => $user->TIPO,
                'USUARIO' => $user->US_COD,

            ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarGestionYUsuario($gestion, $rol, $usuario)
    {

        try {
            DB::beginTransaction();
            if ($gestion !== '' && isset($gestion) && $rol !== '' && isset($rol) && $usuario !== '' && isset($usuario)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                GestionesYUsuario::where('GESTION_COD', $gestion)->where('USROL_COD', $rol)->where('US_COD', $usuario)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GESTIONUSUARIO_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id de la gestión y el código rol,código usuario son requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
