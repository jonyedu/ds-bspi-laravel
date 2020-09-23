<?php

namespace App\Http\Controllers\GestionHospitalaria\Generalidades;

use App\GestionHospitalaria\Generalidades\Aseguradoras;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AseguradorasApiController extends Controller
{
    public function cargarAseguradorasTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $aseguradoras = Aseguradoras::select('ASEGURADORA_COD as codigo', 'ASEGURADORA_NOM as nombre', 'ASEGURADORA_NOM_CONTACTO as nombre_contacto', 'ASEGURADORA_TELF_CONTACTO as telefono_contacto', 'ASEGURADORA_EMAIL_CONTACTO as email_contacto', 'ASEGURADORA_OBS as observacion', 'ASEGURADORA_WEB_PAGE as web_page', 'ASEGURADORA_TIPO as tipo')->where('ASEGURADORA_LOGIC_ESTADO', 'A')->orderBy('ASEGURADORA_NOM', 'asc')->get();
            return  response()->json(['datos' => $aseguradoras], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarAseguradorasLista()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $aseguradoras = Aseguradoras::select('ASEGURADORA_COD as codigo', 'ASEGURADORA_NOM as nombre')->where('ASEGURADORA_LOGIC_ESTADO', 'A')->orderBy('ASEGURADORA_NOM', 'asc')->get();
            return  response()->json(['datos' => $aseguradoras], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarAseguradora(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.aseguradoras,ASEGURADORA_NOM," . $estado . ",ASEGURADORA_LOGIC_ESTADO",
            'nombre_contacto' => 'nullable|string|max:255',
            'telefono_contacto' => 'nullable|string|max:255',
            'email_contacto' => 'nullable|string|max:255',
            'observacion' => 'nullable|string|max:255',
            'web_page' => 'nullable|string|max:255',
            'tipo' => 'required|string|max:2',
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Aseguradoras::Create(
                [
                    'ASEGURADORA_NOM' => $request->input('nombre'),
                    'ASEGURADORA_NOM_CONTACTO' => is_null($request->input('nombre_contacto'))  ? '' : $request->input('nombre_contacto'),
                    'ASEGURADORA_TELF_CONTACTO' => is_null($request->input('telefono_contacto'))  ? '' : $request->input('telefono_contacto'),
                    'ASEGURADORA_EMAIL_CONTACTO' => is_null($request->input('email_contacto'))  ? '' : $request->input('email_contacto'),
                    'ASEGURADORA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'ASEGURADORA_WEB_PAGE' => is_null($request->input('web_page'))  ? '' : $request->input('web_page'),
                    'ASEGURADORA_TIPO' => is_null($request->input('tipo'))  ? '' : $request->input('tipo'),
                    'ASEGURADORA_LOGIC_ESTADO' => 'A',
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
    public function modificarAseguradora(Request $request)
    {
        $request->validate([
            'nombre_contacto' => 'nullable|string|max:255',
            'telefono_contacto' => 'nullable|string|max:255',
            'email_contacto' => 'nullable|string|max:255',
            'observacion' => 'nullable|string|max:255',
            'web_page' => 'nullable|string|max:255',
            'tipo' => 'required|string|max:2',
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Aseguradoras::where('ASEGURADORA_COD', $request->input('codigo'))->update([
                'ASEGURADORA_NOM_CONTACTO' => is_null($request->input('nombre_contacto'))  ? '' : $request->input('nombre_contacto'),
                'ASEGURADORA_TELF_CONTACTO' => is_null($request->input('telefono_contacto'))  ? '' : $request->input('telefono_contacto'),
                'ASEGURADORA_EMAIL_CONTACTO' => is_null($request->input('email_contacto'))  ? '' : $request->input('email_contacto'),
                'ASEGURADORA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'ASEGURADORA_WEB_PAGE' => is_null($request->input('web_page'))  ? '' : $request->input('web_page'),
                'ASEGURADORA_TIPO' => is_null($request->input('tipo'))  ? '' : $request->input('tipo'),
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarAseguradora(Request $request, $id)
    {

        try {
            $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Aseguradoras::where('ASEGURADORA_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'ASEGURADORA_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id de la aseguradora es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
