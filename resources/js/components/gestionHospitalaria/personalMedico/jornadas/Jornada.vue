<template>
  <div class="row">
    <h1 class="mt-4">Jornadas</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaJornada()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="jornadas"
                @handleModificarClick="modificarJornada"
                @handleAnularClick="anularJornadaConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearJornada">
      <crear-Jornada
        :personal-mod="personalMod"
        :personalMedico="personalMedico"
        @recargarJornada="cargarJornada"
        @cerrarModalCrearJornada="cerrarModalCrearJornada"
        ref="crearJornada"
      ></crear-Jornada>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      jornadaMod: null,
      errores: {},
      form: {
        jornada_cod: ""
      },
      personalMedico: [],
      jornadas: [],

      columns: [
        {
          label: "Nombre",
          field: "USER_NOM",
          type: "String"
        },
        {
          label: "Tipo de Personal Medico",
          field: "TIPOTRABAJADOR_NOM",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "TRABAJADORESPERSONALSALUD_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.jornadas.jornada.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarJornadas();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.jornadas.jornada.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarJornada(value) {
      this.jornadaMod = value;
      this.abrirModalCrearJornada();
    },
    anularJornadaConfirmacion(value) {
      this.form.jornada_cod = value.TRABAJADORESPERSONALSALUD_COD;
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
          that.anularJornada();
        }
      });
    },
    anularJornada() {
      let that = this;
      let url = "/gestion_hospitalaria/personalMedico/eliminar_personal_medico";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarJornadas();
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
    cerrarModalCrearJornada: function() {
      this.$modal.hide("crearJornada");
    },
    nuevaJornada: function() {
      this.jornadaMod = null;
      this.abrirModalCrearJornada();
    },
    abrirModalCrearJornada: function() {
      this.$modal.show("crearJornada");
    },
    cargarJornadas: function() {
      let that = this;
      let url = "/gestion_hospitalaria/personalMedico/cargar_personal_medico";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.especialidades = response.data.especialidades;

          that.personalMedico = response.data.medicos;
          that.jornadas = response.data.jornadas;
          
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
