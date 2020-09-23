<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeHospital;

use App\GestionHospitalaria\AdministracionDeHospital\Tipo_Cama;
use App\GestionHospitalaria\AdministracionDeHospital\Cama;
use App\User;
use App\GestionHospitalaria\AdministracionDeHospital\Habitacion;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CamaApiController extends Controller
{
    public function cargarCamaTabla()
    {
        //Se hace select a las tablas organismo, usuarios y cargo en organismo
        
        try {
            $habitaciones = Habitacion::select('HABITACION_COD', 'HABITACION_NOM')->where('HABITACION_LOGIC_ESTADO', 'A')
                ->orderBy('HABITACION_NOM', 'asc')->get();
            $tipos = Tipo_Cama::select('TIPOCAMA_COD', 'TIPOCAMA_NOM')
            ->where('TIPOCAMA_LOGIC_ESTADO', 'A')
                ->orderBy('TIPOCAMA_NOM', 'asc')->get();
           


            $camas = Cama::select('*')
                ->join('habitaciones', 'camas.HABITACION_COD', '=', 'habitaciones.HABITACION_COD')
                ->join('tipos_camas', 'camas.TIPOCAMA_COD', '=', 'tipos_camas.TIPOCAMA_COD')
                ->select(
                    'CAMA_NOM',
                    'CAMA_COD',
                    'CAMA_PRECIO',
                    
                    'habitaciones.HABITACION_COD',
                    'habitaciones.HABITACION_NOM',
                    'tipos_camas.TIPOCAMA_COD',
                    'tipos_camas.TIPOCAMA_NOM',
                    
                    
                    'CAMA_OBS'
                )
                ->where('CAMA_LOGIC_ESTADO','A')
                ->get();


            return response()->json(['camas' => $camas, 'habitaciones' => $habitaciones, 'tipos' => $tipos]);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarCama(Request $request)
    {
        $estado='I';
        $request->validate([
            'tipo_cod' => 'required',
            //'activo' => 'required|string|max:2',
            'habitacion_cod' => 'required',
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.camas,CAMA_NOM," . $estado . ",CAMA_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
            $user = Auth::user();
            Cama::Create(
                [
                    'CAMA_NOM' => $request->input('nombre'),
                    'CAMA_PRECIO'=>$request->input('precio'),
                    'HABITACION_COD' => $request->input('habitacion_cod'),
                    'TIPOCAMA_COD' => $request->input('tipo_cod'),
                    'CAMA_LOGIC_ESTADO' => 'A',
                    'CAMA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function modificarCama(Request $request)
    {
        $request->validate([
            'tipo_cod' => 'required',
            //'activo' => 'required|string|max:2',
            'cama_cod' => 'required',
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.habitaciones,HABITACION_NOM," . $estado . ",HABITACION_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            //$tipo_cod = $request->input('tipo_cod');
           // $hospital_cod = $request->input('hospital_cod');
            $cama_cod=$request->input('cama_cod');
            //$usuario_cod = $request->input('usuario_cod');
            Cama::where('CAMA_COD', $cama_cod)
                //->where('HOSPITAL_COD', $hospital_cod)
                //->where('TIPOHABITACION_COD', $tipo_cod)
                ->update([
                    //'HABITACION_NOM' => $request->input('nombre'),
                    'CAMA_PRECIO'=>$request->input('precio'),
                    'HABITACION_COD' => $request->input('habitacion_cod'),
                    'TIPOCAMA_COD' => $request->input('tipo_cod'),
                    //'CAMA_LOGIC_ESTADO' => $request->input('activo'),
                    'CAMA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarCama(Request $request)
    {
        $cama_cod=$request->input('cama_cod');
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Cama::where('CAMA_COD', $cama_cod)
                ->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'CAMA_LOGIC_ESTADO' => 'I'
                ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
            
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
