<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">PRODUCTOS</h5>
      </center>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="nombre"><label class="text-danger">(*)</label> Nombre</label>
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
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="tipo"><label class="text-danger">(*)</label> Categoria</label>
                  <v-select
                    v-model="selectedCategoria"
                    :value="form.frm_categoria_codigo"
                    :options="categoria"
                    label="display"
                    @input="setSelectedCategoria"
                  >
                    <template slot="no-options">No se ha encontrado ningun dato</template>
                  </v-select>
                  <small
                    v-if="errores.err_categoria_cod !== ''"
                    id="tipoHelp"
                    class="text-danger"
                  >{{ errores.err_categoria_cod[0] }}</small>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="direccion">Clave</label>
                  <input
                    type="text"
                    id="telefono"
                    class="form-control"
                    placeholder="Ingrese El Telefono Del Contacto"
                    v-model="form.frm_clave"
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
                    @click="guardarActualizarProductos()"
                  >
                    {{
                    productosMod === null
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
    productosMod: {
      type: Object,
    },
  },
  data: function () {
    return {
      selectedCategoria: "",
      categoria: [],
      errores: {
        err_categoria_cod: "",
        err_nombre: "",
        err_precio: "",
      },
      form: {
        frm_categoria_codigo: "",
        frm_codigo: "",
        frm_nombre: "",
        frm_clave: "",
      },
    };
  },
  mounted: function () {
    this.setSelectedCategoria();
    if (this.$props.productosMod !== null) {
      var productos = this.$props.productosMod;
      /* Productos */
      this.form.frm_codigo = productos.PRODUCTO_COD;
      this.form.frm_nombre = productos.PRODUCTO_NOM;
      this.form.frm_clave = productos.PRODUCTO_CLAVE;
      /* Categoria */
      this.form.frm_categoria_codigo = productos.CATEGORIA_COD;
      this.selectedCategoria = productos.CATEGORIA_NOM;
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
        frm_telefono: "",
        frm_direccion: "",
        frm_email: "",
        frm_observacion: "",
        frm_pagina_web: "",
      };
    },
    setSelectedCategoria(value) {
      let that = this;
      var loader = that.$loading.show();
      let url =
        "/gestion_hospitalaria/administracion_farmacia/cargar_categoria";
      if (value != null) {
        this.form.frm_categoria_codigo = value.categoria_codigo;
      }
      axios
        .get(url)
        .then(function (response) {
          let categoria = [];
          response.data.categoria.forEach((categorias) => {
            let objeto = {};
            objeto.display = categorias.CATEGORIA_NOM;
            objeto.categoria_codigo = categorias.CATEGORIA_COD;
            categoria.push(objeto);
          });
          that.categoria = categoria;
          loader.hide();
        })
        .catch((error) => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
          loader.hide();
        });
    },
    guardarActualizarProductos: function () {
      let that = this;
      let url = "";
      let mensaje = "";
      //if()
      if (this.$props.productosMod !== null) {
        url =
          "/gestion_hospitalaria/administracion_farmacia/modificar_productos";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/administracion_farmacia/guardar_productos";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function (response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarProductos");
          that.$emit("cerrarModalCrearProductos");
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
            that.errores = {
              err_nombre: "",
              err_categoria_cod: "",
              err_clave: "",
              err_precio: "",
            };
            if (error.response.data.errors.frm_nombre != null) {
              that.errores.err_nombre = error.response.data.errors.frm_nombre;
            }
            if (error.response.data.errors.frm_categoria_codigo != null) {
              that.errores.err_categoria_cod =
                error.response.data.errors.frm_categoria_codigo;
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
