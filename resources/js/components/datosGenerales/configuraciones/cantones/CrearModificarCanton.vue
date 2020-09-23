<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Cantones</h5>
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
                  <label for="organismo">Provincia</label>
                  <v-select
                    v-model="selectedProvincia"
                    :value="form.provincia_cod"
                    :options="provincias"
                    label="PROV_NOM"
                    @input="setSelectedProvincia"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.organismo !== ''"
                    id="organismoHelp"
                    class="text-danger"
                  >{{ errores.paises[0] }}</small>
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
                    cantonMod === null
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
    cantonMod: {
      type: Object
    },
    provincias: {
      type: Array
    }
  },
  data: function() {
    return {
      errores: {
        provincia_cod: "",
        canton_cod: "",
        nombre: "",
        activo: "",
        observacion: "",
        paises: ""
      },
      form: {
        provincia_cod: "",
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
      selectedProvincia: ""
    };
  },
  mounted: function() {
    this.form.activo = "S";
    this.provincias = this.$props.provincias;
    if (this.$props.cantonMod !== null) {
      let canton = this.$props.cantonMod;
      this.form.canton_cod = canton.CANTON_COD;
      this.form.nombre = canton.CANTON_NOM;
      this.form.activo = canton.CANTON_ACTIVO;
      this.form.observacion = canton.CANTON_OBS;
      this.form.provincia_cod = canton.PROV_COD;
      this.selectedProvincia = canton.provincia_nom;
      this.selectedActivo = canton.CANTON_ACTIVO;
    }

    //auditoria
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.cantones.crear_modificar_canton.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.cantones.crear_modificar_canton.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    setSelectedProvincia(value) {
      if (value !== null) {
        this.form.provincia_cod = value.PROV_COD;
      } else {
        this.form.provincia_cod = "";
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
      if (this.$props.cantonMod !== null) {
        url = "/datos_generales/configuraciones/modificar_cantones";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/datos_generales/configuraciones/guardar_cantones";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarCantones");
          that.$emit("cerrarModalCrearModificarCanton");
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
