<?php

namespace App\Http\Controllers\GestionHospitalaria\ConsultaExtena;

use App\GestionHospitalaria\ConsultaExtena\ExamenFisico;
use App\Http\Controllers\Controller;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade as PDF;

class ExamenFisicoApiController extends Controller
{
    //***************EXAMEN FISICO *****************//
    /*Funcion para mostrar de la tabla examenes_fisicos*/
    public function cargarExamenFisico($idCita)
    {
        if ($idCita !== '' && isset($idCita)) {
            try {
                $examenFisico = ExamenFisico::where('CITA_COD', $idCita)->first();
                return  response()->json(['examenFisico' => $examenFisico], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "No Existe Citas"], 500);
        }
        //Se hace select a la tabla organizaciones.

    }
    /*Funcion para guardar o modificar a la tabla examenes_fisicos*/
    public function guardarModificarExamenFisico(Request $request, $idCita)
    {
        $antecedente = new ExamenFisicoApiController();
        $msg = $antecedente->validarFrmExamenFisico($request);
        try {
            if ($msg != null) {
                return $antecedente->validarFrmExamenFisico($request);
            } else {
                $user = Auth::user();
                ExamenFisico::updateOrCreate(
                    [
                        'CITA_COD' => $idCita,
                        'EXAMENFISICO_LOGIC_ESTADO' => 'A',
                    ],
                    [
                        'CITA_COD' => $idCita,
                        'EXAMENFISICO_CABEZA_CP' => $request->input('EXAMENFISICO_CABEZA_CP'),
                        'EXAMENFISICO_CABEZA_SP' => $request->input('EXAMENFISICO_CABEZA_SP'),
                        'EXAMENFISICO_CABEZA_CP_DESCRIPCION' => $request->input('EXAMENFISICO_CABEZA_CP_DESCRIPCION'),
                        'EXAMENFISICO_CUELLO_CP' => $request->input('EXAMENFISICO_CUELLO_CP'),
                        'EXAMENFISICO_CUELLO_SP' => $request->input('EXAMENFISICO_CUELLO_SP'),
                        'EXAMENFISICO_CUELLO_CP_DESCRIPCION' => $request->input('EXAMENFISICO_CUELLO_CP_DESCRIPCION'),
                        'EXAMENFISICO_TORAX_CP' => $request->input('EXAMENFISICO_TORAX_CP'),
                        'EXAMENFISICO_TORAX_SP' => $request->input('EXAMENFISICO_TORAX_SP'),
                        'EXAMENFISICO_TORAX_CP_DESCRIPCION' => $request->input('EXAMENFISICO_TORAX_CP_DESCRIPCION'),
                        'EXAMENFISICO_ABDOMEN_CP' => $request->input('EXAMENFISICO_ABDOMEN_CP'),
                        'EXAMENFISICO_ABDOMEN_SP' => $request->input('EXAMENFISICO_ABDOMEN_SP'),
                        'EXAMENFISICO_ABDOMEN_CP_DESCRIPCION' => $request->input('EXAMENFISICO_ABDOMEN_CP_DESCRIPCION'),
                        'EXAMENFISICO_PELVIS_CP' => $request->input('EXAMENFISICO_PELVIS_CP'),
                        'EXAMENFISICO_PELVIS_SP' => $request->input('EXAMENFISICO_PELVIS_SP'),
                        'EXAMENFISICO_PELVIS_CP_DESCRIPCION' => $request->input('EXAMENFISICO_PELVIS_CP_DESCRIPCION'),
                        'EXAMENFISICO_EXTREMIDADES_CP' => $request->input('EXAMENFISICO_EXTREMIDADES_CP'),
                        'EXAMENFISICO_EXTREMIDADES_SP' => $request->input('EXAMENFISICO_EXTREMIDADES_SP'),
                        'EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION' => $request->input('EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION'),
                        'EXAMENFISICO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
            }

            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    /*Funcion para validar el Formulario/Componente Examen_Fisico*/
    public function validarFrmExamenFisico(Request $request)
    {
        if (
            $request->input('EXAMENFISICO_CABEZA_CP') == 1 && ($request->input('EXAMENFISICO_CABEZA_CP_DESCRIPCION') == null || $request->input('EXAMENFISICO_CABEZA_CP_DESCRIPCION') == "")
        ) {
            return response()->json(['msg' => 'El campo descripción cabeza es requerido.'], 421);
        } else if (
            $request->input('EXAMENFISICO_CUELLO_CP') == 1 && ($request->input('EXAMENFISICO_CUELLO_CP_DESCRIPCION') == null || $request->input('EXAMENFISICO_CUELLO_CP_DESCRIPCION') == "")
        ) {
            return response()->json(['msg' => 'El campo descripción cuello es requerido.'], 421);
        } else if (
            $request->input('EXAMENFISICO_TORAX_CP') == 1 && ($request->input('EXAMENFISICO_TORAX_CP_DESCRIPCION') == null || $request->input('EXAMENFISICO_TORAX_CP_DESCRIPCION') == "")
        ) {
            return response()->json(['msg' => 'El campo descripción torax es requerido.'], 421);
        } else if (
            $request->input('EXAMENFISICO_ABDOMEN_CP') == 1 && ($request->input('EXAMENFISICO_ABDOMEN_CP_DESCRIPCION') == null || $request->input('EXAMENFISICO_ABDOMEN_CP_DESCRIPCION') == "")
        ) {
            return response()->json(['msg' => 'El campo descripción abdomen es requerido.'], 421);
        } else if (
            $request->input('EXAMENFISICO_PELVIS_CP') == 1 && ($request->input('EXAMENFISICO_PELVIS_CP_DESCRIPCION') == null || $request->input('EXAMENFISICO_PELVIS_CP_DESCRIPCION') == "")
        ) {
            return response()->json(['msg' => 'El campo descripción pelvis es requerido.'], 421);
        } else if (
            $request->input('EXAMENFISICO_EXTREMIDADES_CP') == 1 && ($request->input('EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION') == null || $request->input('EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION') == "")
        ) {
            return response()->json(['msg' => 'El campo descripción extremidades es requerido.'], 421);
        }
    }
}
