<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Parroquias</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input
                    type="text"
                    :class="
                                            errores.nombre === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="cicloInicial"
                    placeholder="Ingrese un nombre"
                    v-model="form.nombre"
                  />
                  <small
                    v-if="errores.nombre !== ''"
                    id="nombreHelp"
                    class="text-danger"
                  >{{ errores.nombre[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="organismo">Canton</label>
                  <v-select
                    v-model="selectedCanton"
                    :value="form.canton_cod"
                    :options="cantones"
                    label="CANTON_NOM"
                    @input="setSelectedCanton"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.canton !== ''"
                    id="organismoHelp"
                    class="text-danger"
                  >{{ errores.cantones[0] }}</small>
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
                    parroquiaMod === null
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
<script>
export default {
  props: {
    parroquiaMod: {
      type: Object
    },
    cantones: {
      type: Array
    }
  },
  data: function() {
    return {
      errores: {
        parroquia_cod: "",
        canton_cod: "",
        nombre: "",
        activo: "",
        observacion: "",
        cantones: ""
      },
      form: {
        parroquia_cod: "",
        canton_cod: "",
        nombre: "",
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
      selectedCanton: ""
    };
  },
  mounted: function() {
    this.form.activo = "S";
    //this.cantones = this.$props.provincias;
    if (this.$props.parroquiaMod !== null) {
      let parroquia = this.$props.parroquiaMod;
      this.form.parroquia_cod = parroquia.PARR_COD;
      this.form.nombre = parroquia.PARR_NOM;
      this.form.activo = parroquia.PARR_ACTIVO;
      this.form.observacion = parroquia.PARR_OBS;
      this.form.canton_cod = parroquia.CANTON_COD;
      this.selectedCanton = parroquia.canton_nom;
      this.selectedActivo = parroquia.PARR_ACTIVO;
    }

    //auditoria
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.parroquias.crear_modificar_parroquia.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.parroquias.crear_modificar_parroquia.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    setSelectedCanton(value) {
      if (value !== null) {
        this.form.canton_cod = value.CANTON_COD;
      } else {
        this.form.canton_cod = "";
      }
    },
    setSelected(value) {
      if (value !== null) {
        this.form.activo = value.id_tipo;
      } else {
        this.form.activo = "";
      }
    },
    guardarActualizar: function() {
      let that = this;
      that.errores = {
        nombre: "",
        activo: "",
        observacion: ""
      };

      let url = "";
      let mensaje = "";
      if (this.$props.parroquiaMod !== null) {
        url = "/datos_generales/configuraciones/modificar_parroquias";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/datos_generales/configuraciones/guardar_parroquias";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarParroquias");
          that.$emit("cerrarModalCrearModificarParroquia");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Datos actualizados correctamente."
          });
        })
        .catch(error => {
          //Errores de validación
          if (error.response.status === 422) {
            that.errores.nombre =
              error.response.data.errors.nombre != undefined
                ? error.response.data.errors.nombre
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
