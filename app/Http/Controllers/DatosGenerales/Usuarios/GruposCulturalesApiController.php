<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\GruposCulturales;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GruposCulturalesApiController extends Controller
{
    public function cargarGruposCulturales()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $grupos_culturales = GruposCulturales::where('GCULTURAL_LOGIC_ESTADO', 'A')->where('GCULTURAL_ACTIVO', 'S')->orderBy('GCULTURAL_NOM', 'asc')->get();
            return  response()->json(['grupos_culturales' => $grupos_culturales], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarGruposCulturalesTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $gruposCulturales = GruposCulturales::select('GCULTURAL_COD as codigo', 'GCULTURAL_NOM as nombre', 'GCULTURAL_ACTIVO as activo', 'GCULTURAL_OBS as observacion')->where('GCULTURAL_LOGIC_ESTADO', 'A')->orderBy('GCULTURAL_NOM', 'asc')->get();
            return  response()->json(['datos' => $gruposCulturales], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarGrupoCultural(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:grupos_culturales,GCULTURAL_NOM," . $estado . ",GCULTURAL_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            GruposCulturales::Create(
                [
                    'GCULTURAL_COD' => getNumeroAleatorio(),
                    'GCULTURAL_NOM' => $request->input('nombre'),
                    'GCULTURAL_ACTIVO' => $request->input('activo'),
                    'GCULTURAL_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GCULTURAL_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarGrupoCultural(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:250',
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            GruposCulturales::where('GCULTURAL_COD', $request->input('codigo'))->update([
                'GCULTURAL_ACTIVO' => $request->input('activo'),
                'GCULTURAL_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarGrupoCultural($id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                GruposCulturales::where('GCULTURAL_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GCULTURAL_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id del grupo cultural es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
