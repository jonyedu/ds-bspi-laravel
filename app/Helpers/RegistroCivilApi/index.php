<?php



$result= consulta_de_datos_por_medio_de_la_cedula_al_web_service('0922571856');

function consulta_de_datos_por_medio_de_la_cedula_al_web_service($nui){

    date_default_timezone_set('America/Guayaquil');
    require_once('lib/nusoap.php');

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
    print('dd patriaaa');
    print($resultado);
    if ($resultado == false) {
        print $cliente->error_str;
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



 ?>
