<template>
  <div class="row">
    <h1 class="mt-4">Provincias</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaProvincia()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="provincias"
                @handleModificarClick="
                                    modificarProvincia
                                "
                @handleAnularClick="
                                    anularProvinciaConfirmacion
                                "
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearModificarProvincia">
      <crear-modificar-provincia
        :provincia-mod="provinciaMod"
        :paises="paises"
        @recargarProvincias="cargarProvincias"
        @cerrarModalCrearModificarProvincia="
                    cerrarModalCrearModificarProvincia
                "
        ref="crearModificarProvincia"
      ></crear-modificar-provincia>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      provinciaMod: null,
      errores: {},
      form: {
        provincia_cod: ""
      },
      paises: [],
      provincias: [],
      columns: [
        {
          label: "Nombre",
          field: "PROV_NOM",
          type: "String"
        },
        {
          label: "Pais",
          field: "pais_nom",
          type: "String"
        },
        {
          label: "Activo",
          field: "PROV_ACTIVO",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "PROV_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    //arreglar
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.provincias.provincias.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarProvincias();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.provincias.provincias.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarProvincia(value) {
      this.provinciaMod = value;
      this.abrirModalCrearModificarProvincia();
    },
    anularProvinciaConfirmacion(value) {
      this.form.provincia_cod = value.PROV_COD;

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
          that.anularProvincia();
        }
      });
    },
    anularProvincia() {
      let that = this;
      let url = "/datos_generales/configuraciones/eliminar_provincias/";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarProvincias();
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
    cerrarModalCrearModificarProvincia: function() {
      this.$modal.hide("crearModificarProvincia");
    },
    nuevaProvincia: function() {
      this.provinciaMod = null;
      this.abrirModalCrearModificarProvincia();
    },
    abrirModalCrearModificarProvincia: function() {
      this.$modal.show("crearModificarProvincia");
    },
    cargarProvincias: function() {
      let that = this;
      let url = "/datos_generales/configuraciones/cargar_provincias";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.provincias = response.data.provincias;
          that.paises = response.data.paises;

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