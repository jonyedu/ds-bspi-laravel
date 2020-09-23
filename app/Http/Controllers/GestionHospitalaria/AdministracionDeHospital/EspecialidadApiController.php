<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeHospital;


use App\GestionHospitalaria\AdministracionDeHospital\Especialidad;
use App\User;
use App\GestionHospitalaria\AdministracionDeHospital\Hospital;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EspecialidadApiController extends Controller
{
    public function cargarEspecialidadTabla()
    {
        //Se hace select a las tablas organismo, usuarios y cargo en organismo


        try {
            $hospitales = Hospital::select('HOSPITAL_COD', 'HOSPITAL_NOM')
            ->where('HOSPITAL_LOGIC_ESTADO', 'A')
                ->orderBy('HOSPITAL_NOM', 'asc')->get();
           
            $especialidades = Especialidad::select('*')
                ->join('hospital', 'especialidades.HOSPITAL_COD', '=', 'hospital.HOSPITAL_COD')
                ->select(
                    'ESPECIALIDAD_NOM',
                    'ESPECIALIDAD_COD',
                    
                    'hospital.HOSPITAL_COD',
                    'hospital.HOSPITAL_NOM',
                    
                    
                    
                    'ESPECIALIDAD_OBS'
                )
                ->where('ESPECIALIDAD_LOGIC_ESTADO','A')
                ->orderBy('ESPECIALIDAD_COD','desc')
                ->get();


            return response()->json(['especialidades' => $especialidades, 'hospitales' => $hospitales]);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarEspecialidad(Request $request)
    {
        $estado='I';
        $request->validate([
            //'activo' => 'required|string|max:2',
            'hospital_cod' => 'required',
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.especialidades,ESPECIALIDAD_NOM," . $estado . ",ESPECIALIDAD_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Especialidad::Create(
                [
                    'ESPECIALIDAD_NOM' => $request->input('nombre'),
                    'HOSPITAL_COD' => $request->input('hospital_cod'),
                    'ESPECIALIDAD_LOGIC_ESTADO' => 'A',
                    'ESPECIALIDAD_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function modificarEspecialidad(Request $request)
    {
        $request->validate([
            'hospital_cod' => 'required',
            //'activo' => 'required|string|max:2',
            'especialidad_cod' => 'required',
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.habitaciones,HABITACION_NOM," . $estado . ",HABITACION_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
            $user = Auth::user();
            
            $especialidad_cod=$request->input('especialidad_cod');
            
            Especialidad::where('ESPECIALIDAD_COD', $especialidad_cod)
                
                ->update([
                    
                    'HOSPITAL_COD' => $request->input('hospital_cod'),
                    
                    
                    'ESPECIALIDAD_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarEspecialidad(Request $request)
    {
        

        $especialidad_cod=$request->input('especialidad_cod');
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Especialidad::where('ESPECIALIDAD_COD', $especialidad_cod)
                ->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'ESPECIALIDAD_LOGIC_ESTADO' => 'I'
                ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
            
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
