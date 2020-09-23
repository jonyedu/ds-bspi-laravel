require("./bootstrap");
import Vue from "vue";
import router from "./router";
import VueRouter from "vue-router";

import App from "./components/App";
import VModal from "vue-js-modal";
import VueGoodTablePlugin from "vue-good-table";
import "vue-good-table/dist/vue-good-table.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import vSelect from "vue-select";
import { funcionesGlobales } from "./funciones.js";
import { nombresModulo } from "./nombresModulo";
import { nombresFormulario } from "./nombresFormulario";
import Loading from "vue-loading-overlay";
import VueTimepicker from "vue2-timepicker";

// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

import "vue2-timepicker/dist/VueTimepicker.css";
import moment from "moment";

import swal from 'sweetalert2';
window.Swal = swal;

Vue.prototype.moment = moment;
Vue.prototype.$funcionesGlobales = funcionesGlobales;
Vue.prototype.$nombresModulo = nombresModulo;
Vue.prototype.$nombresFormulario = nombresFormulario;
Vue.component("v-time", VueTimepicker);
Vue.component("v-select", vSelect);
Vue.use(VueGoodTablePlugin);
Vue.use(VModal);
Vue.use(VueSweetalert2);
Vue.use(VueRouter);
Vue.use(Loading);
Vue.component(
    "menuComponente",

    require("./components/componentesGenerales/MenuComponent.vue").default
);
Vue.component(
    "vuetable-component",
    require("./components/componentesGenerales/VueTableComponent.vue").default
);

//MODULO DATOS GENERALES

Vue.component(
    "configuracionGeneralidades",
    require("./components/datosGenerales/generalidades/ConfiguracionGeneralidades.vue")
        .default
);
Vue.component(
    "crear-organizacion-bspi",
    require("./components/datosGenerales/generalidades/organizacionBspi/CrearOrganizacionBspi.vue")
        .default
);
Vue.component(
    "crear-tipo-bspi",
    require("./components/datosGenerales/generalidades/tiposBspi/CrearTiposDeOrganismoBpsi.vue")
        .default
);
Vue.component(
    "crear-organismos-vinculantes-con-la-bspi",
    require("./components/datosGenerales/generalidades/organismosVinculantesConLaBspi/CrearOrganismosVinculantesConLaBspi.vue")
        .default
);

Vue.component(
    "crear-cargos-vinculantes-con-la-bspi",
    require("./components/datosGenerales/generalidades/cargosEnOrganismosBspi/CrearCargosOrganismosBspi.vue")
        .default
);
Vue.component(
    "crear-rol",
    require("./components/datosGenerales/usuarios/roles/CrearRol.vue").default
);

Vue.component(
    "crear-organismosYContactos-bspi",
    require("./components/datosGenerales/generalidades/organismosYContactosBspi/CrearOrganismosYContactosBspi.vue")
        .default
);

Vue.component(
    "informacion-personal",
    require("./components/datosGenerales/usuarios/datos/InformacionPersonal.vue")
        .default
);
Vue.component(
    "informacion-nacimiento",
    require("./components/datosGenerales/usuarios/datos/InformacionNacimiento.vue")
        .default
);
Vue.component(
    "informacion-vivienda",
    require("./components/datosGenerales/usuarios/datos/InformacionVivienda.vue")
        .default
);
Vue.component(
    "informacion-sistema",
    require("./components/datosGenerales/usuarios/datos/InformacionSistema.vue")
        .default
);
Vue.component(
    "informacion-caracteristica-usuario",
    require("./components/datosGenerales/usuarios/datos/CaracteristicaUsuario.vue")
        .default
);
Vue.component(
    "info-usuario",
    require("./components/datosGenerales/usuarios/datos/InfoUsuario.vue")
        .default
);
Vue.component(
    "crear-usuario",
    require("./components/datosGenerales/usuarios/datos/CrearUsuario.vue")
        .default
);
Vue.component(
    "crear-gestiones",
    require("./components/datosGenerales/gestiones/datos/CrearGestiones.vue")
        .default
);
Vue.component(
    "crear-gestiones-y-usuarios",
    require("./components/datosGenerales/gestiones/gestionesYUsuario/CrearGestionesYUsuario.vue")
        .default
);
Vue.component(
    "maestra-general",
    require("./components/componentesGenerales/MaestraGeneral.vue").default
);

