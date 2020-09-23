<?php

namespace App\Http\Controllers\DatosGenerales\Generalidades;

use App\DatosGenerales\Generalidades\Organismos;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class OrganismosApiController extends Controller
{
    public function cargarOrganismos()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $organismos = Organismos::where('ORGANISMO_LOGIC_ESTADO', 'A')->with('pais', 'tipoOrganismo')->orderBy('ORG_NOM', 'asc')->get();
            return  response()->json(['organismos' => $organismos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarOrganismos(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:organismos,ORG_NOM," . $estado . ",ORGANISMO_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',
            'tipo_organismo' => 'nullable|string|max:20',
            'pais' => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Organismos::Create(
                [
                    'ORG_COD' => getNumeroAleatorio(),
                    'ORG_NOM'  => $request->input('nombre'),
                    'ORG_ACTIVO' => $request->input('activo'),
                    'TIPOORG_COD' => is_null($request->input('tipo_organismo')) ? '' : $request->input('tipo_organismo'),
                    'PAIS_COD' => is_null($request->input('pais')) ? '' : $request->input('pais'),
                    'ORG_DIR' => is_null($request->input('direccion')) ? '' : $request->input('direccion'),
                    'ORG_TELF' => is_null($request->input('telefono')) ? '' : $request->input('telefono'),
                    'ORG_CEL' => is_null($request->input('celular')) ? '' : $request->input('celular'),
                    'ORG_EMAIL' => is_null($request->input('email')) ? '' : $request->input('email'),
                    'ORG_WEB' => '',
                    'ORG_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'ORGANISMO_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarOrganismos(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:250',
            'activo' => 'required|string|max:10',
            'tipo_organismo' => 'nullable|string|max:20',
            'pais' => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Organismos::where('ORG_COD', $request->input('organismo_cod'))->update([
                'ORG_NOM'  => $request->input('nombre'),
                'ORG_ACTIVO' => $request->input('activo'),
                'ORG_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarOrganismos(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Organismos::where('ORG_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'ORGANISMO_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id deL organismo es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
