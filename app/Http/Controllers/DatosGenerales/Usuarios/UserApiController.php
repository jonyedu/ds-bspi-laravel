<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Generalidades\Configuracion;
use App\DatosGenerales\Generalidades\IdentificacionesYUsuario;
use App\DatosGenerales\Generalidades\Identificaciones;
use App\GestionHospitalaria\Generalidades\Aseguradoras;
use App\GestionHospitalaria\Pacientes\BeneficiariosPoliza;
use App\GestionHospitalaria\Pacientes\Poliza;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Undefined;

class UserApiController extends Controller
{
    public function cargarUsuarios()
    {

        try {

            $usuarios = User::where('USER_LOGIC_ESTADO', 'A')->with('identificaciones')
                ->orderBy('id', 'desc')->get();
            return  response()->json(['usuarios' => $usuarios], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarUsuariosCampos()
    {

        try {

            $usuarios = User::select('US_COD', 'US_NOM', 'US_APELL', 'id')->where('US_ACTIVO', 'S')->where('USER_LOGIC_ESTADO', 'A')->orderBy('US_NOM', 'asc')->get();
            return  response()->json(['usuarios' => $usuarios], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function obtenerUsuarioPorId($id)
    {

        try {
            if ($id !== '' && isset($id)) {
                $usuario = User::where('US_COD', $id)->where('USER_LOGIC_ESTADO', 'A')
                    ->with(
                        'tipoSangre',
                        'religion',
                        'grupoCultural',
                        'pais',
                        'tipoCasa',
                        'movilizacion',
                        'discapacidad',
                        'tallaZapato',
                        'tallaCamisa',
                        'tallaPantalon',
                        'identificaciones',
                        'polizas.aseguradora'
                    )
                    ->first();
                foreach ($usuario->polizas as  $poliza) {
                    $usuario_titular = User::select('US_NOM', 'US_APELL')->where('id', $poliza->USER_ID)->first();
                    $poliza->POLIZA_TITULAR_NOM = $usuario_titular->US_NOM . ' ' . $usuario_titular->US_APELL;
                }

                return response()->json(['usuario' => $usuario], 200);
            } else {
                return response()->json(['mensaje' => 'El id del usuario es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarArchivos(Request $request)
    {
        try {
            $file = $request->file('fotoUsuario');
            $file1 = $request->file('pdfCedula');
            $file2 = $request->file('pdfConadis');
            $file3 = $request->file('pdfMsp');
            $destinationPath = public_path('files');

            // Generate a file name with extension
            if ($file != null && $file != '') {
                $fileFoto = 'profile-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileFoto);
                $pathFoto = '/' . 'files/' . $fileFoto;
                //$pathFoto = $file->storeAs('public/files.fotosPerfil', $fileFoto);
            }
            if ($file1 != null &&  $file1 != '') {
                $fileCedula = 'cedula-' . time() . '.' . $file1->getClientOriginalExtension();
                $file1->move($destinationPath, $fileCedula);
                $pathCedula = '/' . 'files/' . $fileCedula;
                //$pathCedula = $file1->storeAs('public/files.pdfCedulas', $fileCedula);
            }
            if ($file2 != null && $file2 != '') {
                $fileConadis = 'conadis-' . time() . '.' . $file2->getClientOriginalExtension();
                //$pathConadis = $file1->storeAs('public/files.pdfConadis', $fileConadis);
                $file2->move($destinationPath, $fileConadis);
                $pathConadis = '/' . 'files/' . $fileConadis;
            }
            if ($file3 != null && $file3 != '') {
                $fileMSP = 'msp-' . time() . '.' . $file3->getClientOriginalExtension();
                //$pathMSP = $file3->storeAs('public/files.pdfMSP', $fileMSP);
                $file3->move($destinationPath, $fileMSP);
                $pathMSP = '/' . 'files/' . $fileMSP;
            }
            return response()->json([
                'pathFoto' => isset($pathFoto) && $pathFoto != null ? $pathFoto : '',
                'pathCedula' => isset($pathCedula) && $pathCedula != null ? $pathCedula : '',
                'pathConadis' => isset($pathConadis) && $pathConadis != null ? $pathConadis : '',
                'pathMSP' => isset($pathMSP) && $pathMSP != null ? $pathMSP : '',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }

        //dd($path);

    }

    public function guardarUsuario(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'personal.email_institucional' => "required|string|email|max:250|unique:users,US_EMAIL," . $estado . ",USER_LOGIC_ESTADO",
            'personal.email_alternativo' => "nullable|string|max:250|email|unique:users,US_EMAIL2," . $estado . ",USER_LOGIC_ESTADO",
            'personal.primer_nombre' => 'required|string|max:50',
            'personal.primer_apellido' => 'required|string|max:50',
            'personal.sexo' => 'required|string',
            'sistemas.password' => 'required|string|min:8|max:12|confirmed',
            'nacimiento.fecha_nacimiento' => 'required|date'
        ]);

        $dataSistema = $request->input('sistemas');
        $dataPersonal = $request->input('personal');
        $dataVivienda = $request->input('vivienda');
        $dataNacimiento = $request->input('nacimiento');
        $dataCaracteristicas = $request->input('caracteristicas');
        $dataCedula = $request->input('cedula_pdf');
        $dataPdfConadis = $request->input('conadis_pdf');
        $dataPdfMSP = $request->input('msp_pdf');
        $dataFoto = $request->input('foto');

        $tipo = $dataSistema['tipoIdentificacion'];
        $identification = "";
        if ($tipo == '') {
            return response()->json(['mensaje' => 'Debe seleccionar una identificación en sistema'], 403);
        }

        if ($tipo == 'CEDULA') {
            if ($dataSistema['identificacionCedula'] == '') {
                return response()->json(['mensaje' => 'La cedula no puede estar vacia'], 403);
            }
            $identification = $dataSistema['identificacionCedula'];
            $exists = IdentificacionesYUsuario::where('USID_CODIGO', $identification)->first();

            if ($exists !== null) {
                return response()->json(['mensaje' => 'Cedula ya existe en el sistema'], 403);
            }
        } else {
            if ($tipo == 'PASAPORTE') {
                if ($dataSistema['identificacionPasaporte'] == '') {
                    return response()->json(['mensaje' => 'El pasaporte no puede estar vacia'], 403);
                }
                $identification = $dataSistema['identificacionPasaporte'];
                $exists = IdentificacionesYUsuario::where('USID_CODIGO', $identification)->first();

                if ($exists !== null) {
                    return response()->json(['mensaje' => 'Pasaporte ya existe en el sistema'], 403);
                }
            } else {
                if ($tipo == '17-DIGITOS') {
                    do {
                        $identification = getNumeroAleatorioUser();
                        $exists = IdentificacionesYUsuario::where('USID_CODIGO', $identification)->first();
                    } while ($exists !== null);
                }
            }
        }


        $existeAlias = true;
        $alias = is_null($dataSistema['alias']) ? '' : $dataSistema['alias'];
        if ($alias != '') {
            //se valida el alias

            $i = 0;
            while ($existeAlias) {
                $aliasUser = User::where('US_ALIAS', $alias)->where('USER_LOGIC_ESTADO', 'A')->first();
                if ($aliasUser == null || !isset($aliasUser)) {
                    $existeAlias = false;
                } else {
                    $alias = $alias . $i;
                }
            }
        }

        $datosGeneralesDb = DB::connection();
        $gestionHospitalariaDb = DB::connection('mysql_gestion_hospitalaria');
        try {
            $datosGeneralesDb->beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            $primer_nombre = is_null($dataPersonal['primer_nombre']) ? '' : $dataPersonal['primer_nombre'];
            $segundo_nombre = is_null($dataPersonal['segundo_nombre']) ? '' : $dataPersonal['segundo_nombre'];
            $nombre_completo = $primer_nombre . ' ' . $segundo_nombre;
            $primer_apellido = is_null($dataPersonal['primer_apellido']) ? '' : $dataPersonal['primer_apellido'];
            $segundo_apellido = is_null($dataPersonal['segundo_apellido']) ? '' : $dataPersonal['segundo_apellido'];
            $apellido_completo = $primer_apellido . ' ' . $segundo_apellido;
            $codigo_usuario = getNumeroAleatorio();
            $user_created = User::Create(
                [
                    'name' => $nombre_completo,
                    'email' => $dataPersonal['email_institucional'],
                    'password' =>  Hash::make($dataSistema['password']),
                    'US_COD' => $codigo_usuario,
                    'US_FOTO' => is_null($dataFoto) ? '' :  $dataFoto,
                    'US_CEDULA_PDF' => is_null($dataCedula) ? '' : $dataCedula,
                    'US_MSP_PDF' => is_null($dataPdfMSP) ? '' : $dataPdfMSP,
                    'US_CONADIS_PDF' => is_null($dataPdfConadis) ? '' : $dataPdfConadis,
                    'US_ALIAS' => $alias,
                    'US_APELL' => $apellido_completo,
                    'US_APELL1' => $primer_apellido,
                    'US_APELL2' => $segundo_apellido,
                    'US_NOM' => $nombre_completo,
                    'US_NOM1' => $primer_nombre,
                    'US_NOM2' => $segundo_nombre,
                    'US_FNAC' => is_null($dataNacimiento['fecha_nacimiento']) ? '' : $dataNacimiento['fecha_nacimiento'],
                    'US_LNACIMIENTO' => is_null($dataNacimiento['lugar_nacimiento']) ? '' : $dataNacimiento['lugar_nacimiento'],
                    'PAIS_COD' => is_null($dataNacimiento['pais']) ? '' : $dataNacimiento['pais'],
                    'PARR_COD' => is_null($dataNacimiento['parroquia']) ? '' : $dataNacimiento['parroquia'],
                    'US_DIR' => is_null($dataVivienda['direccion']) ? '' : $dataVivienda['direccion'],
                    'US_URB_O_RURAL' => is_null($dataVivienda['urbano_rural']) ? '' : $dataVivienda['urbano_rural'],
                    'US_TELF' => is_null($dataPersonal['telefono']) ? '' : $dataPersonal['telefono'],
                    'US_CONTACTO_EMERG' => is_null($dataPersonal['nombre_contacto_emergencia']) ? '' : $dataPersonal['nombre_contacto_emergencia'],
                    'US_TELF_EMERG' => is_null($dataPersonal['telefono_contacto_emergencia']) ? '' : $dataPersonal['telefono_contacto_emergencia'],
                    'US_CEL' => is_null($dataPersonal['celular']) ? '' : $dataPersonal['celular'],
                    'US_EMAIL' => is_null($dataPersonal['email_institucional']) ? '' : $dataPersonal['email_institucional'],
                    'US_EMAIL2' => is_null($dataPersonal['email_alternativo']) ? '' : $dataPersonal['email_alternativo'],
                    'US_WEB' => '',
                    'US_WSPAISAREA' => '',
                    'US_WSCEL' => '',
                    'US_SEXO' => is_null($dataPersonal['sexo']) ? '' : $dataPersonal['sexo'],
                    'US_ECIVIL' => is_null($dataPersonal['estado_civil']) ? '' : $dataPersonal['estado_civil'],
                    'TSANGRE_COD' => is_null($dataPersonal['tipo_de_sangre']) ? '' : $dataPersonal['tipo_de_sangre'],
                    'RELIGION_COD' => is_null($dataPersonal['religion']) ? '' : $dataPersonal['religion'],
                    'US_PORC_DISCAPACIDAD' => is_null($dataCaracteristicas['porcentageDiscapacidad']) ? '' : $dataCaracteristicas['porcentageDiscapacidad'],
                    'US_CONADIS_DISCAPACIDAD' => is_null($dataCaracteristicas['conadis']) ? '' : $dataCaracteristicas['conadis'],
                    'US_MSP_DISCAPACIDAD' => is_null($dataCaracteristicas['msp']) ? '' : $dataCaracteristicas['msp'],
                    'US_ESTATURA_METROS' => is_null($dataCaracteristicas['estatura_metros']) ? '' : $dataCaracteristicas['estatura_metros'],
                    'US_PESO_KG' => is_null($dataCaracteristicas['peso_kg']) ? '' : $dataCaracteristicas['peso_kg'],
                    'TALLACAMISA_COD' => is_null($dataCaracteristicas['tallaCamisaNombre']) ? '' : $dataCaracteristicas['tallaCamisaNombre'],
                    'TALLAPANTALON_COD' => is_null($dataCaracteristicas['tallaPantalonNombre']) ? '' : $dataCaracteristicas['tallaPantalonNombre'],
                    'TALLAZAPATO_COD' => is_null($dataCaracteristicas['tallaZapatoNombre']) ? '' : $dataCaracteristicas['tallaZapatoNombre'],
                    'MOVILIZACION_COD' => is_null($dataCaracteristicas['movilizacion']) ? '' : $dataCaracteristicas['movilizacion'],
                    'DISCAPACIDAD_COD' => is_null($dataCaracteristicas['discapacidades']) ? '' : $dataCaracteristicas['discapacidades'],
                    'CASA_COD' => '',
                    'TIPOCASA_COD' => is_null($dataVivienda['tipo_casa']) ? '' : $dataVivienda['tipo_casa'],
                    'US_REFERENCIA_DOMICILIO' => is_null($dataVivienda['referencia_domicilio']) ? '' : $dataVivienda['referencia_domicilio'],
                    'US_LATITUD' => is_null($dataVivienda['latitud']) ? '' : $dataVivienda['latitud'],
                    'US_LONGITUD' => is_null($dataVivienda['longitud']) ? '' : $dataVivienda['longitud'],
                    'US_ZOOM' => '',
                    'US_ACTIVO' => is_null($dataSistema['activo']) ? 'S' : $dataSistema['activo'],
                    'US_TRABAJADOR_BSPI' => is_null($dataSistema['trabajadorBSPI']) ? '' : $dataSistema['trabajadorBSPI'],
                    'US_CLAVE' => Hash::make($dataSistema['password']),
                    'US_OBS' => is_null($dataCaracteristicas['observacion']) ? '' : $dataCaracteristicas['observacion'],
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GCULTURAL_COD' => is_null($dataPersonal['grupo_cultural']) ? '' : $dataPersonal['grupo_cultural'],
                    'US_ULTIMO_ANIO_APROBADO' => '',
                    'US_BARRIO' => is_null($dataVivienda['barrio']) ? '' : $dataVivienda['barrio'],
                    'USER_LOGIC_ESTADO' => 'A',
                    'US_FECHA_CAMBIO_CLAVE' => $this->obtenerFechaCaducaClave(),
                ]
            );

            $identificacionYUsuario = IdentificacionesYUsuario::Create([
                'US_COD' => $codigo_usuario,
                'ID_COD' => $tipo,
                'USID_CODIGO' => $identification,
                'USID_ACTIVO' => is_null($dataSistema['activo']) ? '' : $dataSistema['activo'],
                'USID_OBS' => '',
                'FECHA' => $fecha,
                'HORA' => $time,
                'TIPO' => $user->TIPO,
                'USUARIO' => $user->US_COD,
                'IDENTIFICACIONESUSUARIO_LOGIC_ESTADO' => 'A'
            ]);
            //Cuando se crea un usuario automaticamente se le asigna una poliza del MSP
            $datosGeneralesDb->commit();
            $gestionHospitalariaDb->beginTransaction();
            $aseguradora = Aseguradoras::where('ASEGURADORA_NOM', 'MSP')->where('ASEGURADORA_LOGIC_ESTADO', 'A')->first();

            $poliza = Poliza::Create(
                [
                    'ASEGURADORA_COD' => $aseguradora->ASEGURADORA_COD,
                    'USER_ID' => $user_created->id,
                    'POLIZA_NUMERO' => '9999999999999',
                    'POLIZA_OBS' => 'Autogenerada',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'POLIZA_LOGIC_ESTADO' => 'A'
                ]
            );
            //Se le procede a asignar como beneficiario de su poliza creada automaticamente
            BeneficiariosPoliza::Create([
                'POLIZA_COD' => $poliza->POLIZA_COD,
                'USER_ID' => $user_created->id,
                'BENEFICIARIO_OBS' => 'AUTOGENERADA',
                'US_COD_CREATED_UPDATED' => $user->US_COD,
                'BENEFICIARIO_LOGIC_ESTADO' => 'A'
            ]);
            $gestionHospitalariaDb->commit();

            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $datosGeneralesDb->rollBack();
            $gestionHospitalariaDb->rollBack();
            throw $e;
        }
    }
    /*Metodo para obtener el numero de mes de la tabla configuracion, campo TIEMPO_ACTUALIZACION_CLAVE
     y así guardar el valor en la tabla users campo TIEMPO_ACTUALIZACION_CLAVE para saber cuando 
     se caduca la clave de cada usuario que se cree*/
    public function obtenerFechaCaducaClave()
    {        
        $noMes = Configuracion::where('TIEMPO_ACTUALIZACION_CLAVE', '>', '0')->first();
        if($noMes != null){
            $fechaActual = getFecha();
            $fechaCambioClave = date("Y-m-d", strtotime($fechaActual . "+ " . $noMes->TIEMPO_ACTUALIZACION_CLAVE . " month"));
            return $fechaCambioClave;
        }
        else{
            return getFecha();
        }
        
    }

    public function eliminarUsuario($id)
    {

        try {
            if ($id !== '' && isset($id)) {
                try {
                    DB::beginTransaction();
                    $user = Auth::user();
                    $fecha = getFecha();
                    $time = getTime();
                    IdentificacionesYUsuario::where('US_COD', $id)->update([
                        'FECHA' => $fecha,
                        'HORA' => $time,
                        'TIPO' => $user->TIPO,
                        'USUARIO' => $user->US_COD,
                        'IDENTIFICACIONESUSUARIO_LOGIC_ESTADO' => 'I'
                    ]);
                    User::where('US_COD', $id)->update([
                        'FECHA' => $fecha,
                        'HORA' => $time,
                        'TIPO' => $user->TIPO,
                        'USUARIO' => $user->US_COD,
                        'USER_LOGIC_ESTADO' => 'I'
                    ]);
                    DB::commit();
                    return response()->json(['msg' => 'OK'], 200);
                } catch (Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            } else {
                return response()->json(['mensaje' => 'El id deL usuario es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function modificarUsuario(Request $request)
    {
        $dataSistema = $request->input('sistemas');
        $dataPersonal = $request->input('personal');
        $dataVivienda = $request->input('vivienda');
        $dataNacimiento = $request->input('nacimiento');
        $dataCaracteristicas = $request->input('caracteristicas');
        $dataCedula = $request->input('cedula_pdf');
        $dataPdfConadis = $request->input('conadis_pdf');
        $dataPdfMSP = $request->input('msp_pdf');
        $dataFoto = $request->input('foto');
        $numero_identificacion = $request->input('US_COD');

        DB::beginTransaction();
        try {
            //$numero_identificacion = "";

            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            $primer_nombre = is_null($dataPersonal['primer_nombre']) ? '' : $dataPersonal['primer_nombre'];
            $segundo_nombre = is_null($dataPersonal['segundo_nombre']) ? '' : $dataPersonal['segundo_nombre'];
            $nombre_completo = $primer_nombre . ' ' . $segundo_nombre;
            $primer_apellido = is_null($dataPersonal['primer_apellido']) ? '' : $dataPersonal['primer_apellido'];
            $segundo_apellido = is_null($dataPersonal['segundo_apellido']) ? '' : $dataPersonal['segundo_apellido'];
            $apellido_completo = $primer_apellido . ' ' . $segundo_apellido;

            User::where('US_COD', $numero_identificacion)->update(
                [
                    'name' => $nombre_completo,
                    'email' => $dataPersonal['email_institucional'],
                    //'password' => $dataSistema['password'],
                    'US_COD' => $numero_identificacion,
                    //'US_FOTO' => is_null($dataFoto) ? '' :  $dataFoto,
                    //'US_CEDULA_PDF' => is_null($dataCedula) ? '' : $dataCedula,
                    //'US_MSP_PDF' => is_null($dataPdfMSP) ? '' : $dataPdfMSP,
                    //'US_CONADIS_PDF' => is_null($dataPdfConadis) ? '' : $dataPdfConadis,
                    'US_ALIAS' => is_null($dataSistema['alias']) ? '' : $dataSistema['alias'],
                    'US_APELL' => $apellido_completo,
                    'US_APELL1' => $primer_apellido,
                    'US_APELL2' => $segundo_apellido,
                    'US_NOM' => $nombre_completo,
                    'US_NOM1' => $primer_nombre,
                    'US_NOM2' => $segundo_nombre,
                    'US_FNAC' => is_null($dataNacimiento['fecha_nacimiento']) ? '' : $dataNacimiento['fecha_nacimiento'],
                    'US_LNACIMIENTO' => is_null($dataNacimiento['lugar_nacimiento']) ? '' : $dataNacimiento['lugar_nacimiento'],
                    'PAIS_COD' => is_null($dataNacimiento['pais']) ? '' : $dataNacimiento['pais'],
                    'PARR_COD' => is_null($dataNacimiento['parroquia']) ? '' : $dataNacimiento['parroquia'],
                    'US_DIR' => is_null($dataVivienda['direccion']) ? '' : $dataVivienda['direccion'],
                    'US_URB_O_RURAL' => is_null($dataVivienda['urbano_rural']) ? '' : $dataVivienda['urbano_rural'],
                    'US_TELF' => is_null($dataPersonal['telefono']) ? '' : $dataPersonal['telefono'],
                    'US_CONTACTO_EMERG' => is_null($dataPersonal['nombre_contacto_emergencia']) ? '' : $dataPersonal['nombre_contacto_emergencia'],
                    'US_TELF_EMERG' => is_null($dataPersonal['telefono_contacto_emergencia']) ? '' : $dataPersonal['telefono_contacto_emergencia'],
                    'US_CEL' => is_null($dataPersonal['celular']) ? '' : $dataPersonal['celular'],
                    'US_EMAIL' => is_null($dataPersonal['email_institucional']) ? '' : $dataPersonal['email_institucional'],
                    'US_EMAIL2' => is_null($dataPersonal['email_alternativo']) ? '' : $dataPersonal['email_alternativo'],
                    'US_WEB' => '',
                    'US_WSPAISAREA' => '',
                    'US_WSCEL' => '',
                    'US_SEXO' => is_null($dataPersonal['sexo']) ? '' : $dataPersonal['sexo'],
                    'US_ECIVIL' => is_null($dataPersonal['estado_civil']) ? '' : $dataPersonal['estado_civil'],
                    'TSANGRE_COD' => is_null($dataPersonal['tipo_de_sangre']) ? '' : $dataPersonal['tipo_de_sangre'],
                    'RELIGION_COD' => is_null($dataPersonal['religion']) ? '' : $dataPersonal['religion'],
                    'US_PORC_DISCAPACIDAD' => is_null($dataCaracteristicas['porcentageDiscapacidad']) ? '' : $dataCaracteristicas['porcentageDiscapacidad'],
                    'US_CONADIS_DISCAPACIDAD' => is_null($dataCaracteristicas['conadis']) ? '' : $dataCaracteristicas['conadis'],
                    'US_MSP_DISCAPACIDAD' => is_null($dataCaracteristicas['msp']) ? '' : $dataCaracteristicas['msp'],
                    'US_ESTATURA_METROS' => is_null($dataCaracteristicas['estatura_metros']) ? '' : $dataCaracteristicas['estatura_metros'],
                    'US_PESO_KG' => is_null($dataCaracteristicas['peso_kg']) ? '' : $dataCaracteristicas['peso_kg'],
                    'TALLACAMISA_COD' => is_null($dataCaracteristicas['tallaCamisaNombre']) ? '' : $dataCaracteristicas['tallaCamisaNombre'],
                    'TALLAPANTALON_COD' => is_null($dataCaracteristicas['tallaPantalonNombre']) ? '' : $dataCaracteristicas['tallaPantalonNombre'],
                    'TALLAZAPATO_COD' => is_null($dataCaracteristicas['tallaZapatoNombre']) ? '' : $dataCaracteristicas['tallaZapatoNombre'],
                    'MOVILIZACION_COD' => is_null($dataCaracteristicas['movilizacion']) ? '' : $dataCaracteristicas['movilizacion'],
                    'DISCAPACIDAD_COD' => is_null($dataCaracteristicas['discapacidades']) ? '' : $dataCaracteristicas['discapacidades'],
                    'CASA_COD' => '',
                    'TIPOCASA_COD' => is_null($dataVivienda['tipo_casa']) ? '' : $dataVivienda['tipo_casa'],
                    'US_REFERENCIA_DOMICILIO' => is_null($dataVivienda['referencia_domicilio']) ? '' : $dataVivienda['referencia_domicilio'],
                    'US_LATITUD' => is_null($dataVivienda['latitud']) ? '' : $dataVivienda['latitud'],
                    'US_LONGITUD' => is_null($dataVivienda['longitud']) ? '' : $dataVivienda['longitud'],
                    'US_ZOOM' => '',
                    'US_ACTIVO' => is_null($dataSistema['activo']) ? '' : $dataSistema['activo'],
                    'US_TRABAJADOR_BSPI' => is_null($dataSistema['trabajadorBSPI']) ? '' : $dataSistema['trabajadorBSPI'],
                    //'US_CLAVE' => $dataSistema['password'],
                    'US_OBS' => is_null($dataCaracteristicas['observacion']) ? '' : $dataCaracteristicas['observacion'],
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'GCULTURAL_COD' => is_null($dataPersonal['grupo_cultural']) ? '' : $dataPersonal['grupo_cultural'],
                    'US_ULTIMO_ANIO_APROBADO' => '',
                    'US_BARRIO' => is_null($dataVivienda['barrio']) ? '' : $dataVivienda['barrio'],
                    'USER_LOGIC_ESTADO' => 'A'
                ]
            );

            if ($dataSistema['password'] != null && $dataSistema['password'] != '') {
                User::where('US_COD', $numero_identificacion)->update([
                    'password' =>  Hash::make($dataSistema['password']),
                    'US_CLAVE' =>  Hash::make($dataSistema['password']),
                ]);
            }
            if ($dataFoto != null && $dataFoto != '') {
                User::where('US_COD', $numero_identificacion)->update([
                    'US_FOTO' =>  $dataFoto,

                ]);
            }
            if ($dataCedula != null && $dataCedula != '') {
                User::where('US_COD', $numero_identificacion)->update([
                    'US_CEDULA_PDF' =>  $dataCedula,

                ]);
            }
            if ($dataPdfConadis != null && $dataPdfConadis != '') {
                User::where('US_COD', $numero_identificacion)->update([
                    'US_CONADIS_PDF' =>  $dataPdfConadis,

                ]);
            }
            if ($dataPdfMSP != null && $dataPdfMSP != '') {
                User::where('US_COD', $numero_identificacion)->update([
                    'US_MSP_PDF' => $dataPdfMSP,

                ]);
            }
            $tipo = $dataSistema['tipoIdentificacion'];
            $identification = "";
            if ($tipo == 'CEDULA') {
                $identification = $dataSistema['identificacionCedula'];
            } else {
                if ($tipo == 'PASAPORTE') {
                    $identification = $dataSistema['identificacionPasaporte'];
                } else {
                    if ($tipo == '17-DIGITOS') {
                        $identification = getNumeroAleatorioUser();
                    }
                }
            }

            $identificacionYUsuario = IdentificacionesYUsuario::updateOrCreate(
                ['US_COD' => $numero_identificacion, 'ID_COD' => $tipo, 'USID_CODIGO' => $identification,],
                [
                    'USID_ACTIVO' => is_null($dataSistema['activo']) ? '' : $dataSistema['activo'],
                    'USID_OBS' => '',
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'IDENTIFICACIONESUSUARIO_LOGIC_ESTADO' => 'A'
                ]
            );



            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function modificarClaveUsuario(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|max:12|confirmed|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[-@$!%*#?&]/',
            'password_confirmation' => 'required|string|min:8|max:12'
        ]);
        DB::beginTransaction();
        try {
            if ($request->input('password') != null && $request->input('password') != '') {
                $contrasenaActual =  User::where('US_COD', $request->input('usCod'))
                    ->where('id', $request->input('id'))
                    ->first();

                if (Hash::check($request->input('password'), $contrasenaActual->US_CLAVE)) {
                    return response()->json(['msg' => 'No puede usar la misma clave para la actualización.'], 421);
                } else {
                    User::where('US_COD', $request->input('usCod'))
                        ->where('id', $request->input('id'))->update([
                            'password' =>  Hash::make($request->input('password')),
                            'US_CLAVE' =>  Hash::make($request->input('password')),
                            'US_FECHA_CAMBIO_CLAVE' => $this->obtenerFechaCaducaClave(),
                        ]);
                    DB::commit();
                    return response()->json(['msg' => 'OK'], 200);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
