<template>
  <div class="row">
    <h1 class="mt-2">Categoría</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoCategoria()">Nuevo</button>
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
                :rows-data="categoria"
                @handleModificarClick="modificarCategoria"
                @handleAnularClick="anularCategoriaConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearCategoria">
      <crear-categoria
        :categoria-mod="categoriaMod"
        @recargarCategoria="cargarCategoria"
        @cerrarModalCrearCategoria="cerrarModalCrearCategoria"
        ref="crearCategoria"
      ></crear-categoria>
    </modal>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      categoriaMod: null,
      url_data: "",
      errores: {},
      form: {},
      categoria: [],
      columns: [
        {
          label: "Nombre",
          field: "CATEGORIA_NOM",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "CATEGORIA_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    this.cargarCategoria();
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
    modificarCategoria(value) {
      this.categoriaMod = value;
      this.abrirModalCrearCategoria();
    },
    anularCategoriaConfirmacion(value) {
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
          that.anularCategoria(value.CATEGORIA_COD);
        }
      });
    },
    anularCategoria(id) {
      let that = this;
      let url = "/gestion_hospitalaria/administracion_farmacia/eliminar_categoria/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          loader.hide();
          that.cargarCategoria();
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
    cerrarModalCrearCategoria: function() {
      this.$modal.hide("crearCategoria");
      this.cargarCategoria();
    },
    nuevoCategoria: function() {
      this.categoriaMod = null;
      this.abrirModalCrearCategoria();
    },
    abrirModalCrearCategoria: function() {
      this.$modal.show("crearCategoria");
    },
    cargarCategoria: function() {
      let that = this;
      let url = "/gestion_hospitalaria/administracion_farmacia/cargar_categoria";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let categoria = [];
          for (let i = 0; i < response.data.categoria.length; i++) {
            let objeto = {
              CATEGORIA_COD: response.data.categoria[i].CATEGORIA_COD,
              CATEGORIA_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.categoria[i].CATEGORIA_NOM),
              CATEGORIA_OBS: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.categoria[i].CATEGORIA_OBS)
            }
            categoria.push(objeto);                       
          }
          that.categoria = categoria;
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
