<?php

namespace App\Http\Controllers\DatosGenerales\Generalidades;

use App\DatosGenerales\Generalidades\Organismos;
use App\DatosGenerales\Generalidades\CargosEnOrganismo;
use App\User;
use App\DatosGenerales\Generalidades\OrganismosYContactos;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganismosYContactosApiController extends Controller
{
    public function cargarOrganismosYContactos()
    {
        //Se hace select a las tablas organismo, usuarios y cargo en organismo


        try {
            $users = User::select('US_COD', 'name', 'US_NOM','US_APELL')->where('US_ACTIVO', 'S')->where('USER_LOGIC_ESTADO', 'A')
                ->orderBy('name', 'asc')->get();
            $organismos = Organismos::select('ORG_COD', 'ORG_NOM')->where('ORG_ACTIVO', 'S')->where('ORGANISMO_LOGIC_ESTADO', 'A')
                ->orderBy('ORG_NOM', 'asc')->get();
            $cargos = CargosEnOrganismo::select('CARGOORG_COD', 'CARGOORG_NOM')->where('CARGOORG_ACTIVO', 'S')->where('CARGO_LOGIC_ESTADO', 'A')
                ->orderBy('CARGOORG_NOM', 'asc')->get();


            $organismosYContactos = OrganismosYContactos::where('ORG_Y_CON_LOGIC_ESTADO', 'A')
                ->join('organismos', 'organismos_y_contactos.ORG_COD', '=', 'organismos.ORG_COD')
                ->join('users', 'organismos_y_contactos.US_COD', '=', 'users.US_COD')
                ->join('cargos_en_organismos', 'organismos_y_contactos.CARGOORG_COD', '=', 'cargos_en_organismos.CARGOORG_COD')
                ->select(
                    'organismos.ORG_COD',
                    'organismos.ORG_NOM',
                    'users.US_COD',
                    'users.name',
                    'cargos_en_organismos.CARGOORG_COD',
                    'cargos_en_organismos.CARGOORG_NOM',
                    'ORGCONT_ACTIVO',
                    'ORGCONT_OBS'
                )
                ->get();


            return response()->json(['organismosYContactos' => $organismosYContactos, 'users' => $users, 'organismos' => $organismos, 'cargos' => $cargos]);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarOrganismosYContactos(Request $request)
    {
        $request->validate([
            'cargo_cod' => 'required|string|max:250',
            'activo' => 'required|string|max:10',
            'organismo_cod' => 'required|string|max:20',
            'usuario_cod' => 'required|string|max:20',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            OrganismosYContactos::Create(
                [
                    'ORG_COD' => $request->input('organismo_cod'),
                    'US_COD' => $request->input('usuario_cod'),
                    'CARGOORG_COD' => is_null($request->input('cargo_cod'))  ? '' : $request->input('cargo_cod'),
                    'ORGCONT_ACTIVO' => $request->input('activo'),
                    'ORGCONT_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'ORG_Y_CON_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarOrganismosYContactos(Request $request)
    {
        $request->validate([
            'cargo_cod' => 'required|string|max:250',
            'activo' => 'required|string|max:10',
            'organismo_cod' => 'string|max:20',
            'usuario_cod' => 'string|max:20',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            $organismo_cod = $request->input('organismo_cod');
            $cargo_cod = $request->input('cargo_cod');
            $usuario_cod = $request->input('usuario_cod');
            OrganismosYContactos::where('ORG_COD', $organismo_cod)
                ->where('CARGOORG_COD', $cargo_cod)
                ->where('US_COD', $usuario_cod)
                ->update([
                    'ORG_COD' => $request->input('organismo_cod'),
                    'US_COD' => $request->input('usuario_cod'),
                    'CARGOORG_COD' => is_null($request->input('cargo_cod'))  ? '' : $request->input('cargo_cod'),
                    'ORGCONT_ACTIVO' => $request->input('activo'),
                    'ORGCONT_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD
                ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarOrganismosYContactos(Request $request)
    {
        $organismo_cod = $request->input('organismo_cod');
        $cargo_cod = $request->input('cargo_cod');
        $usuario_cod = $request->input('usuario_cod');

        try {
            DB::beginTransaction();
            if (
                $organismo_cod !== '' && isset($organismo_cod)
                &&
                $cargo_cod !== '' && isset($cargo_cod)
                &&
                $usuario_cod !== '' && isset($usuario_cod)
            ) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                OrganismosYContactos::where('ORG_COD', $organismo_cod)
                    ->where('CARGOORG_COD', $cargo_cod)
                    ->where('US_COD', $usuario_cod)
                    ->update([
                        'FECHA' => $fecha,
                        'HORA' => $time,
                        'TIPO' => $user->TIPO,
                        'USUARIO' => $user->US_COD,
                        'ORG_Y_CON_LOGIC_ESTADO' => 'I'
                    ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'Todos los campos son requeridos'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
