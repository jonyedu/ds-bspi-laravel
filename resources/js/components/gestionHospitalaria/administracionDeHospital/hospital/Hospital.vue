<template>
  <div class="row">
    <h1 class="mt-2">Hospitales</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoHospital()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :info-button="true"
                :columns-data="columns"
                :rows-data="hospitales"
                :logo-hospital="hospitalMod?false: true"
                @handleModificarClick="modificarHospital"
                @handleAnularClick="anularHospitalConfirmacion"
                @handleInfoClick="abrirModalInformacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearHospital">
      <crear-hospital
        :hospital-mod="hospitalMod"
        @recargarHospitales="cargarHospitales"
        @cerrarModalCrearHospital="cerrarModalCrearHospital"
        ref="crearHospital"
      ></crear-hospital>
    </modal>
    <modal :width="'70%'" height="auto" :scrollable="true" name="infoHospital">
      <info-hospital :hospital="hospitalInfo" ref="crearHospital"></info-hospital>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      hospitalMod: null,
      url_data: "",
      hospitalInfo: "",
      errores: {},
      form: {},
      hospitales: [],
      columns: [
        {
          label: "Nombre",
          field: "HOSPITAL_NOM",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "HOSPITAL_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    this.cargarHospitales();
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.hospital.hospital.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.hospital.hospital.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    abrirModalInformacion(value) {
      this.hospitalInfo = value;
      this.$modal.show("infoHospital");
    },
    modificarHospital(value) {
      this.hospitalMod = value;
      this.abrirModalCrearHospital();
    },
    anularHospitalConfirmacion(value) {
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
          that.anularHospital(value.HOSPITAL_COD);
        }
      });
    },
    anularHospital(id) {
      let that = this;
      let url = "/gestion_hospitalaria/hospitales/eliminar_hospitales/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          loader.hide();
          that.cargarHospitales();
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
    cerrarModalCrearHospital: function() {
      this.$modal.hide("crearHospital");
    },
    nuevoHospital: function() {
      this.hospitalMod = null;
      this.abrirModalCrearHospital();
    },
    abrirModalCrearHospital: function() {
      this.$modal.show("crearHospital");
    },
    cargarHospitales: function() {
      let that = this;
      let url = "/gestion_hospitalaria/hospitales/cargar_hospitales";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let hospitales = [];
          hospitales = response.data.datos;
          that.hospitales = hospitales;
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
