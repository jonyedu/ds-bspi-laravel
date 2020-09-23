<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Camas</h5>
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
                    :readonly="camaMod !== null"
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
                  <label for="precio">Precio</label>
                  <input
                    type="text"
                    :class="'form-control'"
                    id="precio"
                    placeholder="Ingrese un precio"
                    v-model="form.precio"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="tipo">Tipo De Cama</label>
                  <v-select
                    v-model="selectedTipo"
                    :value="form.tipo_cod"
                    :options="tipos"
                    label="TIPOCAMA_NOM"
                    @input="setSelectedTipo"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.tipo_cod !== ''"
                    id="tipoHelp"
                    class="text-danger"
                  >{{ errores.tipo_cod[0] }}</small>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="cargo">Habitacion</label>
                  <v-select
                    v-model="selectedHabitacion"
                    :value="form.HABITACION_COD"
                    :options="habitaciones"
                    label="HABITACION_NOM"
                    @input="setSelectedHabitacion"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.habitacion_cod !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.habitacion_cod[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    type="text"
                    :class="'form-control'"
                    id="observacion"
                    placeholder="Ingrese su observación"
                    v-model="form.observacion"
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
                    @click="guardarActualizar()"
                  >
                    {{
                    camaMod === null
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
    camaMod: {
      type: Object,
    },
    habitaciones: {
      type: Array,
    },
    tipos: {
      type: Array,
    },
  },
  data: function () {
    return {
      errores: {
        tipo_cod: "",
        habitacion_cod: "",
        nombre: ""
      },
      form: {
        tipo_cod: "",
        habitacion_cod: "",
        nombre: "",
        cama_cod: "",
        observacion: "",
        precio: "",
      },
      activos: [
        {
          id_tipo: "A",
        },
        {
          id_tipo: "I",
        },
      ],
      selectedTipo: "",
      selectedActivo: "A",
      selectedHabitacion: "",

      //organismosA: [],
      //cargosA: [],
      //usuariosA: []
    };
  },
  mounted: function () {
    this.form.activo = "A";

    if (this.$props.camaMod !== null) {
      var cama = this.$props.camaMod;

      this.form.tipo_cod = cama.TIPOCAMA_COD;
      this.selectedTipo = cama.TIPOCAMA_NOM;

      this.form.habitacion_cod = cama.HABITACION_COD;
      this.selectedHabitacion = cama.HABITACION_NOM;

      this.form.cama_cod = cama.CAMA_COD;
      this.form.nombre = cama.CAMA_NOM;
      this.form.precio = cama.CAMA_PRECIO;

      //this.form.activo = habitacion.HABITACION_LOGIC_ESTADO;

      this.form.observacion = cama.CAMA_OBS;

      this.selectedActivo = cama.HABITACION_LOGIC_ESTADO;
    }
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.camas.crear_modificar_cama.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function () {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.camas.crear_modificar_cama.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    limpiarForm() {
      this.errores = {
        tipo_cod: "",
        habitacion_cod: "",
        nombre: ""
      };
      this.form = {
        tipo_cod: "",
        cama_cod: "",
        nombre: "",

        observacion: "",
      };

      this.selectedActivo = "A";
      this.form.activo = "A";
      this.selectedHospital = "";
      this.selectedTipo = "";
    },
    setSelectedTipo(value) {
      if (value !== null) {
        this.form.tipo_cod = value.TIPOCAMA_COD;
      } else {
        this.form.tipo_cod = "";
      }
    },
    setSelectedHabitacion(value) {
      if (value !== null) {
        this.form.habitacion_cod = value.HABITACION_COD;
      } else {
        this.form.habitacion_cod = "";
      }
    },
    setSelected(value) {
      if (value !== null) {
        this.form.activo = value.id_tipo;
      } else {
        this.form.activo = "";
      }
    },

    guardarActualizar: function () {
      let that = this;
      that.errores = {
        tipo_cod: "",
        habitacion_cod: "",
        nombre: ""
      };
      let url = "";
      let mensaje = "";

      if (this.$props.camaMod !== null) {
        url = "/gestion_hospitalaria/camas/modificar_camas";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/camas/guardar_camas";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function (response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarCamas");
          that.$emit("cerrarModalCrearCama");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Datos actualizados correctamente.",
          });
          that.limpiarForm();
        })
        .catch((error) => {
          //Errores de validación
          if (error.response.status === 422) {
            that.errores.tipo_cod =
              error.response.data.errors.tipo_cod != undefined
                ? error.response.data.errors.tipo_cod
                : "";
            that.errores.nombre =
              error.response.data.errors.nombre != undefined
                ? error.response.data.errors.nombre
                : "";

            that.errores.habitacion_cod =
              error.response.data.errors.habitacion_cod != undefined
                ? error.response.data.errors.habitacion_cod
                : "";
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
