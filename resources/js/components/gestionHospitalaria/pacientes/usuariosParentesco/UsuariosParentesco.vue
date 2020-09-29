<template>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
       <h1 class="mt-4">Usuarios Parentesco</h1>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevo()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                 :seleccionar-button="seleccionarButton"
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="datos"
                @handleModificarClick="modificar"
                @handleAnularClick="anularConfirmacion"
                @handleSeleccionarClick="seleccionarUsuarioParentesco"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearModal">
      <crear-usuario-parentesco
        :usuarios="usuarios"
        :usuarios-parentesco="parentescos"
        :tipos-parentescos="tiposParentescos"
        :objeto-mod="objetoMod"
        @recargarDatos="cargarDatos"
        @cerrarModalCrear="cerrarModalCrear"
        ref="crearModal"
      ></crear-usuario-parentesco>
    </modal>
  </div>
</template>
<script>
export default {
  props:{
    seleccionarButton:{
      type:Boolean,
      default:false
    }
  },
  data: function() {
    return {
      usuarios: [],
      objetoMod: null,
      datos: [],
      parentescos:[],
      tiposParentescos: [],
      columns: [
        {
          label: "Usuario ingresado en parentesco",
          field: "full_name_identification_usuario",
          type: "String"
        },
        {
          label: "Parentesco",
          field: "tipo_parentesco_name",
          type: "String"
        },
        {
          label: "Usuario con el que tiene parentesco",
          field: "full_name_identification_usuario_con_parentesco",
          type: "String"
        },
        {
          label: "Observación",
          field: "observacion",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.usuarios_parentesco.usuarios_parentesco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarDatos();
    this.cargarTiposParentesco();
    this.cargarParentescos();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
     let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.usuarios_parentesco.usuarios_parentesco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    seleccionarUsuarioParentesco(value){
       this.$emit("seleccionarUsuarioParentesco",value);
    },
    modificar(value) {
      this.objetoMod = value;
      this.abrirModalCrear();
    },
    anularConfirmacion(value) {
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
          that.anular(value.codigo);
        }
      });
    },
    anular(id) {
      let that = this;
      let url = "/gestion_hospitalaria/pacientes/eliminar_usuario_parentesco/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          that.cargarDatos();
          loader.hide();
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Dato anulado correctamente."
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
    cerrarModalCrear: function() {
      this.$modal.hide("crearModal");
    },
    nuevo: function() {
      this.objetoMod = null;
      this.abrirModalCrear();
    },
    abrirModalCrear: function() {
      this.$modal.show("crearModal");
    },
    cargarParentescos(){
      let that = this;
      let url =
        "/gestion_hospitalaria/pacientes/cargar_parentesco_lista";
      axios
        .get(url)
        .then(function(response) {
          let datos = [];
          datos = response.data.datos;
          that.parentescos = datos;
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
    cargarTiposParentesco() {
      let that = this;
      let url =
        "/gestion_hospitalaria/generalidades/cargar_tipos_de_parentesco_lista";
      axios
        .get(url)
        .then(function(response) {
          let datos = [];
          datos = response.data.datos;
          that.tiposParentescos = datos;
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
    cargarDatos: function() {
      let that = this;
      let url = "/gestion_hospitalaria/pacientes/cargar_usuario_parentescos";

      var loader = that.$loading.show();

      axios
        .get(url)
        .then(function(response) {
          axios
            .get("/datos_generales/usuarios/cargar_usuarios_campos")
            .then(function(response2) {
              let datos = [];
              let datosFinales=[];
              datos = response.data.datos;
              that.usuarios = response2.data.usuarios;
              datos.forEach(element => {
                  let objeto ={};
                  objeto.codigo=element.USUARIOPARENTESCO_COD;
                  objeto.codigo_usuario=element.PARENTESCO_COD;
                  objeto.codigo_usuario_con_parentesco = element.USER_ID;
                  objeto.tipo_parentesco=element.TIPOPARENTESCO_COD;
                  objeto.observacion= that.$funcionesGlobales.toCapitalFirstAllWords(element.PARENTESCO_OBS);
                  objeto.full_name_identification_usuario= that.$funcionesGlobales.toCapitalFirstAllWords(element.parentesco.FULL_NAME_IDENTIFICACION);
                  objeto.full_name_identification_usuario_con_parentesco = that.$funcionesGlobales.toCapitalFirstAllWords(element.usuario_parentesco.FULL_NAME_IDENTIFICATION);
                  objeto.tipo_parentesco_name= that.$funcionesGlobales.toCapitalFirstAllWords(element.tipo_parentesco.TIPOPARENTESCO_NOM);
                  datosFinales.push(objeto);
              });
              that.datos = datosFinales;
              loader.hide();
            })
            .catch(error => {
              //Errores
              that.$swal({
                icon: "error",
                title: "Existe un error",
                text: error
              });
              loader.hide();
            });
        })
        .catch(error => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
          loader.hide();
        });
    }
  }
};
</script>
