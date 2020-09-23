<template>
  <div class="row">
    <h1 class="mt-4">Funciones de Personal Medico</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoFuncionPersonalMedico()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="false"
                :columns-data="columns"
                :rows-data="funcionesPersonalMedico"
                @handleAnularClick="anularFuncionPersonalMedicoConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearFuncionPersonalMedico">
      <crear-FuncionPersonalMedico
        :personalMedico="personalMedico"
        :especialidades="especialidades"
        @recargarFuncionPersonalMedico="cargarFuncionPersonalMedico"
        @cerrarModalCrearFuncionPersonalMedico="cerrarModalCrearFuncionPersonalMedico"
        ref="crearFuncionPersonalMedico"
      ></crear-FuncionPersonalMedico>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      errores: {},
      form: {
        funcion_cod: ""
      },
      personalMedico: [],
      funcionesPersonalMedico: [],
      especialidades: [],

      columns: [
        {
          label: "Medico",
          field: "MEDICO",
          type: "String"
        },
        {
          label: "Especialidad",
          field: "ESPECIALIDAD",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "FUNCIONTRABAJADOR_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.funcionesDePersonalMedico.funciones_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarFuncionPersonalMedico();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.funcionesDePersonalMedico.funciones_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    anularFuncionPersonalMedicoConfirmacion(value) {
      this.form.funcion_cod = value.FUNCIONTRABAJADOR_COD;
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
          that.anularFuncionPersonalMedico();
        }
      });
    },
    anularFuncionPersonalMedico() {
      let that = this;
      let url =
        "/gestion_hospitalaria/funciones_personalMedico/eliminar_funciones_personalMedico/" +
        this.form.funcion_cod;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          loader.hide();
          that.cargarFuncionPersonalMedico();
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
    cerrarModalCrearFuncionPersonalMedico: function() {
      this.$modal.hide("crearFuncionPersonalMedico");
    },
    nuevoFuncionPersonalMedico: function() {
      this.personalMedicoMod = null;
      this.abrirModalCrearFuncionPersonalMedico();
    },
    abrirModalCrearFuncionPersonalMedico: function() {
      this.$modal.show("crearFuncionPersonalMedico");
    },
    cargarFuncionPersonalMedico: function() {
      let that = this;
      let url =
        "/gestion_hospitalaria/funciones_personalMedico/cargar_funciones_personalMedico";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.personalMedico = response.data.personalMedico;
          that.funcionesPersonalMedico = response.data.funciones;
          that.especialidades = response.data.especialidades;
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
