<template>
  <div class="row">
    <h1 class="mt-4">Personal Medico</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoPersonalMedico()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="personalMedico"
                @handleModificarClick="modificarPersonalMedico"
                @handleAnularClick="anularPersonalMedicoConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearPersonalMedico">
      <crear-PersonalMedico
        :personal-mod="personalMod"
        :usuarios="usuarios"
        :tipos="tipos"
        @recargarPersonalMedico="cargarPersonalMedico"
        @cerrarModalCrearPersonalMedico="cerrarModalCrearPersonalMedico"
        ref="crearPersonalMedico"
      ></crear-PersonalMedico>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      personalMod: null,
      errores: {},
      form: {
        personal_cod: ""
      },
      personalMedico: [],
      usuarios: [],
      tipos: [],

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
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.personalMedico.personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarPersonalMedico();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.personalMedico.personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarPersonalMedico(value) {
      this.personalMod = value;
      this.abrirModalCrearPersonalMedico();
    },
    anularPersonalMedicoConfirmacion(value) {
      this.form.personal_cod = value.TRABAJADORESPERSONALSALUD_COD;
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
          that.anularPersonalMedico();
        }
      });
    },
    anularPersonalMedico() {
      let that = this;
      let url = "/gestion_hospitalaria/personalMedico/eliminar_personal_medico";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarPersonalMedico();
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
    cerrarModalCrearPersonalMedico: function() {
      this.$modal.hide("crearPersonalMedico");
    },
    nuevoPersonalMedico: function() {
      this.personalMod = null;
      this.abrirModalCrearPersonalMedico();
    },
    abrirModalCrearPersonalMedico: function() {
      this.$modal.show("crearPersonalMedico");
    },
    cargarPersonalMedico: function() {
      let that = this;
      let url = "/gestion_hospitalaria/personalMedico/cargar_personal_medico";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.especialidades = response.data.especialidades;

          that.personalMedico = response.data.medicos;
          that.usuarios = response.data.usuarios;
          that.tipos = response.data.tipos;
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
