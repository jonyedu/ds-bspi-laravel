<?php

namespace App\Http\Controllers\GestionHospitalaria\ConsultaExtena;

use App\GestionHospitalaria\AdministracionDeCitas\Cita;
use App\GestionHospitalaria\ConsultaExtena\Antecedente;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntecedenteApiController extends Controller
{
    //***************MOTIVO ANTECEDENTE *****************// y 
    //Funcion para cargar de la tabla antecedentes*/
    public function cargarMotivoAntecedente($idCita)
    {
        if ($idCita !== '' && isset($idCita)) {
            try {
                $antecedente = new AntecedenteApiController();
                $userId = $antecedente->obtenerUserId($idCita);

                $motivoAntecedente = Antecedente::where('USER_ID', $userId->USER_ID)
                ->where('ANTECEDENTE_LOGIC_ESTADO', 'A')
                ->where('CITA_COD', $idCita)->first();
                return  response()->json(['motivoAntecedente' => $motivoAntecedente], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "No Existe Citas"], 500);
        }
    }
    /*Funcion para guardar o modificar a la tabla antecedentes*/
    public function guardarModificarMotivoAntecedente(Request $request, $idCita)
    {
        try {
            $user = Auth::user();
            $antecedente = new AntecedenteApiController();
            $userId = $antecedente->obtenerUserId($idCita);
            Antecedente::UpdateOrCreate(
                [
                    'USER_ID' => $userId->USER_ID,
                    'CITA_COD' => $idCita,
                    'ANTECEDENTE_LOGIC_ESTADO' => 'A',
                ],
                [
                    'USER_ID' => $userId->USER_ID,
                    'CITA_COD' => $idCita,
                    'ANTECEDENTE_MOTIVO_CONSULTA' => $request->input('frm_motivo_consulta'),
                    'ANTECEDENTE_PERSONALES' => $request->input('frm_antecedentePersonal'),
                    'ANTECEDENTE_CARDIOPATIA' => $request->input('frm_cardiopatia'),
                    'ANTECEDENTE_TUBERCULOSIS' => $request->input('frm_tuberculosi'),
                    'ANTECEDENTE_DIABETES' => $request->input('frm_diabete'),
                    'ANTECEDENTE_ENFC_VASCULAR' => $request->input('frm_enfVascular'),
                    'ANTECEDENTE_HIPERTENSION' => $request->input('frm_hipertension'),
                    'ANTECEDENTE_CANCER' => $request->input('frm_cancer'),
                    'ANTECEDENTE_ENFMENTAL' => $request->input('frm_enfMental'),
                    'ANTECEDENTE_ENFINFECCIOSA' => $request->input('frm_enfInfecciosa'),
                    'ANTECEDENTE_MALFORMACION' => $request->input('frm_malfomacion'),
                    'ANTECEDENTE_OTRA' => $request->input('frm_otro'),
                    'ANTECEDENTE_ENFERMEDAD_ACTUAL_PROBLEMA' => $request->input('frm_enfermedadActualProblema'),
                    'ANTECEDENTE_REVISION_ACTUAL_ORGANO_SISTEMA' => $request->input('frm_revisionActualOrganoSistema'),
                    'ANTECEDENTE_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    /*Borrar la funcion "guardarMotivoAntecedente" y "modificarMotivoAntecedente" 
    cuando se haya probado que esté funcionando bien la nueva funcion "guardarModificarMotivoAntecedente"*/ 
    /*Funcion para guardar a la tabla antecedentes*/
    public function guardarMotivoAntecedente(Request $request, $idCita)
    {
        try {
            $user = Auth::user();
            $antecedente = new AntecedenteApiController();
            $userId = $antecedente->obtenerUserId($idCita);
            Antecedente::Create(
                [
                    'USER_ID' => $userId->USER_ID,
                    'CITA_COD' => $idCita,
                    'ANTECEDENTE_MOTIVO_CONSULTA' => $request->input('frm_motivo_consulta'),
                    'ANTECEDENTE_PERSONALES' => $request->input('frm_antecedentePersonal'),
                    'ANTECEDENTE_CARDIOPATIA' => $request->input('frm_cardiopatia'),
                    'ANTECEDENTE_TUBERCULOSIS' => $request->input('frm_tuberculosi'),
                    'ANTECEDENTE_DIABETES' => $request->input('frm_diabete'),
                    'ANTECEDENTE_ENFC_VASCULAR' => $request->input('frm_enfVascular'),
                    'ANTECEDENTE_HIPERTENSION' => $request->input('frm_hipertension'),
                    'ANTECEDENTE_CANCER' => $request->input('frm_cancer'),
                    'ANTECEDENTE_ENFMENTAL' => $request->input('frm_enfMental'),
                    'ANTECEDENTE_ENFINFECCIOSA' => $request->input('frm_enfInfecciosa'),
                    'ANTECEDENTE_MALFORMACION' => $request->input('frm_malfomacion'),
                    'ANTECEDENTE_OTRA' => $request->input('frm_otro'),
                    'ANTECEDENTE_ENFERMEDAD_ACTUAL_PROBLEMA' => $request->input('frm_enfermedadActualProblema'),
                    'ANTECEDENTE_REVISION_ACTUAL_ORGANO_SISTEMA' => $request->input('frm_revisionActualOrganoSistema'),
                    'ANTECEDENTE_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    /*Funcion para moficiar a la tabla antecedentes*/
    public function modificarMotivoAntecedente(Request $request, $idCita)
    {
        try {
            $user = Auth::user();
            $antecedente = new AntecedenteApiController();
            $userId = $antecedente->obtenerUserId($idCita);
            Antecedente::where('USER_ID', $userId->USER_ID)->where('CITA_COD', $idCita)
                ->update(
                    [
                        'ANTECEDENTE_MOTIVO_CONSULTA' => $request->input('frm_motivo_consulta'),
                        'ANTECEDENTE_PERSONALES' => $request->input('frm_antecedentePersonal'),
                        'ANTECEDENTE_CARDIOPATIA' => $request->input('frm_cardiopatia'),
                        'ANTECEDENTE_TUBERCULOSIS' => $request->input('frm_tuberculosi'),
                        'ANTECEDENTE_DIABETES' => $request->input('frm_diabete'),
                        'ANTECEDENTE_ENFC_VASCULAR' => $request->input('frm_enfVascular'),
                        'ANTECEDENTE_HIPERTENSION' => $request->input('frm_hipertension'),
                        'ANTECEDENTE_CANCER' => $request->input('frm_cancer'),
                        'ANTECEDENTE_ENFMENTAL' => $request->input('frm_enfMental'),
                        'ANTECEDENTE_ENFINFECCIOSA' => $request->input('frm_enfInfecciosa'),
                        'ANTECEDENTE_MALFORMACION' => $request->input('frm_malfomacion'),
                        'ANTECEDENTE_OTRA' => $request->input('frm_otro'),
                        'ANTECEDENTE_ENFERMEDAD_ACTUAL_PROBLEMA' => $request->input('frm_enfermedadActualProblema'),
                        'ANTECEDENTE_REVISION_ACTUAL_ORGANO_SISTEMA' => $request->input('frm_revisionActualOrganoSistema'),
                        'ANTECEDENTE_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    //Funcion para obtener el USER_ID desde la tabla cita, con el idCita
    public function obtenerUserId($idCita)
    {
        if ($idCita !== '' && isset($idCita)) {
            $idUser = Cita::where('CITA_COD', $idCita)->first();
            return $idUser;
        }
    }
}
