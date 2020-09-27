<template>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12" v-if="!esAdmisiones"> 
      <h1 class="mt-2">DATOS DE USUARIO</h1>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right" v-if="!esAdmisiones">
                <button class="btn btn-primary" @click="nuevoUsuario()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :seleccionar-button="mostrarSeleccionar"
                :info-button="true"
                :modificar-button="mostrarModificar"
                :anular-button="esAdmisiones?false: true"
                :picture="esAdmisiones?false: true"
                :columns-data="columns"
                :rows-data="usuarios"
                @handleModificarClick="modificarUsuario"
                @handleAnularClick="anularUsuarioConfirmacion"
                @handleInfoClick="abrirModalInformacion"
                @handleSeleccionarClick="seleccionarUsuario"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" height="auto" :scrollable="true" name="crearUsuario">
      <crear-usuario
        :data-usuario="usuarioData"
        :tipos-de-sangre="tiposDeSangre"
        :religiones="religiones"
        :tipos-casa="tiposCasa"
        :grupos-culturales="gruposCulturales"
        @recargarUsuarios="cargarUsuarios"
        @cerrarModalCrearUsuario="cerrarModalCrearUsuario"
        ref="crearUsuario"
      ></crear-usuario>
    </modal>
    <modal :width="'65%'" height="auto" :scrollable="true" name="infoUsuario">
      <info-usuario :usuario="usuarioInfo" ref="crearUsuario"></info-usuario>
    </modal>
  </div>
