<template>
  <div class="row">
     <div class="col-md-9">
      <h1 class="float-left">{{titulo}} - {{titulo_seleccionado }}</h1>
    </div>
    <div class="col-md-3 mt-2">
      <h5 class="float-left">Admisión Nro. {{ ultimo_codigo_cita }}</h5>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
              <div class="btn-group" role="group">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="mostrarComponenteListaAdmisiones()"
                > <i class="fas fa-folder-plus"></i> Ver Admisiones</button>
                <button
                  type="button"
                  class="btn btn-secondary"
                  @click="mostrarComponenteListaUsuarios()"
                > <i class="fas fa-address-book"></i> Ver Pacientes</button>
                
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="mostrarComponenteCrearAdmision()"
                ><i class="fas fa-user-injured"></i> Ingresar Paciente</button>
                <button
                  type="button"
                  class="btn btn-info"
                  @click="mostrarComponenteAsignacionSeguro()"
                ><i class="fas fa-paste"></i> Crear Admisión</button>
              </div>
            </div>
          </div>
          <div class="row mt-2 ">
            <div class="col-lg-12 col-md-12 col-sm-12 alert alert-primary" role="alert">
              <b>{{titulo_mensaje}}</b><br>
              {{linea_uno}}<br>
              {{linea_dos}}<br>
              {{linea_tres}}
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12" v-if="componente_seleccionado=='ListaAdmisiones'">
              <lista-admisiones @modificarAdmision="modificarAdmision" :es-consulta-externa="esConsultaExterna" :es-emergencia="esEmergencia" :derivar-button="esConsultaExterna || esEmergencia || esAdmision" :es-modal="esConsultaExterna || esEmergencia" :es-admision="esAdmision"></lista-admisiones>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" v-if="componente_seleccionado=='ListaUsuarios'">
              <lista-usuarios :es-admisiones="true" @modificarUsuarioAdmision="modificarUsuarioAdmision"></lista-usuarios>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" v-else-if="componente_seleccionado=='CrearAdmision'">
                  <crear-usuario
                    :es-admisiones="true"
                    :data-usuario="usuarioData"
                    :tipos-de-sangre="tiposDeSangre"
                    :religiones="religiones"
                    :tipos-casa="tiposCasa"
                    :grupos-culturales="gruposCulturales"
                    ref="crearUsuario"
                  ></crear-usuario>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" v-if="componente_seleccionado=='CrearAdmisionFinal'">
              <crear-admision @cambioListaAdmisiones="mostrarComponenteListaAdmisiones" :objeto-mod="dataCrearAdmision"></crear-admision>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    titulo:{
      type: String,
      default: 'Admisiones'
    },
    esModal: {
      type: Boolean,
      default: false
    },
    esAdmision:{
      type:Boolean,
      default:true
    },
    esConsultaExterna:{
      type:Boolean,
      default:false
    },
    esEmergencia:{
      type:Boolean,
      default:false
    }
  },
  data: function() {
    return {
      dataCrearAdmision:null,
      ultimo_codigo_cita: "",
      titulo_seleccionado: "",
      componente_seleccionado: "",
      linea_uno:"",
      linea_dos:"",
      linea_tres:"",
      titulo_mensaje:"",
      tiposDeSangre: [],
      religiones: [],
      gruposCulturales: [],
      usuarioData: null,//para cuando se quiera modificar.
      admisiones: [],
      usuarios:[],
      tiposCasa: []
    };
  },
  mounted: function() {
    this.titulo_seleccionado = "Listas de Admisiones";
    this.componente_seleccionado="ListaAdmisiones";
    this.titulo_mensaje= "Información del formulario de lista de admisiones";
    this.linea_uno="El formulario muestra las admisiones registradas en el sistema, que poseen los siguientes filtros:"
    this.linea_dos="1) Admisiones del día en curso (Admisiones Actuales)."
    this.linea_tres="2) Admisiones históricas en un rango de fechas (Admisiones Históricas)."
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
        .administracion_de_hospital.admisiones.admisiones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarDatosIniciales();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.admisiones.admisiones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    limpiar(){
      this.usuarioData=null;
    },
    
    modificarAdmision(admision){
      this.dataCrearAdmision = admision;
      this.mostrarComponenteAsignacionSeguro();
    },
    modificarUsuarioAdmision(usuario){
      this.usuarioData = usuario;
      this.mostrarComponenteCrearAdmision();
    },
    cargarUltimoCodigoCita() {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_cita/cargar_ultimo_codigo_cita";
      axios
        .get(url)
        .then(function(response) {
          let codigo= response.data.datos.codigo;
          that.ultimo_codigo_cita =  that.$funcionesGlobales.addCeroToLeft(codigo,8);
        })
        .catch(error => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    },
    mostrarComponenteListaUsuarios(){
      this.titulo_mensaje= "Lista de pacientes";
      this.linea_uno="1) El formulario muestra los pacientes."
      this.titulo_seleccionado = "Lista Pacientes";
      this.componente_seleccionado = "ListaUsuarios";
      this.usuarioData=null;
      this.dataCrearAdmision=null;

    },
     mostrarComponenteListaAdmisiones() {
      this.titulo_mensaje= "Información del formulario de lista de admisiones";
      this.linea_uno="El formulario muestra las admisiones registradas en el sistema, que poseen los siguientes filtros:"
      this.linea_dos="1) Admisiones del día en curso (Admisiones Actuales)."
      this.linea_tres="2) Admisiones históricas en un rango de fechas (Admisiones Históricas)."
      this.titulo_seleccionado = "Lista Admisiones";
      this.componente_seleccionado = "ListaAdmisiones";
      this.usuarioData=null;
      this.dataCrearAdmision=null;
    },
    mostrarComponenteCrearAdmision() {
      this.titulo_mensaje= "Información del formulario de ingreso de paciente";
      this.linea_uno="1) El formulario permite la creación de un nuevo paciente en el sistema."
      this.linea_dos="2) Es necesario que el paciente sea registrado para posteriormente proceder a hacer un ingreso de admisión."
      this.linea_tres=""
      this.titulo_seleccionado = "Nuevo Paciente";
      this.componente_seleccionado = "CrearAdmision";
      this.dataCrearAdmision=null;
    },
    mostrarComponenteAsignacionSeguro() {
      this.titulo_mensaje= "Información del formulario de creación de admisión";
      this.linea_uno="1) El formulario permite la creación de un nuevo registro de admisión."
      this.linea_dos="2) Es necesario que se seleccione el paciente al cual se le hara el ingreso, el seguro que cubrira al paciente y por ultimo al beneficiario."
      this.linea_tres="3) El formulario tambien permite el ingreso de familiares del paciente(Ingresar Familiar) y su asociación con el usuario(Asociar Familiar Con Paciente)."
      this.titulo_seleccionado = "Creación De Admisión";
      this.componente_seleccionado = "CrearAdmisionFinal";
      this.usuarioData=null;
    },
    async cargarDatosIniciales() {
      var loader = this.$loading.show();
      await this.cargarUltimoCodigoCita();
      await this.cargarTiposDeSangre();
      await this.cargarReligiones();
      await this.cargarGruposCulturales();
      await this.cargarTiposCasa();
      loader.hide();
    },
    cerrarModalPrincipal() {
      this.$emit("cerrarModalListaUsuario");
    },
   
    anularUsuarioConfirmacion(value) {
      let that = this;
      this.$swal({
        title: "¿Desea anular el elemento seleccionado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          that.anularUsuario(value.US_COD);
        }
      });
    },
    cargarTiposDeSangre: function() {
      return new Promise(resolve => {
        let that = this;
        let url = "/datos_generales/usuarios/tipos_sangre";
        axios
          .get(url)
          .then(function(response) {
            let tiposDeSangre = [];
            for (let i = 0; i < response.data.tiposDeSangre.length; i++) {
              let objeto = {};
              objeto.value = response.data.tiposDeSangre[i].TSANGRE_COD;
              objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(response.data.tiposDeSangre[i].TSANGRE_NOM);
              tiposDeSangre.push(objeto);
            }
            that.tiposDeSangre = tiposDeSangre;
            resolve();
          })
          .catch(error => {
            //Errores
            that.$swal({
              icon: "error",
              title: "Existe un error",
              text: error
            });
          });
      });
    },
    cargarReligiones: function() {
      let that = this;
      let url = "/datos_generales/usuarios/religiones";
      axios
        .get(url)
        .then(function(response) {
          let religiones = [];

          for (let i = 0; i < response.data.religiones.length; i++) {
            let objeto = {};
            objeto.value = response.data.religiones[i].RELIGION_COD;
            objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(response.data.religiones[i].RELIGION_NOM);
            religiones.push(objeto);
          }
          that.religiones = religiones;
        })
        .catch(error => {
          //Errores

          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    },
    cargarGruposCulturales: function() {
      let that = this;
      let url = "/datos_generales/usuarios/grupos_culturales";

      axios
        .get(url)
        .then(function(response) {
          let gruposCulturales = [];

          for (let i = 0; i < response.data.grupos_culturales.length; i++) {
            let objeto = {};
            objeto.value = response.data.grupos_culturales[i].GCULTURAL_COD;
            objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(response.data.grupos_culturales[i].GCULTURAL_NOM);
            gruposCulturales.push(objeto);
          }
          that.gruposCulturales = gruposCulturales;
        })
        .catch(error => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    },
    cargarTiposCasa() {
      let that = this;
      let url = "/datos_generales/usuarios/tipos_casa";

      axios
        .get(url)
        .then(function(response) {
          let tiposCasa = [];
          for (let i = 0; i < response.data.tiposDeCasa.length; i++) {
            let objeto = {};
            objeto.value = response.data.tiposDeCasa[i].TIPOCASA_COD;
            objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(response.data.tiposDeCasa[i].TIPOCASA_NOM);
            tiposCasa.push(objeto);
          }
          that.tiposCasa = tiposCasa;
        })
        .catch(error => {
          //Errores

          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    }
  }
};
</script>
