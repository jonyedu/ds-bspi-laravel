<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Presentacion</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
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
                    v-model="form.presentacion_nombre"
                    :readonly="presentacionMod!=null"
                  />
                  <small
                    v-if="errores.err_nombre !== ''"
                    id="correoHelp"
                    class="text-danger"
                  >{{errores.err_nombre[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="unidad">Unidad</label>
                  <input
                    type="text"
                    :class="
                                            errores.err_unidad === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="cicloInicial"
                    placeholder="Ingrese un unidad"
                    v-model="form.presentacion_unidad"
                  />
                  <small
                    v-if="errores.err_unidad !== ''"
                    id="correoHelp"
                    class="text-danger"
                  >{{errores.err_unidad[0] }}</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizarPresentacion()"
                  >
                    {{
                    presentacionMod === null
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
    presentacionMod: {
      type: Object,
    },
  },
  data: function () {
    return {
      errores: {
        err_nombre: "",
        err_unidad: "",
        err_precio: "",
      },
      form: {
        presentacion_codigo: "",
        presentacion_nombre: "",
        presentacion_unidad: "",
        presentacion_precio: "",
      },
    };
  },
  mounted: function () {
    if (this.$props.presentacionMod !== null) {
      var presentacion = this.$props.presentacionMod;
      this.form.presentacion_codigo = presentacion.PRESENTACION_COD;
      this.form.presentacion_nombre = presentacion.PRESENTACION_NOM;
      this.form.presentacion_unidad = presentacion.PRESENTACION_UNIDAD;
      //this.form.presentacion_precio = presentacion.PRESENTACION_PRECIO;
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
        presentacion_codigo: "",
        presentacion_nombre: "",
        presentacion_unidad: "",
      };
    },
    guardarActualizarPresentacion: function () {
      let that = this;
      let url = "";
      let mensaje = "";
      //if()
      if (this.$props.presentacionMod !== null) {
        url =
          "/gestion_hospitalaria/administracion_farmacia/modificar_presentacion";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url =
          "/gestion_hospitalaria/administracion_farmacia/guardar_presentacion";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function (response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarPresentaciones");
          that.$emit("cerrarModalCrearPresentacion");
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
            if (error.response.data.errors.presentacion_nombre != null) {
              that.errores.err_nombre =
                error.response.data.errors.presentacion_nombre;
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
