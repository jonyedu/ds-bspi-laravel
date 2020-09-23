<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12">
      <center>
        <h5 class="mt-4">Carga de Nuevo Archivo</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="form-group">
                  <label for="rol">Tipo *</label>
                  <v-select
                    v-model="selectedtipo"
                    :value="form.tipo"
                    :options="tipos"
                    label="display"
                    @input="setSelected"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.tipo !== ''"
                    id="tipoHelp"
                    class="text-danger"
                  >{{ errores.tipo[0] }}</small>
                </div>
              </div>

              <div class="col-lg-6 col-md-6">
                <div class="form-group">
                  <label for="nombre">Nombre del Documento *</label>
                  <input
                    type="text"
                    :class="errores.nombre === '' ? 'form-control':'form-control is-invalid'"
                    id="nombre_de_documento"
                    placeholder="Ingrese un nombre"
                    v-model="form.nombre"
                  />
                  <small
                    v-if="errores.nombre !== ''"
                    id="nombreHelp"
                    class="text-danger"
                  >{{ errores.nombre[0] }}</small>
                </div>
              </div>
              
              <div class="col-lg-6 col-md-6">
                <div class="form-group">
                  <label for="file">Cargar Archivo *</label>
                  <input
                    type="text" :readonly="true"  @click="$refs.fileElement.click()" 
                    :class="
                                            errores.file === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="file" class="bg-info text-white placeholderWhite" style="cursor:pointer" 
                    placeholder="Se admiten PDF's o Imágenes"
                    v-model="form.file"
                  />
                  <input type="file" ref="fileElement" 
                          @change="verificaDoc()" 
                          accept=".pdf, image/png, image/jpeg, image/jpg"
                          hidden>
                  <small
                    v-if="errores.file !== ''"
                    id="fileHelp"
                    class="text-danger"
                  >{{ errores.file[0] }}</small>
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="form-group">
                  <label for="observacion">Observación (Opcional)</label>
                  <input
                    type="text"
                    :class="'form-control'"
                    id="observacion"
                    placeholder="Ingrese su observación"
                    v-model="form.observacion"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardar($props.cargaCita,$props.cargaUsuario)"
                  >
                    Cargar Documento
                  </button>
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
  .placeholderWhite::-webkit-input-placeholder{
    color: #fff;
  }
</style>
<script>
export default {
  props:{
    codigoUsuario:{
      type: Number
    },
    codigoCita:{
      type: Number
    },
    cargaCita: {
      type: Boolean
    },
    cargaUsuario: {
      type: Boolean
    }
  },
  data: function() {
    return {
      sendForm: new FormData(),
      errores: {
        nombre: "",
        file: "",
        tipo: ""
      },
      form: {
        nombre: "",
        file: "",
        tipo: "",
        observacion: ""
      },
      tipos: [
        {
          display: "Cedula"
        },
        {
          display: "Contrato"
        },
        {
          display: "Pasaporte"
        },
        {
          display: "Licencia de Conducir"
        },
        {
          display: "Examenes Medicos"
        },
        {
          display: "Preescripciones"
        },
        {
          display: "Poliza"
        },
        {
          display: "Otros"
        }
      ],
      selectedtipo: "Cedula"
    };
  },
  mounted: function() {
    this.form.tipo = "Cedula";

    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .admistracion_de_citas.citas.crear_documentos.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .admistracion_de_citas.citas.crear_documentos.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    guardar(cita,usuario) {
      let that = this;
      var loader = that.$loading.show();
      try {
        let filee = that.$refs.fileElement.files[0];
        let blob = filee.slice(0, filee.size, that.$refs.fileElement.files[0].type); 
        let doc = new File([blob],that.form.nombre+filee.name.substr(filee.name.lastIndexOf('.')),{type: filee.type});
        that.sendForm.append("archivo", doc);
        const config = {
          headers: { "content-type": "multipart/form-data" }
        };

        if(this.form.nombre==""){
          throw("Error");
        }
        
        axios
          .post(
            "/gestion_hospitalaria/administracion_cita/guardar_documento",
            that.sendForm,
            config
          )
          .then(function(response) {
            loader.hide();
            if (response.data.path !== "") {
              that.form.file = response.data.path;
            }
            that.cargarRegistro(cita,usuario);
          })
          .catch(error => {
            if (!error.response) {
              // network error
              this.errorStatus = "Error: Network Error";
            } else {
              this.errorStatus = error;
            }
            loader.hide();
          });
      } catch (error){
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existen errores",
            text: "Complete los campos obligatorios."
          });
      }
    },
    verificaDoc(){
      this.form.file=this.$refs.fileElement.value.substr(this.$refs.fileElement.value.lastIndexOf('\\')+1);
      let ext = this.form.file.substr(this.form.file.lastIndexOf('.'))
      if(ext!=".pdf" && ext!=".jpg" && ext!=".png" && ext!=".jpeg" ){
        this.form.file="";
      }
      
    },
    limpiarForm() {
      this.errores = {
        nombre: "",
        file: "",
        tipo: ""
      };
      this.form = {
        nombre: "",
        file: "",
        tipo: "",
        observacion: ""
      };
      this.selectedtipo = "Cedula";
    },
    setSelected(value) {
      if (value !== null) {
        this.form.tipo = value.display;
      } else {
        this.form.tipo = "";
      }
    },

    cargarRegistro(cita, usuario){
      if(cita){
        this.InsertarRegistro('cita');
      }
      if(usuario){
        this.InsertarRegistro('usuario');
      }
    },

    InsertarRegistro: function(donde) {
      let that = this;
      that.errores = {
        nombre: "",
        file: "",
        tipo: ""
      };
      
      let url;
      if(donde=="cita"){
        url = "/gestion_hospitalaria/administracion_cita/crear_documento_cita";
      }else{
        url = "/gestion_hospitalaria/administracion_cita/crear_documento_usuario";
      }
      let mensaje = "Datos guardados correctamente.";

      var loader = that.$loading.show();
      let formuFinal=this.form;
      formuFinal.codigo_cita= this.$props.codigoCita;
      formuFinal.codigo_usuario= this.$props.codigoUsuario;
      formuFinal.tipo=formuFinal.tipo.substring(0,4).toUpperCase();
      axios
        .post(url, formuFinal)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarTabla");
          that.$emit("cerrarModalIngreso");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Datos actualizados correctamente."
          });
          that.limpiarForm();
        })
        .catch(error => {
          //Errores de validación
          if (error.response.status === 422) {
            that.errores.nombre =
              error.response.data.errors.nombre != undefined
                ? error.response.data.errors.nombre
                : "";
            that.errores.file =
              error.response.data.errors.file != undefined
                ? error.response.data.errors.file
                : "";
            that.errores.tipo =
              error.response.data.errors.tipo != undefined
                ? error.response.data.errors.tipo
                : "";
          }
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existen errores",
            text: error
          });
        });
    }
  }
};
</script>
