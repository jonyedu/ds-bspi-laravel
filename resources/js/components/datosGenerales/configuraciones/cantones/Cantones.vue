<template>
  <div class="row">
    <h1 class="mt-4">Cantones</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoCanton()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="cantones"
                @handleModificarClick="
                                    modificarCanton
                                "
                @handleAnularClick="
                                    anularCantonConfirmacion
                                "
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearModificarCanton">
      <crear-modificar-canton
        :canton-mod="cantonMod"
        :provincias="provincias"
        @recargarCantones="cargarCantones"
        @cerrarModalCrearModificarCanton="
                    cerrarModalCrearModificarCanton
                "
        ref="crearModificarCanton"
      ></crear-modificar-canton>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      cantonMod: null,
      errores: {},
      form: {
        canton_cod: ""
      },
      cantones: [],
      provincias: [],
      columns: [
        {
          label: "Nombre",
          field: "CANTON_NOM",
          type: "String"
        },
        {
          label: "Provincia",
          field: "provincia_nom",
          type: "String"
        },
        {
          label: "Activo",
          field: "CANTON_ACTIVO",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "CANTON_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    //arreglar
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.cantones.cantones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarCantones();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.cantones.cantones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarCanton(value) {
      this.cantonMod = value;
      this.abrirModalCrearModificarCanton();
    },
    anularCantonConfirmacion(value) {
      this.form.canton_cod = value.CANTON_COD;

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
          that.anularCanton();
        }
      });
    },
    anularCanton() {
      let that = this;
      let url = "/datos_generales/configuraciones/eliminar_cantones/";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarCantones();
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
    cerrarModalCrearModificarCanton: function() {
      this.$modal.hide("crearModificarCanton");
    },
    nuevoCanton: function() {
      this.cantonMod = null;
      this.abrirModalCrearModificarCanton();
    },
    abrirModalCrearModificarCanton: function() {
      this.$modal.show("crearModificarCanton");
    },
    cargarCantones: function() {
      let that = this;
      let url = "/datos_generales/configuraciones/cargar_cantones";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.provincias = response.data.provincias;
          that.cantones = response.data.cantones;

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