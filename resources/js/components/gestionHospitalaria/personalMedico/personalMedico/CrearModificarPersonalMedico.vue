<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Personal Medico</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="cargo">Trabajadores BSPI</label>
                  <v-select
                    v-model="selectedUsuario"
                    :value="form.USER_COD"
                    :options="usuarios"
                    label="USER_NOM"
                    @input="setSelectedUser"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.usuario !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.usuario[0] }}</small>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="cargo">Tipo De Personal Medico</label>
                  <v-select
                    v-model="selectedTipo"
                    :value="form.TIPOTRABAJADOR_COD"
                    :options="tipos"
                    label="TIPOTRABAJADOR_NOM"
                    @input="setSelectedTipo"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.tipo !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.tipo[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="fecha_cita">Fecha de Contratacion</label>
                  <input
                    type="date"
                    :class="
                                            errores.fecha_contrato === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="fecha_cita"
                    placeholder="Seleccione la fecha de cita"
                    v-model="form.fecha_contrato"
                  />
                  <small
                    v-if="errores.fecha_contrato !== ''"
                    id="fecha_citaHelp"
                    class="text-danger"
                  >{{ errores.fecha_contrato[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    type="text"
                    :class="
                                            errores.observacion === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="observacion"
                    placeholder="Ingrese su observación"
                    v-model="form.observacion"
                  />
                  <small
                    v-if="errores.observacion !== ''"
                    id="observacionHelp"
                    class="text-danger"
                  >{{ errores.observacion[0] }}</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <input type="file" ref="file" @change="onFileSelected" style="display: none" />
                <button
                  type="button"
                  class="btn btn-info btn-sm btn-block mb-2"
                  @click="$refs.file.click()"
                >Cargar Archivo contraro</button>
                <pdf-preview :blobType="blobType" :esTabla="false" :url="(this.form.pathContrato=='' || pdfContrato!='')?URLpreview:this.form.pathContrato" :size="['100%']"></pdf-preview>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button type="button" class="btn btn-success btn-block" @click="guardar()">
                    {{
                    personalMod === null
                    ? "Guardar"
                    : "Modificar"
                    }}
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
<script>
export default {
  props: {
    personalMod: {
      type: Object
    },
    tipos: {
      type: Array
    },
    usuarios: {
      type: Array
    }
  },
  data: function() {
    return {
      blobType: '',
      URLpreview: '',
      errores: {
        usuario: "",
        tipo: "",
        observacion: "",
        fecha_contrato: ""
      },
      form: {
        tipo_cod: "",
        nombre: "",
        user_cod: "",
        observacion: "",
        pathContrato: "",
        fecha_contrato: "",
        personalMedico_cod: ""
      },
      sendForm: new FormData(),
      pdfContrato: "",
      activos: [
        {
          id_tipo: "A"
        },
        {
          id_tipo: "I"
        }
      ],
      selectedTipo: "",
      selectedActivo: "A",
      selectedUsuario: ""

      //organismosA: [],
      //cargosA: [],
      //usuariosA: []
    };
  },
  mounted: function() {
    this.form.activo = "A";

    if (this.$props.personalMod !== null) {
      var personalMedico = this.$props.personalMod;

      this.form.personalMedico_cod =
        personalMedico.TRABAJADORESPERSONALSALUD_COD;

      this.form.user_cod = personalMedico.USER_ID;
      this.selectedUsuario = personalMedico.USER_NOM;

      this.form.tipo_cod = personalMedico.TIPOTRABAJADOR_COD;

      this.selectedTipo = personalMedico.TIPOTRABAJADOR_NOM;

      this.form.fecha_contrato =
        personalMedico.TRABAJADORESPERSONALSALUD_FECHA_CONTRATO;

      this.form.observacion = personalMedico.TRABAJADORESPERSONALSALUD_OBS;
      this.form.fecha_contrato =
        personalMedico.TRABAJADORESPERSONALSALUD_FECHA_CONTRATO;
      this.form.pathContrato =
        personalMedico.TRABAJADORESPERSONALSALUD_CONTRATO_PDF;

      //this.form.activo = habitacion.HABITACION_LOGIC_ESTADO;
    }
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.personalMedico.crear_modificar_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.personalMedico.crear_modificar_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    onFileSelected(event) {
      if (event.target.files[0]["type"] === "application/pdf" || event.target.files[0]["type"] === "image/jpg" || event.target.files[0]["type"] === "image/png" || event.target.files[0]["type"] === "image/jpeg") {
        this.pdfContrato = event.target.files[0];
        this.URLpreview=window.URL.createObjectURL(this.pdfContrato);
        if(this.pdfContrato["type"] === "application/pdf"){
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
    limpiarForm() {
      this.errores = {
        usuarios: "",
        tipo: "",
        observacion: ""
      };
      this.form = {
        user_cod: "",
        tipo_cod: "",
        observacion: ""
      };

      this.selectedUser = "";
      this.selectedTipo = "";
    },
    setSelectedUser(value) {
      if (value !== null) {
        this.form.user_cod = value.USER_COD;
      } else {
        this.form.user_cod = "";
      }
    },
    setSelectedTipo(value) {
      if (value !== null) {
        this.form.tipo_cod = value.TIPOTRABAJADOR_COD;
      } else {
        this.form.tipo_cod = "";
      }
    },
    guardar() {
      let that = this;
      that.sendForm.append("pdfContrato", that.pdfContrato);

      const config = {
        headers: { "content-type": "multipart/form-data" }
      };

      var loader = that.$loading.show();
      axios
        .post(
          "/gestion_hospitalaria/personalMedico/guardar_contrato_personal_medico",
          that.sendForm,
          config
        )
        .then(function(response) {
          loader.hide();
          if (response.data.pathContrato !== "") {
            that.form.pathContrato = response.data.pathContrato;
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

    guardarActualizar: function(pathContrato) {
      let that = this;
      that.errores = {
        nombre: "",
        hospital: "",
        observacion: ""
      };
      let url = "";
      let mensaje = "";

      if (this.$props.personalMod !== null) {
        url = "/gestion_hospitalaria/personalMedico/modificar_personal_medico";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/personalMedico/guardar_personal_medico";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarPersonalMedico");
          that.$emit("cerrarModalCrearPersonalMedico");
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

            that.errores.hospital =
              error.response.data.errors.hospital != undefined
                ? error.response.data.errors.hospital
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
