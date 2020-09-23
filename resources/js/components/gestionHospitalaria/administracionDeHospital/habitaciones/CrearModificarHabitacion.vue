<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">HABITACIONES</h5>
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
                    :readonly="habitacionMod !== null"
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
                    
                    :class="
                                            errores.precio === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="precio"
                    placeholder="Ingrese un precio"
                    v-model="form.precio"
                  />
                  <small
                    v-if="errores.precio !== ''"
                    id="nombreHelp"
                    class="text-danger"
                  >{{ errores.precio[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="tipo">Tipo De Habitacion</label>
                  <v-select
                    v-model="selectedTipo"
                    :value="form.tipo_cod"
                    :options="tipos"
                    label="TIPOHABITACION_NOM"
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
                  <label for="cargo">Area</label>
                  <v-select
                    v-model="selectedArea"
                    :value="form.AREA_COD"
                    :options="areas"
                    label="AREA_NOM"
                    @input="setSelectedArea"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.area_cod !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.area_cod[0] }}</small>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    type="text"
                    :class="'form-control' "
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
                    habitacionMod === null
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
    habitacionMod: {
      type: Object
    },
    tipos: {
      type: Array
    },
    hospitales: {
      type: Array
    },
    areas: {
      type: Array
    }
  },
  data: function() {
    return {
      errores: {
        area_cod: "",
        nombre: "",
        tipo_cod: "",
        precio: ""
      },
      form: {
        precio:"",
        tipo_cod: "",
        nombre: "",
        hospital_cod: "",
        habitacion_cod: "",
        area_cod:"",
        activo: "",
        observacion: ""
      },
      activos: [
        {
          id_tipo: "A"
        },
        {
          id_tipo: "I"
        }
      ],
      selectedTipo: "",
      selectedActivo: "A",
      selectedHospital: "",
      selectedArea:""

      //organismosA: [],
      //cargosA: [],
      //usuariosA: []
    };
  },
  mounted: function() {
    this.form.activo = "A";

    if (this.$props.habitacionMod !== null) {
      var habitacion = this.$props.habitacionMod;

      this.form.tipo_cod = habitacion.TIPOHABITACION_COD;
      this.selectedTipo = habitacion.TIPOHABITACION_NOM;

      this.form.area_cod = habitacion.AREA_COD;
      this.selectedArea = habitacion.AREA_NOM;

      this.form.habitacion_cod = habitacion.HABITACION_COD;

      this.form.precio = habitacion.HABITACION_PRECIO;

      this.form.observacion = habitacion.HABITACION_OBS;

      this.form.nombre = habitacion.HABITACION_NOM;

    }
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.habitaciones.crear_modificar_habitacion.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.habitaciones.crear_modificar_habitacion.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    limpiarForm() {
      this.errores = {
        area_cod: "",
        nombre: "",
        tipo_cod: "",
        precio: ""
      };
      this.form = {
        tipo_cod: "",
        hospital_cod: "",
        nombre: "",
        precio:0,
        activo: "",
        observacion: ""
      };

      this.selectedActivo = "A";
      this.form.activo = "A";
      this.selectedHospital = "";
      this.selectedTipo = "";
    },
    setSelectedTipo(value) {
      if (value !== null) {
        this.form.tipo_cod = value.TIPOHABITACION_COD;
      } else {
        this.form.tipo_cod = "";
      }
    },
    setSelected(value) {
      if (value !== null) {
        this.form.activo = value.id_tipo;
      } else {
        this.form.activo = "";
      }
    },

    setSelectedArea(value) {
      if (value !== null) {
        this.form.area_cod = value.AREA_COD;
      } else {
        this.form.area_cod = "";
      }
    },
    guardarActualizar: function() {
      let that = this;
      that.errores = {
        area_cod: "",
        nombre: "",
        tipo_cod: "",
        precio: ""
      };
      let url = "";
      let mensaje = "";

      if (this.$props.habitacionMod !== null) {
        url = "/gestion_hospitalaria/habitaciones/modificar_habitaciones";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/habitaciones/guardar_habitaciones";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarHabitaciones");
          that.$emit("cerrarModalCrearHabitacion");
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
            that.errores.area_cod =
              error.response.data.errors.area_cod != undefined
                ? error.response.data.errors.area_cod
                : "";
            that.errores.precio =
              error.response.data.errors.precio != undefined
                ? error.response.data.errors.precio
                : "";
            that.errores.nombre =
              error.response.data.errors.nombre != undefined
                ? error.response.data.errors.nombre
                : "";
            that.errores.tipo_cod =
              error.response.data.errors.tipo_cod != undefined
                ? error.response.data.errors.tipo_cod
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
