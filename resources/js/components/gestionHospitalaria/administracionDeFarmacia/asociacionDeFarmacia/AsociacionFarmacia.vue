<template>
  <div class="row">
    <h1 class="mt-2">Asociación de Farmacia</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoAsociacionFarmacia()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :info-button="false"
                :columns-data="columns"
                :rows-data="asociacionFarmacia"
                @handleModificarClick="modificarAsociacionFarmacia"
                @handleAnularClick="anularAsociacionFarmaciaConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearAsociacionFarmacia">
      <crear-asociacion-farmacia
        :asociacion-farmacia-mod="asociacionFarmaciaMod"
        @recargar-asociacion-farmacia="cargarAsociacionFarmacia"
        @cerrarModalCrearAsociacionFarmacia="cerrarModalCrearAsociacionFarmacia"
        ref="crearAsociacionFarmacia"
      ></crear-asociacion-farmacia>
    </modal>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      asociacionFarmaciaMod: null,
      url_data: "",
      errores: {},
      form: {},
      asociacionFarmacia: [],
      columns: [
        {
          label: "Nombre del Hospital",
          field: "HOSPITAL_NOM",
          type: "String"
        },
        {
          label: "Nombre de la Farmacia",
          field: "FARMACIA_NOM",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    this.cargarAsociacionFarmacia();
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organizacion_bspi.organizacion_bspi.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organizacion_bspi.organizacion_bspi.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarAsociacionFarmacia(value) {
      this.asociacionFarmaciaMod = value;
      this.abrirModalCrearAsociacionFarmacia();
    },
    anularAsociacionFarmaciaConfirmacion(value) {
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
          that.anularAsociacionFarmacia(value.HOSP_FARM_COD);
        }
      });
    },
    anularAsociacionFarmacia(id) {
      let that = this;
      let url = "/gestion_hospitalaria/administracion_farmacia/eliminar_asociacion_farmacia/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          loader.hide();
          that.cargarAsociacionFarmacia();
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
    cerrarModalCrearAsociacionFarmacia: function() {
      this.$modal.hide("crearAsociacionFarmacia");
      this.cargarAsociacionFarmacia();
    },
    nuevoAsociacionFarmacia: function() {
      this.asociacionFarmaciaMod = null;
      this.abrirModalCrearAsociacionFarmacia();
    },
    abrirModalCrearAsociacionFarmacia: function() {
      this.$modal.show("crearAsociacionFarmacia");
    },
    cargarAsociacionFarmacia: function() {
      let that = this;
      let url = "/gestion_hospitalaria/administracion_farmacia/cargar_asociacion_farmacia";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let asociacionFarmacia = [];
          for (let i = 0; i < response.data.asociacionFarmacia.length; i++) {
            let objeto = {
              HOSP_FARM_COD: response.data.asociacionFarmacia[i].HOSP_FARM_COD,
              HOSPITAL_COD: response.data.asociacionFarmacia[i].hospital.HOSPITAL_COD,
              HOSPITAL_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.asociacionFarmacia[i].hospital.HOSPITAL_NOM),
              FARMACIA_COD: response.data.asociacionFarmacia[i].farmacia.FARMACIA_COD,
              FARMACIA_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.asociacionFarmacia[i].farmacia.FARMACIA_NOM),
            }
            asociacionFarmacia.push(objeto);
          }
          that.asociacionFarmacia = asociacionFarmacia;
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
