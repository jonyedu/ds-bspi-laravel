<?php

namespace App\Http\Controllers\GestionHospitalaria\PersonalMedico;

use App\GestionHospitalaria\PersonalMedico\Prueba;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class PruebaApiController extends Controller
{
    public function cargarPruebas()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $pruebas = Prueba::where("status",1)->orWhere("status",1)->first();
            return  response()->json(['datos' => $pruebas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
