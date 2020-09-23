<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Funcion de Personal Medico</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="cargo">Personal Medico</label>
                  <v-select
                    v-model="selectedPersonalMedico"
                    :options="personalMedico"
                    label="USER_NOM"
                    @input="setSelectedPersonalMedico"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.personalMedico !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.personalMedico[0] }}</small>
                </div>
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="cargo">Especialidad</label>
                  <v-select
                    v-model="selectedEspecialidad"
                    :options="especialidades"
                    label="nombre"
                    @input="setSelectedEspecialidad"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.especialidades !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.especialidades[0] }}</small>
                </div>
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12">
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
    personalMedico: {
      type: Array
    },
    especialidades: {
      type: Array
    }
  },
  data: function() {
    return {
      errores: {
        personalMedico: "",
        especialidades: "",
        observacion: ""
      },
      form: {
        especialidad_cod: "",

        personalMedico_cod: "",
        observacion: ""
      },

      selectedEspecialidad: "",
      selectedPersonalMedico: ""
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.funcionesDePersonalMedico.crear_modificar_funciones_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.funcionesDePersonalMedico.crear_modificar_funciones_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    onFileSelected(event) {
      if (event.target.files[0]["type"] === "application/pdf") {
        this.pdfContrato = event.target.files[0];
      } else {
        this.$swal({
          icon: "error",
          title: "Error de Archivo",
          text: "Solo archivos de formato: .pdf !"
        });
      }
    },

    setSelectedPersonalMedico(value) {
      if (value !== null) {
        this.form.personalMedico_cod = value.TRABAJADORESPERSONALSALUD_COD;
      } else {
        this.form.personalMedico_cod = "";
      }
    },
    setSelectedEspecialidad(value) {
      if (value !== null) {
        this.form.especialidad_cod = value.codigo;
      } else {
        this.form.especialidad_cod = "";
      }
    },
    guardar: function(pathContrato) {
      let that = this;
      that.errores = {
        nombre: "",
        hospital: "",
        observacion: ""
      };
      let url = "";
      let mensaje = "";

      url =
        "/gestion_hospitalaria/funciones_personalMedico/guardar_funciones_personalMedico";
      mensaje = "Datos guardados correctamente.";

      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarFuncionPersonalMedico");
          that.$emit("cerrarModalCrearFuncionPersonalMedico");
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

            that.errores.hospital =
              error.response.data.errors.hospital != undefined
                ? error.response.data.errors.hospital
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
