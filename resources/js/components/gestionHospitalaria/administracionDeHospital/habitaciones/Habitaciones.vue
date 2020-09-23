<template>
  <div class="row">
    <h1 class="mt-4">HABITACIONES</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaHabitacion()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="habitaciones"
                @handleModificarClick="
                                    modificarHabitacion
                                "
                @handleAnularClick="
                                    anularHabitacionConfirmacion
                                "
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearHabitacion">
      <crear-habitacion
        :habitacion-mod="habitacionMod"
        :hospitales="hospitales"
        :areas="areas"
        :tipos="tipos"
        @recargarHabitaciones="cargarHabitaciones"
        @cerrarModalCrearHabitacion="
                    cerrarModalCrearHabitacion
                "
        ref="crearHabitacion"
      ></crear-habitacion>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      habitacionMod: null,
      errores: {},
      form: {
        habitacion_cod: ""
      },
      habitaciones: [],
      hospitales: [],
      areas:[],
      tipos: [],

      columns: [
        {
          label: "Habitacion",
          field: "HABITACION_NOM",
          type: "String"
        },
        {
          label: "Tipo",
          field: "TIPOHABITACION_NOM",
          type: "String"
        },
        {
          label: "Precio",
          field: "HABITACION_PRECIO",
          type: "String"
        },
        {
          label: "Hospital",
          field: "HOSPITAL_NOM",
          type: "String"
        },

        {
          label: "Observaciones",
          field: "HABITACION_OBS",
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
    this.cargarHabitaciones();
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
    modificarHabitacion(value) {
      this.habitacionMod = value;
      this.abrirModalCrearHabitacion();
    },
    anularHabitacionConfirmacion(value) {
      this.form.habitacion_cod = value.HABITACION_COD;

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
          that.anularHabitacion();
        }
      });
    },
    anularHabitacion() {
      let that = this;
      let url = "/gestion_hospitalaria/habitaciones/eliminar_habitaciones";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarHabitaciones();
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
    cerrarModalCrearHabitacion: function() {
      this.$modal.hide("crearHabitacion");
    },
    nuevaHabitacion: function() {
      this.habitacionMod = null;
      this.abrirModalCrearHabitacion();
    },
    abrirModalCrearHabitacion: function() {
      this.$modal.show("crearHabitacion");
    },
    cargarHabitaciones: function() {
      let that = this;
      let url = "/gestion_hospitalaria/habitaciones/cargar_habitaciones";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.tipos = response.data.tipos;
          that.hospitales = response.data.hospitales;
          that.habitaciones = response.data.habitaciones;
          that.areas=response.data.areas;

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
