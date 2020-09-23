<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeHospital;

use App\GestionHospitalaria\AdministracionDeHospital\Habitacion;
use App\GestionHospitalaria\AdministracionDeHospital\Hospital;
use App\GestionHospitalaria\AdministracionDeHospital\Area;
use App\GestionHospitalaria\AdministracionDeHospital\Tipo_Habitacion;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\AtMost;

class HabitacionApiController extends Controller
{
    public function cargarHabitacionTabla()
    {
        //Se hace select a las tablas organismo, usuarios y cargo en organismo


        try {
            $hospitales = Hospital::select('HOSPITAL_COD', 'HOSPITAL_NOM')
            ->where('HOSPITAL_LOGIC_ESTADO', 'A')
                ->orderBy('HOSPITAL_NOM', 'asc')->get();
            $tipos = Tipo_Habitacion::select('TIPOHABITACION_COD', 'TIPOHABITACION_NOM')
            ->where('TIPOHABITACION_LOGIC_ESTADO', 'A')
                ->orderBy('TIPOHABITACION_NOM', 'asc')->get();          
            $areas= Area::select('AREA_COD','AREA_NOM')
            ->where('AREA_LOGIC_ESTADO','A')
            ->orderBy('AREA_NOM', 'asc')->get();

            $habitaciones = Habitacion::select('*')
                ->join('hospital', 'habitaciones.HOSPITAL_COD', '=', 'hospital.HOSPITAL_COD')
                ->join('tipos_habitacion', 'habitaciones.TIPOHABITACION_COD', '=', 'tipos_habitacion.TIPOHABITACION_COD')
                ->join('areas', 'areas.AREA_COD', '=', 'habitaciones.AREA_COD')
                ->select(
                    'HABITACION_NOM',
                    'HABITACION_COD',
                    'HABITACION_PRECIO',
                    'areas.AREA_NOM',
                    'areas.AREA_COD',
                    'hospital.HOSPITAL_COD',
                    'hospital.HOSPITAL_NOM',
                    'tipos_habitacion.TIPOHABITACION_COD',
                    'tipos_habitacion.TIPOHABITACION_NOM',
                    'HABITACION_OBS'
                )
                ->where('HABITACION_LOGIC_ESTADO','A')
                ->get();


            return response()->json(['habitaciones' => $habitaciones,'areas'=>$areas, 'hospitales' => $hospitales, 'tipos' => $tipos]);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarHabitacion(Request $request)
    {
        $estado='I';
        $request->validate([
            'tipo_cod' => 'required',
            'precio' => 'required',
            'area_cod' => 'required',
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.habitaciones,HABITACION_NOM," . $estado . ",HABITACION_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {

            $area=Area::where('AREA_COD',$request->input('area_cod'))->first();
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Habitacion::Create(
                [
                    'HABITACION_NOM' => $request->input('nombre'),
                    'HABITACION_PRECIO'=>$request->input('precio'),
                    'HOSPITAL_COD' => $area->HOSPITAL_COD,
                    'AREA_COD' => $request->input('area_cod'),
                    'TIPOHABITACION_COD' => $request->input('tipo_cod'),
                    'HABITACION_LOGIC_ESTADO' => 'A',
                    'HABITACION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function modificarHabitacion(Request $request)
    {
        $request->validate([
            'tipo_cod' => 'required',
            //'activo' => 'required|string|max:2',
            
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.habitaciones,HABITACION_NOM," . $estado . ",HABITACION_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $area=Area::where('AREA_COD',$request->input('area_cod'))->first();
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            $tipo_cod = $request->input('tipo_cod');
            
            $habitacion_cod=$request->input('habitacion_cod');
            //$usuario_cod = $request->input('usuario_cod');
            Habitacion::where('HABITACION_COD', $habitacion_cod)
                //->where('HOSPITAL_COD', $hospital_cod)
                //->where('TIPOHABITACION_COD', $tipo_cod)
                ->update([
                    //'HABITACION_NOM' => $request->input('nombre'),
                    'HABITACION_PRECIO'=>$request->input('precio'),
                    'HOSPITAL_COD' => $area->HOSPITAL_COD,
                    'TIPOHABITACION_COD' => $request->input('tipo_cod'),
                    //'HABITACION_LOGIC_ESTADO' => $request->input('activo'),
                    'HABITACION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarHabitacion(Request $request)
    {
        $habitacion_cod=$request->input('habitacion_cod');
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Habitacion::where('HABITACION_COD', $habitacion_cod)
                ->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'HABITACION_LOGIC_ESTADO' => 'I'
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
            
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
