<template>
  <div class="row">
    <h1 class="mt-4">Areas</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaArea()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="areas"
                @handleModificarClick="modificarArea"
                @handleAnularClick="anularAreaConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearArea">
      <crear-area
        :area-mod="areaMod"
        :hospitales="hospitales"
        @recargarAreas="cargarAreas"
        @cerrarModalCrearArea="cerrarModalCrearArea"
        ref="crearArea"
      ></crear-area>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      areaMod: null,
      errores: {},
      form: {
        area_cod: ""
      },

      areas: [],
      hospitales: [],

      columns: [
        {
          label: "Area",
          field: "AREA_NOM",
          type: "String"
        },
        {
          label: "Hospital",
          field: "HOSPITAL_NOM",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "AREA_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.areas.areas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarAreas();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.areas.areas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarArea(value) {
      this.areaMod = value;
      this.abrirModalCrearArea();
    },
    anularAreaConfirmacion(value) {
      this.form.area_cod = value.AREA_COD;

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
          that.anularArea();
        }
      });
    },
    anularArea() {
      let that = this;
      let url = "/gestion_hospitalaria/areas/eliminar_areas";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarAreas();
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
    cerrarModalCrearArea: function() {
      this.$modal.hide("crearArea");
    },
    nuevaArea: function() {
      this.areaMod = null;
      this.abrirModalCrearArea();
    },
    abrirModalCrearArea: function() {
      this.$modal.show("crearArea");
    },
    cargarAreas: function() {
      let that = this;
      let url = "/gestion_hospitalaria/areas/cargar_areas";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.areas = response.data.areas;

          that.hospitales = response.data.hospitales;
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
