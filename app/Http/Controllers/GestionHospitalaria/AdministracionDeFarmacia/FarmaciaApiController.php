<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use App\GestionHospitalaria\AdministracionDeFarmacia\Farmacia;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FarmaciaApiController extends Controller
{
    public function cargarFarmaciaTabla()
    {
        try {
            $farmacia = Farmacia::orderBy('FARMACIA_NOM', 'asc')
                ->where('FARMACIA_LOGIC_ESTADO', 'A')
                ->get();
            return  response()->json(['farmacia' => $farmacia], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarFarmacia(Request $request)
    {
        $request->validate([
            'frm_nombre' =>  "required|string",
            'frm_email' =>  "email",
        ]);
        try {
            $user = Auth::user();
            Farmacia::Create(
                [
                    'FARMACIA_COD' => $request->input('frm_codigo'),
                    'FARMACIA_NOM' => $request->input('frm_nombre'),
                    'FARMACIA_TELF' => $request->input('frm_telefono'),
                    'FARMACIA_DIREC' => $request->input('frm_direccion'),
                    'FARMACIA_EMAIL' => $request->input('frm_email'),
                    'FARMACIA_OBS' => $request->input('frm_observacion'),
                    'FARMACIA_WEB_PAGE' => $request->input('frm_pagina_web'),
                    'FARMACIA_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarFarmacia(Request $request)
    {
        $request->validate([
            'frm_email' =>  "email",
        ]);
        try {
            $user = Auth::user();
            Farmacia::where('FARMACIA_COD', $request->input('frm_codigo'))->update([
                'FARMACIA_NOM' => $request->input('frm_nombre'),
                'FARMACIA_TELF' => $request->input('frm_telefono'),
                'FARMACIA_DIREC' => $request->input('frm_direccion'),
                'FARMACIA_EMAIL' => $request->input('frm_email'),
                'FARMACIA_OBS' => $request->input('frm_observacion'),
                'FARMACIA_WEB_PAGE' => $request->input('frm_pagina_web'),
                'FARMACIA_LOGIC_ESTADO' => 'A',
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarFarmacia(Request $request, $id)
    {
        try {
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Farmacia::where('FARMACIA_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'FARMACIA_LOGIC_ESTADO' => 'I'
                ]);
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id del hospital es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
