<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeHospital;


use App\User;
use App\GestionHospitalaria\AdministracionDeHospital\Consultorio;
use App\GestionHospitalaria\AdministracionDeHospital\Area;
use App\Http\Controllers\GestionHospitalaria\PersonalMedico\JornadaApiController;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultorioApiController extends Controller
{
    public function cargarConsultorioTabla()
    {
        //Se hace select a las tablas organismo, usuarios y cargo en organismo
        
        try {
            $consultoriosB=Consultorio::where('CONSULTORIO_LOGIC_ESTADO','A')
            ->with('jornada.trabajadorPersonalSalud','area')
            ->get();
            $consultorios=collect([]);
            
        foreach ($consultoriosB as $consultorio) {
            $object=collect([]);
            $object->put('CONSULTORIO_COD',$consultorio->CONSULTORIO_COD);
            $object->put('CONSULTORIO_NOM',$consultorio->CONSULTORIO_NOM);
            $object->put('CONSULTORIO_OBS',$consultorio->CONSULTORIO_OBS);
            $object->put('AREA_NOM',$consultorio->area->AREA_NOM);
            $object->put('AREA_COD',$consultorio->AREA_COD);
            $object->put('JORNADA_COD',$consultorio->JORNADATRABAJADOR_COD);
            $object->put('MEDICO_NOM',$consultorio->jornada->trabajadorPersonalSalud->user->FULL_NAME_IDENTIFICATION);
            $days= '';
                if($consultorio->jornada->JORNADATRABAJADOR_LUNES=='A'){
                    $days=$days.'Lunes,';
                }
                if($consultorio->jornada->JORNADATRABAJADOR_MARTES=='A'){
                    $days=$days.' Martes,';
                }
                if($consultorio->jornada->JORNADATRABAJADOR_MIERCOLES=='A'){
                    $days=$days.' Miercoles,';
                }
                if($consultorio->jornada->JORNADATRABAJADOR_JUEVES=='A'){
                    $days=$days.' Jueves,';
                }
                if($consultorio->jornada->JORNADATRABAJADOR_VIERNES=='A'){
                    $days=$days.' Viernes,';
                }
                if($consultorio->jornada->JORNADATRABAJADOR_SABADO=='A'){
                    $days=$days.' Sabado,';
                }
                if($consultorio->jornada->JORNADATRABAJADOR_DOMINGO=='A'){
                    $days=$days.' Domingo,';
                }
                $days=substr($days, 0, -1);
            $object->put('JORNADATRABAJADOR_DIAS',$days);
            $object->put('JORNADATRABAJADOR_HORARIO',$consultorio->jornada->JORNADATRABAJADOR_INICIO.'-'.$consultorio->jornada->JORNADATRABAJADOR_FIN);
            
            
            $consultorios->push($object);


        }

            $areas=Area::where('AREA_LOGIC_ESTADO','A')
            ->get();
            $jornadas=JornadaApiController::cargarJornadas();


            return response()->json(['consultorios' => $consultorios, 'areas' => $areas, 'jornadas' => $jornadas]);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarConsultorio(Request $request)
    {
        $estado='I';
        $request->validate([
            'jornada_cod' => 'required',
            'area_cod' => 'required',
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.consultorios,CONSULTORIO_NOM," . $estado . ",CONSULTORIO_LOGIC_ESTADO",
        ]);

        $jornada_cod=$request->input('jornada_cod');
        $area_cod=$request->input('area_cod');
        $consultorio_nom=$request->input('nombre');
        $observacion=$request->input('observacion');

        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
            $user = Auth::user();
            Consultorio::Create(
                [
                    'AREA_COD' => $area_cod,
                    'JORNADATRABAJADOR_COD' => $jornada_cod,
                    'CONSULTORIO_NOM' => $consultorio_nom,
                    'CONSULTORIO_LOGIC_ESTADO' => 'A',
                    'CONSULTORIO_OBS' => is_null($observacion)  ? '' : $request->input('observacion'),
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

    public function modificarConsultorio(Request $request)
    {
        $estado='I';
        $request->validate([
            'consultorio_cod' => 'required',
            'jornada_cod' => 'required',
            'area_cod' => 'required',
        ]);

        $jornada_cod=$request->input('jornada_cod');
        $consultorio_cod=$request->input('consultorio_cod');
        $area_cod=$request->input('area_cod');
        $consultorio_nom=$request->input('nombre');
        $observacion=$request->input('observacion');

        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
            $user = Auth::user();
            Consultorio::where('CONSULTORIO_COD',$consultorio_cod)->update(
                [
                    'AREA_COD' => $area_cod,
                    'JORNADATRABAJADOR_COD' => $jornada_cod,
                    'CONSULTORIO_NOM' => $consultorio_nom,
                    'CONSULTORIO_LOGIC_ESTADO' => 'A',
                    'CONSULTORIO_OBS' => is_null($observacion)  ? '' : $request->input('observacion'),
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
    public function eliminarConsultorio(Request $request)
    {
        $estado='I';
        $request->validate([
            'consultorio_cod' => 'required',
        ]);
        $consultorio_cod=$request->input('consultorio_cod');
       

        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
            $user = Auth::user();
            Consultorio::where('CONSULTORIO_COD',$consultorio_cod)->update(
                [
                    
                    'CONSULTORIO_LOGIC_ESTADO' => 'I',
                    
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

    }
    

   

