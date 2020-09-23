<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">PÓLIZA</h5>
      </center>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="nombre">Póliza Número</label>
                  <input
                    type="text"
                    :readonly="objetoMod !== null"
                    :class="
                                            errores.poliza_numero === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="poliza_numero"
                    placeholder="Ingrese un número de poliza"
                    v-model="form.poliza_numero"
                  />
                  <small
                    v-if="errores.poliza_numero !== ''"
                    id="poliza_numeroHelp"
                    class="text-danger"
                  >{{ errores.poliza_numero[0] }}</small>
                </div>
              </div>

              <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <v-select
                    v-model="selectedUsuario"
                    :value="form.codigo_usuario"
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
                    v-if="errores.codigo_usuario !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.codigo_usuario[0] }}</small>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Aseguradora</label>
                  <v-select
                    v-model="selectedAseguradora"
                    :value="form.codigo_aseguradora"
                    :options="aseguradoras"
                    label="nombre"
                    @input="setSelectedAseguradora"
                    v-bind:class="{ disabled: objetoMod!=null }"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.codigo_aseguradora !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.codigo_aseguradora[0] }}</small>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
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

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div>
                  <input type="file" ref="file" @change="onFileSelected" style="display: none" />
                  <button v-if="objetoMod==null" type="button" class="btn btn-info btn-sm btn-block" @click="$refs.file.click()">
                    <i class="fas fa-file-pdf"></i> Cargar Archivo Póliza
                  </button>
                  <pdf-preview :blobType="blobType" :esTabla="false" :url="(this.form.pathPoliza=='' || pdfPoliza!='')?URLpreview:this.form.pathPoliza" :size="['100%']"></pdf-preview>
                </div>
              </div>
            </div>
            <div class="row" v-if="objetoMod==null">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button type="button" class="btn btn-success btn-block" @click="guardar()">Guardar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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
      blobType: '',
      URLpreview: '',
      errores: {
        codigo: "",
        codigo_aseguradora: "",
        codigo_usuario: "",
        poliza_numero: "",
        observacion: ""
      },
      sendForm: new FormData(),
      pdfPoliza: "",
      form: {
        codigo: "",
        codigo_aseguradora: "",
        codigo_usuario: "",
        poliza_numero: "",
        observacion: "",
        pathPoliza: ""
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
      this.form.codigo_aseguradora = objeto.codigo_aseguradora;
      this.form.codigo_usuario = objeto.codigo_usuario;
      this.form.poliza_numero = objeto.poliza_numero;
      this.selectedUsuario = objeto.nombre_usuario;
      this.selectedAseguradora = objeto.nombre_aseguradora;
    }
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.polizas.crear_poliza.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.polizas.crear_poliza.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    onFileSelected(event) {
      if (event.target.files[0]["type"] === "application/pdf" || event.target.files[0]["type"] === "image/jpg" || event.target.files[0]["type"] === "image/png" || event.target.files[0]["type"] === "image/jpeg") {
        this.pdfPoliza = event.target.files[0];
        this.URLpreview=window.URL.createObjectURL(this.pdfPoliza);
        if(this.pdfPoliza["type"] === "application/pdf"){
          this.blobType='pdf'
        }else{
          this.blobType='image'
        }
      } else {
        this.$swal({
          icon: "error",
          title: "Error de Archivo",
          text: "Solo archivos de formato: .pdf o de imagen!"
        });
      }
    },
    setSelectedAseguradora(value) {
      if (value !== null) {
        this.form.codigo_aseguradora = value.codigo;
      } else {
        this.form.codigo_aseguradora = "";
      }
    },
    setSelectedUsuario(value) {
      if (value !== null) {
        this.form.codigo_usuario = value.id;
      } else {
        this.form.codigo_usuario = "";
      }
    },
    guardar() {
      let that = this;
      that.sendForm.append("pdfPoliza", that.pdfPoliza);

      const config = {
        headers: { "content-type": "multipart/form-data" }
      };

      var loader = that.$loading.show();
      axios
        .post(
          "/gestion_hospitalaria/pacientes/guardar_documento_poliza",
          that.sendForm,
          config
        )
        .then(function(response) {
          loader.hide();
          if (response.data.pathPoliza !== "") {
            that.form.pathPoliza = response.data.pathPoliza;
          }

          that.guardarActualizar();
        })
        .catch(error => {
          if (!error.response) {
            // network error
            this.errorStatus = "Error: Network Error";
          } else {
            this.errorStatus = error.response.data.message;
          }
          loader.hide();
        });
    },

    guardarActualizar: function() {
      let that = this;
      that.errores = {
        codigo: "",
        codigo_aseguradora: "",
        codigo_usuario: "",
        poliza_numero: "",
        observacion: ""
      };

      let url = "";
      let mensaje = "";

      url = "/gestion_hospitalaria/pacientes/guardar_poliza";
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
            that.errores.poliza_numero =
              error.response.data.errors.poliza_numero != undefined
                ? error.response.data.errors.poliza_numero
                : "";

            that.errores.codigo_aseguradora =
              error.response.data.errors.codigo_aseguradora != undefined
                ? error.response.data.errors.codigo_aseguradora
                : "";
            that.errores.codigo_usuario =
              error.response.data.errors.codigo_usuario != undefined
                ? error.response.data.errors.codigo_usuario
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
