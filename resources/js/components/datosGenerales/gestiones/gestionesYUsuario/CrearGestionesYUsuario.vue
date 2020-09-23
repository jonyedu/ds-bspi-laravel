<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">GESTIONES Y USUARIOS</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="gestion">Gestión</label>
                  <v-select
                    v-model="selectedGestion"
                    :value="form.gestion"
                    :options="gestiones"
                    label="display"
                    v-bind:class="{ disabled: gestionMod!=null }"
                    @input="setSelectedGestion"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.gestion !== ''"
                    id="gestionHelp"
                    class="text-danger"
                  >{{ errores.gestion[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <v-select
                    v-model="selectedUsuario"
                    :value="form.usuari"
                    :options="usuarios"
                    label="display"
                    v-bind:class="{ disabled: gestionMod!=null }"
                    @input="setSelectedUsuario"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.usuario !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.usuario[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="rol">Rol</label>
                  <v-select
                    v-model="selectedRol"
                    :value="form.rol"
                    :options="roles"
                    label="display"
                    v-bind:class="{ disabled: gestionMod!=null }"
                    @input="setSelectedRol"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.rol !== ''"
                    id="rolHelp"
                    class="text-danger"
                  >{{ errores.rol[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="rol">Activo</label>
                  <v-select
                    v-model="selectedActivo"
                    :value="form.activo"
                    :options="activos"
                    label="id_tipo"
                    @input="setSelected"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.activo !== ''"
                    id="activoHelp"
                    class="text-danger"
                  >{{ errores.activo[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    type="text"
                    :class="
                                            errores.observacion === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="observacion"
                    placeholder="Ingrese su observación"
                    v-model="form.observacion"
                  />
                  <small
                    v-if="errores.observacion !== ''"
                    id="observacionHelp"
                    class="text-danger"
                  >{{ errores.observacion[0] }}</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizar()"
                  >
                    {{
                    gestionMod === null
                    ? "Guardar"
                    : "Modificar"
                    }}
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.disabled {
  pointer-events: none;
  color: #bfcbd9;
  cursor: not-allowed;
  background-image: none;
  background-color: #eef1f6;
  border-color: #d1dbe5;
}
</style>
<script>
export default {
  props: {
    gestionMod: {
      type: Object
    },
    gestiones: {
      type: Array
    },
    roles: {
      type: Array
    },
    usuarios: {
      type: Array
    }
  },
  data: function() {
    return {
      errores: {
        gestion: "",
        usuario: "",
        rol: "",
        activo: "",
        observacion: ""
      },
      form: {
        gestion: "",
        usuario: "",
        rol: "",
        activo: "",
        observacion: ""
      },
      activos: [
        {
          id_tipo: "S"
        },
        {
          id_tipo: "N"
        }
      ],
      selectedActivo: "S",
      selectedRol: "",
      selectedUsuario: "",
      selectedGestion: ""
    };
  },
  mounted: function() {
    this.form.activo = "S";
    if (this.$props.gestionMod !== null) {
      var gestion = this.$props.gestionMod;

      this.form.gestion = gestion.GESTION_COD;
      this.form.usuario = gestion.US_COD;
      this.form.rol = gestion.USROL_COD;
      this.form.activo = gestion.GESTIONUS_ACTIVO;
      this.form.observacion = gestion.GESTIONUS_OBS;
      this.selectedActivo = gestion.GESTIONUS_ACTIVO;
      this.selectedRol = gestion.ROL_NOM;
      this.selectedUsuario = gestion.USUARIO_NOM;
      this.selectedGestion = gestion.GESTION_NOM;
    }
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.gestiones
      .datos.crear_gestiones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.gestiones
      .datos.crear_gestiones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    limpiarForm() {
      this.errores = {
        rol: "",
        usuario: "",
        activo: "",
        gestion: "",
        observacion: ""
      };
      this.form = {
        rol: "",
        usuario: "",
        activo: "",
        gestion: "",
        observacion: ""
      };
      this.selectedActivo = "S";
      this.selectedUsuario = "";
      this.selectedRol = "";
      this.selectedGestion = "";
    },
    setSelected(value) {
      if (value !== null) {
        this.form.activo = value.id_tipo;
      } else {
        this.form.activo = "";
      }
    },
    setSelectedUsuario(value) {
      if (value !== null) {
        this.form.usuario = value.value;
      } else {
        this.form.usuario = "";
      }
    },
    setSelectedGestion(value) {
      if (value !== null) {
        this.form.gestion = value.value;
      } else {
        this.form.gestion = "";
      }
    },
    setSelectedRol(value) {
      if (value !== null) {
        this.form.rol = value.value;
      } else {
        this.form.rol = "";
      }
    },
    guardarActualizar: function() {
      let that = this;
      that.errores = {
        rol: "",
        usuario: "",
        activo: "",
        gestion: "",
        observacion: ""
      };
      let url = "";
      let mensaje = "";
      if (this.$props.gestionMod !== null) {
        url = "/datos_generales/gestiones/modificar_gestiones_y_usuarios/";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/datos_generales/gestiones/guardar_gestiones_y_usuarios";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.

          loader.hide();
          that.$emit("recargarGestionesYUsuario");
          that.$emit("cerrarModalCrearGestionYUsuario");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Datos actualizados correctamente."
          });
          that.limpiarForm();
        })
        .catch(error => {
          //Errores de validación
          if (error.response.status === 422) {
            that.errores.gestion =
              error.response.data.errors.gestion != undefined
                ? error.response.data.errors.gestion
                : "";
            that.errores.rol =
              error.response.data.errors.rol != undefined
                ? error.response.data.errors.rol
                : "";
            that.errores.usuario =
              error.response.data.errors.usuario != undefined
                ? error.response.data.errors.usuario
                : "";
            that.errores.activo =
              error.response.data.errors.activo != undefined
                ? error.response.data.errors.activo
                : "";
            that.errores.observacion =
              error.response.data.errors.observacion != undefined
                ? error.response.data.errors.observacion
                : "";
          }
          if (error.response.status === 500) {
            error = error.response.data.mensaje;
          }
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existen errores",
            text: error
          });
        });
    }
  }
};
</script>
