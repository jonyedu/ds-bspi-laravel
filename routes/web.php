<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$prefijo = config('global.router_prefix');

Auth::routes();

Route::get($prefijo . '/{any}', 'AppController@index')->where('any', '.*');
Route::get($prefijo, 'AppController@index')->where('any', '.*');

Route::get('/', function () {
    return view('auth.login');
});

//Datos Generales
Route::group(['prefix' => 'datos_generales', 'middleware' => ['auth:web']], function () {
    //Generalidades
    Route::get('generalidades/obtener_usuario/{id}', 'DatosGenerales\Generalidades\ConfiguracionApiController@obtenerUsuarioPorId');
    Route::get('generalidades/cargar_configuracion', 'DatosGenerales\Generalidades\ConfiguracionApiController@cargarConfiguracion');
    Route::post('generalidades/guardar_actualizar_configuracion', 'DatosGenerales\Generalidades\ConfiguracionApiController@guardarActualizarConfiguracion');
    //Tipos de Organismos
    Route::get('generalidades/cargar_tiposdeorganismos', 'DatosGenerales\Generalidades\TiposDeOrganismoApiController@cargarTiposDeOrganismo');
    Route::get('generalidades/cargar_tiposdeorganismos_combo_box', 'DatosGenerales\Generalidades\TiposDeOrganismoApiController@cargarTiposDeOrganismoComboBox');
    Route::post('generalidades/guardar_tiposdeorganismos', 'DatosGenerales\Generalidades\TiposDeOrganismoApiController@guardarTiposDeOrganismo');
    Route::post('generalidades/modificar_tiposdeorganismos', 'DatosGenerales\Generalidades\TiposDeOrganismoApiController@modificarTiposDeOrganismo');
    Route::delete('generalidades/eliminar_tiposdeorganismos/{id}', 'DatosGenerales\Generalidades\TiposDeOrganismoApiController@eliminarTiposDeOrganismo');
    //Cargos en Organismos
    Route::get('generalidades/cargar_cargos', 'DatosGenerales\Generalidades\CargosEnOrganismoApiController@cargarCargos');
    Route::post('generalidades/guardar_cargos', 'DatosGenerales\Generalidades\CargosEnOrganismoApiController@guardarCargos');
    Route::post('generalidades/modificar_cargos', 'DatosGenerales\Generalidades\CargosEnOrganismoApiController@modificarCargos');
    Route::delete('generalidades/eliminar_cargo/{id}', 'DatosGenerales\Generalidades\CargosEnOrganismoApiController@eliminarCargos');
    //Organizaciones
    Route::get('generalidades/cargar_organizaciones', 'DatosGenerales\Generalidades\OrganizacionesApiController@cargarOrganizaciones');
    Route::post('generalidades/guardar_organizaciones', 'DatosGenerales\Generalidades\OrganizacionesApiController@guardarOrganizacion');
    Route::post('generalidades/modificar_organizaciones', 'DatosGenerales\Generalidades\OrganizacionesApiController@modificarOrganizacion');
    Route::delete('generalidades/eliminar_organizaciones/{id}', 'DatosGenerales\Generalidades\OrganizacionesApiController@eliminarOrganizacion');
    //Organismos
    Route::get('generalidades/cargar_organismos', 'DatosGenerales\Generalidades\OrganismosApiController@cargarOrganismos');
    Route::post('generalidades/guardar_organismos', 'DatosGenerales\Generalidades\OrganismosApiController@guardarOrganismos');
    Route::post('generalidades/modificar_organismos', 'DatosGenerales\Generalidades\OrganismosApiController@modificarOrganismos');
    Route::delete('generalidades/eliminar_organismos/{id}', 'DatosGenerales\Generalidades\OrganismosApiController@eliminarOrganismos');
    //Organismos Y Contactos
    Route::get('generalidades/cargar_organismosYContactos', 'DatosGenerales\Generalidades\OrganismosYContactosApiController@cargarOrganismosYContactos');
    Route::post('generalidades/guardar_organismosYContactos', 'DatosGenerales\Generalidades\OrganismosYContactosApiController@guardarOrganismosYContactos');
    Route::post('generalidades/modificar_organismosYContactos', 'DatosGenerales\Generalidades\OrganismosYContactosApiController@modificarOrganismosYContactos');
    Route::post('generalidades/eliminar_organismosYContactos', 'DatosGenerales\Generalidades\OrganismosYContactosApiController@eliminarOrganismosYContactos');
    //PAISES
    Route::get('generalidades/cargar_paises', 'DatosGenerales\Generalidades\PaisesApiController@cargarPaises');
    //GESTIONES
    Route::get('gestiones/cargar_gestiones', 'DatosGenerales\Gestiones\GestionesApiController@cargarGestiones');
    Route::get('gestiones/cargar_gestiones_combo_box', 'DatosGenerales\Gestiones\GestionesApiController@cargarGestionesComboBox');
    Route::post('gestiones/guardar_gestion', 'DatosGenerales\Gestiones\GestionesApiController@guardarGestion');
    Route::post('gestiones/modificar_gestion', 'DatosGenerales\Gestiones\GestionesApiController@modificarGestion');
    Route::delete('gestiones/eliminar_gestion/{id}', 'DatosGenerales\Gestiones\GestionesApiController@eliminarGestion');
    //GESTIONESYUSUARIOS
    Route::get('gestiones/cargar_gestiones_y_usuarios', 'DatosGenerales\Gestiones\GestionesYUsuarioApiController@cargarGestionesYUsuario');
    Route::post('gestiones/guardar_gestiones_y_usuarios', 'DatosGenerales\Gestiones\GestionesYUsuarioApiController@guardarGestionYUsuario');
    Route::post('gestiones/modificar_gestiones_y_usuarios', 'DatosGenerales\Gestiones\GestionesYUsuarioApiController@modificarGestionYUsuario');
    Route::delete('gestiones/eliminar_gestiones_y_usuarios/{gestion}/{rol}/{usuario}', 'DatosGenerales\Gestiones\GestionesYUsuarioApiController@eliminarGestionYUsuario');
    //USUARIOS
    Route::get('usuarios/cargar_roles', 'DatosGenerales\Usuarios\UsuarioRolApiController@cargarRoles');
    Route::post('usuarios/guardar_rol', 'DatosGenerales\Usuarios\UsuarioRolApiController@guardarRol');
    Route::post('usuarios/modificar_rol', 'DatosGenerales\Usuarios\UsuarioRolApiController@modificarRol');
    Route::delete('usuarios/eliminar_rol/{id}', 'DatosGenerales\Usuarios\UsuarioRolApiController@eliminarRol');
    Route::get('usuarios/tipos_sangre', 'DatosGenerales\Usuarios\TiposDeSangreApiController@cargarTiposDeSangre');
    Route::get('usuarios/cargar_usuarios', 'DatosGenerales\Usuarios\UserApiController@cargarUsuarios');
    Route::get('usuarios/religiones', 'DatosGenerales\Usuarios\ReligionApiController@cargarReligiones');
    Route::get('usuarios/grupos_culturales', 'DatosGenerales\Usuarios\GruposCulturalesApiController@cargarGruposCulturales');
    Route::get('usuarios/tipos_casa', 'DatosGenerales\Usuarios\TiposDeCasaApiController@cargarTiposDeCasa');
    Route::get('usuarios/tallas_camisa', 'DatosGenerales\Usuarios\TallaCamisaApiController@cargarTallas');
    Route::get('usuarios/tallas_pantalon', 'DatosGenerales\Usuarios\TallaPantalonApiController@cargarTallasPantalon');
    Route::get('usuarios/tallas_zapato', 'DatosGenerales\Usuarios\TallaZapatoApiController@cargarTallasZapato');
    Route::get('usuarios/movilizaciones', 'DatosGenerales\Usuarios\MovilizacionApiController@cargarMovilizaciones');
    Route::get('usuarios/discapacidades', 'DatosGenerales\Usuarios\DiscapacidadApiController@cargarMovilizaciones');
    Route::get('usuarios/obtener_usuario/{id}', 'DatosGenerales\Usuarios\UserApiController@obtenerUsuarioPorId');
    Route::delete('usuarios/eliminar_usuario/{id}', 'DatosGenerales\Usuarios\UserApiController@eliminarUsuario');
    Route::get('usuarios/cargar_usuarios_campos', 'DatosGenerales\Usuarios\UserApiController@cargarUsuariosCampos');
    Route::post('usuarios/guardar_usuario', 'DatosGenerales\Usuarios\UserApiController@guardarUsuario');
    Route::post('usuarios/modificar_usuario', 'DatosGenerales\Usuarios\UserApiController@modificarUsuario');
    Route::post('usuarios/modificar_clave_usuario', 'DatosGenerales\Usuarios\UserApiController@modificarClaveUsuario');

    //LOGS
    Route::post('logs/registrar_log_usuario', 'DatosGenerales\Logs\LogUsuarioApiController@guardarLog');
    Route::get('logs/cargar_logs', 'DatosGenerales\Logs\LogUsuarioApiController@cargarLogs');
    //guardar test
    Route::post('usuarios/guardarArchivos', 'DatosGenerales\Usuarios\UserApiController@guardarArchivos');
    //CONFIGURACIONES
    //pais
    Route::get('configuraciones/cargar_paises', 'DatosGenerales\Generalidades\PaisesApiController@cargarPaisesTabla');
    Route::post('configuraciones/guardar_pais', 'DatosGenerales\Generalidades\PaisesApiController@guardarPais');
    Route::post('configuraciones/modificar_pais', 'DatosGenerales\Generalidades\PaisesApiController@modificarPais');
    Route::delete('configuraciones/eliminar_pais/{id}', 'DatosGenerales\Generalidades\PaisesApiController@eliminarPais');
    //sangre
    Route::get('configuraciones/cargar_tipos_de_sangre', 'DatosGenerales\Usuarios\TiposDeSangreApiController@cargarTiposDeSangreTabla');
    Route::post('configuraciones/guardar_tipo_de_sangre', 'DatosGenerales\Usuarios\TiposDeSangreApiController@guardarTipoDeSangre');
    Route::post('configuraciones/modificar_tipo_de_sangre', 'DatosGenerales\Usuarios\TiposDeSangreApiController@modificarTipoDeSangre');
    Route::delete('configuraciones/eliminar_tipo_de_sangre/{id}', 'DatosGenerales\Usuarios\TiposDeSangreApiController@eliminarTipoDeSangre');
    //religion
    Route::get('configuraciones/cargar_religiones', 'DatosGenerales\Usuarios\ReligionApiController@cargarReligionesTabla');
    Route::post('configuraciones/guardar_religion', 'DatosGenerales\Usuarios\ReligionApiController@guardarReligion');
    Route::post('configuraciones/modificar_religion', 'DatosGenerales\Usuarios\ReligionApiController@modificarReligion');
    Route::delete('configuraciones/eliminar_religion/{id}', 'DatosGenerales\Usuarios\ReligionApiController@eliminarReligion');
    //tipo de casa
    Route::get('configuraciones/cargar_tipos_de_casa', 'DatosGenerales\Usuarios\TiposDeCasaApiController@cargarTiposCasaTabla');
    Route::post('configuraciones/guardar_tipo_de_casa', 'DatosGenerales\Usuarios\TiposDeCasaApiController@guardarTipoCasa');
    Route::post('configuraciones/modificar_tipo_de_casa', 'DatosGenerales\Usuarios\TiposDeCasaApiController@modificarTipoCasa');
    Route::delete('configuraciones/eliminar_tipo_de_casa/{id}', 'DatosGenerales\Usuarios\TiposDeCasaApiController@eliminarTipoCasa');
    //movilizacion
    Route::get('configuraciones/cargar_movilizaciones', 'DatosGenerales\Usuarios\MovilizacionApiController@cargarMovilizacionesTabla');
    Route::post('configuraciones/guardar_movilizacion', 'DatosGenerales\Usuarios\MovilizacionApiController@guardarMovilizacion');
    Route::post('configuraciones/modificar_movilizacion', 'DatosGenerales\Usuarios\MovilizacionApiController@modificarMovilizacion');
    Route::delete('configuraciones/eliminar_movilizacion/{id}', 'DatosGenerales\Usuarios\MovilizacionApiController@eliminarMovilizacion');
    //discapacidad
    Route::get('configuraciones/cargar_discapacidades', 'DatosGenerales\Usuarios\DiscapacidadApiController@cargarDiscapacidadesTabla');
    Route::post('configuraciones/guardar_discapacidad', 'DatosGenerales\Usuarios\DiscapacidadApiController@guardarDiscapacidad');
    Route::post('configuraciones/modificar_discapacidad', 'DatosGenerales\Usuarios\DiscapacidadApiController@modificarDiscapacidad');
    Route::delete('configuraciones/eliminar_discapacidad/{id}', 'DatosGenerales\Usuarios\DiscapacidadApiController@eliminarDiscapacidad');
    //casa
    Route::get('configuraciones/cargar_casas', 'DatosGenerales\Usuarios\CasaApiController@cargarCasasTabla');
    Route::post('configuraciones/guardar_casa', 'DatosGenerales\Usuarios\CasaApiController@guardarCasa');
    Route::post('configuraciones/modificar_casa', 'DatosGenerales\Usuarios\CasaApiController@modificarCasa');
    Route::delete('configuraciones/eliminar_casa/{id}', 'DatosGenerales\Usuarios\CasaApiController@eliminarCasa');
    //grupos culturales
    Route::get('configuraciones/cargar_grupos_culturales', 'DatosGenerales\Usuarios\GruposCulturalesApiController@cargarGruposCulturalesTabla');
    Route::post('configuraciones/guardar_grupo_cultural', 'DatosGenerales\Usuarios\GruposCulturalesApiController@guardarGrupoCultural');
    Route::post('configuraciones/modificar_grupo_cultural', 'DatosGenerales\Usuarios\GruposCulturalesApiController@modificarGrupoCultural');
    Route::delete('configuraciones/eliminar_grupo_cultural/{id}', 'DatosGenerales\Usuarios\GruposCulturalesApiController@eliminarGrupoCultural');
    Route::get('configuraciones/cargar_tipos_de_organizacion', 'DatosGenerales\Usuarios\TipoDeOrganizacionApiController@cargarTiposDeOrganizacionTabla');
    Route::post('configuraciones/guardar_tipo_de_organizacion', 'DatosGenerales\Usuarios\TipoDeOrganizacionApiController@guardarTipoDeOrganizacion');
    Route::post('configuraciones/modificar_tipo_de_organizacion', 'DatosGenerales\Usuarios\TipoDeOrganizacionApiController@modificarTipoDeOrganizacion');
    Route::delete('configuraciones/eliminar_tipo_de_organizacion/{id}', 'DatosGenerales\Usuarios\TipoDeOrganizacionApiController@eliminarTipoDeOrganizacion');
    //provincias
    Route::get('configuraciones/cargar_provincias', 'DatosGenerales\Usuarios\ProvinciaApiController@cargarProvincias');
    Route::post('configuraciones/guardar_provincias', 'DatosGenerales\Usuarios\ProvinciaApiController@guardarProvincias');
    Route::post('configuraciones/modificar_provincias', 'DatosGenerales\Usuarios\ProvinciaApiController@modificarProvincias');
    Route::post('configuraciones/eliminar_provincias', 'DatosGenerales\Usuarios\ProvinciaApiController@eliminarProvincias');
    //Cantones
    Route::get('configuraciones/cargar_cantones', 'DatosGenerales\Usuarios\CantonesApiController@cargarCantones');
    Route::post('configuraciones/guardar_cantones', 'DatosGenerales\Usuarios\CantonesApiController@guardarCantones');
    Route::post('configuraciones/modificar_cantones', 'DatosGenerales\Usuarios\CantonesApiController@modificarCantones');
    Route::post('configuraciones/eliminar_cantones', 'DatosGenerales\Usuarios\CantonesApiController@eliminarCantones');
    //Parroquias
    Route::get('configuraciones/cargar_parroquias', 'DatosGenerales\Usuarios\ParroquiaApiController@cargarParroquias');
    Route::post('configuraciones/guardar_parroquias', 'DatosGenerales\Usuarios\ParroquiaApiController@guardarParroquias');
    Route::post('configuraciones/modificar_parroquias', 'DatosGenerales\Usuarios\ParroquiaApiController@modificarParroquias');
    Route::post('configuraciones/eliminar_parroquias', 'DatosGenerales\Usuarios\ParroquiaApiController@eliminarParroquias');

    /* Modulo Configuraciones */

    //Tipo Unidad
    //***Ruta para cargar los datos de Tipo Unidad
    Route::get('configuraciones/cargar_tipo_unidad', 'DatosGenerales\Configuraciones\TipoUnidadApiController@cargarTipoUnidadTabla');
    //***Ruta para guardar o modificar los datos de Tipo Unidad
    Route::post('configuraciones/guardar_modificar_tipo_unidad', 'DatosGenerales\Configuraciones\TipoUnidadApiController@guardarModificarTipoUnidad');
    //***Ruta para eliminar los datos de Tipo Unidad
    Route::delete('configuraciones/eliminar_tipo_unidad/{id}', 'DatosGenerales\Configuraciones\TipoUnidadApiController@eliminarTipoUnidad');

    //Unidad
    //***Ruta para cargar los datos de Unidad por Tipo de Unidad
    Route::get('configuraciones/cargar_unidad_por_tipo_unidad/{id}', 'DatosGenerales\Configuraciones\UnidadApiController@cargarUnidadPorTipoUnidad');
    //***Ruta para cargar los datos de Unidad
    Route::get('configuraciones/cargar_unidad', 'DatosGenerales\Configuraciones\UnidadApiController@cargarUnidadTabla');
    //***Ruta para guardar o modificar los datos de Unidad
    Route::post('configuraciones/guardar_modificar_unidad', 'DatosGenerales\Configuraciones\UnidadApiController@guardarModificarUnidad');
    //***Ruta para eliminar los datos de Unidad
    Route::delete('configuraciones/eliminar_unidad/{id}', 'DatosGenerales\Configuraciones\UnidadApiController@eliminarUnidad');

});
//Gestion Hospitalaria
Route::group(['prefix' => 'gestion_hospitalaria', 'middleware' => ['auth:web']], function () {
    //GENERALIDADES
    Route::get('generalidades/cargar_tipos_de_parentesco', 'GestionHospitalaria\Generalidades\TiposParentescoApiController@cargarTiposParentescoTabla');
    Route::get('generalidades/cargar_tipos_de_parentesco_lista', 'GestionHospitalaria\Generalidades\TiposParentescoApiController@cargarTiposParentescoLista');
    Route::post('generalidades/guardar_tipo_de_parentesco', 'GestionHospitalaria\Generalidades\TiposParentescoApiController@guardarTipoParentesco');
    Route::post('generalidades/modificar_tipo_de_parentesco', 'GestionHospitalaria\Generalidades\TiposParentescoApiController@modificarTipoParentesco');
    Route::delete('generalidades/eliminar_tipo_de_parentesco/{id}', 'GestionHospitalaria\Generalidades\TiposParentescoApiController@eliminarTipoParentesco');
    Route::get('generalidades/cargar_ocupaciones', 'GestionHospitalaria\Generalidades\OcupacionesApiController@cargarOcupacionesTabla');
    Route::post('generalidades/guardar_ocupacion', 'GestionHospitalaria\Generalidades\OcupacionesApiController@guardarOcupacion');
    Route::post('generalidades/modificar_ocupacion', 'GestionHospitalaria\Generalidades\OcupacionesApiController@modificarOcupacion');
    Route::delete('generalidades/eliminar_ocupacion/{id}', 'GestionHospitalaria\Generalidades\OcupacionesApiController@eliminarOcupacion');

    Route::get('generalidades/cargar_aseguradoras', 'GestionHospitalaria\Generalidades\AseguradorasApiController@cargarAseguradorasTabla');
    Route::get('generalidades/cargar_aseguradoras_lista', 'GestionHospitalaria\Generalidades\AseguradorasApiController@cargarAseguradorasLista');
    Route::post('generalidades/guardar_aseguradora', 'GestionHospitalaria\Generalidades\AseguradorasApiController@guardarAseguradora');
    Route::post('generalidades/modificar_aseguradora', 'GestionHospitalaria\Generalidades\AseguradorasApiController@modificarAseguradora');
    Route::delete('generalidades/eliminar_aseguradora/{id}', 'GestionHospitalaria\Generalidades\AseguradorasApiController@eliminarAseguradora');
    //PERSONAL MEDICO
    Route::get('personal_medico/cargar_especialidades_lista', 'GestionHospitalaria\PersonalMedico\EspecialidadApiController@cargarEspecialidadesLista');
    Route::post('personal_medico/cargar_medicos_consulta_general', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@cargarMedicosParaConsultaGeneral');
    Route::post('personal_medico/cargar_medicos_emergencias', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@cargarMedicosParaEmergencia');
    //ADMINISTRACION DE CITAS

    Route::get('administracion_cita/cargar_citas_usuario/{userId}', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@cargarCitasDeUsuario');
    Route::get('administracion_cita/cargar_citas', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@cargarCitasTabla');
    Route::get('administracion_cita/cargar_emergencias', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@cargarEmergenciasTabla');
    Route::get('administracion_cita/cargar_documentosCita/{idCita}', 'GestionHospitalaria\AdministracionDeCitas\DocumentosApiController@cargarDocumentosCita');
    Route::get('administracion_cita/cargar_documentosUsuario/{idUsuario}', 'GestionHospitalaria\AdministracionDeCitas\DocumentosApiController@cargarDocumentosUsuario');
    Route::post('administracion_cita/crear_documento_cita', 'GestionHospitalaria\AdministracionDeCitas\DocumentosApiController@crearDocumentoCita');
    Route::post('administracion_cita/crear_documento_usuario', 'GestionHospitalaria\AdministracionDeCitas\DocumentosApiController@crearDocumentoUsuario');
    Route::post('administracion_cita/guardar_documento', 'GestionHospitalaria\AdministracionDeCitas\DocumentosApiController@guardarDocumento');
    Route::post('administracion_cita/anular_documento_usuario', 'GestionHospitalaria\AdministracionDeCitas\DocumentosApiController@AnularDocumentoUsuario');
    Route::post('administracion_cita/anular_documento_cita', 'GestionHospitalaria\AdministracionDeCitas\DocumentosApiController@AnularDocumentoCita');
    Route::post('administracion_cita/anular_all_docs', 'GestionHospitalaria\AdministracionDeCitas\DocumentosApiController@AnularAllDocs');

    Route::get('administracion_cita/cargar_citas_emergencia_hospitalizacion', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@cargarConsultaEmergenciaHospitalizacionTabla');
    Route::get('administracion_cita/cargar_ultimo_codigo_cita', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@cargarUltimoCodigoCita');
    Route::post('administracion_cita/crear_cita', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@crearCita');
    Route::get('administracion_cita/imprimir_ticket/{idCita}/{tipo}', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@generarTicketPdf');
    
    Route::get('administracion_cita/cita_paciente/{idCita}', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@getPaciente');
    Route::post('administracion_cita/terminar_cita/{idCita}', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@terminarCita');

    //ESTADO DE CITA
    Route::get('administracion_cita/cargar_estado_citas/{idCita}', 'GestionHospitalaria\AdministracionDeCitas\EstadoDeCitaApiController@cargarEstadoDeCitasTabla');
    Route::post('administracion_cita/cargar_agenda', 'GestionHospitalaria\AdministracionDeCitas\EstadoDeCitaApiController@cargarCitasParaAgenda');

    //CONSULTA EXTERNA
    /*Signos Vitales*/
    //***Ruta para cargar los detalles del paciente | Componente: Signos Vitales
    Route::get('consulta_externa/cargar_detalle_paciente/{idCita}', 'GestionHospitalaria\ConsultaExtena\InformacionInicialApiController@cargarInformacionPaciente');
    //***Ruta para guardar o modificar los Signos Vitales | Componente: Signos Vitales
    Route::post('consulta_externa/guardar_modificar_signo_vital/{idCita}', 'GestionHospitalaria\ConsultaExtena\InformacionInicialApiController@guardarModificarSignoVital');

    /*Motivo/Antecedente*/
    //***Ruta para cargar los datos de Motivo/Antecedente | Componente: Motivo/Antecedente  
    Route::get('consulta_externa/cargar_motivo_antecedente/{idCita}', 'GestionHospitalaria\ConsultaExtena\AntecedenteApiController@cargarMotivoAntecedente');
    //***Ruta para guardar o modificar los datos de Motivo/Antecedente | Componente: Motivo/Antecedente  
    Route::post('consulta_externa/guardar_modificar_motivo_antecedente/{idCita}', 'GestionHospitalaria\ConsultaExtena\AntecedenteApiController@guardarModificarMotivoAntecedente');
    
    /*Examen Fisico*/
    //***Ruta para cargar los datos de Examen Fisico | Componente: Examen Fisico   
    Route::get('consulta_externa/cargar_examen_fisico/{idCita}', 'GestionHospitalaria\ConsultaExtena\ExamenFisicoApiController@cargarExamenFisico');
    //***Ruta para guardar o modificar los datos de Examen Fisico | Componente: Examen Fisico  
    Route::post('consulta_externa/guardar_modificar_examen_fisico/{idCita}', 'GestionHospitalaria\ConsultaExtena\ExamenFisicoApiController@guardarModificarExamenFisico');
    
    /*Diagnostico*/
    //***Ruta para cargar los Grupos de Diagnostico | Componente: Diagnostico 
    Route::get('consulta_externa/cargar_cie_grupos','GestionHospitalaria\ConsultaExtena\DiagnosticoApiController@cargarCieGrupos');
    //***Ruta para cargar los Subgrupos de Diagnostico | Componente: Diagnostico
    Route::get('consulta_externa/cargar_cie_sub_grupos/{cie_padre_cod}','GestionHospitalaria\ConsultaExtena\DiagnosticoApiController@cargarCieSubGrupos');
    //***Ruta para cargar los datos de Diagnostico Tabla | Componente: Diagnostico
    Route::get('consulta_externa/cargar_cie/{cie_hijo_cod}','GestionHospitalaria\ConsultaExtena\DiagnosticoApiController@cargarCieTabla');
    //***Ruta para cargar los datos de Diagnostico | Componente: Diagnostico   
    Route::get('consulta_externa/cargar_diagnostico/{idCita}', 'GestionHospitalaria\ConsultaExtena\DiagnosticoApiController@cargarDiagnostico');
    //***Ruta para guardar o modificar los datos de Diagnostico | Componente: Diagnostico  
    Route::post('consulta_externa/guardar_modificar_diagnostico/{idCita}', 'GestionHospitalaria\ConsultaExtena\DiagnosticoApiController@guardarModificarDiagnostico');
    
    /*Prescripcion*/
    //***Ruta para cargar el Stock actual del Producto
    Route::get('consulta_externa/cargar_stock_producto/{idProducto}/{idFarmaciaOrigen}', 'GestionHospitalaria\AdministracionDeFarmacia\MovimientoProductosApiController@cargarStockActual');
    //***Ruta para cargar las Firmas del doctor y del paciente | Componente: Prescripcion   
    Route::get('consulta_externa/cargar_firma_doctor_paciente/{idCita}', 'GestionHospitalaria\ConsultaExtena\PrescripcionApiController@cargarFirmaDoctorPaciente');
    //***Ruta para cargar los datos de Prescripcion | Componente: Prescripcion   
    Route::get('consulta_externa/cargar_prescripcion/{idCita}', 'GestionHospitalaria\ConsultaExtena\PrescripcionApiController@cargarPrescripcion');
    //***Ruta para cargar los PDF de Prescripcion | Componente: Prescripcion   
    Route::get('consulta_externa/cargar_pdf_prescripcion/{idCita}', 'GestionHospitalaria\ConsultaExtena\PrescripcionApiController@cargarPdfPrescripcion');
    //***Ruta para guardar los datos de Prescripcion | Componente: Prescripcion  
    Route::post('consulta_externa/guardar_modificar_prescripcion/{idCita}', 'GestionHospitalaria\ConsultaExtena\PrescripcionApiController@guardarModificarPrescripcion');

    /*Evolucion*/
    //***Ruta para cargar la evolucion del paciente | Componente: Evolucion
    Route::get('consulta_externa/cargar_evolucion/{idCita}', 'GestionHospitalaria\ConsultaExtena\PrescripcionApiController@cargarEvolucion');
    //***Ruta para guardar o modificar la evolucion del paciente | Componente: Evolucion
    Route::post('consulta_externa/guardar_modificar_evolucion/{idCita}', 'GestionHospitalaria\ConsultaExtena\PrescripcionApiController@guardarModificarEvolucion');

    //FARMACIA
    /*Farmacia*/
    //***Ruta para cargar los datos de Farmacia
    Route::get('administracion_farmacia/cargar_farmacia', 'GestionHospitalaria\AdministracionDeFarmacia\FarmaciaApiController@cargarFarmaciaTabla');
    //***Ruta para guardar los datos de Farmacia
    Route::post('administracion_farmacia/guardar_farmacia', 'GestionHospitalaria\AdministracionDeFarmacia\FarmaciaApiController@guardarFarmacia');
    //***Ruta para modificar los datos de Farmacia
    Route::post('administracion_farmacia/modificar_farmacia', 'GestionHospitalaria\AdministracionDeFarmacia\FarmaciaApiController@modificarFarmacia');
    //***Ruta para eliminar los datos de Farmacia
    Route::delete('administracion_farmacia/eliminar_farmacia/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\FarmaciaApiController@eliminarFarmacia');

    /*Asociacion de Farmacia*/
    //***Ruta para cargar los datos de Asociacion de Farmacia por ID
    Route::get('administracion_farmacia/cargar_asociacion_farmacia_por_id/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\HospitalFarmaciaApiController@cargarAsociacionFarmaciaPorId');
    //***Ruta para cargar los datos de Asociacion de Farmacia
    Route::get('administracion_farmacia/cargar_asociacion_farmacia', 'GestionHospitalaria\AdministracionDeFarmacia\HospitalFarmaciaApiController@cargarAsociacionFarmaciaTabla');
    //***Ruta para guardar los datos de Asociacion de Farmacia
    Route::post('administracion_farmacia/guardar_asociacion_farmacia', 'GestionHospitalaria\AdministracionDeFarmacia\HospitalFarmaciaApiController@guardarAsociacionFarmacia');
    //***Ruta para modificar los datos de Asociacion de Farmacia
    Route::post('administracion_farmacia/modificar_asociacion_farmacia', 'GestionHospitalaria\AdministracionDeFarmacia\HospitalFarmaciaApiController@modificarAsociacionFarmacia');
    //***Ruta para eliminar los datos de Asociacion de Farmacia
    Route::delete('administracion_farmacia/eliminar_asociacion_farmacia/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\HospitalFarmaciaApiController@eliminarAsociacionFarmacia');

    /*Categoria*/
    //***Ruta para cargar los datos de Categoria
    Route::get('administracion_farmacia/cargar_categoria', 'GestionHospitalaria\AdministracionDeFarmacia\CategoriaApiController@cargarCategoriaTabla');
    //***Ruta para guardar los datos de Categoria
    Route::post('administracion_farmacia/guardar_categoria', 'GestionHospitalaria\AdministracionDeFarmacia\CategoriaApiController@guardarCategoria');
    //***Ruta para modificar los datos de Categoria
    Route::post('administracion_farmacia/modificar_categoria', 'GestionHospitalaria\AdministracionDeFarmacia\CategoriaApiController@modificarCategoria');
    //***Ruta para eliminar los datos de Categoria
    Route::delete('administracion_farmacia/eliminar_categoria/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\CategoriaApiController@eliminarCategoria');

    /*Productos*/
    //***Ruta para cargar los Productos por Farmacia
    Route::get('administracion_farmacia/cargar_producto_por_farmacia/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\ProductoDetalleApiController@cargarProductoPorFarmacia');
    //***Ruta para cargar los datos de Productos por ID
    Route::get('administracion_farmacia/cargar_producto_por_id/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\ProductosApiController@cargarProductosPorId');
    //***Ruta para cargar los datos de Productos
    Route::get('administracion_farmacia/cargar_productos', 'GestionHospitalaria\AdministracionDeFarmacia\ProductosApiController@cargarProductosTabla');
    //***Ruta para guardar los datos de Productos
    Route::post('administracion_farmacia/guardar_productos', 'GestionHospitalaria\AdministracionDeFarmacia\ProductosApiController@guardarProductos');
    //***Ruta para modificar los datos de Productos
    Route::post('administracion_farmacia/modificar_productos', 'GestionHospitalaria\AdministracionDeFarmacia\ProductosApiController@modificarProductos');
    //***Ruta para eliminar los datos de Productos
    Route::delete('administracion_farmacia/eliminar_productos/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\ProductosApiController@eliminarProductos');

    /*Presentaciones*/
    Route::get('administracion_farmacia/cargar_presentaciones', 'GestionHospitalaria\AdministracionDeFarmacia\PresentacionApiController@cargarPresentaciones');
    Route::post('administracion_farmacia/guardar_presentacion', 'GestionHospitalaria\AdministracionDeFarmacia\PresentacionApiController@guardarPresentacion');
    Route::post('administracion_farmacia/modificar_presentacion', 'GestionHospitalaria\AdministracionDeFarmacia\PresentacionApiController@modificarPresentacion');
    Route::delete('administracion_farmacia/eliminar_presentacion/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\PresentacionApiController@eliminarPresentacion');

    /*PresentacionProducto*/
    Route::get('administracion_farmacia/cargar_presentacion_producto', 'GestionHospitalaria\AdministracionDeFarmacia\PresentacionProductoApiController@cargarPresentacionProductoTabla');
    Route::get('administracion_farmacia/cargar_presentacion_producto_por_id/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\PresentacionProductoApiController@cargarPresentacionProductoPorId');
    Route::post('administracion_farmacia/guardar_presentacion_producto', 'GestionHospitalaria\AdministracionDeFarmacia\PresentacionProductoApiController@guardarPresentacionProducto');
    Route::delete('administracion_farmacia/eliminar_presentacion_producto/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\PresentacionProductoApiController@eliminarPresentacionProducto');
   
    /*Tipo de Movimiento*/
    //***Ruta para cargar los datos de Tipo de Movimiento
    Route::get('administracion_farmacia/cargar_tipo_movimiento', 'GestionHospitalaria\AdministracionDeFarmacia\TipoMovimientoApiController@cargarTipoMovimientoTabla');
    //***Ruta para guardar los datos de Tipo de Movimiento
    Route::post('administracion_farmacia/guardar_tipo_movimiento', 'GestionHospitalaria\AdministracionDeFarmacia\TipoMovimientoApiController@guardarTipoMovimiento');
    //***Ruta para modificar los datos de Tipo de Movimiento
    Route::post('administracion_farmacia/modificar_tipo_movimiento', 'GestionHospitalaria\AdministracionDeFarmacia\TipoMovimientoApiController@modificarTipoMovimiento');
    //***Ruta para eliminar los datos de Tipo de Movimiento
    Route::delete('administracion_farmacia/eliminar_tipo_movimiento/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\TipoMovimientoApiController@eliminarTipoMovimiento');

    /*Movimiento de Productos*/
    //***Ruta para cargar el Stock actual del Producto
    Route::get('administracion_farmacia/cargar_stock_producto/{idProducto}/{idFarmaciaOrigen}', 'GestionHospitalaria\AdministracionDeFarmacia\MovimientoProductosApiController@cargarStockActual');
    //***Ruta para validar el Stock del Producto
    Route::get('administracion_farmacia/validar_stock_producto/{idProducto}/{idFarmaciaOrigen}/{cantidad}', 'GestionHospitalaria\AdministracionDeFarmacia\MovimientoProductosApiController@validarStockProducto');
    //***Ruta para guardar los datos del Movimiento de Productos
    Route::post('administracion_farmacia/guardar_movimiento_productos', 'GestionHospitalaria\AdministracionDeFarmacia\MovimientoProductosApiController@guardarMovimientoProductos');
    //***Ruta para modificar los datos de Productos
    Route::post('administracion_farmacia/modificar_productos', 'GestionHospitalaria\AdministracionDeFarmacia\ProductosApiController@modificarProductos');
    //***Ruta para eliminar los datos de Productos
    Route::delete('administracion_farmacia/eliminar_productos/{id}', 'GestionHospitalaria\AdministracionDeFarmacia\ProductosApiController@eliminarProductos');

    // FIN FARMACIA

    // FORMULARIOS MSP
    /*Generar Formulario MSP*/
    //***Ruta para cargar los pacientes con historial clinico
    Route::get('formulario_msp/cargar_paciente_historia_clinico', 'GestionHospitalaria\FormularioMSP\FormularioMPSApiController@cargarHistoriaClinicaTabla');
    //***Ruta para cargar el PDF del formulario MSP 002    
    Route::get('formulario_msp/cargar_pdf_formulario_msp_002/{idUser}', 'GestionHospitalaria\FormularioMSP\FormularioMPSApiController@cargarPdfFormularioMsp002');

    // FIN FORMULARIOS MSP 

    //PACIENTES
    Route::get('pacientes/cargar_parentescos', 'GestionHospitalaria\Pacientes\ParentescoApiController@cargarParentescosTabla');
    Route::get('pacientes/cargar_parentesco_lista', 'GestionHospitalaria\Pacientes\ParentescoApiController@cargarParentescosLista');
    Route::post('pacientes/modificar_parentesco', 'GestionHospitalaria\Pacientes\ParentescoApiController@modificarParentesco');
    Route::post('pacientes/guardar_parentesco', 'GestionHospitalaria\Pacientes\ParentescoApiController@guardarParentesco');
    Route::delete('pacientes/eliminar_parentesco/{id}', 'GestionHospitalaria\Pacientes\ParentescoApiController@eliminarParentesco');
    Route::get('pacientes/cargar_polizas', 'GestionHospitalaria\Pacientes\PolizaApiController@cargarPolizasTabla');
    Route::get('pacientes/cargar_polizas_por_usuario/{id}', 'GestionHospitalaria\Pacientes\PolizaApiController@cargarPolizasPorUsuario');
    Route::post('pacientes/guardar_poliza', 'GestionHospitalaria\Pacientes\PolizaApiController@guardarPoliza');
    Route::delete('pacientes/eliminar_poliza/{id}', 'GestionHospitalaria\Pacientes\PolizaApiController@eliminarPoliza');

    Route::get('pacientes/cargar_beneficiarios_por_poliza/{id}', 'GestionHospitalaria\Pacientes\BeneficiariosPolizaApiController@cargarBeneficiariosPorPolizaId');
    Route::get('pacientes/cargar_beneficiarios_poliza', 'GestionHospitalaria\Pacientes\BeneficiariosPolizaApiController@cargarBeneficiariosPolizaTabla');
    Route::post('pacientes/guardar_beneficiario_poliza', 'GestionHospitalaria\Pacientes\BeneficiariosPolizaApiController@guardarBeneficiarioPoliza');
    Route::delete('pacientes/eliminar_beneficiario_poliza/{id}', 'GestionHospitalaria\Pacientes\BeneficiariosPolizaApiController@eliminarBeneficiarioPoliza');

    Route::get('pacientes/cargar_lugares_de_trabajo', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoApiController@cargarLugaresDeTrabajoTabla');
    Route::post('pacientes/guardar_lugar_de_trabajo', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoApiController@guardarLugarDeTrabajo');
    Route::post('pacientes/modificar_lugar_de_trabajo', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoApiController@modificarLugarDeTrabajo');
    Route::delete('pacientes/eliminar_lugar_de_trabajo/{id}', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoApiController@eliminarLugarDeTrabajo');
    Route::get('pacientes/cargar_lugares_de_trabajo_usuario', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoUsuarioApiController@cargarLugaresDeTrabajoUsuarioTabla');
    Route::post('pacientes/guardar_lugar_de_trabajo_usuario', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoUsuarioApiController@guardarLugarDeTrabajoUsuario');
    Route::post('pacientes/modificar_lugar_de_trabajo_usuario', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoUsuarioApiController@modificarLugarDeTrabajoUsuario');
    Route::delete('pacientes/eliminar_lugar_de_trabajo_usuario/{id}', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoUsuarioApiController@eliminarLugarDeTrabajoUsuario');
    Route::get('pacientes/cargar_lugares_de_trabajo_usuario_por_lugar_id/{id}', 'GestionHospitalaria\Pacientes\LugaresDeTrabajoUsuarioApiController@cargarLugaresDeTrabajoUsuarioPorLugarId');

    Route::get('pacientes/cargar_usuario_parentescos', 'GestionHospitalaria\Pacientes\UsuariosParentescoApiController@cargarUsuariosParentescosTabla');
    Route::post('pacientes/guardar_usuario_parentesco', 'GestionHospitalaria\Pacientes\UsuariosParentescoApiController@guardarUsuarioParentesco');
    Route::post('pacientes/modificar_usuario_parentesco', 'GestionHospitalaria\Pacientes\UsuariosParentescoApiController@modificarUsuarioParentesco');
    Route::delete('pacientes/eliminar_usuario_parentesco/{id}', 'GestionHospitalaria\Pacientes\UsuariosParentescoApiController@eliminarUsuarioParentesco');


    //TIPO DE HABITACIONES
    Route::get('tipo_habitaciones/cargar_tipo_habitaciones', 'GestionHospitalaria\AdministracionDeHospital\TipoDeHabitacionApiController@cargarTipoDeHabitacionTabla');
    Route::post('tipo_habitaciones/guardar_tipo_habitaciones', 'GestionHospitalaria\AdministracionDeHospital\TipoDeHabitacionApiController@guardarTipoDeHabitacion');
    Route::post('tipo_habitaciones/modificar_tipo_habitaciones', 'GestionHospitalaria\AdministracionDeHospital\TipoDeHabitacionApiController@modificarTipoDeHabitacion');
    Route::delete('tipo_habitaciones/eliminar_tipo_habitaciones/{id}', 'GestionHospitalaria\AdministracionDeHospital\TipoDeHabitacionApiController@eliminarTipoDeHabitacion');
    //HOSPITALES
    Route::get('hospitales/cargar_hospitales', 'GestionHospitalaria\AdministracionDeHospital\HospitalApiController@cargarHospitalTabla');
    Route::post('hospitales/guardarModificarArchivo', 'GestionHospitalaria\AdministracionDeHospital\HospitalApiController@guardarModificarArchivo');
    Route::post('hospitales/guardar_hospitales', 'GestionHospitalaria\AdministracionDeHospital\HospitalApiController@guardarHospital');
    Route::post('hospitales/modificar_hospitales', 'GestionHospitalaria\AdministracionDeHospital\HospitalApiController@modificarHospital');
    Route::delete('hospitales/eliminar_hospitales/{id}', 'GestionHospitalaria\AdministracionDeHospital\HospitalApiController@eliminarHospital');
    //HABITACIONES
    Route::get('habitaciones/cargar_habitaciones', 'GestionHospitalaria\AdministracionDeHospital\HabitacionApiController@cargarHabitacionTabla');
    Route::post('habitaciones/guardar_habitaciones', 'GestionHospitalaria\AdministracionDeHospital\HabitacionApiController@guardarHabitacion');
    Route::post('habitaciones/modificar_habitaciones', 'GestionHospitalaria\AdministracionDeHospital\HabitacionApiController@modificarHabitacion');
    Route::post('habitaciones/eliminar_habitaciones', 'GestionHospitalaria\AdministracionDeHospital\HabitacionApiController@eliminarHabitacion');
    //Consultorios
    Route::get('consultorios/cargar_consultorios', 'GestionHospitalaria\AdministracionDeHospital\ConsultorioApiController@cargarConsultorioTabla');
    Route::post('consultorios/guardar_consultorios', 'GestionHospitalaria\AdministracionDeHospital\ConsultorioApiController@guardarConsultorio');
    Route::post('consultorios/modificar_consultorios', 'GestionHospitalaria\AdministracionDeHospital\ConsultorioApiController@modificarConsultorio');
    Route::post('consultorios/eliminar_consultorios', 'GestionHospitalaria\AdministracionDeHospital\ConsultorioApiController@eliminarConsultorio');
    //TIPO DE CAMAS
    Route::get('tipo_camas/cargar_tipo_camas', 'GestionHospitalaria\AdministracionDeHospital\TipoDeCamaApiController@cargarTipoDeCamaTabla');
    Route::post('tipo_camas/guardar_tipo_camas', 'GestionHospitalaria\AdministracionDeHospital\TipoDeCamaApiController@guardarTipoDeCama');
    Route::post('tipo_camas/modificar_tipo_camas', 'GestionHospitalaria\AdministracionDeHospital\TipoDeCamaApiController@modificarTipoDeCama');
    Route::delete('tipo_camas/eliminar_tipo_camas/{id}', 'GestionHospitalaria\AdministracionDeHospital\TipoDeCamaApiController@eliminarTipoDeCama');
    //CAMAS
    Route::get('camas/cargar_camas', 'GestionHospitalaria\AdministracionDeHospital\CamaApiController@cargarCamaTabla');
    Route::post('camas/guardar_camas', 'GestionHospitalaria\AdministracionDeHospital\CamaApiController@guardarCama');
    Route::post('camas/modificar_camas', 'GestionHospitalaria\AdministracionDeHospital\CamaApiController@modificarCama');
    Route::post('camas/eliminar_camas', 'GestionHospitalaria\AdministracionDeHospital\CamaApiController@eliminarCama');
    //Areas
    Route::get('areas/cargar_areas', 'GestionHospitalaria\AdministracionDeHospital\AreaApiController@cargarAreaTabla');
    Route::post('areas/guardar_areas', 'GestionHospitalaria\AdministracionDeHospital\AreaApiController@guardarArea');
    Route::post('areas/modificar_areas', 'GestionHospitalaria\AdministracionDeHospital\AreaApiController@modificarArea');
    Route::post('areas/eliminar_areas', 'GestionHospitalaria\AdministracionDeHospital\AreaApiController@eliminarArea');
    //Especialidades
    Route::get('especialidades/cargar_especialidades', 'GestionHospitalaria\AdministracionDeHospital\EspecialidadApiController@cargarEspecialidadTabla');
    Route::post('especialidades/guardar_especialidades', 'GestionHospitalaria\AdministracionDeHospital\EspecialidadApiController@guardarEspecialidad');
    Route::post('especialidades/modificar_especialidades', 'GestionHospitalaria\AdministracionDeHospital\EspecialidadApiController@modificarEspecialidad');
    Route::post('especialidades/eliminar_especialidades', 'GestionHospitalaria\AdministracionDeHospital\EspecialidadApiController@eliminarEspecialidad');
    //Tipo  de Personal Medico
    Route::get('personalMedico/cargar_tipo_personal_medico', 'GestionHospitalaria\PersonalMedico\TipoDePersonalMedicoApiController@cargarTipoDePersonalMedicoTabla');
    Route::post('personalMedico/guardar_tipo_personal_medico', 'GestionHospitalaria\PersonalMedico\TipoDePersonalMedicoApiController@guardarTipoDePersonalMedico');
    Route::post('personalMedico/modificar_tipo_personal_medico', 'GestionHospitalaria\PersonalMedico\TipoDePersonalMedicoApiController@modificarTipoDePersonalMedico');
    Route::delete('personalMedico/eliminar_tipo_personal_medico/{id}', 'GestionHospitalaria\PersonalMedico\TipoDePersonalMedicoApiController@eliminarTipoDePersonalMedico');
    //Personal Medico
    Route::get('personalMedico/cargar_personal_medico', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@cargarPersonalMedicoTabla');
    Route::post('personalMedico/guardar_personal_medico', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@guardarPersonalMedico');
    Route::post('personalMedico/guardar_contrato_personal_medico', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@guardarArchivos');
    Route::post('personalMedico/modificar_personal_medico', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@modificarPersonalMedico');
    Route::post('personalMedico/eliminar_personal_medico', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@eliminarPersonalMedico');
    Route::get('personalMedico/cargar_personal_medico_dropdown', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@cargarPersonalMedicoDropdown');
    Route::get('personalMedico/verTipoPersonalMedico', 'GestionHospitalaria\PersonalMedico\PersonalMedicoApiController@verTipoPersonalMedico');

    //Funciones de Personal Medico
    Route::get('funciones_personalMedico/cargar_funciones_personalMedico', 'GestionHospitalaria\PersonalMedico\FuncionTrabajadorApiController@cargarFuncionTrabajadorTabla');
    Route::post('funciones_personalMedico/guardar_funciones_personalMedico', 'GestionHospitalaria\PersonalMedico\FuncionTrabajadorApiController@guardarFuncionTrabajador');
    Route::delete('funciones_personalMedico/eliminar_funciones_personalMedico/{id}', 'GestionHospitalaria\PersonalMedico\FuncionTrabajadorApiController@eliminarFuncionTrabajador');
    //Jornada Personal Medico
    Route::get('jornadas/cargar_jornadas/{id}', 'GestionHospitalaria\PersonalMedico\JornadaApiController@cargarJornadaTabla');
    Route::post('jornadas/guardar_jornadas', 'GestionHospitalaria\PersonalMedico\JornadaApiController@guardarJornada');
    Route::post('jornadas/modificar_jornadas', 'GestionHospitalaria\PersonalMedico\JornadaApiController@modificarJornada');
    Route::post('jornadas/eliminar_jornadas', 'GestionHospitalaria\PersonalMedico\JornadaApiController@eliminarJornada');
    //POLIZA
    Route::get('pacientes/cargar_polizas', 'GestionHospitalaria\Pacientes\PolizaApiController@cargarPolizasTabla');
    Route::post('pacientes/guardar_poliza', 'GestionHospitalaria\Pacientes\PolizaApiController@guardarPoliza');
    Route::post('pacientes/guardar_documento_poliza', 'GestionHospitalaria\Pacientes\PolizaApiController@guardarArchivos');
    Route::delete('pacientes/eliminar_poliza/{id}', 'GestionHospitalaria\Pacientes\PolizaApiController@eliminarPoliza');
    Route::delete('camas/eliminar_camas', 'GestionHospitalaria\AdministracionDeHospital\CamaApiController@eliminarCama');
    //ADMISIONES
    Route::post('administracion_cita/cargar_admisiones_por_fecha', 'GestionHospitalaria\AdministracionDeCitas\AdmisionApiController@cargarAdmisionesPorFecha');
    Route::post('administracion_cita/crear_admision', 'GestionHospitalaria\AdministracionDeCitas\AdmisionApiController@crearAdmision');
    Route::post('administracion_cita/modificar_admision', 'GestionHospitalaria\AdministracionDeCitas\AdmisionApiController@modificarAdmision');
    Route::get('administracion_cita/cargar_ultimo_estado_cita/{id}', 'GestionHospitalaria\AdministracionDeCitas\CitaApiController@cargarUltimoEstadoCita');
});
Route::group(['prefix' => 'rpis', 'middleware' => ['auth:web']], function () {
    Route::get('obtener/seguros/{codigo_usuario}', 'RpisApiController@cargarSegurosPaciente');
    Route::get('obtener/seguros/{codigo_usuario}/{fecha_consulta}', 'RpisApiController@cargarSegurosPacientePorFecha');
    Route::get('obtener/seguros/{codigo_usuario}/{fecha_consulta}/pdf', 'RpisApiController@descargarPdfSegurosPacientePorFecha');
    Route::get('obtener/pdf/{codigo_usuario}/seguros', 'RpisApiController@descargarPdfSegurosPaciente');
});
Route::group(['prefix' => 'regcivil', 'middleware' => ['auth:web']], function () {
    Route::get('obtener/persona', 'RegistroCivilApiController@getPerson');
});
