<template>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h1 class="mt-4">Parentesco</h1>
    </div>
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
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="datos"
                @handleModificarClick="modificar"
                @handleAnularClick="anularConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearModal">
      <crear-parentesco
        :tipos-parentescos="tiposParentescos"
        :objeto-mod="objetoMod"
        @recargarDatos="cargarDatos"
        @cerrarModalCrear="cerrarModalCrear"
        ref="crearModal"
      ></crear-parentesco>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      objetoMod: null,
      datos: [],
      tiposParentescos: [],
      columns: [
        {
          label: "Nombre",
          field: "nombre",
          type: "String"
        },
        {
          label: "Apellido",
          field: "apellido",
          type: "String"
        },
        {
          label: "Tipo Identificación",
          field: "TIPO_IDENTIFICACION_NOM",
          type: "String"
        },
        {
          label: "Identificación",
          field: "identificacion",
          type: "String"
        },
        {
          label: "Observación",
          field: "observacion",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.parentescos.parentescos.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarDatos();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.parentescos.parentescos.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificar(value) {
      this.objetoMod = value;
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
      let url = "/gestion_hospitalaria/pacientes/eliminar_parentesco/" + id;
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
      this.$modal.hide("crearModal");
    },
    nuevo: function() {
      this.objetoMod = null;
      this.abrirModalCrear();
    },
    abrirModalCrear: function() {
      this.$modal.show("crearModal");
    },
    
    cargarDatos: function() {
      let that = this;
      let url = "/gestion_hospitalaria/pacientes/cargar_parentescos";

      var loader = that.$loading.show();

      axios
        .get(url)
        .then(function(response) {
              let datos = [];
              for (let i = 0; i < response.data.datos.length; i++) {
                let objeto = {
                  codigo: response.data.datos[i].codigo,
                  nombre: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.datos[i].nombre),
                  apellido: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.datos[i].apellido),
                  identificacion: response.data.datos[i].identificacion,
                  tipo_identificacion: response.data.datos[i].tipo_identificacion,
                  observacion: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.datos[i].observacion),
                  TIPO_IDENTIFICACION_NOM: response.data.datos[i].TIPO_IDENTIFICACION_NOM,
                }
                datos.push(objeto);                       
              }
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
