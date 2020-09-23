<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeCitas;

use App\GestionHospitalaria\AdministracionDeCitas\Diagnostico;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class DiagnosticoApiController extends Controller
{
    public function cargarDiagnosticoTabla()
    {
        try {
            $diagnostico = Diagnostico::where('DIAGNOSTICO_LOGIC_ESTADO', 'A')
                ->orderBy('DIAGNOSTICO_NOM', 'asc')
                ->get();
            return  response()->json(['diagnostico' => $diagnostico], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
