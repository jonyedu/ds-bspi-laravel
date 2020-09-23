<?php

namespace app\Http\Controllers\GestionHospitalaria\PersonalMedico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GestionHospitalaria\PersonalMedico\TipoTrabajador;
use App\GestionHospitalaria\PersonalMedico\TrabajadorPersonalSalud;
use App\GestionHospitalaria\PersonalMedico\Jornada_Trabajador;
use App\GestionHospitalaria\PersonalMedico\Especialidad;
use App\GestionHospitalaria\PersonalMedico\Funcion_Trabajador;
use App\GestionHospitalaria\AdministracionDeCitas\Cita;
use App\GestionHospitalaria\AdministracionDeCitas\EstadoDeCita;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PersonalMedicoApiController extends Controller
{
    //

    public function cargarPersonalMedicoDropdown(){
        try{
            $personalMedico=TrabajadorPersonalSalud::
            where('TRABAJADORESPERSONALSALUD_LOGIC_ESTADO','A')
            ->with('user','tipoTrabajador')
            ->get();
            $medicos= collect([]);
        foreach ($personalMedico as $key => $value) {
            $object= collect([]);
            $object->put('TRABAJADORESPERSONALSALUD_COD',$value->TRABAJADORESPERSONALSALUD_COD);
            $object->put('USER_ID',$value->USER_ID);
            $object->put('USER_NOM',$value->user->US_NOM.' '.$value->user->US_APELL.'-'.
            $value->tipoTrabajador->TIPOTRABAJADOR_NOM);
            $object->put('TIPOTRABAJADOR_COD',$value->TIPOTRABAJADOR_COD);
            $object->put('TIPOTRABAJADOR_NOM',$value->tipoTrabajador->TIPOTRABAJADOR_NOM);
            $object->put('TRABAJADORESPERSONALSALUD_OBS',$value->TRABAJADORESPERSONALSALUD_OBS);
            $object->put('TRABAJADORESPERSONALSALUD_FECHA_CONTRATO',$value->TRABAJADORESPERSONALSALUD_FECHA_CONTRATO);
            $object->put('TRABAJADORESPERSONALSALUD_CONTRATO_PDF',$value->TRABAJADORESPERSONALSALUD_CONTRATO_PDF);
           $medicos->push($object);
        }
        return  response()->json(['medicos'=>$medicos], 200);
        }catch(Exception $e){
            
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public static function cargarPersonalMedico(){
        $personalMedico=TrabajadorPersonalSalud::
            where('TRABAJADORESPERSONALSALUD_LOGIC_ESTADO','A')
            ->with('user','tipoTrabajador')
            ->get();
            $medicos= collect([]);
            foreach ($personalMedico as $key => $value) {
            $object= collect([]);
            $object->put('TRABAJADORESPERSONALSALUD_COD',$value->TRABAJADORESPERSONALSALUD_COD);
            $object->put('USER_ID',$value->USER_ID);
            $object->put('USER_NOM',$value->user->US_NOM.' '.$value->user->US_APELL.'-'.
            $value->tipoTrabajador->TIPOTRABAJADOR_NOM);
            $object->put('TIPOTRABAJADOR_COD',$value->TIPOTRABAJADOR_COD);
            $object->put('TIPOTRABAJADOR_NOM',$value->tipoTrabajador->TIPOTRABAJADOR_NOM);
            $object->put('TRABAJADORESPERSONALSALUD_OBS',$value->TRABAJADORESPERSONALSALUD_OBS);
            $object->put('TRABAJADORESPERSONALSALUD_FECHA_CONTRATO',$value->TRABAJADORESPERSONALSALUD_FECHA_CONTRATO);
            $object->put('TRABAJADORESPERSONALSALUD_CONTRATO_PDF',$value->TRABAJADORESPERSONALSALUD_CONTRATO_PDF);
           $medicos->push($object);
        }
        return $medicos;
    }

    public function verTipoPersonalMedico(){
        $user = Auth::user();
        $tipoMedico=TrabajadorPersonalSalud::
            where('TRABAJADORESPERSONALSALUD_LOGIC_ESTADO','A')
            ->where('USER_ID',$user->id)
            ->first();
            return  response()->json(['tipoMedico'=>$tipoMedico->TIPOTRABAJADOR_COD], 200);
    }

    public function cargarPersonalMedicoTabla(){
        try {
            $personalMedico=TrabajadorPersonalSalud::
            where('TRABAJADORESPERSONALSALUD_LOGIC_ESTADO','A')
            ->with('user','tipoTrabajador')
            ->orderBy('TRABAJADORESPERSONALSALUD_COD','desc')
            ->get();
            $users=User::where('US_TRABAJADOR_BSPI','S')
            ->get();
            $tipos=TipoTrabajador::
            select('TIPOTRABAJADOR_COD','TIPOTRABAJADOR_NOM')
            ->where('TIPOTRABAJADOR_LOGIC_ESTADO','A')
            ->get();
        $usuarios= collect([]);
        foreach ($users as $key => $value) {
            $object= collect([]);
            
            $object->put('USER_COD',$value->id);
            $object->put('USER_NOM',$value->US_NOM.' '.$value->US_APELL);
            
           $usuarios->push($object);
        }




        $medicos= collect([]);
        foreach ($personalMedico as $key => $value) {
            $object= collect([]);
            $object->put('TRABAJADORESPERSONALSALUD_COD',$value->TRABAJADORESPERSONALSALUD_COD);
            $object->put('USER_ID',$value->USER_ID);
            $object->put('USER_NOM',$value->user->US_NOM.' '.$value->user->US_APELL);
            $object->put('TIPOTRABAJADOR_COD',$value->TIPOTRABAJADOR_COD);
            $object->put('TIPOTRABAJADOR_NOM',$value->tipoTrabajador->TIPOTRABAJADOR_NOM);
            $object->put('TRABAJADORESPERSONALSALUD_OBS',$value->TRABAJADORESPERSONALSALUD_OBS);
            $object->put('TRABAJADORESPERSONALSALUD_FECHA_CONTRATO',$value->TRABAJADORESPERSONALSALUD_FECHA_CONTRATO);
            $object->put('TRABAJADORESPERSONALSALUD_CONTRATO_PDF',$value->TRABAJADORESPERSONALSALUD_CONTRATO_PDF);
           $medicos->push($object);
        }
            return  response()->json(['medicos'=>$medicos, 'usuarios'=>$usuarios, 'tipos'=>$tipos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }


        

        return $personalMedico;
    }

    public function guardarArchivos(Request $request)
    {
        try {
            $file = $request->file('pdfContrato');
            
            $destinationPath=public_path('files');

            // Generate a file name with extension
            if ($file != null && $file != '') {
                $fileContrato = 'contrato-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileContrato);
                $pathContrato='/'.'files/'.$fileContrato;
                //$pathContrato = $file->storeAs('public/files.ContratosPerfil', $fileContrato);
            } 
           
            return response()->json([
                'pathContrato' => isset($pathContrato) && $pathContrato != null ? $pathContrato : ''
            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }

        //dd($path);

    }

    public function guardarPersonalMedico(Request $request){
        $estado = 'I';
        
        $request->validate([
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.tipos_trabajadores,TIPOTRABAJADOR_NOM," . $estado . ",TIPOTRABAJADOR_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            'tipo_cod' => 'required|integer',
            'user_cod'=> 'required|integer',
            
    ]);
        $fecha=new Carbon($request->input('fecha_contrato'));
            //$active=$request->input('activo')=='S' ? 'A' : 'I';
        try {
            DB::beginTransaction();
            $user = Auth::user();
            TrabajadorPersonalSalud::Create(
                [
                    'TIPOTRABAJADOR_COD'=> $request->input('tipo_cod'),
                    'USER_ID'=> $request->input('user_cod'),
                    'TRABAJADORESPERSONALSALUD_FECHA_CONTRATO'=> is_null($fecha)  ? '' : $fecha,
                    'TRABAJADORESPERSONALSALUD_CONTRATO_PDF'=> is_null($request->input('pathContrato'))  ? '' : $request->input('pathContrato'),


                    'TRABAJADORESPERSONALSALUD_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'TRABAJADORESPERSONALSALUD_LOGIC_ESTADO'=>'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function modificarPersonalMedico(Request $request){
        $estado = 'I';
        
        $request->validate([
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.tipos_trabajadores,TIPOTRABAJADOR_NOM," . $estado . ",TIPOTRABAJADOR_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            'tipo_cod' => 'required|integer',
            'user_cod'=> 'required|integer',
            'personalMedico_cod'=> 'required|integer',

            
    ]);
        $fecha=new Carbon($request->input('fecha_contrato'));
            //$active=$request->input('activo')=='S' ? 'A' : 'I';
        try {
            DB::beginTransaction();
            $user = Auth::user();
            TrabajadorPersonalSalud::where('TRABAJADORESPERSONALSALUD_COD',$request->input('personalMedico_cod'))->update(
                [
                    'TIPOTRABAJADOR_COD'=> $request->input('tipo_cod'),
                    'USER_ID'=> $request->input('user_cod'),
                    'TRABAJADORESPERSONALSALUD_FECHA_CONTRATO'=> is_null($fecha)  ? '' : $fecha,
                    'TRABAJADORESPERSONALSALUD_CONTRATO_PDF'=> is_null($request->input('pathContrato'))  ? '' : $request->input('pathContrato'),


                    'TRABAJADORESPERSONALSALUD_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'TRABAJADORESPERSONALSALUD_LOGIC_ESTADO'=>'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function eliminarPersonalMedico(Request $request){
        $estado = 'I';
        
        $request->validate([
            
            'personal_cod'=> 'required|integer',

            
    ]);
        
        try {
            DB::beginTransaction();
            $user = Auth::user();
            TrabajadorPersonalSalud::where('TRABAJADORESPERSONALSALUD_COD',$request->input('personal_cod'))->update(
                [
                    'TRABAJADORESPERSONALSALUD_LOGIC_ESTADO'=>'I',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function cargarMedicosParaEmergencia(Request $request){
        $now=Carbon::now();
        $timestamp = $now->timestamp;
        $nowDate = $now->format('Y-m-d');
        $nowTime =$now->format(' H:i:s');
        

        $horaInicial=$nowTime;
        $horaFinal=$nowTime;
        //$especialidad=$request->input('id_especialidad');
        $especialidad=$request->input('especialidad');
        $fecha=$nowDate;
        $day=$now->dayOfWeek;

        //extraer id de los trabajadores segun la especialidad solicitada
        $idDoctoresEspecialidad=Funcion_Trabajador::select('TRABAJADORESPERSONALSALUD_COD')
        ->where('FUNCIONTRABAJADOR_LOGIC_ESTADO','A')
        ->where('ESPECIALIDAD_COD',$especialidad)
        ->get()
        ->map(function ($funcion) {
            return $funcion->TRABAJADORESPERSONALSALUD_COD;
        });

        //extraer el id de tipo de trabajador q pertenezca a: Doctor(a)
        $idTipoDoctores=TipoTrabajador::select('TIPOTRABAJADOR_COD')
        ->where('TIPOTRABAJADOR_NOM','Doctor(a)')
        ->where('TIPOTRABAJADOR_LOGIC_ESTADO','A')
        ->first();
        
        if($idTipoDoctores==null){
            return response()->json(['msg' => 'No existen doctores disponibles'], 421);
        }
        $idTipoDoctores=$idTipoDoctores->TIPOTRABAJADOR_COD;

        //extraer el id de los doctores con cita agendada en el horario indicado
        $citasOcupadas=EstadoDeCita::select('CITA_DOCTOR_COD')
        ->where('ESTADOCITA_LOGIC_ESTADO','A')
        ->where('ESTADOCITA_HORA_INICIAL','<',$horaInicial)
        ->Where('ESTADOCITA_HORA_FINAL','>',$horaInicial)
        ->where('ESTADOCITA_FECHA',$fecha)
        ->get()
        ->map(function ($citasOcupada) {
           return $citasOcupada->CITA_DOCTOR_COD;
        });
        
        //return $citasOcupadas;

        $citasOcupadas2=EstadoDeCita::select('CITA_DOCTOR_COD')
        ->where('ESTADOCITA_LOGIC_ESTADO','A')
        ->where('ESTADOCITA_HORA_INICIAL','<',$horaFinal)
        ->Where('ESTADOCITA_HORA_FINAL','>',$horaFinal)
        ->where('ESTADOCITA_FECHA',$fecha)
        ->get()
        ->map(function ($citasOcupada) {
           return $citasOcupada->CITA_DOCTOR_COD;
        });
        
        //return $citasOcupadas2;
        
        //extraer id de quienes esten trabajando en el horario indicado
        $jornadasPorRequest=Jornada_Trabajador::select('TRABAJADORESPERSONALSALUD_COD')
        ->where('JORNADATRABAJADOR_INICIO','<=',$horaInicial)
        ->where('JORNADATRABAJADOR_FIN','>=',$horaFinal)
        ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
        ->when($day==1, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_LUNES', 'A');
                })
        ->when($day==2, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_MARTES', 'A');
                })
        ->when($day==3, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_MIERCOLES', 'A');
                })
        ->when($day==4, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_JUEVES', 'A');
                })
        ->when($day==5, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_VIERNES', 'A');
                })
        ->when($day==6, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_SABADO', 'A');
                })
        ->when($day==0, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_DOMINGO', 'A');
                })
        ->get()
        ->map(function ($jornada) {
            return $jornada->TRABAJADORESPERSONALSALUD_COD;
        });
        
        
        
        //devolver los doctores disponibles, utilizando los queries anteriores
        $doctores=TrabajadorPersonalSalud::
        where('TRABAJADORESPERSONALSALUD_LOGIC_ESTADO','A')
        ->with('user')
        ->where('TIPOTRABAJADOR_COD',$idTipoDoctores)
        ->whereIn('TRABAJADORESPERSONALSALUD_COD',$idDoctoresEspecialidad)
        ->whereIn('TRABAJADORESPERSONALSALUD_COD', $jornadasPorRequest)//filtro jornada
        ->whereNotIn('TRABAJADORESPERSONALSALUD_COD', $citasOcupadas)//filtro x citas ocupadas
        ->whereNotIn('TRABAJADORESPERSONALSALUD_COD', $citasOcupadas2)
        ->get();
        return $doctores;
    }

    public function cargarMedicosParaConsultaGeneral(Request $request){
        $horaInicial=$request->input('horaInicial');
        $horaFinal=$request->input('horaFinal');
        //$especialidad=$request->input('id_especialidad');
        $especialidad=$request->input('especialidad');
        $fecha=new Carbon($request->input('fecha'));
        $fecha_request=$request->input('fecha');
        $day=$fecha->dayOfWeek;

        //extraer id de los trabajadores segun la especialidad solicitada
        $idDoctoresEspecialidad=Funcion_Trabajador::select('TRABAJADORESPERSONALSALUD_COD')
        ->where('FUNCIONTRABAJADOR_LOGIC_ESTADO','A')
        ->where('ESPECIALIDAD_COD',$especialidad)
        ->get()
        ->map(function ($funcion) {
            return $funcion->TRABAJADORESPERSONALSALUD_COD;
        });

        //return $idDoctoresEspecialidad;

        //extraer el id de tipo de trabajador q pertenezca a: Doctor(a)
        $idTipoDoctores=TipoTrabajador::select('TIPOTRABAJADOR_COD')
        ->where('TIPOTRABAJADOR_NOM','Doctor(a)')
        ->where('TIPOTRABAJADOR_LOGIC_ESTADO','A')
        ->first();
        if($idTipoDoctores==null){
            return response()->json(['msg' => 'No existen doctores disponibles. Consulte en otros horarios'], 421);
        }
        $idTipoDoctores=$idTipoDoctores->TIPOTRABAJADOR_COD;
        //return $idTipoDoctores;

        //extraer el id de los doctores con cita agendada en el horario indicado
        $citasOcupadas=EstadoDeCita::select('CITA_DOCTOR_COD')
        ->where('ESTADOCITA_LOGIC_ESTADO','A')
        ->Where('ESTADOCITA_HORA_INICIAL','<=',$horaInicial)
        ->Where('ESTADOCITA_HORA_FINAL','>=',$horaInicial)
        ->where('ESTADOCITA_FECHA',$fecha_request)
        ->get()
        ->map(function ($citasOcupada) {
           return $citasOcupada->CITA_DOCTOR_COD;
        });
       
        //return $citasOcupadas;

        $citasOcupadas2=EstadoDeCita::select('CITA_DOCTOR_COD')
        ->where('ESTADOCITA_LOGIC_ESTADO','A')
        ->Where('ESTADOCITA_HORA_INICIAL','<=',$horaFinal)
        ->Where('ESTADOCITA_HORA_FINAL','>=',$horaFinal)
        ->where('ESTADOCITA_FECHA',$fecha_request)
        ->get()
        ->map(function ($citasOcupada) {
           return $citasOcupada->CITA_DOCTOR_COD;
        });
        //return   ['horaInicial'=>$horaInicial,'horaFinal'=>$horaFinal,'fechaRe'=>$request->input('fecha'), 'citasOcupadas2'=>$citasOcupadas2,'citasOcupadas'=>$citasOcupadas];
        //return $citasOcupadas2;
        
        //extraer id de quienes esten trabajando en el horario indicado
        $jornadasPorRequest=Jornada_Trabajador::select('TRABAJADORESPERSONALSALUD_COD')
        ->where('JORNADATRABAJADOR_INICIO','<=',$horaInicial)
        ->where('JORNADATRABAJADOR_FIN','>=',$horaFinal)
        ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
        ->when($day==1, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_LUNES', 'A');
                })
        ->when($day==2, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_MARTES', 'A');
                })
        ->when($day==3, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_MIERCOLES', 'A');
                })
        ->when($day==4, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_JUEVES', 'A');
                })
        ->when($day==5, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_VIERNES', 'A');
                })
        ->when($day==6, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_SABADO', 'A');
                })
        ->when($day==0, function ($query, $day) {
                    return $query->where('JORNADATRABAJADOR_DOMINGO', 'A');
                })
        ->get()
        ->map(function ($jornada) {
            return $jornada->TRABAJADORESPERSONALSALUD_COD;
        });

        //return $jornadasPorRequest;
        //devolver los doctores disponibles, utilizando los queries anteriores
        $doctores=TrabajadorPersonalSalud::
        where('TRABAJADORESPERSONALSALUD_LOGIC_ESTADO','A')
        ->with('user')
        ->where('TIPOTRABAJADOR_COD',$idTipoDoctores)
        ->whereIn('TRABAJADORESPERSONALSALUD_COD',$idDoctoresEspecialidad)
        ->whereIn('TRABAJADORESPERSONALSALUD_COD', $jornadasPorRequest)//filtro jornada
        ->whereNotIn('TRABAJADORESPERSONALSALUD_COD', $citasOcupadas)//filtro x citas ocupadas
        ->whereNotIn('TRABAJADORESPERSONALSALUD_COD', $citasOcupadas2)
        ->get();
        return $doctores;
    }
}
