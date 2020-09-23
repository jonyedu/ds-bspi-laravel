<template>
  <div class="row">
    <h1 class="mt-4">Camas</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaCama()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="camas"
                @handleModificarClick="
                                    modificarCama
                                "
                @handleAnularClick="
                                    anularCamaConfirmacion
                                "
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearCama">
      <crear-cama
        :cama-mod="camaMod"
        :tipos="tipos"
        :habitaciones="habitaciones"
        @recargarCamas="cargarCamas"
        @cerrarModalCrearCama="
                    cerrarModalCrearCama
                "
        ref="crearCama"
      ></crear-cama>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      camaMod: null,
      errores: {},
      form: {
        cama_cod: ""
      },

      tipos: [],
      camas: [],
      habitaciones: [],

      columns: [
        {
          label: "Cama",
          field: "CAMA_NOM",
          type: "String"
        },
        {
          label: "Tipo",
          field: "TIPOCAMA_NOM",
          type: "String"
        },
        {
          label: "Precio",
          field: "CAMA_PRECIO",
          type: "String"
        },

        {
          label: "Habitacion",
          field: "HABITACION_NOM",
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
      .administracion_de_hospital.camas.camas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarCamas();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.camas.camas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarCama(value) {
      this.camaMod = value;
      this.abrirModalCrearCama();
    },
    anularCamaConfirmacion(value) {
      this.form.cama_cod = value.CAMA_COD;

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
          that.anularCama();
        }
      });
    },
    anularCama() {
      let that = this;
      let url = "/gestion_hospitalaria/camas/eliminar_camas";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarCamas();
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
    cerrarModalCrearCama: function() {
      this.$modal.hide("crearCama");
    },
    nuevaCama: function() {
      this.camaMod = null;
      this.abrirModalCrearCama();
    },
    abrirModalCrearCama: function() {
      this.$modal.show("crearCama");
    },
    cargarCamas: function() {
      let that = this;
      let url = "/gestion_hospitalaria/camas/cargar_camas";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.tipos = response.data.tipos;
          that.camas = response.data.camas;
          that.habitaciones = response.data.habitaciones;
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
