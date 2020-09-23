<?php

namespace App\Http\Controllers\DatosGenerales\Gestiones;

use App\DatosGenerales\Generalidades\GestionesYUsuario;
use App\DatosGenerales\Gestiones\Gestiones;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GestionesApiController extends Controller
{
    public function cargarGestiones()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $gestiones = Gestiones::where('GESTION_LOGIC_ESTADO', 'A')->orderBy('GESTION_NOM', 'asc')->get();
            return  response()->json(['gestiones' => $gestiones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarGestionesComboBox()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $gestiones = Gestiones::where('GESTION_LOGIC_ESTADO', 'A')->where('GESTION_ACTIVO', 'S')->orderBy('GESTION_NOM', 'asc')->get();
            return  response()->json(['gestiones' => $gestiones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarGestion(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'codigo' => 'required|string|max:20|unique:gestiones,GESTION_NOM,' . $estado . ",GESTION_LOGIC_ESTADO",
            'nombre' => 'required|string|max:250|unique:gestiones,GESTION_NOM,' . $estado . ",GESTION_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',
            'observacion' => 'string|nullable|max:250',
            'ruta' => 'required|nullable|string|max:250'
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Gestiones::Create(
                [
                    'GESTION_COD' => $request->input('codigo'),
                    'GESTION_NOM' => $request->input('nombre'),
                    'GESTION_ACTIVO' => $request->input('activo'),
                    'GESTION_RUTA' => is_null($request->input('ruta'))  ? '' : $request->input('ruta'),
                    'GESTION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GESTION_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarGestion(Request $request)
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
            Gestiones::where('GESTION_COD',  $request->input('codigo'))->update([
                'GESTION_ACTIVO' => $request->input('activo'),
                'GESTION_RUTA' => is_null($request->input('ruta'))  ? '' : $request->input('ruta'),
                'GESTION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarGestion($id)
    {

        try {
            if ($id !== '' && isset($id)) {
                DB::beginTransaction();
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Gestiones::where('GESTION_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GESTION_LOGIC_ESTADO' => 'I'
                ]);
                GestionesYUsuario::where('GESTION_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GESTIONUSUARIO_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id de la gestion es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
