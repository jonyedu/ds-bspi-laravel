<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\Provincia;
use App\DatosGenerales\Usuarios\Cantones;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CantonesApiController extends Controller
{
    //

    public function cargarCantones()
    {

        try {
            $cantones = Cantones::where('CANTON_LOGIC_ESTADO', 'A')
                ->orderBy('CANTON_NOM', 'asc')->get();
            $provincias = Provincia::select('PROV_COD', 'PROV_NOM')
                ->where('PROVINCIA_ACTIVO', 'S')
                ->where('PROVINCIA_LOGIC_ESTADO', 'A')
                ->orderBy('PROV_NOM', 'asc')->get();
            return  response()->json(['provincias' => $provincias, 'cantones' => $cantones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function cargarCantonUltimoId()
    {
        $cantonID = Cantones::select('CANTON_COD')

            ->orderBy('CANTON_COD', 'desc')
            ->first();

        return $cantonID->CANTON_COD + 1;
    }

    public function guardarCantones(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:cantones,CANTON_NOM," . $estado . ",CANTON_LOGIC_ESTADO",
            'provincia_cod' => 'required|string|max:20',
            'activo' => 'required|string|max:2',
        ]);

        try {
            DB::beginTransaction();
            $id = $this->cargarCantonUltimoId();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Cantones::Create(
                [
                    'CANTON_COD' => $id,
                    'CANTON_NOM' => $request->input('nombre'),
                    'CANTON_ACTIVO' => $request->input('activo'),
                    'PROV_COD' => $request->input('provincia_cod'),
                    'CANTON_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'CANTON_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function modificarCantones(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' => 'required|string|max:250',
            'canton_cod' => 'required|string|max:20',
            'activo' => 'required|string|max:2',
        ]);

        try {
            DB::beginTransaction();
            $id = $request->input('canton_cod');
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Cantones::where('canton_cod', $id)->update(
                [

                    'CANTON_NOM' => $request->input('nombre'),
                    'CANTON_ACTIVO' => $request->input('activo'),
                    'PROV_COD' => $request->input('provincia_cod'),
                    'CANTON_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,

                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function eliminarCantones(Request $request)
    {
        $id = $request->input('canton_cod');

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Cantones::where('CANTON_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'CANTON_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id del canton  es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
