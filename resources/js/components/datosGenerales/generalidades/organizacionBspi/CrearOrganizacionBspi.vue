<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">ORGANIZACIONES</h5>
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
                    :readonly="organizacionMod !== null"
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
                    organizacionMod === null
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
    organizacionMod: {
      type: Object
    }
  },
  data: function() {
    return {
      errores: {
        nombre: "",
        activo: "",
        observacion: ""
      },
      form: {
        organizacion_cod: "",
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
      selectedActivo: "S"
    };
  },
  mounted: function() {
    this.form.activo = "S";
    if (this.$props.organizacionMod !== null) {
      var organizacion = this.$props.organizacionMod;
      this.form.organizacion_cod = organizacion.ORGANIZACION_COD;
      this.form.nombre = organizacion.ORGANIZACION_NOM;
      this.form.activo = organizacion.ORGANIZACION_ACTIVO;
      this.form.observacion = organizacion.ORGANIZACION_OBS;
      this.selectedActivo = organizacion.ORGANIZACION_ACTIVO;
    }
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organizacion_bspi.crear_organizacion_bspi.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organizacion_bspi.crear_organizacion_bspi.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    limpiarForm() {
      this.errores = {
        nombre: "",
        activo: "",
        observacion: ""
      };
      this.form = {
        organizacion_cod: "",
        nombre: "",
        activo: "",
        observacion: ""
      };
      this.selectedActivo = "S";
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
      if (this.$props.organizacionMod !== null) {
        url = "/datos_generales/generalidades/modificar_organizaciones";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/datos_generales/generalidades/guardar_organizaciones";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarOrganizaciones");
          that.$emit("cerrarModalCrearOrganizacion");
          that.$swal({
            icon: "success",
            title: "111Proceso realizado exitosamente",
            text: "222Datos actualizados correctamente."
          });
          that.limpiarForm();
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
