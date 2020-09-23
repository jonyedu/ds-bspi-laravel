<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Especialidades</h5>
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
                    :readonly="especialidadMod !== null"
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
                  <label for="cargo">Hospitales</label>
                  <v-select
                    v-model="selectedHospital"
                    :value="form.HOSPITAL_COD"
                    :options="hospitales"
                    label="HOSPITAL_NOM"
                    @input="setSelectedHospital"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.hospital_cod !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.hospital_cod[0] }}</small>
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
                    especialidadMod === null
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
    especialidadMod: {
      type: Object
    },
    hospitales: {
      type: Array
    }
  },
  data: function() {
    return {
      errores: {
        nombre: "",
        hospital_cod: "",
        observacion: ""
      },
      form: {
        hospital_cod: "",
        nombre: "",
        especialidad_cod: "",
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
      selectedHospital: ""

      //organismosA: [],
      //cargosA: [],
      //usuariosA: []
    };
  },
  mounted: function() {
    this.form.activo = "A";

    if (this.$props.especialidadMod !== null) {
      var especialidad = this.$props.especialidadMod;

      this.form.hospital_cod = especialidad.HOSPITAL_COD;
      this.selectedHospital = especialidad.HOSPITAL_NOM;

      this.form.especialidad_cod = especialidad.ESPECIALIDAD_COD;
      this.form.nombre = especialidad.ESPECIALIDAD_NOM;

      //this.form.activo = habitacion.HABITACION_LOGIC_ESTADO;

      this.form.observacion = especialidad.ESPECIALIDAD_OBS;
    }
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.especialidades.crear_modificar_especialidad.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.especialidades.crear_modificar_especialidad.nombre_formulario;
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
        hospital_cod: "",
        observacion: ""
      };
      this.form = {
        hospital_cod: "",
        nombre: "",
        especialidad_cod: "",
        observacion: ""
      };

      this.selectedHospital = "";
    },

    setSelectedHospital(value) {
      if (value !== null) {
        this.form.hospital_cod = value.HOSPITAL_COD;
      } else {
        this.form.hospital_cod = "";
      }
    },

    guardarActualizar: function() {
      let that = this;
      that.errores = {
        nombre: "",
        hospital_cod: "",
        observacion: ""
      };
      let url = "";
      let mensaje = "";

      if (this.$props.especialidadMod !== null) {
        url = "/gestion_hospitalaria/especialidades/modificar_especialidades";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/especialidades/guardar_especialidades";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarEspecialidades");
          that.$emit("cerrarModalCrearEspecialidad");
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
            that.errores.nombre =
              error.response.data.errors.nombre != undefined
                ? error.response.data.errors.nombre
                : "";

            that.errores.hospital_cod =
              error.response.data.errors.hospital_cod != undefined
                ? error.response.data.errors.hospital_cod
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