Vue.component(
    "crear-general",
    require("./components/componentesGenerales/CrearGeneral.vue").default
);
Vue.component(
    "crear-modificar-provincia",
    require("./components/datosGenerales/configuraciones/provincias/CrearModificarProvincia.vue")
        .default
);
Vue.component(
    "crear-modificar-canton",
    require("./components/datosGenerales/configuraciones/cantones/CrearModificarCanton.vue")
        .default
);
Vue.component(
    "crear-modificar-parroquia",
    require("./components/datosGenerales/configuraciones/parroquias/CrearModificarParroquia.vue")
        .default
);
Vue.component(
    "crear-aseguradoras",
    require("./components/gestionHospitalaria/generalidades/aseguradoras/CrearAseguradoras.vue")
        .default
);
Vue.component(
    "menu-gestion-hospitalaria",
    require("./components/componentesGenerales/MenuGestionHospitalaria.vue")
        .default
);
Vue.component(
    "menu-datos-generales",
    require("./components/componentesGenerales/MenuDatosGenerales.vue").default
);
Vue.component(
    "ingreso-consulta-externa",
    require("./components/gestionHospitalaria/administracionDeCitas/citas/IngresoConsultaExterna.vue")
        .default
);
Vue.component(
    "ingreso-emergencia",
    require("./components/gestionHospitalaria/administracionDeCitas/citas/IngresoEmergencia.vue")
        .default
);
/* Empieza los componentes del MenuConsultaExterna*/
/* Signos Vitales */
Vue.component(
    "signo-vitales",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/SignosVitales.vue")
        .default
);
/* Motivo-Antecedentes */
Vue.component(
    "motivo-antecedente",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/Motivo-Antecedentes.vue")
        .default
);
/* Evolucion */
Vue.component(
    "evolucion",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/Evolucion.vue")
        .default
);

/* Examen Fisico */
Vue.component(
    "examen-fisico",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/ExamenFisico.vue")
        .default
);
/* Diagnostico */
Vue.component(
    "diagnostico",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/Diagnostico.vue")
        .default
);
Vue.component(
    "lista-diagnostico",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/ListaDiagnostico.vue")
        .default
);
/* Prescripcion */
Vue.component(
    "prescripcion",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/Prescripcion.vue")
        .default
);
/* Laboratorio Clinico */
Vue.component(
    "laboratorio-clinico",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/LaboratorioClinico.vue")
        .default
);
/* Imageneolgia */
Vue.component(
    "imageneologia",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/Imageneologia.vue")
        .default
);
/* Firma */
Vue.component(
    "firma",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/Firma.vue")
        .default
);
/* Fin los componentes del MenuConsultaExterna*/

Vue.component(
    "lista-cita-emergencia-consulta-externa-hospitalizacion",
    require("./components/gestionHospitalaria/administracionDeCitas/citas/ListaCitasEmergenciaHospitalizacion.vue")
        .default
);
/* Fin de los componentes del MenuConsultaExterna*/

/* Empieza los componentes del Menu Administracion de Farmacia*/
//Crear Farmacia
Vue.component(
    "crear-farmacia",
    require("./components/gestionHospitalaria/administracionDeFarmacia/farmacia/CrearModificarFarmacia.vue")
        .default
);
//Informacion de Farmacia
Vue.component(
    "info-farmacia",
    require("./components/gestionHospitalaria/administracionDeFarmacia/farmacia/InfoFarmacia.vue")
        .default
);
//Crear Asocicacion de farmacia
Vue.component(
    "crear-asociacion-farmacia",
    require("./components/gestionHospitalaria/administracionDeFarmacia/asociacionDeFarmacia/CrearModificarAsociacionFarmacia.vue")
        .default
);
//Crear Categoria
Vue.component(
    "crear-categoria",
    require("./components/gestionHospitalaria/administracionDeFarmacia/categoria/CrearModificarCategoria.vue")
        .default
);
//Crear Productos
Vue.component(
    "crear-productos",
    require("./components/gestionHospitalaria/administracionDeFarmacia/productos/CrearModificarProductos.vue")
        .default
);
//Crear Presentacion
Vue.component(
    "crear-presentacionProducto",
    require("./components/gestionHospitalaria/administracionDeFarmacia/presentacionProducto/CrearModificarPresentacionProducto.vue")
        .default
);
//Crear Presentacion
Vue.component(
    "crear-presentacion",
    require("./components/gestionHospitalaria/administracionDeFarmacia/presentacion/CrearModificarPresentacion.vue")
        .default
);
//ListaProductos
Vue.component(
    "lista-producto-por-farmacia",
    require("./components/gestionHospitalaria/administracionDeFarmacia/productos/ListaProductoPorFarmacia.vue")
        .default
);
//Crear Tipo de Movimiento
Vue.component(
    "crear-tipo-movimiento",
    require("./components/gestionHospitalaria/administracionDeFarmacia/tipoMovimiento/CrearModificarTipoMovimiento.vue")
        .default
);
/* Fin los componentes del Menu Administracion de Farmacia*/

/* Empieza los componentes del Menu Formulario MSP*/
//Generar Formulario MSP
Vue.component(
    "generar-formulario-msp",
    require("./components/gestionHospitalaria/formulariosMSP/GenerarFormularioMSP.vue")
        .default
);
/* Fin los componentes del Menu Formulario MSP*/

Vue.component(
    "lista-usuarios",
    require("./components/datosGenerales/usuarios/datos/Usuarios.vue").default
);

