<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Tipo de Unidad</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="nombre"><span class="text-danger">(*)</span> Nombre</label>
                  <input
                    type="text"
                    :class="
                                            errores.err_nombre === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="cicloInicial"
                    placeholder="Ingrese un nombre"
                    v-model="form.frm_nombre"
                  />
                  <small
                    v-if="errores.err_nombre !== ''"
                    id="correoHelp"
                    class="text-danger"
                  >{{errores.err_nombre[0] }}</small>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    type="text"
                    id="observacion"
                    class="form-control"
                    placeholder="Ingrese su observación"
                    v-model="form.frm_observacion"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizarTipoUnidad()"
                  >
                    {{
                    tipoUnidadMod === null
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
    tipoUnidadMod: {
      type: Object,
    },
  },
  data: function () {
    return {
      errores: {
        err_nombre: "",
      },
      form: {
        frm_codigo: "",
        frm_nombre: "",
        frm_observacion: "",
      },
    };
  },
  mounted: function () {
    if (this.$props.tipoUnidadMod !== null) {
      var tipoUnidad = this.$props.tipoUnidadMod;
      this.form.frm_codigo = tipoUnidad.TIPOUNIDAD_COD;
      this.form.frm_nombre = tipoUnidad.TIPOUNIDAD_NOM;
      this.form.frm_observacion = tipoUnidad.TIPOUNIDAD_OBS;
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
  beforeDestroy: function () {
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
        err_nombre: "",
        err_email: "",
      };
      this.form = {
        frm_codigo: "",
        frm_nombre: "",
        frm_observacion: "",
      };
    },
    guardarActualizarTipoUnidad: function () {
      let that = this;
      let url = "/datos_generales/configuraciones/guardar_modificar_tipo_unidad";
      let mensaje = "";
      //if()
      if (this.$props.tipoUnidadMod !== null) {
        mensaje = "Datos actualizados correctamente.";
      } else {
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function (response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarTipoUnidad");
          that.$emit("cerrarModalCrearTipoUnidad");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: that.mensaje,
          });
          that.limpiarForm();
        })
        .catch((error) => {
          //Errores de validación
          if (error.response.status === 422) {
            if (error.response.data.errors.frm_nombre != null) {
              that.errores.err_nombre = error.response.data.errors.frm_nombre;
            }
            loader.hide();
          }
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existen errores",
            text: error,
          });
        });
    },
  },
};
</script>
