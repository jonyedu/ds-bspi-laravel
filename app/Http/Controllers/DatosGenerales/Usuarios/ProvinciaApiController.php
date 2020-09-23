<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\Provincia;
use App\DatosGenerales\Generalidades\Paises;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProvinciaApiController extends Controller
{
    //

    public function cargarProvincias()
    {

        try {
            $provincias = Provincia::where('PROVINCIA_LOGIC_ESTADO', 'A')
                ->orderBy('PROV_NOM', 'asc')->get();
            $paises = Paises::select('PAIS_COD', 'PAIS_NOM')
                ->where('PAIS_LOGIC_ESTADO', 'A')
                ->where('PAIS_ACTIVO', 'S')
                ->orderBy('PAIS_NOM', 'asc')->get();
            return  response()->json(['provincias' => $provincias, 'paises' => $paises], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function cargarProvinciaUltimoId()
    {
        $provinciaID = Provincia::select('PROV_COD')
            ->where('PROVINCIA_LOGIC_ESTADO', 'A')
            ->where('PROV_COD', '<>', 90)
            ->orderBy('PROV_COD', 'desc')
            ->first();
        if ($provinciaID->PROV_COD == 89) {
            return 91;
        } else {
            return $provinciaID->PROV_COD + 1;
        }
    }

    public function guardarProvincias(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:provincias,PROV_NOM," . $estado . ",PROVINCIA_LOGIC_ESTADO",
            'pais_cod' => 'required|string|max:20',
            'activo' => 'required|string|max:2',
        ]);

        try {
            DB::beginTransaction();
            $id = $this->cargarProvinciaUltimoId();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Provincia::Create(
                [
                    'PROV_COD' => $id,
                    'PROV_NOM' => $request->input('nombre'),
                    'PROV_ACTIVO' => $request->input('activo'),
                    'PAIS_COD' => $request->input('pais_cod'),
                    'PROV_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'MOVILIZACION_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function modificarProvincias(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' => 'required|string|max:250',
            'pais_cod' => 'required|string|max:20',
            'provincia_cod' => 'required|string|max:20',
            'activo' => 'required|string|max:2',
        ]);

        try {
            DB::beginTransaction();
            $id = $request->input('provincia_cod');
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Provincia::where('PROV_COD', $id)->update(
                [

                    'PROV_NOM' => $request->input('nombre'),
                    'PROV_ACTIVO' => $request->input('activo'),
                    'PAIS_COD' => $request->input('pais_cod'),
                    'PROV_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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

    public function eliminarProvincias(Request $request)
    {
        $id = $request->input('provincia_cod');

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Provincia::where('PROV_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'PROVINCIA_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id de la provincia  es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
