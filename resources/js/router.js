import Vue from "vue";
import { prefix } from "./variables";
import VueRouter from "vue-router";
import ExampleComponent from "./components/ExampleComponent";
import Tabla from "./components/componentesGenerales/VueTableComponent";
import ConfiguracionGeneralidades from "./components/datosGenerales/generalidades/ConfiguracionGeneralidades";
import OrganizacionBspi from "./components/datosGenerales/generalidades/organizacionBspi/OrganizacionBspi";
import TiposdeOrganismo from "./components/datosGenerales/generalidades/tiposBspi/TiposdeOrganismoBpsi";
import CargosdeOrganismo from "./components/datosGenerales/generalidades/cargosEnOrganismosBspi/CargosOrganismosBspi";
import OrganismosVinculantesConLaBspi from "./components/datosGenerales/generalidades/organismosVinculantesConLaBspi/OrganismosVinculantesConLaBspi.vue";
import Roles from "./components/datosGenerales/usuarios/roles/Roles.vue";
import OrganismoYContactos from "./components/datosGenerales/generalidades/OrganismosYContactosBspi/OrganismosYContactosBspi";
import Usuarios from "./components/datosGenerales/usuarios/datos/Usuarios.vue";
import Logs from "./components/datosGenerales/logs/LogUsuario.vue";
import Gestiones from "./components/datosGenerales/gestiones/datos/Gestiones.vue";
import GestionesYUsuarios from "./components/datosGenerales/gestiones/gestionesYUsuario/GestionesYUsuario.vue";
import Paises from "./components/datosGenerales/configuraciones/Paises.vue";
import TiposDeSangre from "./components/datosGenerales/configuraciones/TiposDeSangre.vue";
import Religiones from "./components/datosGenerales/configuraciones/Religiones.vue";
import TiposDeCasa from "./components/datosGenerales/configuraciones/TiposDeCasa.vue";
import Movilizaciones from "./components/datosGenerales/configuraciones/Movilizaciones.vue";
import Discapacidades from "./components/datosGenerales/configuraciones/Discapacidades.vue";
import Casas from "./components/datosGenerales/configuraciones/Casas.vue";
import GruposCulturales from "./components/datosGenerales/configuraciones/GruposCulturales.vue";
import TiposDeOrganizacion from "./components/datosGenerales/configuraciones/TiposDeOrganizacion.vue";
import Provincias from "./components/datosGenerales/configuraciones/provincias/Provincias.vue";
import Cantones from "./components/datosGenerales/configuraciones/cantones/Cantones.vue";
import Parroquias from "./components/datosGenerales/configuraciones/parroquias/Parroquias.vue";
import TiposParentesco from "./components/gestionHospitalaria/generalidades/TiposParentesco.vue";
import Ocupaciones from "./components/gestionHospitalaria/generalidades/Ocupaciones.vue";
import Aseguradoras from "./components/gestionHospitalaria/generalidades/aseguradoras/Aseguradoras.vue";
import Parentescos from "./components/gestionHospitalaria/pacientes/parentescos/Parentescos.vue";
import PreparacionDelPaciente from "./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/PreparacionDelPaciente.vue";
import TipoHabitaciones from "./components/gestionHospitalaria/administracionDeHospital/tipoHabitaciones/TipoHabitaciones.vue";
import Hospitales from "./components/gestionHospitalaria/administracionDeHospital/hospital/Hospital.vue";
import Habitaciones from "./components/gestionHospitalaria/administracionDeHospital/habitaciones/Habitaciones.vue";
import Consultorios from "./components/gestionHospitalaria/administracionDeHospital/consultorios/Consultorios.vue";
import TipoCamas from "./components/gestionHospitalaria/administracionDeHospital/tipoCamas/TipoCamas.vue";
import Camas from "./components/gestionHospitalaria/administracionDeHospital/camas/Camas.vue";
import Areas from "./components/gestionHospitalaria/administracionDeHospital/areas/Areas.vue";
import Especialidades from "./components/gestionHospitalaria/administracionDeHospital/especialidades/Especialidades.vue";
import TipoTrabajadores from "./components/gestionHospitalaria/personalMedico/tiposDePersonalMedico/TipoPersonalMedico";
import PersonalMedico from "./components/gestionHospitalaria/personalMedico/personalMedico/PersonalMedico";
import Jornadas from "./components/gestionHospitalaria/consultaExterna/horariosMedicos/Jornadas.vue";
import AsignacionJornada from "./components/gestionHospitalaria/personalMedico/jornadas/Jornadas.vue";
import Funciones from "./components/gestionHospitalaria/personalMedico/funcionesDePersonalMedico/FuncionesPersonalMedico.vue";
import DocumentosCitas from "./components/gestionHospitalaria/administracionDeCitas/citas/DocumentosCitas.vue";

