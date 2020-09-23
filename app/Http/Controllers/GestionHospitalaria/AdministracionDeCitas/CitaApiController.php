<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeCitas;

use App\GestionHospitalaria\AdministracionDeCitas\Antecedente;
use App\GestionHospitalaria\AdministracionDeCitas\Cita;
use App\GestionHospitalaria\AdministracionDeCitas\EstadoDeCita;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CitaApiController extends Controller
{
    public function cargarCitasDeUsuario($userId)
    {
        try {
            $citas = Cita::select('CITA_COD', 'created_at as FECHA_CITA')
                ->with('antecedente', 'estadosCita')
                ->where('USER_ID', $userId)
                ->where('CITA_LOGIC_ESTADO', 'A')
                ->orderBy('created_at', 'desc')
                ->get();
            foreach ($citas as $key => $cita) {
                $date = new DateTime($cita->FECHA_CITA);
                $cita->FECHA_CITA = $date->format('Y-m-d');
                $cita->MOTIVO_MOSTRAR = '';
                foreach ($cita->estadosCita as $key2 => $estado) {
                    if ($key2 == sizeof($cita->estadosCita) - 1) {
                        $cita->MOTIVO_MOSTRAR = $cita->MOTIVO_MOSTRAR . ' ' . EstadoDeCita::getEstadoCitaNomById($estado->ESTADOCITA_TIPO);
                    } else {
                        $cita->MOTIVO_MOSTRAR = $cita->MOTIVO_MOSTRAR . ' ' . EstadoDeCita::getEstadoCitaNomById($estado->ESTADOCITA_TIPO) . ', ';
                    }
                }
            }

            return  response()->json(['citas' => $citas], 200);
        } catch (Exception $e) {

            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function terminarCita($citaId)
    {
        try {
            $estado_cita = EstadoDeCita::where('CITA_COD', $citaId)->where('ESTADOCITA_TIPO', 'C')->first();
            $estado_cita->ESTADOCITA_LOGIC_ESTADO = 'T';
            $estado_cita->save();
            return  response()->json(['stauts' => 'Ok'], 200);
        } catch (Exception $e) {

            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarCitasTabla()
    {
        try {

            $citas = Cita::with('paciente', 'informacionInicial')
                ->where('CITA_LOGIC_ESTADO', 'A')
                ->orderBy('CITA_COD', 'DESC')
                ->get();
            $citasFinales = array();
            foreach ($citas as $key => $cita) {
                //Se procede a buscar las citas que solo tengan estado C->consulta externa
                $estadoCita = EstadoDeCita::with('doctor.user', 'especialidad')
                    ->where('CITA_COD', $cita->CITA_COD)
                    ->where('ESTADOCITA_LOGIC_ESTADO', 'A')
                    ->orderBy('ESTADOCITA_COD', 'DESC')
                    ->first();
                //Se comprueba que el ultimo estado sea de tipo 'C'
                if ($estadoCita != null) {
                    if ($estadoCita['ESTADOCITA_TIPO'] == 'C') {
                        $cita->estado_cita = $estadoCita;
                        array_push($citasFinales, $cita);
                    }
                }
            }

            return  response()->json(['datos' => $citasFinales], 200);
        } catch (Exception $e) {

            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function getPaciente($id)
    {
        try {

            $citas = Cita::where('CITA_COD', $id)
                ->where('CITA_LOGIC_ESTADO', 'A')
                ->orderBy('CITA_COD', 'DESC')
                ->first();



            return  response()->json(['paciente' => $citas->USER_ID], 200);
        } catch (Exception $e) {

            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarEmergenciasTabla()
    {
        try {

            $citas = Cita::with('paciente')->select('CITA_COD as codigo', 'USER_ID', 'CITA_LOGIC_ESTADO')
                ->where('CITA_LOGIC_ESTADO', 'A')
                ->orderBy('CITA_COD', 'desc')
                ->get();
            $citasFinales = array();
            foreach ($citas as $key => $cita) {
                //Se procede a buscar las citas que solo tengan estado E->Emergencia
                $estadoCita = EstadoDeCita::with('doctor.user', 'especialidad')->where('CITA_COD', $cita->codigo)->orderBy('ESTADOCITA_COD', 'DESC')->first();
                //Se comprueba que el ultimo estado sea de tipo 'E'
                if ($estadoCita['ESTADOCITA_TIPO'] == 'E') {
                    $cita->estado_cita = $estadoCita;
                    array_push($citasFinales, $cita);
                }
            }

            return  response()->json(['datos' => $citasFinales], 200);
        } catch (Exception $e) {

            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarConsultaEmergenciaHospitalizacionTabla()
    {
        //Carga las citas que esten en hospitalización, emergencia, hospitalización.
        try {

            $citas = Cita::with('paciente')->select('CITA_COD as codigo', 'USER_ID', 'CITA_LOGIC_ESTADO')
                ->where('CITA_LOGIC_ESTADO', 'A')
                ->orderBy('CITA_COD', 'desc')
                ->get();
            $citasFinales = array();
            foreach ($citas as $key => $cita) {
                //Se procede a buscar las citas que solo tengan estado C, H, E
                $estadoCita = EstadoDeCita::with('doctor.user', 'especialidad')->where('CITA_COD', $cita->codigo)->orderBy('ESTADOCITA_COD', 'DESC')->first();
                //Se comprueba que el ultimo estado sea de tipo 'C', 'H', 'E'
                if ($estadoCita['ESTADOCITA_TIPO'] == 'E'  || $estadoCita['ESTADOCITA_TIPO'] == 'C' || $estadoCita['ESTADOCITA_TIPO'] == 'H') {
                    $cita->estado_cita = $estadoCita;
                    array_push($citasFinales, $cita);
                }
            }

            return  response()->json(['datos' => $citasFinales], 200);
        } catch (Exception $e) {

            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarUltimoCodigoCita()
    {
        try {
            $ultimoCodigoCita = Cita::select('CITA_COD as codigo')
                ->where('CITA_LOGIC_ESTADO', 'A')
                ->latest()->first();
            if ($ultimoCodigoCita == null) {
                $ultimoCodigoCita = (object)array('codigo' => 1);
            }
            $ultimoCodigoCita->codigo = $ultimoCodigoCita->codigo + 1;

            return  response()->json(['datos' => $ultimoCodigoCita], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function crearCita(Request $request)
    {
        // $request->validate([
        //     'ciclo_inicial' => 'required|numeric',
        //     'ciclo_final' => 'required|numeric',
        //     'ciclo_activo' => 'required|numeric',
        //     'email_administrador' => 'required|string|email|max:50',
        //     'cedula_administrador' =>  ['required', 'string', 'min:10', 'max:13', new CedulaValidator]
        // ]);
        //Se comprueba el estado actual de la cita, puesto que no se puede derivar para el mismo estado.
        $estado = $request->input('estado');
        //Se comprueba que la cita no se encuentre como finalizada, en caso de estarlo no se podra derivar a ninguna instancia.
        $estadoCitaTerminado = EstadoDeCita::where('CITA_COD', $request->input('codigo_cita'))
            ->where('ESTADOCITA_TIPO', 'T')
            ->first();
        if ($estadoCitaTerminado != null) {
            return response()->json(['mensaje' => 'La cita ya se encuentra terminada, no es posible continuar'], 421);
        }
        $estadoCita = EstadoDeCita::where('CITA_COD', $request->input('codigo_cita'))
            ->orderBy('ESTADOCITA_COD', 'desc')
            ->first();
        $descripcionEstado = $estado == 'C' ? 'Consulta Externa' : 'Emergencia';
        if ($estadoCita->ESTADOCITA_TIPO == $estado) {
            return response()->json(['mensaje' => 'El paciente ya se encuentra derivado en ' . $descripcionEstado], 421);
        }

        //Se obtiene el ultimo estado de cita para ponerlo como terminado.
        $ultimoEstadoCita = EstadoDeCita::where('CITA_COD', $request->input('codigo_cita'))
            ->orderBy('ESTADOCITA_COD', 'desc')->first();
        //Se modifica el estado
        if ($ultimoEstadoCita != null) {
            EstadoDeCita::where('ESTADOCITA_COD',  $ultimoEstadoCita->ESTADOCITA_COD)->update(
                [
                    'ESTADOCITA_LOGIC_ESTADO' => 'T'
                ]
            );
        }
        $gestionHospitalariaDb = DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            if ($estado == 'C') {
                //Se obtiene el ultimo codigo del ticket consulta externa y se le incrementa 1
                $ultimo_codigo_ticket = Cita::max('CITA_TICKET_CONSULTA');
                $ultimo_codigo_ticket = intval($ultimo_codigo_ticket) + 1;
                Cita::Where('CITA_COD', $request->input('codigo_cita'))->update(
                    [
                        'CITA_TICKET_CONSULTA' => $ultimo_codigo_ticket,
                        'CITA_OBS' => "",
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
            } else if ($estado == 'E') {
                //Se obtiene el ultimo codigo del ticket emergencia y se le incrementa 1
                $ultimo_codigo_ticket = Cita::max('CITA_TICKET_EMERGENCIA');
                $ultimo_codigo_ticket = intval($ultimo_codigo_ticket) + 1;
                Cita::Where('CITA_COD', $request->input('codigo_cita'))->update(
                    [
                        'CITA_TICKET_EMERGENCIA' => $ultimo_codigo_ticket,
                        'CITA_OBS' => "",
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
            }




            EstadoDeCita::Create(
                [
                    'CITA_COD' => $request->input('codigo_cita'),
                    'ESPECIALIDAD_COD' => $request->input('id_especialidad'),
                    'ESTADOCITA_TIPO' => $estado,
                    'ESTADOCITA_OBS' => '',
                    'ESTADOCITA_LOGIC_ESTADO' => 'A',
                    'ESTADOCITA_FECHA' => $request->input('fecha_cita'),
                    'ESTADOCITA_HORA_INICIAL' => $request->input('hora_inicio'),
                    'ESTADOCITA_HORA_FINAL' => $request->input('hora_cierre'),
                    'CITA_DOCTOR_COD' => $request->input('id_doctor'),
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarUltimoEstadoCita($id)
    {
        if ($id != null && $id != '') {
            $estado_cita_final = EstadoDeCita::with('doctor.user', 'especialidad')->where('CITA_COD', $id)
                ->orderBy('ESTADOCITA_COD', 'desc')
                ->first();
            if ($estado_cita_final != null && $estado_cita_final != '') {
                if ($estado_cita_final->ESTADOCITA_TIPO == 'C' || $estado_cita_final->ESTADOCITA_TIPO == 'E') {
                    return response()->json(['dato' => $estado_cita_final], 200);
                } else {
                    return response()->json(['dato' => null], 200);
                }
            }
        } else {
            return response()->json(['mensaje' => 'El código de la cita es requerido.'], 493);
        }
    }
    public static function imprimirTicketPdf($idCita, $tipo)
    {
        if ($idCita != null && $idCita != '') {
            $cita_final = Cita::with('paciente')
                ->where('CITA_COD', $idCita)
                ->first();
            $estado_cita_final = EstadoDeCita::with('doctor.user', 'especialidad')->where('CITA_COD', $idCita)
                ->orderBy('ESTADOCITA_COD', 'desc')
                ->first();
            $pdf = '';
            $estado_cita_final->paciente = $cita_final->paciente;
            $dateTime = new DateTime();
            $estado_cita_final->date = $dateTime->format('Y-m-d');
            $created_at = new DateTime($estado_cita_final->ESTADOCITA_FECHA);
            $estado_cita_final->created_at_parseado = $created_at->format('Y-m-d');
            if ($tipo == 'C') {
                $estado_cita_final->numero_ticket = addNumberToLeft($cita_final->CITA_TICKET_CONSULTA, 10);
                $pdf = PDF::loadView('reports.ticket-consulta-externa', ['dato' => $estado_cita_final, 'titulo' => $tipo == 'C' ? 'Consulta Externa' : 'Emergencia']);
            } else if ($tipo == 'E') {
                $estado_cita_final->numero_ticket = addNumberToLeft($cita_final->CITA_TICKET_EMERGENCIA, 10);
                $pdf = PDF::loadView('reports.ticket-emergencia', ['dato' => $estado_cita_final, 'titulo' => $tipo == 'C' ? 'Consulta Externa' : 'Emergencia']);
            }


            //$pdf = PDF::loadView('reports.ticket', ['dato' => $estado_cita_final, 'titulo'=>$tipo=='C'?'Consulta Externa':'Emergencia']);
            return $pdf;

            //return response()->json(['datos' => $estado_cita_final, 'titulo'=>$tipo=='C'?'Consulta Externa':'Emergencia'], 200);
        }
    }
    public  function generarTicketPdf($idCita, $tipo)
    {
        //Se procede a generar el ticket para la cita o emergencia seleccionadas
        $gestionHospitalariaDb = DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();

            $cita = Cita::where('CITA_COD', $idCita)
                ->first();
            $pdf = null;
            //En caso que ya tenga un ticket asigando
            if ($cita->CITA_TICKET_CONSULTA > 0 && $tipo == 'C') {
                $gestionHospitalariaDb->commit();
                $pdf = self::imprimirTicketPdf($idCita, $tipo);
            }
            //En caso que ya tenga un ticket asigando
            if ($cita->CITA_TICKET_CONSULTA > 0 && $tipo == 'E') {
                $gestionHospitalariaDb->commit();
                $pdf = self::imprimirTicketPdf($idCita, $tipo);
            }
            //Se comprueba que la cita no tenga generado un ticket, en caso de tenerlo se procede a imprimirlo
            if ($tipo == 'C' && $cita->CITA_TICKET_CONSULTA = 0) {
                //Se obtiene el ultimo codigo del ticket consulta externa y se le incrementa 1
                $ultimo_codigo_ticket = Cita::max('CITA_TICKET_CONSULTA');
                $ultimo_codigo_ticket = intval($ultimo_codigo_ticket) + 1;
                $cita->CITA_TICKET_CONSULTA = $ultimo_codigo_ticket;
            } else if ($tipo == 'E' && $cita->CITA_TICKET_EMERGENCIA = 0) {
                //Se obtiene el ultimo codigo del ticket emergencia y se le incrementa 1
                $ultimo_codigo_ticket = Cita::max('CITA_TICKET_EMERGENCIA');
                $ultimo_codigo_ticket = intval($ultimo_codigo_ticket) + 1;
                $cita->CITA_TICKET_EMERGENCIA = $ultimo_codigo_ticket;
            }
            $gestionHospitalariaDb->commit();
            $pdf = self::imprimirTicketPdf($idCita, $tipo);
            return $pdf->stream('ticket.pdf');
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
