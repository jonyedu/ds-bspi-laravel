<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">BENEFICIARIO</h5>
      </center>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <label class="col-lg-12 col-md-12 col-sm-12 mt-2" for="usuario">Póliza</label>
               <div class="input-group col-lg-12 col-md-12 col-sm-12 mt-2">
                 
                    <input
                        class="form-control"
                        :readonly="true"
                        type="search"
                        value="search"
                        v-model="form.nombre_poliza_mostrar"
                        placeholder="Seleccione la poliza del paciente o cree una nueva poliza"
                        id="example-search-input"
                    />
                    <span class="input-group-append">
                        <button
                        :disabled="objetoMod !== null"
                        class="btn btn-outline-secondary"
                        type="button"
                        @click="mostrarModalPoliza()"
                        >
                        <i class="fa fa-search"></i>
                        </button>
                    </span>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                 <small
                    v-if="errores.codigo_poliza !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.codigo_poliza[0] }}</small>
              </div>
              <div class="col-lg-12col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Usuario Beneficiario</label>
                  <v-select
                    v-model="selectedUsuario"
                    :value="form.codigo_usuario_beneficiario"
                    :options="usuarios"
                    label="FULL_NAME_IDENTIFICATION"
                    @input="setSelectedUsuario"
                    v-bind:class="{ disabled: objetoMod!=null }"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.codigo_usuario_beneficiario !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.codigo_usuario_beneficiario[0] }}</small>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    :readonly="objetoMod !== null"
                    type="text"
                    :class="'form-control'"
                    id="observacion"
                    placeholder="Ingrese su observación"
                    v-model="form.observacion"
                  />
                </div>
              </div>
            </div>
            <div class="row" v-if="objetoMod==null">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizar()"
                  >Guardar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <modal
      :clickToClose="false"
      :width="'80%'"
      height="auto"
      :scrollable="true"
      name="listaPolizas"
    >
      <lista-polizas
        :esAdmisiones="true"
        @cerrarModalListaPoliza="cerrarModalListaPoliza"
        @handleSeleccionarClick ="seleccionarPoliza"
        ref="listaPolizas"
      ></lista-polizas>
    </modal>
  </div>
</template>
<style>
.disabled {
  pointer-events: none;
  color: #bfcbd9;
  cursor: not-allowed;
  background-image: none;
  background-color: #eef1f6;
  border-color: #d1dbe5;
}
</style>
<script>
export default {
  props: {
    objetoMod: {
      type: Object
    },
    usuarios: {
      type: Array
    },
    aseguradoras: {
      type: Array
    }
  },
  data: function() {
    return {
      errores: {
        codigo: "",
        codigo_poliza: "",
        codigo_usuario_beneficiario: "",
        observacion: ""
      },
      form: {
        codigo: "",
        codigo_poliza: "",
        nombre_poliza_mostrar:"",
        codigo_usuario_beneficiario: "",
        observacion: ""
      },

      selectedTipo: "CEDULA",
      selectedUsuario: "",
      selectedAseguradora: ""
    };
  },
  mounted: function() {
    if (this.$props.objetoMod !== null) {
      let objeto = this.$props.objetoMod;
      this.form = objeto;
      this.form.codigo = objeto.codigo;
      this.form.codigo_usuario_beneficiario = objeto.codigo_usuario_beneficiario;
      this.form.codigo_poliza= objeto.codigo_poliza;
      this.form.nombre_poliza_mostrar = objeto.nombre_poliza_mostrar;
      this.selectedUsuario = objeto.nombre_usuario_beneficiario;
    }
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.beneficiario_poliza.crear_beneficiario_poliza.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.beneficiario_poliza.crear_beneficiario_poliza.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    seleccionarPoliza(poliza){
      this.form.codigo_poliza=poliza.codigo;
      this.form.nombre_poliza_mostrar= poliza.nombre_poliza_mostrar;
    },
    cerrarModalListaPoliza() {
      this.$modal.hide("listaPolizas");
    },
    mostrarModalPoliza() {
      this.$modal.show("listaPolizas");
    },
    
    setSelectedUsuario(value) {
    
      if (value !== null) {
        this.form.codigo_usuario_beneficiario = value.id;
      } else {
        this.form.codigo_usuario_beneficiario = "";
      }
    },
    
    guardarActualizar: function() {
      let that = this;
      that.errores = {
        codigo: "",
        codigo_poliza: "",
        codigo_usuario_beneficiario: "",
        observacion: ""
      };

      let url = "";
      let mensaje = "";
      url = "/gestion_hospitalaria/pacientes/guardar_beneficiario_poliza";
      mensaje = "Datos guardados correctamente.";

      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarDatos");
          that.$emit("cerrarModalCrear");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Datos actualizados correctamente."
          });
        })
        .catch(error => {
          //Errores de validación
          let mensaje = error;
          if (error.response.status === 421) {
            mensaje = error.response.data.msg;
          }

          if (error.response.status === 422) {
        
            that.errores.codigo_poliza =
              error.response.data.errors.codigo_poliza != undefined
                ? error.response.data.errors.codigo_poliza
                : "";
            that.errores.codigo_usuario_beneficiario =
              error.response.data.errors.codigo_usuario_beneficiario != undefined
                ? error.response.data.errors.codigo_usuario_beneficiario
                : "";
          }
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existen errores",
            text: mensaje
          });
        });
    }
  }
};
</script>
