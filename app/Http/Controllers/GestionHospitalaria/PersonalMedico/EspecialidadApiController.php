<?php

namespace App\Http\Controllers\GestionHospitalaria\PersonalMedico;

use App\GestionHospitalaria\AdministracionDeHospital\Especialidad;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class EspecialidadApiController extends Controller
{
    public static function cargarEspecialidadesLista()
    {
        try {
            $especialidades = Especialidad::select('ESPECIALIDAD_COD as codigo', 'ESPECIALIDAD_NOM as nombre')
            ->where('ESPECIALIDAD_LOGIC_ESTADO', 'A')->orderBy('ESPECIALIDAD_COD', 'desc')->get();
            return  response()->json(['datos' => $especialidades], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }


    public static function cargarEspecialidad($id){
        $funciones = Especialidad::where('ESPECIALIDAD_COD',$id)
                ->where('ESPECIALIDAD_LOGIC_ESTADO', 'A')
                ->with('especialidad','trabajadorPersonalSalud')->get();
    }
}
