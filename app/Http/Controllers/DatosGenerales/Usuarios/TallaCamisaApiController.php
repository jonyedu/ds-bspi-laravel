<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\TallaCamisa;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class TallaCamisaApiController extends Controller
{
    public function cargarTallas()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tallasCamisa = TallaCamisa::where('TALLACAMISA_LOGIC_ESTADO', 'A')->orderBy('TALLACAMISA_NOM', 'asc')->get();
            return  response()->json(['tallasCamisa' => $tallasCamisa], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