</template>
<script>
export default {
  props:{
    esAdmisiones: {
      type: Boolean,
      default:false,
      required:false
    },
    mostrarModificar:{
      type: Boolean,
      default:true,
      required:false
    },
    mostrarSeleccionar:{
      type: Boolean,
      default:false,
      required:false
    }
  },
  data: function() {
    return {
      tiposDeSangre: [],
      religiones: [],
      gruposCulturales: [],
      usuarioData: null,
      usuarioInfo: {},
      usuarioMod: null,
      usuarios: [],
      tiposCasa: [],
      columns: [
        {
          label: "Trabajador BSPI",
          field: "US_TRABAJADOR_BSPI",
          type: "String"
        },
        {
          label: "Identificación Usuario",
          field: "US_IDENT_HTML"
        },
        {
          label: "Nombres",
          field: "US_NOM",
          type: "String"
        },
        {
          label: "Apellidos",
          field: "US_APELL",
          type: "String"
        },
        {
          label: "Alias",
          field: "US_ALIAS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.usuarios
      .datos.usuarios.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );

    this.cargarDatosIniciales();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.usuarios
      .datos.usuarios.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    async cargarDatosIniciales() {
      var loader = this.$loading.show();
      await this.cargarUsuarios();
      await this.cargarTiposDeSangre();
      await this.cargarReligiones();
      await this.cargarGruposCulturales();
      await this.cargarTiposCasa();
      loader.hide();
    },
    seleccionarUsuario(usuario) {
      let that = this;
      let url = "/datos_generales/usuarios/obtener_usuario/" + usuario.US_COD;
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let usuarioData = response.data.usuario;
          loader.hide();
          that.$emit("seleccionarUsuario", usuarioData);
        })
        .catch(error => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un Error.",
            text: error
          });
        });
    },
    cerrarModalPrincipal() {
      this.$emit("cerrarModalListaUsuario");
    },
    abrirModalInformacion(value) {
      this.usuarioInfo = value;
      this.$modal.show("infoUsuario");
    },
    modificarUsuario(value) {
      this.obtenerUsuarioPorId(value.US_COD);
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
    obtenerUsuarioPorId(id) {
      let that = this;
      let url = "/datos_generales/usuarios/obtener_usuario/" + id;
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.usuarioData = response.data.usuario;
          loader.hide();
          if(!that.$props.esAdmisiones){
            that.$modal.show("crearUsuario");
          }else{
            that.$emit("modificarUsuarioAdmision",that.usuarioData);
          }      
        })
        .catch(error => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un Error.",
            text: error
          });
        });
    },
    anularUsuario(id) {
      let that = this;
      let url = "/datos_generales/usuarios/eliminar_usuario/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          that.cargarUsuarios();
          loader.hide();
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente.",
            text: "Dato Anulado Correctamente."
          });
        })
        .catch(error => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    },
    cerrarModalCrearUsuario: function() {
      this.$modal.hide("crearUsuario");
    },
    nuevoUsuario: function() {
      this.rolMod = null;
      this.abrirModalCrearUsuario();
    },
    abrirModalCrearUsuario: function() {
      this.$modal.show("crearUsuario");
    },
    cargarUsuarios: function() {
      let that = this;
      let url = "/datos_generales/usuarios/cargar_usuarios";

      axios
        .get(url)
        .then(function(response) {
          let usuarios = [];
          let URLactual = window.location.protocol + window.location.host;

          for (let i = 0; i < response.data.usuarios.length; i++) {
            let objeto = {};
            let cedulaObject = response.data.usuarios[i].identificaciones.find(
              element => element.ID_COD === "CEDULA"
            );
            if (cedulaObject == null || cedulaObject == undefined) {
              cedulaObject = response.data.usuarios[i].identificaciones.find(
                element => element.ID_COD === "PASAPORTE "
              );
            }
            if (cedulaObject == null || cedulaObject == undefined) {
              cedulaObject = response.data.usuarios[i].identificaciones.find(
                element => element.ID_COD === "17-DIGITOS "
              );
            }
            objeto.US_FOTO_URL = response.data.usuarios[i].IMAGEN_PERFIL_URL;
            //objeto.US_FOTO_URL = "/files/profile-1589932251.jpg";
            objeto.US_FOTO = response.data.usuarios[i].US_FOTO;
            // objeto.US_FOTO = "/files/profile-1589932251.jpg";
            objeto.US_TRABAJADOR_BSPI = response.data.usuarios[i].US_TRABAJADOR_BSPI;
            objeto.US_NOM =that.$funcionesGlobales.toCapitalFirstAllWords(response.data.usuarios[i].US_NOM);
            objeto.US_APELL = that.$funcionesGlobales.toCapitalFirstAllWords(response.data.usuarios[i].US_APELL);
            objeto.US_ALIAS = response.data.usuarios[i].US_ALIAS;
            objeto.US_EMAIL = response.data.usuarios[i].US_EMAIL;
            objeto.US_EMAIL2 = response.data.usuarios[i].US_EMAIL2;
            objeto.US_DIR = response.data.usuarios[i].US_DIR;
            objeto.US_TELF = response.data.usuarios[i].US_TELF;
            objeto.US_CEL = response.data.usuarios[i].US_CEL;
            objeto.US_TELF = response.data.usuarios[i].US_TELF;
            objeto.US_ACTIVO = response.data.usuarios[i].US_ACTIVO;
            objeto.US_OBS = response.data.usuarios[i].US_OBS;
            objeto.US_COD = response.data.usuarios[i].US_COD;
            objeto.US_CED = cedulaObject !== null && cedulaObject !== undefined ? cedulaObject.USID_CODIGO: "";
            usuarios.push(objeto);
          }
          that.usuarios = usuarios;
        })
        .catch(error => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un Error.",
            text: error
          });
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
              objeto.display = response.data.tiposDeSangre[i].TSANGRE_NOM;
              tiposDeSangre.push(objeto);
            }
            that.tiposDeSangre = tiposDeSangre;
            resolve();
          })
          .catch(error => {
            //Errores
            that.$swal({
              icon: "error",
              title: "Existe un Error.",
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
            title: "Existe un Error.",
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
            title: "Existe un Error.",
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
            title: "Existe un Error.",
            text: error
          });
        });
    }
  }
};
</script>
