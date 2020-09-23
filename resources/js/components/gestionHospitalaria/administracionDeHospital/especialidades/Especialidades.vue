<template>
  <div class="row">
    <h1 class="mt-4">Especialidades</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaEspecialidad()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="especialidades"
                @handleModificarClick="modificarEspecialidad"
                @handleAnularClick="anularEspecialidadConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearEspecialidad">
      <crear-especialidad
        :especialidad-mod="especialidadMod"
        :hospitales="hospitales"
        @recargarEspecialidades="cargarEspecialidades"
        @cerrarModalCrearEspecialidad="cerrarModalCrearEspecialidad"
        ref="crearEspecialidad"
      ></crear-especialidad>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      especialidadMod: null,
      errores: {},
      form: {
        especialidad_cod: ""
      },

      especialidades: [],
      hospitales: [],

      columns: [
        {
          label: "Especialidad",
          field: "ESPECIALIDAD_NOM",
          type: "String"
        },
        {
          label: "Hospital",
          field: "HOSPITAL_NOM",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "ESPECIALIDAD_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.especialidades.especialidades.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarEspecialidades();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
   let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.especialidades.especialidades.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarEspecialidad(value) {
      this.especialidadMod = value;
      this.abrirModalCrearEspecialidad();
    },
    anularEspecialidadConfirmacion(value) {
      this.form.especialidad_cod = value.ESPECIALIDAD_COD;
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
          that.anularEspecialidad();
        }
      });
    },
    anularEspecialidad() {
      let that = this;
      let url = "/gestion_hospitalaria/especialidades/eliminar_especialidades";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarEspecialidades();
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
    cerrarModalCrearEspecialidad: function() {
      this.$modal.hide("crearEspecialidad");
    },
    nuevaEspecialidad: function() {
      this.areaMod = null;
      this.abrirModalCrearEspecialidad();
    },
    abrirModalCrearEspecialidad: function() {
      this.$modal.show("crearEspecialidad");
    },
    cargarEspecialidades: function() {
      let that = this;
      let url = "/gestion_hospitalaria/especialidades/cargar_especialidades";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.especialidades = response.data.especialidades;

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
