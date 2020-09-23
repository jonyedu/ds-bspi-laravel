<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeHospital;

use App\GestionHospitalaria\AdministracionDeHospital\Hospital;
use App\GestionHospitalaria\AdministracionDeHospital\Habitacion;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HospitalApiController extends Controller
{
    public function cargarHospitalTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $hospital = Hospital::orderBy('HOSPITAL_NOM', 'asc')
            ->where('HOSPITAL_LOGIC_ESTADO','A')
            ->get();
            return  response()->json(['datos' => $hospital], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarModificarArchivo(Request $request)
    {
        try {
            $file = $request->file('logo');
            //echo "foto: " . $request->file('logo');
            $destinationPath=public_path('files');

            // Generate a file name with extension
            if ($file != null && $file != '') {
                $fileFoto = 'logoHospital-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileFoto);
                $pathFoto='/'.'files/'.$fileFoto;
            } 
            return response()->json(['pathFoto' => isset($pathFoto) && $pathFoto != null ? $pathFoto : ''], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarHospital(Request $request)
    {
        $estado = 'I';
        
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.hospital,HOSPITAL_NOM," . $estado . ",HOSPITAL_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            
        ]);
        //$gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            //$gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            $hospital = Hospital::Create(
                [
                    'HOSPITAL_NOM'=> $request->input('nombre'),
                    'HOSPITAL_NOM_CONTACTO'=>is_null($request->input('contacto'))  ? '' : $request->input('contacto'),
                    'HOSPITAL_TELF_CONTACTO'=>is_null($request->input('telf_contacto'))  ? '' : $request->input('telf_contacto'),
                    'HOSPITAL_EMAIL_CONTACTO'=>is_null($request->input('email_contacto'))  ? '' : $request->input('email_contacto'),
                    'HOSPITAL_WEB_PAGE'=>is_null($request->input('webpage'))  ? '' : $request->input('webpage'),
                    'HOSPITAL_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'HOSPITAL_LOGO'=>is_null($request->input('nuevaURL'))  ? '' : $request->input('nuevaURL'),
                    'HOSPITAL_LOGIC_ESTADO'=>'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            //$gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            //$gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarHospital(Request $request)
    {
        $request->validate([
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.aseguradoras,ASEGURADORA_NOM," . $estado . ",ASEGURADORA_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria'); 
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Hospital::where('HOSPITAL_COD', $request->input('hospital_cod'))->update([
                    //'HOSPITAL_NOM'=> $request->input('nombre'),
                    'HOSPITAL_NOM_CONTACTO'=>is_null($request->input('contacto'))  ? '' : $request->input('contacto'),
                    'HOSPITAL_TELF_CONTACTO'=>is_null($request->input('telf_contacto'))  ? '' : $request->input('telf_contacto'),
                    'HOSPITAL_EMAIL_CONTACTO'=>is_null($request->input('email_contacto'))  ? '' : $request->input('email_contacto'),
                    'HOSPITAL_WEB_PAGE'=>is_null($request->input('webpage'))  ? '' : $request->input('webpage'),
                    'HOSPITAL_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'HOSPITAL_LOGO'=>is_null($request->input('nuevaURL'))  ? '' : $request->input('nuevaURL'),
                    //'HOSPITAL_LOGIC_ESTADO'=>$request->input('activo'),
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarHospital(Request $request,$id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Hospital::where('HOSPITAL_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'HOSPITAL_LOGIC_ESTADO' => 'I'
                ]);
                Habitacion::where('HOSPITAL_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'HABITACION_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id del hospital es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
