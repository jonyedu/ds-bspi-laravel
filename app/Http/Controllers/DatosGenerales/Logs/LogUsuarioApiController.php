<?php

namespace App\Http\Controllers\DatosGenerales\Logs;

use App\DatosGenerales\Logs\LogUsuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LogUsuarioApiController extends Controller
{
    public function cargarLogs()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $logs = LogUsuario::orderBy('created_at', 'desc')->get();
            return  response()->json(['logs' => $logs], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarLog(Request $request)
    {

        try {
            DB::beginTransaction();
            $user = Auth::user();
            LogUsuario::Create(
                [

                    'US_COD' => $user->US_COD,
                    'US_NOM' => $user->US_NOM,
                    'MODULO_NOM' => $request->input('modulo_nombre'),
                    'FORMULARIO_NOM' => $request->input('formulario_nombre'),
                    'ACCION' => $request->input('accion'),
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
