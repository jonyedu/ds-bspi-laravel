<template>
  <div class="row">
    <h1 class="mt-4">GESTIONES EN EL SISTEMA</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoCargo()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :titulo-data="'Gestiones en el sistema'"
                :columns-data="columns"
                :rows-data="gestiones"
                @handleModificarClick="modificarGestion"
                @handleAnularClick="anularGestionConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearGestion">
      <crear-gestiones
        :gestion-mod="gestionMod"
        @recargarGestiones="cargarGestiones"
        @cerrarModalCrearGestion="cerrarModalCrearGestion"
        ref="crearGestion"
      ></crear-gestiones>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      gestionMod: null,
      gestiones: [],
      columns: [
        {
          label: "Código",
          field: "GESTION_COD",
          type: "String"
        },
        {
          label: "Nombre",
          field: "GESTION_NOM",
          type: "String"
        },
        {
          label: "Ruta",
          field: "GESTION_RUTA",
          type: "String"
        },
        {
          label: "Activo",
          field: "GESTION_ACTIVO",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "GESTION_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.gestiones
      .datos.gestiones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarGestiones();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.gestiones
      .datos.gestiones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarGestion(value) {
      this.gestionMod = value;
      this.abrirModalCrearGestion();
    },
    anularGestionConfirmacion(value) {
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
          that.anularGestion(value.GESTION_COD);
        }
      });
    },
    anularGestion(id) {
      let that = this;
      let url = "/datos_generales/gestiones/eliminar_gestion/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          that.cargarGestiones();
          loader.hide();
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
    cerrarModalCrearGestion: function() {
      this.$modal.hide("crearGestion");
    },
    nuevoCargo: function() {
      this.gestionMod = null;
      this.abrirModalCrearGestion();
    },
    abrirModalCrearGestion: function() {
      this.$modal.show("crearGestion");
    },
    cargarGestiones: function() {
      let that = this;
      let url = "/datos_generales/gestiones/cargar_gestiones";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let gestiones = [];
          gestiones = response.data.gestiones;

          that.gestiones = gestiones;
          loader.hide();
        })
        .catch(error => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
          loader.hide();
        });
    }
  }
};
</script>
