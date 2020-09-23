<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\TallaZapato;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class TallaZapatoApiController extends Controller
{
    public function cargarTallasZapato()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tallasZapato = TallaZapato::where('TALLAZAPATO_LOGIC_ESTADO', 'A')->orderBy('TALLAZAPATO_NOM', 'asc')->get();
            return  response()->json(['tallasZapato' => $tallasZapato], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
