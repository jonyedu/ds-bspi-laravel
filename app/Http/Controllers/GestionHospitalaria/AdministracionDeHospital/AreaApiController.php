<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeHospital;


use App\GestionHospitalaria\AdministracionDeHospital\Area;
use App\User;
use App\GestionHospitalaria\AdministracionDeHospital\Hospital;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AreaApiController extends Controller
{
    public function cargarAreaTabla()
    {
        //Se hace select a las tablas organismo, usuarios y cargo en organismo


        try {
            $hospitales = Hospital::select('HOSPITAL_COD', 'HOSPITAL_NOM')
            ->where('HOSPITAL_LOGIC_ESTADO', 'A')
                ->orderBy('HOSPITAL_NOM', 'asc')->get();
           
            $areas = Area::select('*')
                ->join('hospital', 'areas.HOSPITAL_COD', '=', 'hospital.HOSPITAL_COD')
                ->select(
                    'AREA_NOM',
                    'AREA_COD',
                    
                    'hospital.HOSPITAL_COD',
                    'hospital.HOSPITAL_NOM',
                    
                    
                    
                    'AREA_OBS'
                )
                ->where('AREA_LOGIC_ESTADO','A')
                ->get();


            return response()->json(['areas' => $areas, 'hospitales' => $hospitales]);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarArea(Request $request)
    {
        $estado='I';
        $request->validate([
            //'activo' => 'required|string|max:2',
            'hospital_cod' => 'required',
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.areas,AREA_NOM," . $estado . ",AREA_LOGIC_ESTADO",
        ]);

        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Area::Create(
                [
                    'AREA_NOM' => $request->input('nombre'),
                    'HOSPITAL_COD' => $request->input('hospital_cod'),
                    'AREA_PISO' => 0,
                    'AREA_LOGIC_ESTADO' => 'A',
                    'AREA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function modificarArea(Request $request)
    {
        $request->validate([
            'hospital_cod' => 'required',
            //'activo' => 'required|string|max:2',
            'area_cod' => 'required',
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.habitaciones,HABITACION_NOM," . $estado . ",HABITACION_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            
            $area_cod=$request->input('area_cod');
            
            Area::where('AREA_COD', $area_cod)
                
                ->update([
                    
                    'HOSPITAL_COD' => $request->input('hospital_cod'),
                    
                    
                    'AREA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarArea(Request $request)
    {
        $area_cod=$request->input('area_cod');
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Area::where('AREA_COD', $area_cod)
                ->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'AREA_LOGIC_ESTADO' => 'I'
                ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
            
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
