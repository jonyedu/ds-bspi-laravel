<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\TallaPantalon;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class TallaPantalonApiController extends Controller
{
    public function cargarTallasPantalon()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tallasPantalon = TallaPantalon::where('TALLAPANTALON_LOGIC_ESTADO', 'A')->orderBy('TALLAPANTALON_NOM', 'asc')->get();
            return  response()->json(['tallasPantalon' => $tallasPantalon], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
