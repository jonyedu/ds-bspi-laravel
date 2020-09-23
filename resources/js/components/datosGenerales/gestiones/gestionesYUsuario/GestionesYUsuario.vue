<template>
  <div class="row">
    <h1 class="mt-4">GESTIONES Y USUARIOS</h1>
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
                :anular-button="true"
                :modificar-button="true"
                :titulo-data="'Gestiones en el sistema'"
                :columns-data="columns"
                :rows-data="gestionesYUsuarios"
                @handleModificarClick="modificarGestion"
                @handleAnularClick="anularGestionConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearGestionYUsuario">
      <crear-gestiones-y-usuarios
        :gestion-mod="gestionesYUsuarioMod"
        :gestiones="gestiones"
        :roles="roles"
        :usuarios="usuarios"
        @recargarGestionesYUsuario="cargarGestionesYUsuario"
        @cerrarModalCrearGestionYUsuario="cerrarModalCrearGestionYUsuario"
        ref="crearGestionYUsuario"
      ></crear-gestiones-y-usuarios>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      gestionesYUsuarioMod: null,
      gestionesYUsuarios: [],
      roles: [],
      usuarios: [],
      gestiones: [],
      columns: [
        {
          label: "Gestión",
          field: "GESTION_NOM",
          type: "String"
        },
        {
          label: "Roles",
          field: "ROL_NOM",
          type: "String"
        },
        {
          label: "Usuario",
          field: "USUARIO_NOM",
          type: "String"
        },
        {
          label: "Identificación Usuario",
          field: "US_IDENT_HTML"
        },
        {
          label: "Activo",
          field: "GESTIONUS_ACTIVO",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "GESTIONUS_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.gestiones
      .gestiones_y_usuario.gestiones_y_usuario.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarGestionesYUsuario();
    this.cargarGestiones();
    this.cargarRoles();
    this.cargarUsuarios();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.gestiones
      .gestiones_y_usuario.gestiones_y_usuario.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarGestion(value) {
      this.gestionesYUsuarioMod = value;
      this.abrirModalCrearGestion();
    },
    anularGestionConfirmacion(value) {
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
          that.anularGestion(value.GESTION_COD, value.USROL_COD, value.US_COD);
        }
      });
    },
    anularGestion(gestion, rol, usuario) {
      let that = this;
      let url =
        "/datos_generales/gestiones/eliminar_gestiones_y_usuarios/" +
        gestion +
        "/" +
        rol +
        "/" +
        usuario;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          that.cargarGestionesYUsuario();
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
    cerrarModalCrearGestionYUsuario: function() {
      this.$modal.hide("crearGestionYUsuario");
    },
    nuevo: function() {
      this.gestionesYUsuarioMod = null;
      this.abrirModalCrearGestion();
    },
    abrirModalCrearGestion: function() {
      this.$modal.show("crearGestionYUsuario");
    },
    cargarGestiones() {
      let that = this;
      let url = "/datos_generales/gestiones/cargar_gestiones_combo_box";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let gestiones = [];

          for (let i = 0; i < response.data.gestiones.length; i++) {
            let objeto = {};
            objeto.value = response.data.gestiones[i].GESTION_COD;
            objeto.display = response.data.gestiones[i].GESTION_NOM;

            gestiones.push(objeto);
          }

          that.gestiones = gestiones;
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
    },
    cargarUsuarios() {
      let that = this;
      let url = "/datos_generales/usuarios/cargar_usuarios_campos";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let usuarios = [];

          for (let i = 0; i < response.data.usuarios.length; i++) {
            let objeto = {};
            objeto.value = response.data.usuarios[i].US_COD;
            objeto.display = response.data.usuarios[i].FULL_NAME_IDENTIFICATION;
            usuarios.push(objeto);
          }
          that.usuarios = usuarios;
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
    },
    cargarRoles() {
      let that = this;
      let url = "/datos_generales/usuarios/cargar_roles";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let roles = [];

          for (let i = 0; i < response.data.roles.length; i++) {
            let objeto = {};
            objeto.value = response.data.roles[i].USROL_COD;
            objeto.display = response.data.roles[i].USROL_NOM;
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
    },
    cargarGestionesYUsuario: function() {
      let that = this;
      let url = "/datos_generales/gestiones/cargar_gestiones_y_usuarios";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let gestionesYUsuarios = [];
          gestionesYUsuarios = response.data.gestionesYUsuarios;

          that.gestionesYUsuarios = gestionesYUsuarios;
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
    }
  }
};
</script>
