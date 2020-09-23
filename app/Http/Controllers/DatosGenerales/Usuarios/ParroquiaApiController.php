<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\Parroquias;
use App\DatosGenerales\Usuarios\Cantones;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParroquiaApiController extends Controller
{
    //

    public function cargarParroquias(){
        
        try{
            $parroquias=Parroquias::where('PARR_LOGIC_ESTADO', 'A')
            ->orderBy('PARR_NOM', 'asc')->get();
            $cantones=Cantones::select('CANTON_COD','CANTON_NOM')
            ->where('CANTON_LOGIC_ESTADO', 'A')
            ->orderBy('CANTON_NOM', 'asc')->get();
            return  response()->json(['parroquias' => $parroquias, 'cantones' => $cantones], 200);
        }catch(Exception $e){
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function cargarParroquiaUltimoId(){
        $parroquiaID=Parroquias::select('PARR_COD')
        
        ->orderBy('PARR_COD', 'desc')
        ->first();
        
            return $parroquiaID->PARR_COD +1;        
        
    }

    public function guardarParroquias(Request $request){
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:parroquias,PARR_NOM," . $estado . ",PARR_LOGIC_ESTADO",
            'canton_cod' => 'required|string|max:20',
            'activo' => 'required|string|max:2',
        ]);

        try {
            DB::beginTransaction();
            $id=$this->cargarParroquiaUltimoId();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Parroquias::Create(
                [
                    'PARR_COD' => $id,
                    'PARR_NOM' => $request->input('nombre'),
                    'PARR_ACTIVO' => $request->input('activo'),
                    'CANTON_COD' => $request->input('canton_cod'),
                    'PARR_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'PARR_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }


    }

    public function modificarParroquias(Request $request){
        $estado = 'I';
        $request->validate([
            'nombre' => 'required|string|max:250',
            'parroquia_cod' => 'required|string|max:20',
            'activo' => 'required|string|max:2',
        ]);

        try {
            DB::beginTransaction();
            $id=$request->input('parroquia_cod');
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Parroquias::where('PARR_COD',$id)->update(
                [
                    
                    'PARR_NOM' => $request->input('nombre'),
                    'PARR_ACTIVO' => $request->input('activo'),
                    'CANTON_COD' => $request->input('canton_cod'),
                    'PARR_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }


    }

    public function eliminarParroquias(Request $request)
    {
        $id=$request->input('parroquia_cod');

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Parroquias::where('PARR_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'PARR_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id del canton  es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}