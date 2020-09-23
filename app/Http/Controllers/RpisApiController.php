<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GestionHospitalaria\Pacientes\PolizaApiController;
use App\User;
use Exception;
use Goutte\Client;
use Illuminate\Http\Request;
use stdClass;
use Symfony\Component\HttpClient\HttpClient;

class RpisApiController extends Controller
{
    public function cargarSegurosPacientePorFecha($codigo_usuario, $fecha_consulta){
        //Se hace select a la tabla organizaciones.
        try {
            $cobertura_seguros = array();
            //Se obtiene el usuario con su cedula.
            $user= User::where('id',$codigo_usuario)
                ->with('identificaciones')
                ->first();
            $cedula='';
            foreach ($user->identificaciones as  $identificacion) {
                if($identificacion->ID_COD=='CEDULA'){
                    $cedula=$identificacion->USID_CODIGO;
                    break;
                }
            }
            if($cedula==''){
                return response()->json(['msg' => 'El usuario no posee una identificación del tipo cedula.' ], 421);
            }
            
            $client = new Client(HttpClient::create(['timeout' => 60]));
            $fecha= $fecha_consulta;
            $crawler = $client->request('GET', 'https://coresalud.msp.gob.ec/coresalud/app.php/publico/rpis/afiliacion/consultafiliacion/'.$cedula.'/'.$fecha);
            $filter0='table-responsive';
            $filter= 'font-weight: normal';
            $filter2='border: 1px solid  #AED0EA;padding: 3px';
            $findme   = 'Si registra cobertura';
            $indice=0;
            $crawler->filter("[class='$filter0']")->each(function($node) use($filter,$filter2, &$cobertura_seguros,&$indice,$findme) {
                if($indice==0){
                    $node->filter("[style='$filter']")->each(function($node2) use($filter2, &$cobertura_seguros,$findme) {
                        $objeto= new stdClass();
                        $objeto->nombre_seguro=$node2->filter("[style='$filter2']")->first()->text();
                        $objeto->posee_cobertura= $node2->filter("[style='$filter2']")->last()->text();
                        $objeto->tipo_seguro='PU';//publico 
                        //Se averigua si posee cobertura
                        $posicionPalabraEncontrada = strpos($objeto->posee_cobertura, $findme)!==false;
                        $objeto->posee_cobertura_bool=$posicionPalabraEncontrada;
                        array_push($cobertura_seguros,$objeto);
                     });
                }else{
                    $node->filter("[style='$filter']")->each(function($node2) use($filter2, &$cobertura_seguros,$findme) {
                        $objeto= new stdClass();
                        $objeto->nombre_seguro=$node2->filter("[style='$filter2']")->eq(1)->text();
                        $objeto->posee_cobertura= $node2->filter("[style='$filter2']")->eq(2)->text();
                        $objeto->tipo_seguro='PR';//privado 
                        $objeto->posee_cobertura_bool= true;
                        array_push($cobertura_seguros,$objeto);
                     });
                }
                
                 $indice++;
            });
             //Se procede a actualizar o crear las nuevas polizas del usuario.
             PolizaApiController::guardarPolizaDesdeRpis($codigo_usuario, $cobertura_seguros);
            
            
            return  response()->json(['datos' =>$cobertura_seguros], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarSegurosPaciente($codigo_usuario)
    {
        //Se hace select a la tabla organizaciones.
        try {
            $cobertura_seguros = array();
            //Se obtiene el usuario con su cedula.
            $user= User::where('id',$codigo_usuario)
                ->with('identificaciones')
                ->first();
            $cedula='';
            foreach ($user->identificaciones as  $identificacion) {
                if($identificacion->ID_COD=='CEDULA'){
                    $cedula=$identificacion->USID_CODIGO;
                    break;
                }
            }
            if($cedula==''){
                return response()->json(['msg' => 'El usuario no posee una identificación del tipo cedula.' ], 421);
            }
            $client = new Client(HttpClient::create(['timeout' => 60]));
            $fecha= getFechaCoberturaSeguro();
            $crawler = $client->request('GET', 'https://coresalud.msp.gob.ec/coresalud/app.php/publico/rpis/afiliacion/consultafiliacion/'.$cedula.'/'.$fecha);
            $filter0='table-responsive';
            $filter= 'font-weight: normal';
            $filter2='border: 1px solid  #AED0EA;padding: 3px';
            $indice=0;
            $findme   = 'Si registra cobertura';
            $crawler->filter("[class='$filter0']")->each(function($node) use($filter,$filter2, &$cobertura_seguros,&$indice,$findme) {
                if($indice==0){
                    //SegurosPublicos
                    $node->filter("[style='$filter']")->each(function($node2) use($filter2, &$cobertura_seguros,$findme) {
                        $objeto= new stdClass();
                        $objeto->nombre_seguro=$node2->filter("[style='$filter2']")->first()->text();
                        $objeto->posee_cobertura= $node2->filter("[style='$filter2']")->last()->text();
                        $objeto->tipo_seguro='PU';//publico 
                        //Se averigua si posee cobertura
                        $posicionPalabraEncontrada = strpos($objeto->posee_cobertura, $findme)!==false;
                        $objeto->posee_cobertura_bool=$posicionPalabraEncontrada;
                        
                        array_push($cobertura_seguros,$objeto);
                     });
                }else{
                    //Segurosprivados
                    $node->filter("[style='$filter']")->each(function($node2) use($filter2, &$cobertura_seguros,$findme) {
                        $objeto= new stdClass();
                        $objeto->nombre_seguro=$node2->filter("[style='$filter2']")->eq(1)->text();
                        $objeto->posee_cobertura= $node2->filter("[style='$filter2']")->eq(2)->text();
                        $objeto->tipo_seguro='PR';//privado 
                        $objeto->posee_cobertura_bool= true;
                       
                        array_push($cobertura_seguros,$objeto);
                     });
                }
                
                 $indice++;
            });
            //Se procede a actualizar o crear las nuevas polizas del usuario.
            $prueba=PolizaApiController::guardarPolizaDesdeRpis($codigo_usuario, $cobertura_seguros);
            
            return  response()->json(['datos' =>$cobertura_seguros, 'prueba'=>$prueba], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function descargarPdfSegurosPaciente($codigo_usuario){
        
        //Se hace select a la tabla organizaciones.
        try {
          
            //Se obtiene el usuario con su cedula.
            $user= User::where('id',$codigo_usuario)
                ->with('identificaciones')
                ->first();
            $cedula='';
            foreach ($user->identificaciones as  $identificacion) {
                if($identificacion->ID_COD=='CEDULA'){
                    $cedula=$identificacion->USID_CODIGO;
                    break;
                }
            }
            if($cedula==''){
                return response()->json(['msg' => 'El usuario no posee una identificación del tipo cedula.' ], 421);
            }
            $client = new \GuzzleHttp\Client();
            $fecha= getFechaCoberturaSeguro();
            $url='https://coresalud.msp.gob.ec/coresalud/app.php/publico/rpis/afiliacion/pdf/'.$cedula.'/'.$fecha;
           
            $response = $client->get($url);
            $body= json_decode($response->getBody()->__toString());
            $urlPdf='https://coresalud.msp.gob.ec'.$body->filename;
            return  response()->json(['url'=>$urlPdf], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function descargarPdfSegurosPacientePorFecha($codigo_usuario,$fecha_consulta){
        //Se hace select a la tabla organizaciones.
        try {
          
            //Se obtiene el usuario con su cedula.
            $user= User::where('id',$codigo_usuario)
                ->with('identificaciones')
                ->first();
            $cedula='';
            foreach ($user->identificaciones as  $identificacion) {
                if($identificacion->ID_COD=='CEDULA'){
                    $cedula=$identificacion->USID_CODIGO;
                    break;
                }
            }
            if($cedula==''){
                return response()->json(['msg' => 'El usuario no posee una identificación del tipo cedula.' ], 421);
            }
            $client = new \GuzzleHttp\Client();
            $fecha= $fecha_consulta;
           
            $url='https://coresalud.msp.gob.ec/coresalud/app.php/publico/rpis/afiliacion/pdf/'.$cedula.'/'.$fecha;
            
            $response = $client->get($url);
            $body= json_decode($response->getBody()->__toString());
            $urlPdf='https://coresalud.msp.gob.ec'.$body->filename;
            return  response()->json(['url'=>$urlPdf], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

}
