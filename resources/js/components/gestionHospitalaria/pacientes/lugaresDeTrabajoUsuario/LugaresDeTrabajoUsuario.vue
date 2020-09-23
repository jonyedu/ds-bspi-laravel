<template>
  <div class="row">
    <h1 class="mt-4">LUGARES DE TRABAJO USUARIO</h1>
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
      <crear-lugar-de-trabajo-usuario
        :usuarios="usuarios"
        :lugares-de-trabajo="lugaresDeTrabajo"
        :objeto-mod="objetoMod"
        @recargarDatos="cargarDatos"
        @cerrarModalCrear="cerrarModalCrear"
        ref="crearModal"
      ></crear-lugar-de-trabajo-usuario>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      usuarios: [],
      lugaresDeTrabajo: [],
      objetoMod: null,
      datos: [],
      columns: [
        {
          label: "Lugar De Trabajo",
          field: "nombre_lugar_de_trabajo",
          type: "String"
        },
        {
          label: "Usuario",
          field: "nombre_usuario",
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
      .pacientes.lugares_de_trabajo_usuario.lugares_de_trabajo_usuario.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarDatos();
    this.cargarLugaresDeTrabajo();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.lugares_de_trabajo_usuario.lugares_de_trabajo_usuario.nombre_formulario;
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
      let url = "/gestion_hospitalaria/pacientes/eliminar_lugar_de_trabajo_usuario/" + id;
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
    cargarLugaresDeTrabajo() {
      let that = this;
      let url = "/gestion_hospitalaria/pacientes/cargar_lugares_de_trabajo";
      axios
        .get(url)
        .then(function(response) {
          let datos = [];
          that.lugaresDeTrabajo = response.data.datos;
        })
        .catch(error => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    },
    cargarDatos: function() {
      let that = this;
      let url = "/gestion_hospitalaria/pacientes/cargar_lugares_de_trabajo_usuario";

      var loader = that.$loading.show();

      axios
        .get(url)
        .then(function(response) {
          axios
            .get("/datos_generales/usuarios/cargar_usuarios_campos")
            .then(function(response2) {
              let datos = [];
              datos = response.data.datos;
              let datosFinal = [];
              for (let i = 0; i < datos.length; i++) {
                let objeto = {};
                objeto.codigo = datos[i].LUGARTRABAJOUSUARIO_COD;
                objeto.codigo_lugar_de_trabajo = datos[i].LUGARESDETRABAJO_COD;
                objeto.codigo_usuario = datos[i].USER_ID;
                objeto.nombre_lugar_de_trabajo =
                  datos[i].lugar_de_trabajo.LUGARESDETRABAJO_NOM;
                objeto.nombre_usuario =
                  datos[i].usuario.US_NOM +
                  " " +
                  datos[i].usuario.US_APELL;
                objeto.observacion = datos[i].LUGARTRABAJOUSUARIO_OBS;
                datosFinal.push(objeto);
              }

              that.usuarios = response2.data.usuarios;
              that.datos = datosFinal;
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
