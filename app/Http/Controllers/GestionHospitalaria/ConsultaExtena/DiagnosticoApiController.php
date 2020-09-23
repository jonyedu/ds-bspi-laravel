<?php

namespace App\Http\Controllers\GestionHospitalaria\ConsultaExtena;

use App\GestionHospitalaria\AdministracionDeCitas\Cie;
use App\GestionHospitalaria\ConsultaExtena\Diagnostico;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosticoApiController extends Controller
{  
    //***************DIAGNOSTICO *****************//
    public function cargarCieGrupos()
    {
        try {
            $grupos = Cie::where('CIE_NIVEL', 1)
                ->where('CIE_LOGIC_ESTADO', 'A')
                ->orderBy('CIE_CLAVE', 'desc')
                ->get();
            return  response()->json(['grupos' => $grupos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarCieSubGrupos($cie_padre_cod)
    {
        try {
            $subGrupos = Cie::where('CIE_NIVEL', 2)
                ->where('CIE_PADRE_COD', $cie_padre_cod)
                ->where('CIE_LOGIC_ESTADO', 'A')
                ->orderBy('CIE_CLAVE', 'desc')
                ->get();
            return  response()->json(['subGrupos' => $subGrupos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    /*Funcion para mostrar de la tabla cie*/
    public function cargarCieTabla($cie_hijo_cod)
    {
        try {
            $cie = Cie::where('CIE_PADRE_COD', $cie_hijo_cod)
                ->where('CIE_LOGIC_ESTADO', 'A')
                ->orderBy('CIE_DESCRIPCION', 'asc')
                ->get();
            return  response()->json(['cie' => $cie], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    /*Funcion para mostrar de la tabla diagnosticos*/
    public function cargarDiagnostico($idCita)
    {
        if ($idCita !== '' && isset($idCita)) {
            try {
                $diagnostico = Diagnostico::with('cie')
                    ->where('CITA_COD', $idCita)
                    ->orderBy('DIAGNOSTICO_COD', 'asc')
                    ->get();
                return  response()->json(['diagnostico' => $diagnostico], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "No Existe Citas"], 500);
        }
    }
    /*Funcion para guardar o moficiar a la tabla diagnosticos*/
    public function guardarModificarDiagnostico(Request $request, $idCita)
    {
        try {
            $user = Auth::user();
            if ($request->input('frm_idCie_principal') != null && $request->input('frm_idCie_uno') == null && $request->input('frm_idCie_dos') == null) {
                Diagnostico::updateOrCreate(
                    [
                        'CITA_COD' => $idCita, 
                        'CIE_COD' => $request->input('frm_idCie_principal_modif'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A'
                    ],
                    [
                        'CITA_COD' => $idCita,
                        'CIE_COD' => $request->input('frm_idCie_principal'),
                        'DIAGNOSTICO_PRESUNTIVO' => $request->input('frm_tipo_presuntivo_principal'),
                        'DIAGNOSTICO_DEFINITIVO' => $request->input('frm_tipo_definitivo_principal'),
                        'DIAGNOSTICO_PLAN' => $request->input('frm_plan'),
                        'DIAGNOSTICO_SIGNOS_SINTOMAS' => $request->input('frm_signo_sintoma'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
            } else if ($request->input('frm_idCie_principal') != null && $request->input('frm_idCie_uno') != null && $request->input('frm_idCie_dos') == null) {
                Diagnostico::updateOrCreate(
                    [
                        'CITA_COD' => $idCita, 
                        'CIE_COD' => $request->input('frm_idCie_principal_modif'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A'
                    ],
                    [
                        'CITA_COD' => $idCita,
                        'CIE_COD' => $request->input('frm_idCie_principal'),
                        'DIAGNOSTICO_PRESUNTIVO' => $request->input('frm_tipo_presuntivo_principal'),
                        'DIAGNOSTICO_DEFINITIVO' => $request->input('frm_tipo_definitivo_principal'),
                        'DIAGNOSTICO_PLAN' => $request->input('frm_plan'),
                        'DIAGNOSTICO_SIGNOS_SINTOMAS' => $request->input('frm_signo_sintoma'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                Diagnostico::updateOrCreate(
                    [
                        'CITA_COD' => $idCita, 
                        'CIE_COD' => $request->input('frm_idCie_uno_modif'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A'
                    ],
                    [
                        'CITA_COD' => $idCita,
                        'CIE_COD' => $request->input('frm_idCie_uno'),
                        'DIAGNOSTICO_PRESUNTIVO' => $request->input('frm_tipo_presuntivo_uno'),
                        'DIAGNOSTICO_DEFINITIVO' => $request->input('frm_tipo_definitivo_uno'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
            } else if ($request->input('frm_idCie_principal') != null && $request->input('frm_idCie_uno') != null && $request->input('frm_idCie_dos') != null) {
                Diagnostico::updateOrCreate(
                    [
                        'CITA_COD' => $idCita, 
                        'CIE_COD' => $request->input('frm_idCie_principal_modif'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A'
                    ],
                    [
                        'CITA_COD' => $idCita,
                        'CIE_COD' => $request->input('frm_idCie_principal'),
                        'DIAGNOSTICO_PRESUNTIVO' => $request->input('frm_tipo_presuntivo_principal'),
                        'DIAGNOSTICO_DEFINITIVO' => $request->input('frm_tipo_definitivo_principal'),
                        'DIAGNOSTICO_PLAN' => $request->input('frm_plan'),
                        'DIAGNOSTICO_SIGNOS_SINTOMAS' => $request->input('frm_signo_sintoma'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                Diagnostico::updateOrCreate(
                    [
                        'CITA_COD' => $idCita, 
                        'CIE_COD' => $request->input('frm_idCie_uno_modif'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A'
                    ],
                    [
                        'CITA_COD' => $idCita,
                        'CIE_COD' => $request->input('frm_idCie_uno'),
                        'DIAGNOSTICO_PRESUNTIVO' => $request->input('frm_tipo_presuntivo_uno'),
                        'DIAGNOSTICO_DEFINITIVO' => $request->input('frm_tipo_definitivo_uno'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                Diagnostico::updateOrCreate(
                    [
                        'CITA_COD' => $idCita, 
                        'CIE_COD' => $request->input('frm_idCie_dos_modif'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A'
                    ],
                    [
                        'CITA_COD' => $idCita,
                        'CIE_COD' => $request->input('frm_idCie_dos'),
                        'DIAGNOSTICO_PRESUNTIVO' => $request->input('frm_tipo_presuntivo_dos'),
                        'DIAGNOSTICO_DEFINITIVO' => $request->input('frm_tipo_definitivo_dos'),
                        'DIAGNOSTICO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
            }
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
