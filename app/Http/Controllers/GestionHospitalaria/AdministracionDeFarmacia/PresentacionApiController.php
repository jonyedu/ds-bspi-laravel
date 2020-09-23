<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use App\GestionHospitalaria\AdministracionDeFarmacia\Presentacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PresentacionApiController extends Controller
{
    //

    

    public static function cargarPresentaciones(Request $request){
        try {
            
            $presentaciones=Presentacion::where('PRESENTACION_LOGIC_ESTADO','A')
            ->get();
            
            return response()->json(['presentaciones' => $presentaciones], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public static function cargarPresentacionesCombo(){
        try {
            
            $presentaciones=Presentacion::where('PRESENTACION_LOGIC_ESTADO','A')
            ->get();
            
            return $presentaciones;
        } catch (Exception $e) {
            
            return $e;
        }
    }


    public function guardarPresentacion(Request $request){
        
        $request->validate([
            'presentacion_nombre' =>  "required|string|max:250",
            'presentacion_unidad'=> "required|string|max:20"
            ]);
        
        $presentacion_nombre=$request->input('presentacion_nombre');
        
        $presentacion_unidad=$request->input('presentacion_unidad');
        $exists=Presentacion::where('PRESENTACION_LOGIC_ESTADO','A')
        ->where('PRESENTACION_UNIDAD',$presentacion_unidad)
        ->where('PRESENTACION_NOM',$presentacion_nombre)
        ->get();
        
        if($exists->count()>0)
        {
            return response()->json(['mensaje' => 'Ya existe esta esta asociacion!'], 500);
        }
        
           
       
        try {
            DB::beginTransaction();
            $user = Auth::user();
            Presentacion::Create(
                [
                    'PRESENTACION_NOM'=>$presentacion_nombre,
                    'PRESENTACION_UNIDAD'=>is_null($presentacion_unidad)  ? '' : $presentacion_unidad,
                    
                    
                    'PRESENTACION_LOGIC_ESTADO'=>'A',
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

    public function modificarPresentacion(Request $request){
        $estado = 'I';
        
        $request->validate([
            'presentacion_codigo' => 'required|integer',
            'presentacion_unidad'=> "required|string|max:20"
            
            
    ]);
        $presentacion_cod=$request->input('presentacion_codigo');
        $presentacion_nombre=$request->input('presentacion_nombre');
        $presentacion_precio=$request->input('presentacion_precio');
        $presentacion_unidad=$request->input('presentacion_unidad');    
        
           
       
        try {
            DB::beginTransaction();
            $user = Auth::user();
            Presentacion::where('PRESENTACION_COD',$presentacion_cod)->update(
                [
                    'PRESENTACION_NOM'=>$presentacion_nombre,
                    'PRESENTACION_UNIDAD'=>is_null($presentacion_unidad)  ? '' : $presentacion_unidad,                    
                    'PRESENTACION_LOGIC_ESTADO'=>'A',
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

    public function eliminarPresentacion(Request $request,$id){
        try {
            DB::beginTransaction();
            $user = Auth::user();
            Presentacion::where('PRESENTACION_COD',$id)->update(
                [
                    
                    'PRESENTACION_LOGIC_ESTADO'=>'I',
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
}
