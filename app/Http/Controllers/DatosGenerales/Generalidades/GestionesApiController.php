<?php

namespace App\Http\Controllers\DatosGenerales\Generalidades;

use App\DatosGenerales\Generalidades\Gestiones;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class GestionesApiController extends Controller
{
    public function cargarGestiones()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $gestiones = Gestiones::where('GESTION_LOGIC_ESTADO', 'A')->orderBy('GESTION_NOM', 'asc')->get();
            return  response()->json(['gestiones' => $gestiones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
