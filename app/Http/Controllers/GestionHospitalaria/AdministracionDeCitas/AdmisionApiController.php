<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeCitas;

use App\GestionHospitalaria\AdministracionDeCitas\Cita;
use App\GestionHospitalaria\AdministracionDeCitas\CoberturaPoliza;
use App\GestionHospitalaria\AdministracionDeCitas\EstadoDeCita;
use App\GestionHospitalaria\Pacientes\UsuariosParentesco;
use App\Http\Controllers\Controller;
use App\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class AdmisionApiController extends Controller
{
    public function cargarAdmisionesPorFecha(Request $request)
    {
        //Se hace select a la tabla organizaciones.
        try {
            
            $tipoConsulta = $request->input('tipo_consulta');
            //puede traer tipo A -> son las admisiones del día en curso.(por defecto.)
            //puede traer tipo H -> historico de admisiones.
            $dateTime = new DateTime();
            $fecha = $dateTime->format('Y-m-d');
            
            $fechaDesde= $fecha;
            $fechaHasta= $fecha;
            
                if($tipoConsulta ==='H'){
                    $fechaDesde=$request->input('fechaDesde');
                    $fechaHasta= $request->input('fechaHasta');
                    if($fechaDesde ===''){
                        return response()->json(['msg' => 'La fecha desde no puede estar vacio' ], 421);
                    }
                    if($fechaHasta ===''){
                        return response()->json(['msg' => 'La fecha hasta no puede estar vacio' ], 421);
                    }
                }
           
            //Se valida que la fecha desde no sea mayor a la fecha hasta
            if( date_create_from_format('Y-m-d', $fechaDesde)>date_create_from_format('Y-m-d', $fechaHasta)){
                return response()->json(['msg' => 'La fecha desde no puede ser mayor a la fecha hasta' ], 421);
            }
            //Se obtiene las citas dependiendo del formulario en el qeu se encuentre el usuario
            $formulario= $request->input('formulario');
            
            //Se obtienen las citas en el rango de fechas establecido.
            $admisiones= Cita::with('paciente','acompanante','coberturaPolizas.poliza','coberturaPolizas.beneficiario.usuario_beneficiario')
                ->whereDate('created_at', '>=',$fechaDesde)
                ->whereDate('created_at', '<=',$fechaHasta)
                ->where('CITA_LOGIC_ESTADO','A')
                ->orderBy('CITA_COD','desc')
                ->get();      
            $admisiones_result=array();
            foreach ($admisiones as $key => $admisiones) {
                $estado_cita_final= EstadoDeCita::where('CITA_COD',$admisiones->CITA_COD)
                    ->where('ESTADOCITA_LOGIC_ESTADO','A')
                    ->orderBy('ESTADOCITA_COD','desc')
                    ->first();
                if($estado_cita_final!=null){
                    if($formulario=='E')
                    {
                        if($estado_cita_final->ESTADOCITA_TIPO==$formulario || $estado_cita_final->ESTADOCITA_TIPO=='A'){
                            array_push($admisiones_result,$admisiones);
                        }
                    }else{
                        if($formulario=='C')
                        {
                            if($estado_cita_final->ESTADOCITA_TIPO==$formulario || $estado_cita_final->ESTADOCITA_TIPO=='A'){
                                array_push($admisiones_result,$admisiones);
                            }
                        }else{
                            if($estado_cita_final->ESTADOCITA_TIPO=='A'){
                                array_push($admisiones_result,$admisiones);
                            }
                        }
                        
                    }
                }
                
                
            }
            return  response()->json(['datos' => $admisiones_result], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function crearAdmision(Request $request)
    {
        //VALIDACIONES GENERALES PARA ADMISION
        //el usuario, la poliza, y el beneficiario no pueden ser vacios
        $codigo_usuario= $request->input('codigo_usuario');
        $id_acompanante=$request->input('id_acompanante');
        $acompanante=$request->input('acompanante');
        if($codigo_usuario==null || $codigo_usuario==''){
            return response()->json(['mensaje' => 'Debe seleccionar un usuario para la admisión.'], 403);
        }
        if($acompanante=='A'){
            if($id_acompanante==null || $id_acompanante==''){
                return response()->json(['mensaje' => 'Debe seleccionar un acompañante puesto que ha seleccionado que el usaurio viene acompañado.'], 403);
            }
            //Se comprueba si el usuario asociado posee parentesco con el paciente.
            $usuario_parentesco = UsuariosParentesco::where('PARENTESCO_COD',$id_acompanante)
                ->where('USER_ID',$codigo_usuario) 
                ->where('PARENTESCO_LOGIC_ESTADO','A')
                ->first();
            if($usuario_parentesco==null || !isset($usuario_parentesco)){
                return response()->json(['mensaje' => 'El acompañante seleccionado no posee parentesco con el usuario a ingresar en admisiones.'], 403);
            }
            
        }
        
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            $paciente=User::where('id',$codigo_usuario)->first();
            //Se comprueba que el paciente tenga una historia clinica en caso de no tenerlo se le creara
            if($paciente==null){
                return response()->json(['mensaje' => 'El paciente no se encuentra en nuestros registros.'], 403);
            }
            if($paciente->US_HISTORIACLINICACOD==null || $paciente->US_HISTORIACLINICACOD==''){
                //Se procede a crear la historia clinica 
                $ultima_historia_clinica= User::max('US_HISTORIACLINICACOD');
                $ultima_historia_clinica = intval( $ultima_historia_clinica) + 1;
                $paciente->US_HISTORIACLINICACOD =  $ultima_historia_clinica ;
                $paciente->save();
            }

            $cita = Cita::Create(
                [
                    'USER_ID' => $codigo_usuario,
                    'CITA_ACOMPAÑANTE_COD' => $id_acompanante,
                    'CITA_OBS' => "",
                    'CITA_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            
            EstadoDeCita::Create(
                [
                    'CITA_COD' => $cita->CITA_COD,
                    'ESTADOCITA_TIPO' => 'A',//de admisión.
                    'ESTADOCITA_OBS' => '',
                    'ESTADOCITA_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            //Se ingresa los registros en la tabla cobertura poliza
            foreach ($request->input('coberturaPolizas') as  $poliza) {
                CoberturaPoliza::Create(
                    [
                        'CITA_COD'=>$cita->CITA_COD,
                        'POLIZA_COD'=>$poliza['codigo_poliza'],
                        'BENEFICIARIO_COD'=>$poliza['codigo_usuario_beneficiario'],
                        'COBERTURAPOLIZA_PORCENTAJE'=>$poliza['porcentaje'],
                        'COBERTURAPOLIZA_LOGIC_ESTADO'=>'A',
                        'US_COD_CREATED_UPDATED'=>$user->US_COD,
                    ]
                );
            }
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarAdmision(Request $request)
    {
        //VALIDACIONES GENERALES PARA ADMISION
        //el usuario, la poliza, y el beneficiario no pueden ser vacios
        $codigo_usuario= $request->input('codigo_usuario');
        $id_acompanante=$request->input('id_acompanante');
        $acompanante=$request->input('acompanante');
       
        if($codigo_usuario==null || $codigo_usuario==''){
            return response()->json(['mensaje' => 'Debe seleccionar un usuario para la admisión.'], 403);
        }
        if($acompanante=='A'){
            if($id_acompanante==null || $id_acompanante==''){
                return response()->json(['mensaje' => 'Debe seleccionar un acompañante puesto que ha seleccionado que el usaurio viene acompañado.'], 403);
            }
            //Se comprueba si el usuario asociado posee parentesco con el paciente.
            $usuario_parentesco = UsuariosParentesco::where('PARENTESCO_COD',$id_acompanante)
                ->where('USER_ID',$codigo_usuario) 
                ->where('PARENTESCO_LOGIC_ESTADO','A')
                ->first();
            if($usuario_parentesco==null || !isset($usuario_parentesco)){
                return response()->json(['mensaje' => 'El acompañante seleccionado no posee parentesco con el usuario a ingresar en admisiones.'], 403);
            }
            
        }else{
            $id_acompanante=null;
        }
        
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
        

                Cita::where('CITA_COD',$request->input('codigo'))->update(
                [
                    'CITA_ACOMPAÑANTE_COD' => $id_acompanante,
                    'CITA_OBS' => "",
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            //Se eliminan las polizas que se ingresaron previamente.
            CoberturaPoliza::where('CITA_COD',$request->input('codigo'))->delete();
            //Se ingresa los registros en la tabla cobertura poliza
            foreach ($request->input('coberturaPolizas') as  $poliza) {
                CoberturaPoliza::Create(
                    [
                        'CITA_COD'=>$request->input('codigo'),
                        'POLIZA_COD'=>$poliza['codigo_poliza'],
                        'BENEFICIARIO_COD'=>$poliza['codigo_usuario_beneficiario'],
                        'COBERTURAPOLIZA_PORCENTAJE'=>$poliza['porcentaje'],
                        'COBERTURAPOLIZA_LOGIC_ESTADO'=>'A',
                        'US_COD_CREATED_UPDATED'=>$user->US_COD,
                    ]
                );
            }
            
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    
}
