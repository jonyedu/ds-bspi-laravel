<?php

namespace App\Http\Controllers\GestionHospitalaria\Pacientes;

use App\GestionHospitalaria\Generalidades\Aseguradoras;
use App\GestionHospitalaria\Pacientes\BeneficiariosPoliza;
use App\GestionHospitalaria\Pacientes\Poliza;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PolizaApiController extends Controller
{
    public function cargarPolizasTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $polizas = Poliza::with('aseguradora', 'usuario_poliza')->where('POLIZA_LOGIC_ESTADO', 'A')->orderBy('POLIZA_COD', 'desc')->get();
            return  response()->json(['datos' => $polizas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarPolizasPorUsuario($id)
    {
        //Se hace select a la tabla organizaciones.
        try {
            $polizas = Poliza::with('aseguradora', 'usuario_poliza')->where('USER_ID',$id)
                ->where('POLIZA_LOGIC_ESTADO', 'A')
                ->orderBy('POLIZA_COD', 'desc')->get();
            return  response()->json(['datos' => $polizas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarPolizasLista()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $polizas = Poliza::select('POLIZA_COD', 'ASEGURADORA_COD', 'USER_ID')->where('POLIZA_LOGIC_ESTADO', 'A')->orderBy('POLIZA_COD', 'desc')->get();
            return  response()->json(['datos' => $polizas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarArchivos(Request $request)
    {
        try {
            $file = $request->file('pdfPoliza');
            
            $destinationPath=public_path('files');

            // Generate a file name with extension
            if ($file != null && $file != '') {
                $filePoliza = 'poliza-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filePoliza);
                $pathPoliza='/'.'files/'.$filePoliza;
                //$pathPoliza = $file->storeAs('public/files.PolizasPerfil', $filePoliza);
            } 
           
            return response()->json([
                'pathPoliza' => isset($pathPoliza) && $pathPoliza != null ? $pathPoliza : ''
            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }

        //dd($path);

    }


    public function guardarPoliza(Request $request)
    {
     
        $request->validate([
            'codigo_aseguradora' =>  "required",
            'codigo_usuario' =>  "required",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            //Se procede a buscar el registro a ver si existe
            $polizaBase = Poliza::where('ASEGURADORA_COD', $request->input('codigo_aseguradora'))
                ->where('USER_ID', $request->input('codigo_usuario'))
                ->where('POLIZA_LOGIC_ESTADO','A')
                ->first();
            if (!isset($polizaBase)) {
                $poliza=Poliza::Create(
                    [
                        'ASEGURADORA_COD' => $request->input('codigo_aseguradora'),
                        'USER_ID' => $request->input('codigo_usuario'),
                        'POLIZA_DOCUMENTO' => $request->input('pathPoliza'),
                        'POLIZA_NUMERO' => is_null($request->input('poliza_numero'))  ? '' : $request->input('poliza_numero'),
                        'POLIZA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                        'POLIZA_LOGIC_ESTADO' => 'A'
                    ]
                );
                //Se procede a asociar a ese usuario como beneficiario de la poliza.
                BeneficiariosPoliza::Create(
                    [
                        'POLIZA_COD' => $poliza->POLIZA_COD,
                        'USER_ID' => $request->input('codigo_usuario'),
                        'BENEFICIARIO_OBS' => 'Autogenerada',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                        'BENEFICIARIO_LOGIC_ESTADO' => 'A'
                    ]
                );
            }else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['msg' => 'La poliza ya se encuentra registrada'], 421);
            }
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    
    public function eliminarPoliza(Request $request, $id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                //Se procede a anular los beneficiarios asociados a la poliza
                BeneficiariosPoliza::where('POLIZA_COD',$id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'BENEFICIARIO_LOGIC_ESTADO' => 'I'
                ]);
                Poliza::where('POLIZA_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'POLIZA_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id de poliza es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public static function guardarPolizaDesdeRpis($codigo_usuario, $polizas){
        //Se procede a crear un aray con las polizas que posea cobertura.
        $polizasConCobertura=array();
       
        foreach ($polizas as  $poliza) {
            if($poliza->posee_cobertura_bool){
                array_push($polizasConCobertura,$poliza);
            }   
        }
        
        $user = Auth::user();
        $nombres_aseguradora=array();
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
   
        try {
            $gestionHospitalariaDb->beginTransaction();
            if(sizeof($polizasConCobertura)==0){
                //Se procede a inactivar todas las polizas del usuario
                 Poliza::where('USER_ID',$codigo_usuario)
                ->where('ASEGURADORA_COD','!=',2)
                ->update([
                    'POLIZA_LOGIC_ESTADO'=>'I'
                ]);
               
                $polizas_anuladas= Poliza::where('USER_ID',$codigo_usuario)
                    ->where('POLIZA_LOGIC_ESTADO','I')
                    ->get()
                    ->map(function ($poliza) {
                        return $poliza->POLIZA_COD;
                    });
                   
                //Se anula los beneficiarios de las polizas inactivas
                BeneficiariosPoliza::whereIn('POLIZA_COD',$polizas_anuladas)
                    ->update([
                        'BENEFICIARIO_LOGIC_ESTADO'=>'I'
                    ]);
            }
            
            foreach ($polizasConCobertura as  $polizaCobertura) {
                array_push($nombres_aseguradora, $polizaCobertura->nombre_seguro);
                //Se procede a comprobar que la aseguradora exista
                $aseguradora  = Aseguradoras::where('ASEGURADORA_NOM',$polizaCobertura->nombre_seguro)
                    ->first();
                if($aseguradora==null){
                    //Se crea la aseguradora
                    $aseguradora = new Aseguradoras();
                    $aseguradora->ASEGURADORA_NOM= $polizaCobertura->nombre_seguro;
                    $aseguradora->ASEGURADORA_TIPO= $polizaCobertura->tipo_seguro;
                    $aseguradora->ASEGURADORA_OBS= 'CREADA A PARTIR DE CONSULTA RPIS'; 
                    $aseguradora->ASEGURADORA_LOGIC_ESTADO = 'A';
                    $aseguradora->US_COD_CREATED_UPDATED = $user->US_COD;
                    $aseguradora->save();
                    //Se procede a añadir una poliza al usuario
                    $poliza= new Poliza();
                    $poliza->ASEGURADORA_COD=$aseguradora->ASEGURADORA_COD;
                    $poliza->USER_ID=$codigo_usuario;
                    $poliza->POLIZA_OBS= 'CREADA A PARTIR DE CONSULTA RPIS'; 
                    $poliza->POLIZA_LOGIC_ESTADO='A';
                    $poliza->US_COD_CREATED_UPDATED = $user->US_COD;
                    $poliza->save();
                    //Se procede a añadir un beneficiario a la poliza creada.
                    $beneficiarioPoliza= new BeneficiariosPoliza();
                    $beneficiarioPoliza->POLIZA_COD=$poliza->POLIZA_COD;
                    $beneficiarioPoliza->USER_ID=$codigo_usuario;
                    $beneficiarioPoliza->BENEFICIARIO_OBS = 'CREADA A PARTIR DE CONSULTA RPIS'; 
                    $beneficiarioPoliza->BENEFICIARIO_LOGIC_ESTADO='A';
                    $beneficiarioPoliza->US_COD_CREATED_UPDATED=$user->US_COD;
                    $beneficiarioPoliza->save();
                }else{
                    //Existe la aseguradora, se modifica el estado en caso de que este anulada.
                    $aseguradora->ASEGURADORA_LOGIC_ESTADO = 'A';
                    $aseguradora->save();
                    //Se procede a comprobar si el usuario tiene una poliza asignada con la asegudora.
                    $poliza= Poliza::where('ASEGURADORA_COD',$aseguradora->ASEGURADORA_COD)
                        ->where('USER_ID',$codigo_usuario)
                        ->first();
                    if($poliza==null){
                        //la poliza no existe se procede a crearla
                        $poliza= new Poliza();
                        $poliza->ASEGURADORA_COD=$aseguradora->ASEGURADORA_COD;
                        $poliza->USER_ID=$codigo_usuario;
                        $poliza->POLIZA_OBS= 'CREADA A PARTIR DE CONSULTA RPIS'; 
                        $poliza->POLIZA_LOGIC_ESTADO='A';
                        $poliza->US_COD_CREATED_UPDATED = $user->US_COD;
                        $poliza->save();
                    }else
                    {
                        //la poliza existe se modifica el status en caso de que este anulado
                        $poliza->POLIZA_LOGIC_ESTADO = 'A';
                        $poliza->save();
                    }
                    //Se comprueba si existe beneficiarios para la poliza
                    $beneficiarioPoliza= BeneficiariosPoliza::where('POLIZA_COD',$poliza->POLIZA_COD)
                        ->where('USER_ID',$codigo_usuario)
                        ->first();
                    if($beneficiarioPoliza==null){
                        //si no existe el benifiario poliza se lo crea
                        $beneficiarioPoliza= new BeneficiariosPoliza();
                        $beneficiarioPoliza->POLIZA_COD=$poliza->POLIZA_COD;
                        $beneficiarioPoliza->USER_ID=$codigo_usuario;
                        $beneficiarioPoliza->BENEFICIARIO_OBS = 'CREADA A PARTIR DE CONSULTA RPIS'; 
                        $beneficiarioPoliza->BENEFICIARIO_LOGIC_ESTADO='A';
                        $beneficiarioPoliza->US_COD_CREATED_UPDATED=$user->US_COD;
                        $beneficiarioPoliza->save();
                    }else{
                        //en caso de que exista se procede a actualizar el estado en el caso de que este anulada.
                        $beneficiarioPoliza->BENEFICIARIO_LOGIC_ESTADO= 'A';
                        $beneficiarioPoliza->save();
    
                    }
                }
    
            }
            
            //Se procede a inactivar las polizas y beneficiarios que no aparecen en la lista de polizas  activas
            $aseguradoras_activas= Aseguradoras::select('ASEGURADORA_COD')
                ->whereIn('ASEGURADORA_NOM',$nombres_aseguradora)
                ->get()
                ->map(function ($aseguradora) {
                    return $aseguradora->ASEGURADORA_COD;
                });
  
          
         
           
            $polizas_no_activas= Poliza::whereNotIn('ASEGURADORA_COD',$aseguradoras_activas)
                ->where('USER_ID',$codigo_usuario)
                ->where('ASEGURADORA_COD','!=',2)
                ->get()
                ->map(function ($poliza) {
                    return $poliza->POLIZA_COD;
                });
          
            Poliza::whereIn('POLIZA_COD',$polizas_no_activas)
                ->update([
                    'POLIZA_LOGIC_ESTADO'=>'I'
                ]);
           
            //Se anula los beneficiarios de las polizas inactivas
            BeneficiariosPoliza::whereIn('POLIZA_COD',$polizas_no_activas)
                ->update([
                    'BENEFICIARIO_LOGIC_ESTADO'=>'I'
                ]);
            $gestionHospitalariaDb->commit();
            return "Exito";
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
        }
        
    }
}