Vue.component(
    "crear-parentesco",
    require("./components/gestionHospitalaria/pacientes/parentescos/CrearParentescos.vue")
        .default
);
Vue.component(
    "crear-hospital",
    require("./components/gestionHospitalaria/administracionDeHospital/hospital/CrearModificarHospital.vue")
        .default
);
Vue.component(
    "crear-documento",
    require("./components/gestionHospitalaria/administracionDeCitas/citas/CrearDocumentos.vue")
        .default
);
Vue.component(
    "info-hospital",
    require("./components/gestionHospitalaria/administracionDeHospital/hospital/InfoHospital.vue")
        .default
);
Vue.component(
    "crear-habitacion",
    require("./components/gestionHospitalaria/administracionDeHospital/habitaciones/CrearModificarHabitacion.vue")
        .default
);
Vue.component(
    "crear-consultorio",
    require("./components/gestionHospitalaria/administracionDeHospital/consultorios/CrearModificarConsultorio.vue")
        .default
);
Vue.component(
    "info-consultorio",
    require("./components/gestionHospitalaria/administracionDeHospital/consultorios/InfoConsultorio.vue")
        .default
);

Vue.component(
    "crear-cama",
    require("./components/gestionHospitalaria/administracionDeHospital/camas/CrearModificarCama.vue")
        .default
);
Vue.component(
    "crear-area",
    require("./components/gestionHospitalaria/administracionDeHospital/areas/CrearModificarArea.vue")
        .default
);
Vue.component(
    "crear-especialidad",
    require("./components/gestionHospitalaria/administracionDeHospital/especialidades/CrearModificarEspecialidad.vue")
        .default
);
Vue.component(
    "crear-PersonalMedico",
    require("./components/gestionHospitalaria/personalMedico/personalMedico/CrearModificarPersonalMedico.vue")
        .default
);
Vue.component(
    "crear-FuncionPersonalMedico",
    require("./components/gestionHospitalaria/personalMedico/funcionesDePersonalMedico/CrearModificarFuncionesPersonalMedico.vue")
        .default
);
Vue.component(
    "crear-Jornada",
    require("./components/gestionHospitalaria/personalMedico/jornadas/CrearModificarJornada.vue")
        .default
);

Vue.component(
    "crear-poliza",
    require("./components/gestionHospitalaria/pacientes/polizas/CrearPoliza.vue")
        .default
);
Vue.component(
    "crear-lugar-de-trabajo",
    require("./components/gestionHospitalaria/pacientes/lugaresDeTrabajo/CrearLugarDeTrabajo.vue")
        .default
);
Vue.component(
    "crear-lugar-de-trabajo-usuario",
    require("./components/gestionHospitalaria/pacientes/lugaresDeTrabajoUsuario/CrearLugarDeTrabajoUsuario.vue")
        .default
);
Vue.component(
    "crear-usuario-parentesco",
    require("./components/gestionHospitalaria/pacientes/usuariosParentesco/CrearUsuarioParentesco.vue")
        .default
);
Vue.component(
    "lista-polizas",
    require("./components/gestionHospitalaria/pacientes/polizas/Polizas.vue")
        .default
);
Vue.component(
    "crear-beneficiario-poliza",
    require("./components/gestionHospitalaria/pacientes/beneficiariosPoliza/CrearBeneficiarioPoliza.vue")
        .default
);
Vue.component(
    "lista-admisiones",
    require("./components/gestionHospitalaria/administracionDeHospital/admisiones/ListaAdmisiones.vue")
        .default
);
Vue.component(
    "crear-admision",
    require("./components/gestionHospitalaria/administracionDeHospital/admisiones/CrearAdmision.vue")
        .default
);
Vue.component(
    "lista-parentescos",
    require("./components/gestionHospitalaria/pacientes/parentescos/Parentescos.vue")
        .default
);

Vue.component(
    "lista-usuarios-parentescos",
    require("./components/gestionHospitalaria/pacientes/usuariosParentesco/UsuariosParentesco.vue")
        .default
);
Vue.component(
    "derivacion",
    require("./components/gestionHospitalaria/administracionDeHospital/admisiones/Derivacion.vue")
        .default
);
Vue.component(
    "derivacion-consulta-externa",
    require("./components/gestionHospitalaria/administracionDeHospital/admisiones/DerivacionConsultaExterna.vue")
        .default
);
Vue.component(
    "derivacion-emergencia",
    require("./components/gestionHospitalaria/administracionDeHospital/admisiones/DerivacionEmergencia.vue")
        .default
);
Vue.component(
    "lista-cita-consulta-externa",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/ListaDeCitasConsultaExterna.vue")
        .default
);
Vue.component(
    "lista-emergencia",
    require("./components/gestionHospitalaria/emergencia/visualizacionDeEmergencia/ListaEmergencia.vue")
        .default
);
Vue.component(
    "pdf-preview",
    require("./components/componentesGenerales/PdfPreview.vue").default
);
Vue.component(
    "admisiones",
    require("./components/gestionHospitalaria/administracionDeHospital/admisiones/Admisiones.vue")
        .default
);
Vue.component(
    "visualizacion-preparacion",
    require("./components/gestionHospitalaria/consultaExterna/preparacionDelMedico/VisualizacionPreparacion.vue")
        .default
);

const app = new Vue({
    el: "#app",

    components: {
        App
    },
    router
});
