<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use App\GestionHospitalaria\AdministracionDeFarmacia\HospitalFarmacia;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HospitalFarmaciaApiController extends Controller
{
    public function cargarAsociacionFarmaciaPorId($id)
    {
        try {
            $asociacionFarmaciaPorId = HospitalFarmacia::with('hospital', 'farmacia')
                ->where('HOSP_FARM_LOGIC_ESTADO', 'A')
                ->where('HOSPITAL_COD', $id)
                ->get();
            return  response()->json(['asociacionFarmaciaPorId' => $asociacionFarmaciaPorId], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarAsociacionFarmaciaTabla()
    {
        try {
            $asociacionFarmacia = HospitalFarmacia::orderBy('HOSP_FARM_COD', 'asc')
                ->with('hospital', 'farmacia')
                ->where('HOSP_FARM_LOGIC_ESTADO', 'A')
                ->get();
            return  response()->json(['asociacionFarmacia' => $asociacionFarmacia], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarAsociacionFarmacia(Request $request)
    {
        $request->validate([
            'frm_hospital_cod' =>  "required|numeric",
            'frm_farmacia_cod' =>  "required|numeric",
        ]);
        $hospital = HospitalFarmacia::where('HOSP_FARM_LOGIC_ESTADO', 'A')
            ->where('HOSPITAL_COD', $request->input('frm_hospital_cod'))
            ->where('FARMACIA_COD', $request->input('frm_farmacia_cod'))
            ->first();
        if ($hospital != null) {
            return response()->json(['msg' => 'Ya existen registros con el mismo Hospital y Farmacia'], 421);
        } else {
            try {
                $user = Auth::user();
                HospitalFarmacia::Create(
                    [
                        'HOSPITAL_COD' => $request->input('frm_hospital_cod'),
                        'FARMACIA_COD' => $request->input('frm_farmacia_cod'),
                        'HOSP_FARM_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                return response()->json(['msg' => 'OK'], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        }
    }
    public function modificarAsociacionFarmacia(Request $request)
    {
        $request->validate([
            'frm_hospital_cod' =>  "required|string",
            'frm_farmacia_cod' =>  "required|string",
        ]);
        $hospital = HospitalFarmacia::where('HOSP_FARM_LOGIC_ESTADO', 'A')
            ->where('HOSPITAL_COD', $request->input('frm_hospital_cod'))
            ->where('FARMACIA_COD', $request->input('frm_farmacia_cod'))
            ->whereNotIn('HOSP_FARM_COD', [$request->input('frm_hosp_farm_cod')])
            ->first();
        if ($hospital != null) {
            return response()->json(['msg' => 'Ya existen registros con el mismo Hospital y Farmacia'], 421);
        } else {
            try {
                $user = Auth::user();
                HospitalFarmacia::where('HOSP_FARM_COD', $request->input('frm_hosp_farm_cod'))->update([
                    'HOSPITAL_COD' => $request->input('frm_hospital_cod'),
                    'FARMACIA_COD' => $request->input('frm_farmacia_cod'),
                    'HOSP_FARM_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]);
                return response()->json(['msg' => 'OK'], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        }
    }
    public function eliminarAsociacionFarmacia(Request $request, $id)
    {
        try {
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                HospitalFarmacia::where('HOSP_FARM_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'HOSP_FARM_LOGIC_ESTADO' => 'I'
                ]);
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id del hospital es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
