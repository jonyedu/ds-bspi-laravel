<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeHospital;

use App\GestionHospitalaria\AdministracionDeHospital\Tipo_Habitacion;
use App\GestionHospitalaria\AdministracionDeHospital\Habitacion;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoDeHabitacionApiController extends Controller
{
    public function cargarTipoDeHabitacionTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tipoHabitaciones = Tipo_Habitacion::select('TIPOHABITACION_COD as codigo',
            'TIPOHABITACION_NOM as nombre',
            'TIPOHABITACION_OBS as observacion',
            'TIPOHABITACION_LOGIC_ESTADO as activo')
            ->where('TIPOHABITACION_LOGIC_ESTADO','A')
            ->orderBy('TIPOHABITACION_NOM', 'asc')->get();
            return  response()->json(['datos' => $tipoHabitaciones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoDeHabitacion(Request $request)
    {
        $estado = 'I';
        
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.tipos_habitacion,TIPOHABITACION_NOM,".$estado.",TIPOHABITACION_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            
        ]);
            //$active=$request->input('activo')=='S' ? 'A' : 'I';
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Tipo_Habitacion::Create(
                [
                    'TIPOHABITACION_NOM'=> $request->input('nombre'),
                    'TIPOHABITACION_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'TIPOHABITACION_LOGIC_ESTADO'=>'A',
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
    public function modificarTipoDeHabitacion(Request $request)
    {
        $request->validate([
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.aseguradoras,ASEGURADORA_NOM," . $estado . ",ASEGURADORA_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Tipo_Habitacion::where('TIPOHABITACION_COD', $request->input('codigo'))->update([
                //'TIPOHABITACION_NOM'=> $request->input('nombre'),
                    'TIPOHABITACION_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    //'TIPOHABITACION_LOGIC_ESTADO'=>'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarTipoDeHabitacion(Request $request, $id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            if ($id !== '' && isset($id)) {
                $gestionHospitalariaDb->beginTransaction();
                $user = Auth::user();
                Tipo_Habitacion::where('TIPOHABITACION_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOHABITACION_LOGIC_ESTADO' => 'I'
                ]);
                Habitacion::where('HOSPITAL_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'HABITACION_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id de la aseguradora es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
