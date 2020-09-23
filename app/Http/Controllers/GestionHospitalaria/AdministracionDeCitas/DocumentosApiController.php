<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeCitas;

use App\GestionHospitalaria\AdministracionDeCitas\DocumentosCita;
use App\GestionHospitalaria\AdministracionDeCitas\DocumentosUsuario;
use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use system;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class DocumentosApiController extends Controller
{
    public function cargarDocumentosCita($idCita)
    {
        try {
            $docs = DocumentosCita::select('DOCUMENTOSCITA_COD as codigoDoc','CITA_COD as codigoUsuCita', 'DOCUMENTOSCITA_NOM as nombreDoc','DOCUMENTOSCITA_TIPO as tipoDoc', 'DOCUMENTOSCITA_OBS as obsDoc', 'DOCUMENTOSCITA_RUTA as rutaDoc','DOCUMENTOSCITA_LOGIC_ESTADO', 'created_at as fechaCreacion')
                ->where('CITA_COD',$idCita)
                ->where('DOCUMENTOSCITA_LOGIC_ESTADO', 'A')
                ->orderBy('created_at', 'asc')
                ->get();
            $docsArray = array();
            foreach ($docs as $key => $doc) {
                array_push($docsArray, $doc);
            }
            
            return  response()->json(['datos' => $docsArray],200);
        } catch (Exception $e) {
            
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function cargarDocumentosUsuario($idUsuario)
    {
        try {
            $docs = DocumentosUsuario::select('DOCUMENTOSUSUARIO_COD as codigoDoc','USER_ID as codigoUsuCita', 'DOCUMENTOSUSUARIO_NOM as nombreDoc','DOCUMENTOSUSUARIO_TIPO as tipoDoc', 'DOCUMENTOSUSUARIO_OBS as obsDoc', 'DOCUMENTOSUSUARIO_RUTA as rutaDoc','DOCUMENTOSUSUARIO_LOGIC_ESTADO', 'created_at as fechaCreacion')
            ->where('USER_ID',$idUsuario)    
            ->where('DOCUMENTOSUSUARIO_LOGIC_ESTADO', 'A')
                ->orderBy('created_at', 'asc')
                ->get();
            $docsArray = array();
            foreach ($docs as $key => $doc) {
                array_push($docsArray, $doc);
            }
            
            return  response()->json(['datos' => $docsArray],200);
        } catch (Exception $e) {
            
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function crearDocumentoCita(Request $request)
    {
        try {
            DB::beginTransaction();
            $fecha = getFullTime();
            $user = Auth::user();

            $cita = DocumentosCita::Create(
                [
                    'CITA_COD' => $request->input('codigo_cita'),
                    'DOCUMENTOSCITA_NOM' => $request->input('nombre'),
                    'DOCUMENTOSCITA_RUTA' => $request->input('file'),
                    'DOCUMENTOSCITA_OBS' => $request->input('observacion'),
                    'DOCUMENTOSCITA_TIPO' => $request->input('tipo'),
                    'DOCUMENTOSCITA_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );

            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function crearDocumentoUsuario(Request $request)
    {
        try {
            DB::beginTransaction();
            $fecha = getFullTime();
            $user = Auth::user();

            $cita = DocumentosUsuario::Create(
                [
                    'USER_ID' => $request->input('codigo_usuario'),
                    'DOCUMENTOSUSUARIO_NOM' => $request->input('nombre'),
                    'DOCUMENTOSUSUARIO_RUTA' => $request->input('file'),
                    'DOCUMENTOSUSUARIO_OBS' => $request->input('observacion'),
                    'DOCUMENTOSUSUARIO_TIPO' => $request->input('tipo'),
                    'DOCUMENTOSUSUARIO_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'created_at' => $fecha,
                    'updated_at' => $fecha,
                ]
            );

            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarDocumento(Request $request){
        try {
            $file = $request->file('archivo');
            $destinationPath=public_path('files');
            
            // Generate a file name with extension
            if ($file != null && $file != '') {
                $pos = strpos($file->getClientOriginalName(),".");
                $nombreDoc = substr($file->getClientOriginalName(),0,$pos);
                $fileContrato = $nombreDoc . ' - ' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileContrato);
                $pathContrato='/'.'files/'.$fileContrato;
            }else{
                return response()->json(['mensaje' => 'No Se Pudo Subir el Archivo.'], 500);
            }
            return response()->json([
                'path' => isset($pathContrato) && $pathContrato != null ? $pathContrato : ''
            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
        //dd($path);
    }

    public function AnularDocumentoUsuario(Request $request){
        try {
            DB::beginTransaction();
            DocumentosUsuario::where('USER_ID', $request->input('id'))->where('DOCUMENTOSUSUARIO_COD', $request->input('idDoc'))->update([
                'DOCUMENTOSUSUARIO_LOGIC_ESTADO' => 'I'
            ]);

            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function AnularDocumentoCita(Request $request){
        try {
            DB::beginTransaction();
            DocumentosCita::where('CITA_COD', $request->input('id'))->where('DOCUMENTOSCITA_COD', $request->input('idDoc'))->update([
                'DOCUMENTOSCITA_LOGIC_ESTADO' => 'I'
            ]);

            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function AnularAllDocs(Request $request){
        try {
            DB::beginTransaction();
            if($request->input('tipo')=="cita"){
                DocumentosCita::where('DOCUMENTOSCITA_LOGIC_ESTADO', 'A')->update([
                    'DOCUMENTOSCITA_LOGIC_ESTADO' => 'I'
                ]);
            }elseif($request->input('tipo')=="usuario"){
                DocumentosUsuario::where('DOCUMENTOSUSUARIO_LOGIC_ESTADO', 'A')->update([
                    'DOCUMENTOSUSUARIO_LOGIC_ESTADO' => 'I'
                ]);
            }

            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