import LugaresDeTrabajo from "./components/gestionHospitalaria/pacientes/lugaresDeTrabajo/LugaresDeTrabajo.vue";
import Polizas from "./components/gestionHospitalaria/pacientes/polizas/Polizas.vue";
import LugaresDeTrabajoUsuario from "./components/gestionHospitalaria/pacientes/lugaresDeTrabajoUsuario/lugaresDeTrabajoUsuario.vue";
import UsuariosParentesco from "./components/gestionHospitalaria/pacientes/usuariosParentesco/UsuariosParentesco.vue";
import Admisiones from "./components/gestionHospitalaria/administracionDeHospital/admisiones/Admisiones.vue";
import Beneficiarios from "./components/gestionHospitalaria/pacientes/beneficiariosPoliza/BeneficiariosPoliza.vue";
import VisualizacionConsultaExterna from "./components/gestionHospitalaria/consultaExterna/visualizacionDeConsultaExterna/VisualizacionConsultaExterna.vue";
import VisualizacionEmergencia from "./components/gestionHospitalaria/emergencia/visualizacionDeEmergencia/VisualizacionEmergencia.vue";
//Farmacia
import Farmacia from "./components/gestionHospitalaria/administracionDeFarmacia/farmacia/Farmacia.vue";
//Calendar Test
import Calendar from "./components/componentesGenerales/AgendaCitas/Calendar.vue";
//Asocicacion de Farmacia
import AsocicacionFarmacia from "./components/gestionHospitalaria/administracionDeFarmacia/asociacionDeFarmacia/AsociacionFarmacia.vue";
//Categoria
import Categoria from "./components/gestionHospitalaria/administracionDeFarmacia/categoria/Categoria.vue";
//Productos
import Productos from "./components/gestionHospitalaria/administracionDeFarmacia/productos/Productos.vue";
import Presentaciones from "./components/gestionHospitalaria/administracionDeFarmacia/presentacion/Presentacion.vue";
import PresentacionProducto from "./components/gestionHospitalaria/administracionDeFarmacia/presentacionProducto/PresentacionProducto.vue";
TipoMovimiento;
//Tipo de Movimiento
import TipoMovimiento from "./components/gestionHospitalaria/administracionDeFarmacia/tipoMovimiento/TipoMovimiento.vue";
//Movimiento de Productos
import MovimientoProductos from "./components/gestionHospitalaria/administracionDeFarmacia/movimientoDeProductos/MovimientoProductos.vue";
//Fomulario MSP
import PacienteHistorialClinico from "./components/gestionHospitalaria/formulariosMSP/ListaPacienteHistorialClinico.vue";

import DisponibilidadSeguros from "./components/gestionHospitalaria/pacientes/disponibilidadSeguros/DisponibilidadSeguros.vue";
import DocumentosUsuarios from "./components/gestionHospitalaria/administracionDeCitas/citas/DocumentosUsuarios.vue";

