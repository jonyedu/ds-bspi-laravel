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

class JornadaApiController extends Controller
{
    
    public function cargarJornadaTabla($id){
        
        try {
            $jornadasBase=Jornada_Trabajador::
            where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->where('TRABAJADORESPERSONALSALUD_COD', $id)
            ->get();
            $jornadas= collect([]);
            foreach ($jornadasBase as $key => $value) {
            $object= collect([]);
            $object->put('JORNADATRABAJADOR_COD',$value->JORNADATRABAJADOR_COD);
            $object->put('JORNADATRABAJADOR_INICIO',$value->JORNADATRABAJADOR_INICIO);
            $object->put('JORNADATRABAJADOR_FIN',$value->JORNADATRABAJADOR_FIN);
            $object->put('JORNADATRABAJADOR_OBS',$value->JORNADATRABAJADOR_OBS);
            $days= '';
                if($value->JORNADATRABAJADOR_LUNES=='A'){
                    $days=$days.'Lunes,';
                }
                if($value->JORNADATRABAJADOR_MARTES=='A'){
                    $days=$days.' Martes,';
                }
                if($value->JORNADATRABAJADOR_MIERCOLES=='A'){
                    $days=$days.' Miercoles,';
                }
                if($value->JORNADATRABAJADOR_JUEVES=='A'){
                    $days=$days.' Jueves,';
                }
                if($value->JORNADATRABAJADOR_VIERNES=='A'){
                    $days=$days.' Viernes,';
                }
                if($value->JORNADATRABAJADOR_SABADO=='A'){
                    $days=$days.' Sabado,';
                }
                if($value->JORNADATRABAJADOR_DOMINGO=='A'){
                    $days=$days.' Domingo,';
                }
                $days=substr($days, 0, -1);
            $object->put('JORNADATRABAJADOR_DIAS',$days);
            
           $jornadas->push($object);
        }

            return  response()->json(['jornadas'=>$jornadas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }


        

        
    }

    public static function cargarJornadas(){
        
        try {
            $jornadasBase=Jornada_Trabajador::
            where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->with('trabajadorpersonalsalud')
            ->get();
            $jornadas= collect([]);
            foreach ($jornadasBase as $key => $value) {
            $object= collect([]);
            $object->put('JORNADATRABAJADOR_COD',$value->JORNADATRABAJADOR_COD);
            $object->put('JORNADATRABAJADOR_INICIO',$value->JORNADATRABAJADOR_INICIO);
            $object->put('JORNADATRABAJADOR_FIN',$value->JORNADATRABAJADOR_FIN);
            $object->put('JORNADATRABAJADOR_OBS',$value->JORNADATRABAJADOR_OBS);
            $object->put('JORNADATRABAJADOR_TRABAJADOR',$value->trabajadorpersonalsalud->USERMEDIC);
            $days= '';
                if($value->JORNADATRABAJADOR_LUNES=='A'){
                    $days=$days.'Lunes,';
                }
                if($value->JORNADATRABAJADOR_MARTES=='A'){
                    $days=$days.' Martes,';
                }
                if($value->JORNADATRABAJADOR_MIERCOLES=='A'){
                    $days=$days.' Miercoles,';
                }
                if($value->JORNADATRABAJADOR_JUEVES=='A'){
                    $days=$days.' Jueves,';
                }
                if($value->JORNADATRABAJADOR_VIERNES=='A'){
                    $days=$days.' Viernes,';
                }
                if($value->JORNADATRABAJADOR_SABADO=='A'){
                    $days=$days.' Sabado,';
                }
                if($value->JORNADATRABAJADOR_DOMINGO=='A'){
                    $days=$days.' Domingo,';
                }
                $days=substr($days, 0, -1);
            $object->put('JORNADATRABAJADOR_DIAS',$days);
            
           $jornadas->push($object);
        }

            return  response()->json(['jornadas'=>$jornadas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }


        

        
    }


    public function guardarJornada(Request $request){
        $estado = 'I';
        
        $request->validate([
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.tipos_trabajadores,TIPOTRABAJADOR_NOM," . $estado . ",TIPOTRABAJADOR_LOGIC_ESTADO",
            'personalMedico_cod' => 'required|integer',
            'hora_inicio' => 'required',
            'hora_cierre'=> 'required',
            
    ]);
        
        $hora_inicio=new Carbon($request->input('hora_inicio'));
        $hora_cierre=new Carbon($request->input('hora_cierre'));
        $lunes = (is_null($request->input('lunes')) || $request->input('lunes')==false) ? '' : 'A';
        $martes = (is_null($request->input('martes')) || $request->input('martes')==false) ? '' : 'A';
        $miercoles = (is_null($request->input('miercoles')) || $request->input('miercoles')==false) ? '' : 'A';
        $jueves = (is_null($request->input('jueves')) || $request->input('jueves')==false) ? '' : 'A';
        $viernes = (is_null($request->input('viernes')) || $request->input('viernes')==false) ? '' : 'A';
        $sabado = (is_null($request->input('sabado')) || $request->input('sabado')==false) ? '' : 'A';
        $domingo = (is_null($request->input('domingo')) || $request->input('domingo')==false) ? '' : 'A';
        
            if($this->validarJornada($request)==false){
                return response()->json(['mensaje' => 'Jornada enviada tiene cruce con otro horario!'], 200);
            }
       
        try {
            DB::beginTransaction();
            $user = Auth::user();
            Jornada_Trabajador::Create(
                [
                    'TRABAJADORESPERSONALSALUD_COD'=> $request->input('personalMedico_cod'),
                    'JORNADATRABAJADOR_INICIO'=> $hora_inicio,
                    'JORNADATRABAJADOR_FIN'=> $hora_cierre,
                    'JORNADATRABAJADOR_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    
                    'JORNADATRABAJADOR_LUNES'=> $lunes,
                    'JORNADATRABAJADOR_MARTES'=> $martes,
                    'JORNADATRABAJADOR_MIERCOLES'=> $miercoles,
                    'JORNADATRABAJADOR_JUEVES'=> $jueves,
                    'JORNADATRABAJADOR_VIERNES'=> $viernes,
                    'JORNADATRABAJADOR_SABADO'=> $sabado,
                    'JORNADATRABAJADOR_DOMINGO'=> $domingo,

                    'JORNADATRABAJADOR_LOGIC_ESTADO'=>'A',
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

    public function eliminarJornada(Request $request){
        $estado = 'I';
        
        $request->validate([
            
            'jornada_cod'=> 'required|integer',

            
    ]);
        
        try {
            DB::beginTransaction();
            $user = Auth::user();
            Jornada_Trabajador::where('JORNADATRABAJADOR_COD',$request->input('jornada_cod'))->update(
                [
                    'JORNADATRABAJADOR_LOGIC_ESTADO'=>'I',
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


    public function validarJornada(Request $request){
        

        $hora_inicio=new Carbon($request->input('hora_inicio'));
        $hora_cierre=new Carbon($request->input('hora_cierre'));
        $lunes = (is_null($request->input('lunes')) || $request->input('lunes')==false) ? '' : 'A';
        $martes = (is_null($request->input('martes')) || $request->input('martes')==false) ? '' : 'A';
        $miercoles = (is_null($request->input('miercoles')) || $request->input('miercoles')==false) ? '' : 'A';
        $jueves = (is_null($request->input('jueves')) || $request->input('jueves')==false) ? '' : 'A';
        $viernes = (is_null($request->input('viernes')) || $request->input('viernes')==false) ? '' : 'A';
        $sabado = (is_null($request->input('sabado')) || $request->input('sabado')==false) ? '' : 'A';
        $domingo = (is_null($request->input('domingo')) || $request->input('domingo')==false) ? '' : 'A';
        //validation begin
        $general=Jornada_Trabajador::
        where('TRABAJADORESPERSONALSALUD_COD',$request->input('personalMedico_cod'))
        ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A');

        $crossHoraInicial=$general
        ->where('JORNADATRABAJADOR_INICIO', '<=',$hora_inicio)
        ->where('JORNADATRABAJADOR_FIN', '>=',$hora_inicio)
        ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
        ->get()->map(function ($id) {
            return $id->JORNADATRABAJADOR_COD;
        });
        $crossHoraFinal=$general
        ->where('JORNADATRABAJADOR_INICIO', '<=',$hora_cierre)
        ->where('JORNADATRABAJADOR_FIN', '>=',$hora_cierre)
        ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
        ->get()->map(function ($id) {
            return $id->JORNADATRABAJADOR_COD;
        });

        $general2=Jornada_Trabajador::
        where('TRABAJADORESPERSONALSALUD_COD',$request->input('personalMedico_cod'))
        ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
        ->whereIn('JORNADATRABAJADOR_COD',$crossHoraInicial)
        ->orWhere(function($query) use($crossHoraFinal){
            $query->whereIn('JORNADATRABAJADOR_COD',$crossHoraFinal);
        })
        ->get()->map(function ($id) {
            return $id->JORNADATRABAJADOR_COD;
        });
    
        
        

        
        $lunesQuery=collect([]);
        if($lunes=='A'){
            $lunesQuery=Jornada_trabajador::where('JORNADATRABAJADOR_LUNES', 'A')
            ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->whereIn('JORNADATRABAJADOR_COD', $general2)
            ->get()->map(function ($id) {
                return $id->JORNADATRABAJADOR_COD;
            });
        }
        $martesQuery=collect([]);
        if($martes=='A'){
            $martesQuery=Jornada_trabajador::where('JORNADATRABAJADOR_MARTES', 'A')
            ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->whereIn('JORNADATRABAJADOR_COD', $general2)
            ->get()->map(function ($id) {
                return $id->JORNADATRABAJADOR_COD;
            });
        }
        $miercolesQuery=collect([]);
        if($miercoles=='A'){
            $miercolesQuery=Jornada_trabajador::where('JORNADATRABAJADOR_MIERCOLES', 'A')
            ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->whereIn('JORNADATRABAJADOR_COD', $general2)
            ->get()->map(function ($id) {
                return $id->JORNADATRABAJADOR_COD;
            });
        }
        $juevesQuery=collect([]);
        if($jueves=='A'){
            $juevesQuery=Jornada_trabajador::where('JORNADATRABAJADOR_JUEVES', 'A')
            ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->whereIn('JORNADATRABAJADOR_COD', $general2)
            ->get()->map(function ($id) {
                return $id->JORNADATRABAJADOR_COD;
            });
        }
        $viernesQuery=collect([]);
        if($viernes=='A'){
            $viernesQuery=Jornada_trabajador::where('JORNADATRABAJADOR_VIERNES', 'A')
            ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->whereIn('JORNADATRABAJADOR_COD', $general2)
            ->get()->map(function ($id) {
                return $id->JORNADATRABAJADOR_COD;
            });
        }
        $sabadoQuery=collect([]);
        if($sabado=='A'){
            $sabadoQuery=Jornada_trabajador::where('JORNADATRABAJADOR_SABADO', 'A')
            ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->whereIn('JORNADATRABAJADOR_COD', $general2)
            ->get()->map(function ($id) {
                return $id->JORNADATRABAJADOR_COD;
            });
        }
        $domingoQuery=collect([]);
        if($domingo=='A'){
            $domingoQuery=Jornada_trabajador::where('JORNADATRABAJADOR_DOMINGO', 'A')
            ->where('JORNADATRABAJADOR_LOGIC_ESTADO','A')
            ->whereIn('JORNADATRABAJADOR_COD', $general2)
            ->get()->map(function ($id) {
                return $id->JORNADATRABAJADOR_COD;
            });
        }

        if($lunesQuery->count()==0 && $martesQuery->count()==0 && $miercolesQuery->count()==0
           && $juevesQuery->count()==0 && $viernesQuery->count()==0 && $sabadoQuery->count()==0
           && $domingoQuery->count()==0
        )
        {
            return true;
        }else{
            return false;
        }
        //validation end
    }
}
