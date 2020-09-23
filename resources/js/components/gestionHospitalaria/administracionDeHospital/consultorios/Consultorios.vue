<template>
  <div class="row">
    <h1 class="mt-4">Consultorios</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoConsultorio()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="consultorios"
                :info-button="true"
                @handleModificarClick="
                                    modificarConsultorio
                                "
                @handleAnularClick="
                                    anularConsultorioConfirmacion
                                "
                                @handleInfoClick="abrirModalInformacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearConsultorio">
      <crear-consultorio
        :consultorio-mod="consultorioMod"
        :jornadas="jornadas"
        :areas="areas"
        @handleInfoClick="abrirModalInformacion"
        @recargarConsultorios="cargarConsultorios"
        @cerrarModalCrearConsultorio="
                    cerrarModalCrearConsultorio
                "
        ref="crearConsultorio"
      ></crear-consultorio>
    </modal>
    <modal :width="'70%'" height="auto" :scrollable="true" name="infoConsultorio">
      <info-consultorio :consultorio="consultorioInfo" ref="infoConsultorio"></info-consultorio>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      consultorioMod: null,
      errores: {},
      form: {
        habitacion_cod: ""
      },
      consultorios: [],
      areas: [],
      jornadas: [],
      consultorioInfo:"",
      columns: [
        {
          label: "Consultorio",
          field: "CONSULTORIO_NOM",
          type: "String"
        },
        {
          label: "Area",
          field: "AREA_NOM",
          type: "String"
        },
        {
          label: "Jornada",
          field: "MEDICO_NOM",
          type: "String"
        },

        {
          label: "Observaciones",
          field: "CONSULTORIO_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.habitaciones.habitaciones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarConsultorios();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.habitaciones.habitaciones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    abrirModalInformacion(value) {
      this.consultorioInfo = value;
      this.$modal.show("infoConsultorio");
    },
    modificarConsultorio(value) {
      this.consultorioMod = value;
      this.abrirModalCrearConsultorio();
    },
    anularConsultorioConfirmacion(value) {
      this.form.consultorio_cod = value.CONSULTORIO_COD;
      let that = this;
      this.$swal({
        title: "¿Desea anular el elemento seleccionado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          that.anularConsultorio();
        }
      });
    },
    anularConsultorio() {
      let that = this;
      let url = "/gestion_hospitalaria/consultorios/eliminar_consultorios";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarConsultorios();
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Dato anulado correctamente."
          });
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
    cerrarModalCrearConsultorio: function() {
      this.$modal.hide("crearConsultorio");
    },
    nuevoConsultorio: function() {
      this.consultorioMod = null;
      this.abrirModalCrearConsultorio();
    },
    abrirModalCrearConsultorio: function() {
      this.$modal.show("crearConsultorio");
    },
    cargarConsultorios: function() {
      let that = this;
      let url = "/gestion_hospitalaria/consultorios/cargar_consultorios";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.areas = response.data.areas;
          that.consultorios = response.data.consultorios;
          that.jornadas = response.data.jornadas.original.jornadas;

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
    }
  }
};
</script>
