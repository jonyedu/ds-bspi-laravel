<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Crear Asociación entre Productos y Presentaciones </h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="cargo"><label class="text-danger">(*)</label> Producto</label>
                  <v-select
                    v-model="selectedProducto"
                    :options="productos"
                    label="PRODUCTO_NOM"
                    @input="setSelectedProducto"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.producto !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.producto[0] }}</small>
                </div>
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="cargo"><label class="text-danger">(*)</label> Presentación</label>
                  <v-select
                    v-model="selectedPresentacion"
                    :options="presentaciones"
                    label="PRESENTACIONFULLPRECIO"
                    @input="setSelectedPresentacion"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.presentacion !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.presentacion[0] }}</small>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="nombre"><label class="text-danger">(*)</label> Precio</label>
                  <input
                    type="number"
                    :class="
                                            errores.precio === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="cicloInicial"
                    placeholder="Ingrese el precio"
                    v-model="form.presentacionproducto_precio"
                  />
                  <small
                    v-if="errores.precio !== ''"
                    id="correoHelp"
                    class="text-danger"
                  >{{errores.precio[0] }}</small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button type="button" class="btn btn-success btn-block" @click="guardar()">Guardar</button>
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
    productos: {
      type: Array,
    },
    presentaciones: {
      type: Array,
    },
  },
  data: function () {
    return {
      errores: {
        producto: "",
        presentacion: "",
        precio: "",
      },
      form: {
        producto_cod: "",

        presentacion_cod: "",
        presentacionproducto_precio: "",
      },

      selectedProducto: "",
      selectedPresentacion: "",
    };
  },
  mounted: function () {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.funcionesDePersonalMedico
      .crear_modificar_funciones_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function () {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.funcionesDePersonalMedico
      .crear_modificar_funciones_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    setSelectedProducto(value) {
      if (value !== null) {
        this.form.producto_cod = value.PRODUCTO_COD;
      } else {
        this.form.producto_cod = "";
      }
    },
    setSelectedPresentacion(value) {
      if (value !== null) {
        this.form.presentacion_cod = value.PRESENTACION_COD;
      } else {
        this.form.presentacion_cod = "";
      }
    },
    guardar: function () {
      let that = this;
      let url = "";
      let mensaje = "";

      url =
        "/gestion_hospitalaria/administracion_farmacia/guardar_presentacion_producto";
      mensaje = "Datos guardados correctamente.";

      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function (response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarPresentacionProductos");
          that.$emit("cerrarModalCrearPresentacionProducto");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: that.mensaje,
          });
          that.limpiarForm();
        })
        .catch((error) => {
          //Errores de validación
          if (error.response.status === 421) {
            loader.hide();
            that.$swal({
                icon: "error",
                title: "Existe un Error.",
                text: error.response.data.mensaje
            });
          }
          if (error.response.status === 422) {
            if (error.response.data.errors.presentacion_nombre != null) {
              that.errores.err_nombre =
                error.response.data.errors.presentacion_nombre;
            }
            loader.hide();
          }
          loader.hide();
        });
    },
  },
};
</script>
