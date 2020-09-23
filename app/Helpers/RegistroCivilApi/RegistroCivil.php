<?php

namespace App\Helpers\RegistroCivilApi;
//use App\Helpers\RegistroCivilApi\lib\nusoap_client;
include 'lib/nusoap.php';
use nusoap_client;


class RegistroCivil
{
    
    public static function getFromRegistroCivil($nui)
    {
        

    date_default_timezone_set('America/Guayaquil');
    //require_once('lib/nusoap.php');

    //print_r("<br> NuSoap Correcto </br>");

    $cliente = new nusoap_client("https://wsprodu.registrocivil.gob.ec/WsRegistroCivil/ConsultaCiudadano?wsdl",'wsdl');

    //print_r("<br> SoapCliente </br>");

    $codins = '18';
    $codage = '18';
    $user = 'hleonb1';
    $pass = 'Pt456n@Qye';
    
    $nui = trim($nui);


    $prm = array("CodigoInstitucion"=>$codins ,"CodigoAgencia"=>$codage, "Usuario"=>$user, "Contrasenia"=>$pass,"NUI"=>$nui);


    $resultado = $cliente->call('BusquedaPorNui',$prm);
    //print('dd patriaaa');
    //print($resultado);
    if ($resultado == false) {
        return $cliente->error_str;
    }


    $Calle=$resultado['return']["Calle"];
    $CodigoError=$resultado['return']["CodigoError"];
    $CondicionCedulado=$resultado['return']["CondicionCedulado"];
    $Conyuge=$resultado['return']["Conyuge"];
    $Domicilio=$resultado['return']["Domicilio"];
    $FechaCedulacion=$resultado['return']["FechaCedulacion"];
    $FechaFallecimiento=$resultado['return']["FechaFallecimiento"];
    $FechaNacimiento=$resultado['return']["FechaNacimiento"];
    $Instruccion=$resultado['return']["Instruccion"];
    $LugarNacimiento=$resultado['return']["LugarNacimiento"];
    $NUI=$resultado['return']["NUI"];
    $Nacionalidad=$resultado['return']["Nacionalidad"];
    $Nombre=$resultado['return']["Nombre"];
    $NombreMadre=$resultado['return']["NombreMadre"];
    $NombrePadre=$resultado['return']["NombrePadre"];
    $NumeroCasa=$resultado['return']["NumeroCasa"];
    $Sexo=$resultado['return']["Sexo"];

    return $resultado;


    
    }
    
}
