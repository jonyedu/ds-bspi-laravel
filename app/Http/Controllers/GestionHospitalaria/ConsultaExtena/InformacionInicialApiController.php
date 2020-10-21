<?php

namespace App\Http\Controllers\GestionHospitalaria\ConsultaExtena;

use App\GestionHospitalaria\AdministracionDeCitas\Cita;
use App\GestionHospitalaria\ConsultaExtena\InformacionInicial;
use App\Http\Controllers\Controller;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade as PDF;

class InformacionInicialApiController extends Controller
{
    //***************SIGNOS VITALES *****************//
    /*Funcion para Cargar el detalle paciente en el Componente Signos Vitales*/
    public function cargarInformacionPaciente($idCita)
    {
        if ($idCita !== '' && isset($idCita)) {
            try {
                $cita = Cita::with('paciente.discapacidad', 'informacionInicial')
                    ->where('CITA_COD', $idCita)
                    ->where('CITA_LOGIC_ESTADO', 'A')
                    ->first();

                return  response()->json(['datos' => $cita], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "No Existe Citas"], 500);
        }
    }
    /*Funcion para guardar o moficiar a la tabla informacion_inicial*/
    public function guardarModificarSignoVital(Request $request, $idCita)
    {
        $request->validate([
            'temperatura' => 'required|numeric|min:0|max:40',
            'pulso' => 'required|numeric|min:60|max:90',
            'presion_arterial' => 'required|numeric|min:60|max:120',
            'respiracion' => 'numeric|max:30',
            'peso' => 'required|numeric|min:2.26|max:200',
            'estatura' => 'required|numeric|min:60|max:210',
            'superficie_corporal' => 'numeric',
        ]);
        try {
            $user = Auth::user();
            InformacionInicial::updateOrCreate(
                [
                    'CITA_COD' => $idCita,
                    'INFORMACIONINICIAL_COD' => $request->input('id_infomacion_inicial'),
                    'INFORMACIONINICIAL_LOGIC_ESTADO' => 'A',
                ],
                [
                    'INFORMACIONINICIAL_TEMPERATURA' => $request->input('temperatura'),
                    'INFORMACIONINICIAL_RESPIRACION' => $request->input('respiracion'),
                    'INFORMACIONINICIAL_TALLA' => $request->input('talla'),
                    'INFORMACIONINICIAL_PULSO' => $request->input('pulso'),
                    'INFORMACIONINICIAL_PESO' => $request->input('peso'),
                    'INFORMACIONINICIAL_PRESION_ARTERIAL' => $request->input('presion_arterial'),
                    'INFORMACIONINICIAL_ESTATURA' => $request->input('estatura'),
                    'INFORMACIONINICIAL_SUPERFICIE_CORPORAL' => $request->input('superficie_corporal'),
                    'INFORMACIONINICIAL_FECHA' => $request->input('fecha'),
                    'INFORMACIONINICIAL_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