import AsignacionConsultaExterna from "./components/gestionHospitalaria/consultaExterna/asignacionDeConsultaExterna/AsignacionConsultaExterna.vue";
import AsignacionEmergencia from "./components/gestionHospitalaria/emergencia/asignacionDeEmergencia/AsignacionEmergencia.vue";
import Bienvenido from "./components/componentesGenerales/Bienvenido.vue";

//Formulario para el Cambio de Clave
import CambioClave from "./components/componentesGenerales/CambioClave/CambioClave.vue";
Vue.use(VueRouter);
let prefijo = prefix;
export default new VueRouter({
    routes: [
        { path: prefijo + "/gestion_hospitalaria/agenda", component: Calendar },

        { 
            path: prefijo + "/gestion_hospitalaria/cambio_clave", component: CambioClave 
        },

        { path: prefijo, component: Bienvenido },
        {
            path:
                prefijo +
                "/datos_generales/generalidades/mostrar_configuracion",
            component: ConfiguracionGeneralidades
        },
        {
            path:
                prefijo +
                "/datos_generales/generalidades/mostrar_organizacion_bspi",
            component: OrganizacionBspi
        },
        {
            path: prefijo + "/tabla",
            component: Tabla
        },
        {
            path:
                prefijo +
                "/datos_generales/generalidades/mostrar_tipos_de_organismo",
            component: TiposdeOrganismo
        },
        {
            path:
                prefijo +
                "/datos_generales/generalidades/mostrar_organismos_vinculantes_con_la_bspi",
            component: OrganismosVinculantesConLaBspi
        },
        {
            path:
                prefijo +
                "/datos_generales/generalidades/mostrar_cargos_en_organismos",
            component: CargosdeOrganismo
        },
        {
            path: prefijo + "/datos_generales/usuarios/mostrar_roles",
            component: Roles
        },
        {
            path:
                prefijo +
                "/datos_generales/generalidades/mostrar_organismos_contactos",
            component: OrganismoYContactos
        },
        {
            path: prefijo + "/datos_generales/usuarios/mostrar_usuarios",
            component: Usuarios
        },
        {
            path: prefijo + "/datos_generales/logs/mostrar_logs",
            component: Logs
        },
        {
            path: prefijo + "/datos_generales/gestiones/mostrar_gestiones",
            component: Gestiones
        },
        {
            path:
                prefijo +
                "/datos_generales/gestiones/mostrar_gestiones_y_usuarios",
            component: GestionesYUsuarios
        },
        {
            path: prefijo + "/datos_generales/configuraciones/mostrar_paises",
            component: Paises
        },
        {
            path:
                prefijo +
                "/datos_generales/configuraciones/mostrar_tipos_de_sangre",
            component: TiposDeSangre
        },
        {
            path:
                prefijo + "/datos_generales/configuraciones/mostrar_religiones",
            component: Religiones
        },
        {
            path:
                prefijo +
                "/datos_generales/configuraciones/mostrar_tipos_de_casa",
            component: TiposDeCasa
        },
        {
            path:
                prefijo +
                "/datos_generales/configuraciones/mostrar_movilizaciones",
            component: Movilizaciones
        },
        {
            path:
                prefijo +
                "/datos_generales/configuraciones/mostrar_discapacidades",
            component: Discapacidades
        },
        {
            path: prefijo + "/datos_generales/configuraciones/mostrar_casas",
            component: Casas
        },
        {
            path:
                prefijo +
                "/datos_generales/configuraciones/mostrar_tipos_de_organizacion",
            component: TiposDeOrganizacion
        },
        {
            path:
                prefijo +
                "/datos_generales/configuraciones/mostrar_grupos_culturales",
            component: GruposCulturales
        },
        {
            path:
                prefijo + "/datos_generales/configuraciones/mostrar_provincias",
            component: Provincias
        },
        {
            path: prefijo + "/datos_generales/configuraciones/mostrar_cantones",
            component: Cantones
        },
        {
            path:
                prefijo + "/datos_generales/configuraciones/mostrar_parroquias",
            component: Parroquias
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/generalidades/mostrar_tipos_parentesco",
            component: TiposParentesco
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/generalidades/mostrar_ocupaciones",
            component: Ocupaciones
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/generalidades/mostrar_aseguradoras",
            component: Aseguradoras
        },

        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_citas/mostrar_consulta_externa/:citaId",
            name: "ConsultaExterna",
            component: PreparacionDelPaciente
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/consulta_externa/mostrar_preparacion_del_paciente",

            component: PreparacionDelPaciente
        },
        {
            path:
                prefijo + "/gestion_hospitalaria/pacientes/mostrar_parentescos",
            component: Parentescos
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/tipo_habitaciones",
            component: TipoHabitaciones
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/hopistales",
            component: Hospitales
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/habitaciones",
            component: Habitaciones
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/consultorios",
            component: Consultorios
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/tipo_camas",
            component: TipoCamas
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/camas",
            component: Camas
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/areas",
            component: Areas
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/especialidades",
            component: Especialidades
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/tipo_trabajadores",
            component: TipoTrabajadores
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/personal_medico",
            component: PersonalMedico
        },
        {
            path: prefijo + "/gestion_hospitalaria/consulta_externa/jornadas",
            component: Jornadas
        },
        {
            path: prefijo + "/gestion_hospitalaria/jornadas",
            component: AsignacionJornada
        },

        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_hospital/funciones_personal_medico",
            component: Funciones
        },
        {
            path: prefijo + "/gestion_hospitalaria/pacientes/mostrar_polizas",
            component: Polizas
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/pacientes/mostrar_lugares_de_trabajo",
            component: LugaresDeTrabajo
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/pacientes/mostrar_lugares_de_trabajo_usuario",
            component: LugaresDeTrabajoUsuario
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/pacientes/mostrar_usuarios_patentesco",
            component: UsuariosParentesco
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_citas/mostrar_admisiones",
            component: Admisiones
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/pacientes/mostrar_beneficiarios",
            component: Beneficiarios
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/consulta_externa/mostrar_visualizacion_consulta_externa",
            component: VisualizacionConsultaExterna
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/emergencia/mostrar_visualizacion_emergencia",
            component: VisualizacionEmergencia
        },
        //Farmacia
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_farmacia/farmacia/mostrar_farmacia",
            component: Farmacia
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/pacientes/seguros/disponibilidad",
            component: DisponibilidadSeguros
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_citas/mostrar_documentos_citas",
            component: DocumentosCitas
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_citas/mostrar_documentos_usuarios",
            component: DocumentosUsuarios
        },
        //Asociacion de Farmacia
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_farmacia/asociacion_de_farmacia/mostrar_asociacion_farmacia",
            component: AsocicacionFarmacia
        },
        //Categoria
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_farmacia/categoria/mostrar_categoria",
            component: Categoria
        },
        //Productos
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_farmacia/productos/mostrar_productos",
            component: Productos
        },
        //Presentaciones
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_farmacia/presentaciones/mostrar_presentaciones",
            component: Presentaciones
        },
        //Presentaciones
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_farmacia/presentaciones/mostrar_presentacion_productos",
            component: PresentacionProducto
        },

        //Movimientos de Productos
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_farmacia/tipo_movimiento/mostrar_tipo_movimiento",
            component: TipoMovimiento
        },
        //Movimientos de Productos
        {
            path:
                prefijo +
                "/gestion_hospitalaria/administracion_de_farmacia/movimiento_producto/mostrar_movimiento_productos",
            component: MovimientoProductos
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/consulta_externa/mostrar_asignacion_consulta_externa",
            component: AsignacionConsultaExterna
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/emergencia/mostrar_asignacion_emergencia",
            component: AsignacionEmergencia
        },
        {
            path:
                prefijo +
                "/gestion_hospitalaria/formulario_msp/mostrar_formulario_msp",
            component: PacienteHistorialClinico
        }
    ],
    mode: "history"
});
