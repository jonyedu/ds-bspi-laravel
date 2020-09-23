<template>
  <div class="row">
    <h1 class="mt-2">Tipo de Movimiento</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoTipoMovimiento()">Nuevo</button>
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
                :rows-data="tipoMovimiento"
                @handleModificarClick="modificarTipoMovimiento"
                @handleAnularClick="anularTipoMovimientoConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearTipoMovimiento">
      <crear-tipo-movimiento
        :tipo-movimiento-mod="tipoMovimientoMod"
        @recargarTipoMovimiento="cargarTipoMovimiento"
        @cerrarModalCrearTipoMovimiento="cerrarModalCrearTipoMovimiento"
        ref="crearTipoMovimiento"
      ></crear-tipo-movimiento>
    </modal>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      tipoMovimientoMod: null,
      url_data: "",
      errores: {},
      form: {},
      tipoMovimiento: [],
      columns: [
        {
          label: "Nombre",
          field: "TIPOMOVIMIENTO_NOMBRE",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "TIPOMOVIMIENTO_OBS",
          type: "String"
        }
        ,
        {
          label: "Abreviatura",
          field: "TIPOMOVIMIENTO_ABREVIATURA",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    this.cargarTipoMovimiento();
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
    modificarTipoMovimiento(value) {
      this.tipoMovimientoMod = value;
      this.abrirModalCrearTipoMovimiento();
    },
    anularTipoMovimientoConfirmacion(value) {
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
          that.anularTipoMovimiento(value.TIPOMOVIMIENTO_COD);
        }
      });
    },
    anularTipoMovimiento(id) {
      let that = this;
      let url = "/gestion_hospitalaria/administracion_farmacia/eliminar_tipo_movimiento/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          loader.hide();
          that.cargarTipoMovimiento();
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
    cerrarModalCrearTipoMovimiento: function() {
      this.$modal.hide("crearTipoMovimiento");
      this.cargarTipoMovimiento();
    },
    nuevoTipoMovimiento: function() {
      this.tipoMovimientoMod = null;
      this.abrirModalCrearTipoMovimiento();
    },
    abrirModalCrearTipoMovimiento: function() {
      this.$modal.show("crearTipoMovimiento");
    },
    cargarTipoMovimiento: function() {
      let that = this;
      let url = "/gestion_hospitalaria/administracion_farmacia/cargar_tipo_movimiento";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.tipoMovimiento = response.data.tipoMovimiento;
          loader.hide();

          let tipoMovimiento = [];
          for (let i = 0; i < response.data.tipoMovimiento.length; i++) {
            let objeto = {
              TIPOMOVIMIENTO_COD: response.data.tipoMovimiento[i].TIPOMOVIMIENTO_COD,
              TIPOMOVIMIENTO_NOMBRE: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.tipoMovimiento[i].TIPOMOVIMIENTO_NOMBRE),
              TIPOMOVIMIENTO_OBS: that.$funcionesGlobales.toCapitalFirstWords(response.data.tipoMovimiento[i].TIPOMOVIMIENTO_OBS),
              TIPOMOVIMIENTO_ABREVIATURA: response.data.tipoMovimiento[i].TIPOMOVIMIENTO_ABREVIATURA,
            }
            tipoMovimiento.push(objeto);                       
          }
          that.tipoMovimiento = tipoMovimiento;
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
