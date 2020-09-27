<?php

namespace App\Http\Controllers\GestionHospitalaria\FormularioMSP;

use App\User;
use App\GestionHospitalaria\AdministracionDeCitas\Cita;
use App\GestionHospitalaria\AdministracionDeCitas\EstadoDeCita;

use App\Http\Controllers\Controller;
use Exception;
use Barryvdh\DomPDF\Facade as PDF;

class FormularioMPSApiController extends Controller
{
    public function cargarHistoriaClinicaTabla()
    {
        try {
            $formularioMSP = User::orderBy('US_HISTORIACLINICACOD', 'desc')
                ->where('USER_LOGIC_ESTADO', 'A')
                ->where('US_HISTORIACLINICACOD', "!=", "null")
                ->whereNotNull('US_HISTORIACLINICACOD')
                ->get();
            //Se procede a comprobar que los usuarios tengan por lo menos un estado de consulta externa o un estado de emergencia o hospitalizacion
            $usuarios = [];
            foreach ($formularioMSP as $key => $user) {
                $citasBd = Cita::where('user_id', $user->id)
                    ->where('CITA_LOGIC_ESTADO', 'A')->get()
                    ->map(function ($citas) {
                        return $citas->CITA_COD;
                    });
                $estados_cita_validos = EstadoDeCita::whereIn('CITA_COD', $citasBd)
                    ->whereIn('ESTADOCITA_TIPO',['E','C','H'])
                    ->get();
                $estados_cita_validos = $estados_cita_validos == null ? [] : $estados_cita_validos;
                if (count($estados_cita_validos) > 0) {
                    array_push($usuarios, $user);
                }
            }
            return  response()->json(['formularioMSP' => $usuarios], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    /*Funcion para mostrar los datos en el pdf Formulario MSP 002*/
    public function cargarPdfFormularioMsp002($idUser)
    {
        if ($idUser !== '' && isset($idUser)) {
            try {
                //Variables para retornar al pdf
                $cita = null;
                $citaArray = null;
                $antecedenteFamiliar = null;
                $examenFisico = null;
                $nombreArchivo = "No existen datos.pdf";
                
                //Creo un objeto de la clase FormularioMPSApiController, para llamar a sus metodos
                $formularioMSP = new FormularioMPSApiController;

                /*Para llenar la session: 0 ENCABEZADO, 1 MOTIVO DE CONSULTA, 2 ANTECEDENTES PERSONALES, 3 ANTECEDENTES FAMILIARES, 
                4 ENFERMEDAD O PROBLEMA ACTUAL, 5 REVISION ACTUAL DE ORGANOS Y SISTEMAS, 7 EXAMEN FISICO, 8 DIAGNOSTICOS
                9 PLANES DE DIAGNOSTICO, TERAPEUTICOS Y EDUCACIONALES, 10 PIE DE PAGINA */
                $cita = Cita::where('CITA_LOGIC_ESTADO', 'A')
                    ->where('USER_ID', $idUser)
                    ->orderBy('created_at', 'desc')
                    ->with('antecedente', 'examenFisico', 'diagnostico', 'paciente', 'estadosCita.doctor', 'estadosCita.especialidad.hospital')
                    ->with(['estadosCita' => function ($i) {
                        $i->where('ESTADOCITA_TIPO', 'C')->where('ESPECIALIDAD_COD', '!=', 'null');
                    }])
                    ->first();
                //return $cita;  
               
                /*Para llenar la session: 6 SIGNOS VITALES, 11 EVOLUCION Y PRESCRIPCIONES */
                 $citaArray = Cita::where('CITA_LOGIC_ESTADO', 'A')
                     ->where('USER_ID', $idUser)
                     ->orderBy('created_at', 'desc')
                     ->with( 'prescripcion.medico', 'prescripcion.prescripcionDetalle.productoDetalle.presentacionProducto.presentaciones', 'prescripcion.prescripcionDetalle.productoDetalle.presentacionProducto.productos','informacionInicial')
                     ->with(['estadosCita' => function ($i) {
                         $i->where('ESTADOCITA_TIPO', 'C')->where('ESPECIALIDAD_COD', '!=', 'null');
                     }])
                     ->take(8)
                     ->get();  
                // $citaArray = Cita::where('CITA_LOGIC_ESTADO', 'A')
                //     ->where('USER_ID', $idUser)
                //     ->orderBy('created_at', 'desc')
                //     ->with('prescripcion.medico')
                //     ->get();
                // return $citaArray;
                
                //Para concatenar el nombre del archivo
                if ($cita != null) {
                    if ($cita->paciente != null) {
                        $nombrePaciente = $cita->paciente->FULL_NAME;
                        $cedulaPaciente = $cita->paciente->FULL_IDENTIFICATION;
                        $fechaImpresion = date("Y-m-d H:i:s");
                        $nombreArchivo = $nombrePaciente . '-' . $cedulaPaciente . '-' . $fechaImpresion . '.pdf';
                    }
                }
                
                //Si no hay datos en cita o en citaArray retorna al pdf vacio
                if ($cita == null || $citaArray == null) {
                    $pdf = PDF::loadView(
                        'formularios-msp.formulario-msp-002-pdf',
                        [
                            'cita' => $cita,
                            'citaArray' => $citaArray,
                            'antecedenteFamiliar' => $antecedenteFamiliar,
                            'examenFisico' => $examenFisico
                        ]
                    );
                    return $pdf->stream($nombreArchivo);
                }
                //Si no hay datos en la tabla antecedente o en la tabla examenFisico
                else if ($cita->antecedente == null || $cita->examenFisico == null) {
                    
                    $pdf = PDF::loadView(
                        'formularios-msp.formulario-msp-002-pdf',
                        [
                            'cita' => $cita,
                            'citaArray' => $citaArray,
                            'antecedenteFamiliar' => $antecedenteFamiliar,
                            'examenFisico' => $examenFisico
                        ]
                    );
                    return $pdf->stream($nombreArchivo);
                } else {

                    $antecedenteFamiliar = $formularioMSP->armarAntecedenteFamiliar($cita->antecedente);
                    $examenFisico = $formularioMSP->armarExamenFisico($cita->examenFisico);
                  
                    $pdf = PDF::loadView('formularios-msp.formulario-msp-002-pdf', [
                        'cita' => $cita,
                        'citaArray' => $citaArray,
                        'antecedenteFamiliar' => $antecedenteFamiliar,
                        'examenFisico' => $examenFisico
                    ]);
                    return $pdf->stream($nombreArchivo);
                }
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "El Codigo del Usuario, no Existe"], 500);
        }
    }
    public function armarAntecedenteFamiliar($motivoAntecedente)
    {
        //Variables para guardar los datos de los antecedentes familiares

        $cardiopatia = "NO";
        $diabetes = "NO";
        $enfCVascular = "NO";
        $hipertension = "NO";
        $cancer = "NO";
        $tuberculosis = "NO";
        $enfMental = "NO";
        $enfInfecciosa = "NO";
        $malfomación = "NO";
        $otro = "NO";
        if($motivoAntecedente!=null){
            if ($motivoAntecedente->ANTECEDENTE_CARDIOPATIA == 1) {
                $cardiopatia = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_TUBERCULOSIS == 1) {
                $tuberculosis = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_DIABETES == 1) {
                $diabetes = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_ENFC_VASCULAR == 1) {
                $enfCVascular = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_HIPERTENSION == 1) {
                $hipertension = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_CANCER == 1) {
                $cancer = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_ENFMENTAL == 1) {
                $enfMental = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_ENFINFECCIOSA == 1) {
                $enfInfecciosa = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_MALFORMACION == 1) {
                $malfomación = "SI";
            }
            if ($motivoAntecedente->ANTECEDENTE_OTRA == 1) {
                $otro = "SI";
            }
        }
        

        return 'Cardiopatia: ' . $cardiopatia . ',' .
            ' Diabetes: ' . $diabetes . ',' .
            ' Enfermedades Cardio Vascular: ' . $enfCVascular . ',' .
            ' Hipertension: ' . $hipertension . ',' .
            ' Cancer: ' . $cancer . ',' .
            ' Tuberculosis: ' . $tuberculosis . ',' .
            ' Enfermedades Mental: ' . $enfMental . ',' .
            ' Enfermedades Infecciosa: ' . $enfInfecciosa . ',' .
            ' Mal Fomación:' . $malfomación . ',' .
            ' Otro: ' . $otro;
    }
    public function armarExamenFisico($examenFisico)
    {
        //Variables para guardar los datos de los antecedentes familiares
        $cabeza = "SP";
        $cabezaDescripcion = "No";
        $cuello = "SP";
        $cuelloDescripcion = "No";
        $torax = "SP";
        $toraxDescripcion = "No";
        $abdomen = "SP";
        $abdomenDescripcion = "No";
        $pelvis = "SP";
        $pelvisDescripcion = "No";
        $extremides = "SP";
        $extremidesDescripcion = "No";
        if($examenFisico!=null){
            if ($examenFisico->EXAMENFISICO_CABEZA_CP == 1) {
                $cabeza = "CP";
                $cabezaDescripcion = $examenFisico->EXAMENFISICO_CABEZA_CP_DESCRIPCION;
            }
            if ($examenFisico->EXAMENFISICO_CUELLO_CP == 1) {
                $cuello = "CP";
                $cuelloDescripcion = $examenFisico->EXAMENFISICO_CUELLO_CP_DESCRIPCION;
            }
            if ($examenFisico->EXAMENFISICO_TORAX_CP == 1) {
                $torax = "CP";
                $toraxDescripcion = $examenFisico->EXAMENFISICO_TORAX_CP_DESCRIPCION;
            }
            if ($examenFisico->EXAMENFISICO_ABDOMEN_CP == 1) {
                $abdomen = "CP";
                $abdomenDescripcion = $examenFisico->EXAMENFISICO_ABDOMEN_CP_DESCRIPCION;
            }
            if ($examenFisico->EXAMENFISICO_PELVIS_CP == 1) {
                $pelvis = "CP";
                $pelvisDescripcion = $examenFisico->EXAMENFISICO_PELVIS_CP_DESCRIPCION;
            }
            if ($examenFisico->EXAMENFISICO_EXTREMIDADES_CP == 1) {
                $extremides = "CP";
                $extremidesDescripcion = $examenFisico->EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION;
            }
        }
       

        return 'Cabeza: ' . $cabeza . ',' .
            ' Descripcion de Cabeza: ' . $cabezaDescripcion . ',' .
            ' Cuello: ' . $cuello . ',' .
            ' Descripcion de Cuello: ' . $cuelloDescripcion . ',' .
            ' Torax: ' . $torax . ',' .
            ' Descripcion de Torax: ' . $toraxDescripcion . ',' .
            ' Abdomen: ' . $abdomen . ',' .
            ' Descripcion de Abdomen: ' . $abdomenDescripcion . ',' .
            ' Pelvis:' . $pelvis . ',' .
            ' Descripcion de Pelvis: ' . $pelvisDescripcion . ',' .
            ' Extremides:' . $extremides . ',' .
            ' Descripcion de Extremides: ' . $extremidesDescripcion;
    }
}
