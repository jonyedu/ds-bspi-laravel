<template>
    <div class="card col-md-12 p-3">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                <label for="area">Especialidad</label>
                <v-select
                    v-model="selectedEspecialidad"
                    :value="form.id_especialidad"
                    :options="especialidades"
                    label="display"
                    @input="setselectedEspecialidad"
                    v-bind:class="{ disabled: objetoMod!=null }"
                ></v-select>
                </div>
            </div>
            
            <div
            class="col-lg-12 col-md-12 col-sm-12 mt-1"
            v-if="
                                form.id_especialidad != null && form.id_especialidad != ''
                            "
            >
                <div class="form-group">
                    <label for="medico">Medico</label>
                    <v-select
                    v-model="selectedMedico"
                    :value="form.id_doctor"
                    :options="medicos"
                    label="display"
                    @input="setSelectedMedico"
                    v-bind:class="{ disabled: objetoMod!=null }"
                    ></v-select>
                </div>
            </div>
        </div>       
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
            <div class="form-inline">
                <button
                :disabled="objetoMod!=null"
                type="button"
                class="btn btn-success btn-block"
                @click="guardarActualizar()"
                >
                Ingresar Emergencia
                </button>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  props: {
     codigoCita:{
      type:Number
    },
    objetoMod: {
      type: Object,
      default:null
    },
    especialidades: {
      type: Array
    },
    acompanantes: {
      type: Array
    }
  },
  data: function() {
    return {
      existenErroresForm: false,
      medicos: [],
      selectedMedico: "",
      selectedEspecialidad: "",
      form: {
        codigo_cita: "",
        id_especialidad: "",
        id_doctor: "",
        estado: "E" //Emergencia
      },
    };
  },
  mounted: function() {
    this.form.codigo_cita= this.$props.codigoCita;
    if (this.$props.objetoMod !== null) {
      let objeto=this.$props.objetoMod;
      this.form.codigo_cita= objeto.CITA_COD;
      this.form.id_especialidad= objeto.ESPECIALIDAD_COD;
      this.form.id_doctor=objeto.CITA_DOCTOR_COD;
      this.selectedEspecialidad= objeto.especialidad.ESPECIALIDAD_NOM;
      this.selectedMedico= objeto.doctor.user.FULL_NAME;
    }
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.admisiones.derivacion_emergencia.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
     let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.admisiones.derivacion_emergencia.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    loadDoctors() {
      let getDoctor = {
        especialidad: this.form.id_especialidad
      };
      let that = this;
      let url =
        "/gestion_hospitalaria/personal_medico/cargar_medicos_emergencias";
      var loader = that.$loading.show();
      axios
        .post(url, getDoctor)
        .then(function(response) {
          let doctores = [];

          for (let i = 0; i < response.data.length; i++) {
            let objeto = {
              display: response.data[i].user.US_NOM,
              value: response.data[i].TRABAJADORESPERSONALSALUD_COD
            };
            doctores.push(objeto);
          }
          that.medicos = doctores;

          loader.hide();
        })
        .catch(error => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    },
    setSelectedMedico(value) {
      if (value !== null) {
        this.form.id_doctor = value.value;
      } else {
        this.form.id_doctor = "";
      }
    },
    validarFormulario() {
      
      if (
        this.form.id_especialidad == "" ||
        this.form.id_especialidad == null ||
        this.form.id_especialidad == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione una especialidad"
        });
        this.existenErroresForm = true;
        return;
      }
      if (
        this.form.id_doctor == "" ||
        this.form.id_doctor == null ||
        this.form.id_doctor == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione un Medico"
        });
        this.existenErroresForm = true;
        return;
      }
    },
    
    setselectedEspecialidad(value) {
      if (value !== null) {
        this.form.id_especialidad = value.value;
        this.loadDoctors();
      } else {
        this.form.id_especialidad = "";
      }
    },

    guardarActualizar: function() {
      this.existenErroresForm = false;
      this.validarFormulario();
      if (this.existenErroresForm) {
        return;
      }
      let that = this;
      that.errores = {
        nombre: "",
        id_poliza: "",
        id_especialidad: ""
      };

      let url = "";
      let mensaje = "";
      //if (this.$props.objetoMod !== null) {
      url = "/gestion_hospitalaria/administracion_cita/crear_cita";
      mensaje = "Datos actualizados correctamente.";
      //}
      //else {
      //   url = "/gestion_hospitalaria/generalidades/guardar_aseguradora";
      //   mensaje = "Datos guardados correctamente.";
      // }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarDatosEmergencia");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Datos actualizados correctamente."
          });
        })
        .catch(error => {
          //Errores de validación
         if (error.response.status === 421) {
            that.$swal({
              icon: "error",
              title: "Existen errores",
              text: error.response.data.mensaje
            });
          }else{
            that.$swal({
              icon: "error",
              title: "Existen errores",
              text: error
            });
          }
          loader.hide();
        });
    }
  }
};
</script>
