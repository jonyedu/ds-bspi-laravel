<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeCitas;

use App\GestionHospitalaria\AdministracionDeCitas\Cita;
use App\GestionHospitalaria\AdministracionDeCitas\EstadoDeCita;
use App\GestionHospitalaria\PersonalMedico\TrabajadorPersonalSalud;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Exception;

class EstadoDeCitaApiController extends Controller
{
    public function cargarEstadoDeCitasTabla($idCita)
    { {
            try {
                $estadoCitas = EstadoDeCita::with('doctor.user')
                    ->select('ESTADOCITA_TIPO', 'ESTADOCITA_FECHA','created_at','CITA_DOCTOR_COD','ESTADOCITA_TIPO')
                    ->where('CITA_COD', $idCita)
                    ->orderBy('ESTADOCITA_TIPO', 'asc')
                    ->get();
               
                foreach ($estadoCitas as $key => $estadoCita) {
                    $date = new DateTime($estadoCita->FECHA_CITA);
                    $estadoCita->ESTADOCITA_FECHA=$date->format('Y-m-d');
                }

                return  response()->json(['estadoCita' => $estadoCitas], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        }
    }

    public function cargarCitasParaAgenda(Request $request){
        $user = Auth::user();
        $doctor=TrabajadorPersonalSalud::
            where('TRABAJADORESPERSONALSALUD_LOGIC_ESTADO','A')
            ->where('USER_ID',$user->id)
            ->get();
     

         $fecha_actual=$request->input('fecha_actual');
         $fecha_cita=$request->input('fecha_cita');
         $fecha_busqueda= $fecha_cita=='' ? $fecha_actual : $fecha_cita;
         $citas=EstadoDeCita::where('ESTADOCITA_LOGIC_ESTADO','A')
         ->with('cita.paciente')
         ->where('CITA_DOCTOR_COD',$doctor[0]->TRABAJADORESPERSONALSALUD_COD)
         ->where('ESTADOCITA_FECHA',$fecha_busqueda)
         ->orderBy('ESTADOCITA_HORA_INICIAL','asc')
         ->get();
         $agenda=collect([]);
         foreach ($citas as $citax) {
             $object=collect([]);
             $object->put('ESPECIALIDAD_NOM',$citax->especialidad->ESPECIALIDAD_NOM);
             $object->put('ESTADOCITA_HORA_INICIAL',$citax->ESTADOCITA_HORA_INICIAL);
             $object->put('ESTADOCITA_HORA_FINAL',$citax->ESTADOCITA_HORA_FINAL);
             $object->put('ESTADOCITA_FECHA',$citax->ESTADOCITA_FECHA);
             $object->put('PACIENTE',$citax->cita->paciente->FULL_NAME);
             $object->put('CITA',$citax->cita->CITA_COD);
             $agenda->push($object);


         }
        

        return response()->json([
             'citas'=>$agenda,
             'fecha'=>$fecha_busqueda,
            '$doctor'=>$doctor,
            'auth'=>$user
            ], 200);
    }
}
