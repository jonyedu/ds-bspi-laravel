<template>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h1 class="mt-4">PÓLIZAS</h1>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12" v-if="esAdmisiones">
              <div class="float-right">
                <button class="btn btn-danger" @click="cerrarModalPrincipal()">Cerrar Modal</button>
              </div>
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevo()">Nuevo</button>
              </div>
            </div>
            <div class="col-md-12" v-else>
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
                :seleccionar-button="esAdmisiones"
                :columns-data="columns"
                :rows-data="datos"
                @handleModificarClick="modificar"
                @handleAnularClick="comprobarBeneficiariosPoliza"
                @handleSeleccionarClick="seleccionarPoliza"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearModal">
      <crear-poliza
        :usuarios="usuarios"
        :aseguradoras="aseguradoras"
        :objeto-mod="objetoMod"
        @recargarDatos="cargarDatos"
        @cerrarModalCrear="cerrarModalCrear"
        ref="crearModal"
      ></crear-poliza>
    </modal>
  </div>
</template>
<script>
export default {
  props: {
    esAdmisiones: {
      type: Boolean,
      default: false
    }
  },
  data: function() {
    return {
      usuarios: [],
      aseguradoras: [],
      objetoMod: null,
      datos: [],
      columns: [
        {
          label: "Aseguradora",
          field: "nombre_aseguradora",
          type: "String"
        },
        {
          label: "Usuario",
          field: "nombre_usuario",
          type: "String"
        },
        {
          label: "Poliza Numero",
          field: "poliza_numero",
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
      .pacientes.polizas.polizas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarDatos();
    this.cargarAseguradoras();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.polizas.polizas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    seleccionarPoliza(poliza) {
      this.$emit("handleSeleccionarClick", poliza);
      this.$emit("cerrarModalListaPoliza");
    },
    cerrarModalPrincipal() {
      this.$emit("cerrarModalListaPoliza");
    },
    modificar(value) {
      this.objetoMod = value;
      this.abrirModalCrear();
    },
    comprobarBeneficiariosPoliza(value) {
      let that = this;
      let url =
        "/gestion_hospitalaria/pacientes/cargar_beneficiarios_por_poliza/" +
        value.codigo;

      axios
        .get(url)
        .then(function(response) {
          let beneficiarios = response.data.datos;
          let mensaje = "";
          let title = "";
          if (beneficiarios.length > 0) {
            title = "¿La póliza posee beneficiarios, desea anularla?";
            mensaje = "Beneficiarios:\n";
            beneficiarios.forEach(beneficiario => {
              mensaje =
                mensaje +
                beneficiario.usuario_beneficiario.US_NOM +
                beneficiario.usuario_beneficiario.US_APELL +
                "\n";
            });
            var confirmacion = confirm(title + "\n" + mensaje);
            if (confirmacion) {
              that.anular(value.codigo);
            } else {
              return;
            }
          }
          that.anularConfirmacion(value);
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
      let url = "/gestion_hospitalaria/pacientes/eliminar_poliza/" + id;
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
    cargarAseguradoras() {
      let that = this;
      let url = "/gestion_hospitalaria/generalidades/cargar_aseguradoras_lista";
      axios
        .get(url)
        .then(function(response) {
          let datos = [];
          that.aseguradoras = response.data.datos;
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
      let url = "/gestion_hospitalaria/pacientes/cargar_polizas";

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
                objeto.codigo = datos[i].POLIZA_COD;
                objeto.codigo_aseguradora = datos[i].ASEGURADORA_COD;
                objeto.codigo_usuario = datos[i].USER_ID;
                objeto.nombre_aseguradora =
                  datos[i].aseguradora.ASEGURADORA_NOM;
                objeto.nombre_usuario =
                  datos[i].usuario_poliza.FULL_NAME_IDENTIFICATION;
                objeto.poliza_numero = datos[i].POLIZA_NUMERO;
                objeto.observacion = datos[i].POLIZA_OBS;
                objeto.nombre_poliza_mostrar =
                  datos[i].aseguradora.ASEGURADORA_NOM +
                  " - "+datos[i].usuario_poliza.FULL_NAME_IDENTIFICATION;
                
                objeto.pathPoliza = datos[i].POLIZA_DOCUMENTO;
                
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
