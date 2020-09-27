<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Unidad</h5>
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
                  <label for="tipo"><label class="text-danger">(*)</label> Tipo de Unidad</label>
                  <v-select
                  :class="
                                            errores.err_tipo_unidad_codigo === ''
                                                ? ''
                                                : 'form-control is-invalid'
                                        "
                    v-model="selectedTipoUnidad"
                    :value="form.frm_tipo_unidad_codigo"
                    :options="tipo_unidad"
                    label="display"
                    @input="setSelectedTipoUnidad"
                  >
                    <template slot="no-options">No se ha encontrado ningun dato</template>
                  </v-select>
                  <small
                    v-if="errores.err_tipo_unidad_codigo !== ''"
                    id="tipoHelp"
                    class="text-danger"
                  >{{ errores.err_tipo_unidad_codigo[0] }}</small>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="tipo"><span class="text-danger">(*)</span> Simbología</label>
                  <input
                  :class="
                                            errores.err_simbologia === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    type="text"
                    id="telefono"
                    class="form-control"
                    placeholder="Ingrese simbología"
                    v-model="form.frm_simbologia"
                  />
                </div>
                <small
                    v-if="errores.err_simbologia !== ''"
                    id="correoHelp"
                    class="text-danger"
                  >{{errores.err_simbologia[0] }}</small>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="direccion">Equivalencia</label>
                  <input
                    type="text"
                    id="telefono"
                    class="form-control"
                    placeholder="Ingrese equivalencia"
                    v-model="form.frm_equivalencia"
                  />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="direccion">Observación</label>
                  <input
                    type="text"
                    id="telefono"
                    class="form-control"
                    placeholder="Ingrese observación"
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
                    @click="guardarActualizarUnidad()"
                  >
                    {{
                    unidadMod === null
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
    unidadMod: {
      type: Object,
    },
  },
  data: function () {
    return {
      selectedTipoUnidad: "",
      tipo_unidad: [],
      errores: {
        err_unidad_codigo: "",
        err_tipo_unidad_codigo: "",
        err_nombre: "",
        err_simbologia: "",
        err_equivalencia: "",
        err_observacion: "",
      },
      form: {
        frm_unidad_codigo: "",
        frm_tipo_unidad_codigo: "",
        frm_nombre: "",
        frm_simbologia: "",
        frm_equivalencia: "",
        frm_observacion: "",
      },
    };
  },
  mounted: function () {
    this.setSelectedTipoUnidad();
    if (this.$props.unidadMod !== null) {
      var unidad = this.$props.unidadMod;
      /* Unidad */
      this.form.frm_unidad_codigo = unidad.UNIDAD_COD;
      this.form.frm_nombre = unidad.UNIDAD_NOM;
      this.form.frm_simbologia = unidad.UNIDAD_SIMB;
      this.form.frm_equivalencia = unidad.UNIDAD_EQUIV;
      this.form.frm_observacion = unidad.UNIDAD_OBS;
      /* Tipo Unidad */
      this.form.frm_tipo_unidad_codigo = unidad.TIPOUNIDAD_COD;
      this.selectedTipoUnidad = unidad.TIPOUNIDAD_NOM;
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
        err_unidad_codigo: "",
        err_tipo_unidad_codigo: "",
        err_nombre: "",
        err_simbologia: "",
        err_equivalencia: "",
        err_observacion: "",
      };
      this.form = {
        frm_unidad_codigo: "",
        frm_tipo_unidad_codigo: "",
        frm_nombre: "",
        frm_simbologia: "",
        frm_equivalencia: "",
        frm_observacion: "",
      };
    },
    setSelectedTipoUnidad(value) {
      let that = this;
      var loader = that.$loading.show();
      let url =
        "/datos_generales/configuraciones/cargar_tipo_unidad";
      if (value != null) {
        this.form.frm_tipo_unidad_codigo = value.tipo_unidad_codigo;
      }
      axios
        .get(url)
        .then(function (response) {
          let tipo_unidad = [];
          response.data.tipoUnidad.forEach((tipoUnidades) => {
            let objeto = {};
            objeto.display = tipoUnidades.TIPOUNIDAD_NOM;
            objeto.tipo_unidad_codigo = tipoUnidades.TIPOUNIDAD_COD;
            tipo_unidad.push(objeto);
          });
          that.tipo_unidad = tipo_unidad;
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
    guardarActualizarUnidad: function () {
      let that = this;
      let url = "/datos_generales/configuraciones/guardar_modificar_unidad";
      let mensaje = "";
      //if()
      if (this.$props.unidadMod !== null) {
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
          that.$emit("recargarUnidad");
          that.$emit("cerrarModalCrearUnidad");
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
              err_unidad_codigo: "",
              err_tipo_unidad_codigo: "",
              err_nombre: "",
              err_simbologia: "",
              err_equivalencia: "",
              err_observacion: "",
            };
            if (error.response.data.errors.frm_nombre != null) {
              that.errores.err_nombre = error.response.data.errors.frm_nombre;
            }
            if (error.response.data.errors.frm_tipo_unidad_codigo != null) {
              that.errores.err_tipo_unidad_codigo =
                error.response.data.errors.frm_tipo_unidad_codigo;
            }
            if (error.response.data.errors.frm_simbologia != null) {
              that.errores.err_simbologia =
                error.response.data.errors.frm_simbologia;
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
