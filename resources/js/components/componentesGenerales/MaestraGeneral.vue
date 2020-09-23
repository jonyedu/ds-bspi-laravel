<template>
  <div class="row">
    <h1 class="mt-4">{{ titulo }}</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevo()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3" >
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columnas"
                :rows-data="datos"
                @handleModificarClick="modificar"
                @handleAnularClick="anularConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crear">
      <crear-general
        :activo-field="activoFieldC"
        :dato-mod="datoMod"
        :url-guardar="urlGuardar"
        :url-modificar="urlModificar"
        @recargarDatos="cargarDatos"
        @cerrarModalCrear="cerrarModalCrear"
        ref="crear"
      ></crear-general>
    </modal>
  </div>
</template>
<script>
export default {
  props: {
    activoField:{
      type:Boolean,
      default:true
    },
    columnas:{
      type:Array,
      default:[
        {
          label: "Nombre",
          field: "nombre",
          type: "String"
        },
        {
          label: "Activo",
          field: "activo",
          type: "String",
        },
        {
          label: "Observación",
          field: "observacion",
          type: "String"
        }
      ]
    },
    titulo: {
      type: String
    },
    urlGuardar: {
      type: String
    },
    urlModificar: {
      type: String
    },
    urlEliminar: {
      type: String
    },
    urlCargar: {
      type: String
    }
  },
  data: function() {
    return {
      datoMod: null,
      datos: [],
      activoFieldC:false
    };
  },
  mounted: function() {
   
    this.cargarDatos();
  },
  beforeDestroy: function() {},
  methods: {
    modificar(value) {
      this.datoMod = value;
      this.abrirModalCrear();
    },
    anularConfirmacion(value) {
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
          that.anular(value.codigo);
        }
      });
    },
    anular(id) {
      let that = this;
      let url = that.$props.urlEliminar + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          that.cargarDatos();
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
    cerrarModalCrear: function() {
      this.$modal.hide("crear");
    },
    nuevo: function() {
      this.datoMod = null;
      this.abrirModalCrear();
    },
    abrirModalCrear: function() {
      this.$modal.show("crear");
    },
    cargarDatos: function() {
      let that = this;
      let url = that.$props.urlCargar;
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let datos = [];
          datos = response.data.datos;

          that.datos = datos;
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
