<template>
  <div class="row">
    <h1 class="mt-4">ROLES</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoRol()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="roles"
                @handleModificarClick="modificarRol"
                @handleAnularClick="anularRolConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearRol">
      <crear-rol
        :rol-mod="rolMod"
        @recargarRoles="cargarRoles"
        @cerrarModalCrearRol="cerrarModalCrearRol"
        ref="crearRol"
      ></crear-rol>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      rolMod: null,
      roles: [],
      columns: [
        {
          label: "Código",
          field: "USROL_COD",
          type: "String"
        },
        {
          label: "Nombre",
          field: "USROL_NOM",
          type: "String"
        },
        {
          label: "Activo",
          field: "USROL_ACTIVO",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "USROL_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    this.cargarRoles();
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.usuarios
      .roles.roles.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.usuarios
      .roles.roles.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarRol(value) {
      this.rolMod = value;
      this.abrirModalCrearRol();
    },
    anularRolConfirmacion(value) {
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
          that.anularRol(value.USROL_COD);
        }
      });
    },
    anularRol(id) {
      let that = this;
      let url = "/datos_generales/usuarios/eliminar_rol/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          loader.hide();
          that.cargarRoles();
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
    cerrarModalCrearRol: function() {
      this.$modal.hide("crearRol");
    },
    nuevoRol: function() {
      this.rolMod = null;
      this.abrirModalCrearRol();
    },
    abrirModalCrearRol: function() {
      this.$modal.show("crearRol");
    },
    cargarRoles: function() {
      let that = this;
      let url = "/datos_generales/usuarios/cargar_roles";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let roles = [];

          for (let i = 0; i < response.data.roles.length; i++) {
            let objeto = {};
            objeto.USROL_COD = response.data.roles[i].USROL_COD;
            objeto.USROL_NOM = response.data.roles[i].USROL_NOM;
            objeto.USROL_ACTIVO = response.data.roles[i].USROL_ACTIVO;
            objeto.USROL_OBS = response.data.roles[i].USROL_OBS;
            roles.push(objeto);
          }
          that.roles = roles;
          loader.hide();
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
    }
  }
};
</script>
