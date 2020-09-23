<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="input-group col-lg-12 col-md-12 col-sm-12">
                  <input
                    class="form-control py-2"
                    :readonly="true"
                    type="search"
                    value="search"
                    v-model="datos_paciente_mostrar"
                    placeholder="Seleccione el paciente"
                    id="example-search-input"
                  />
                  <span class="input-group-append">
                    <button
                      class="btn btn-outline-secondary"
                      type="button"
                      @click="mostrarModalUsuarios()"
                    >
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 mt-1">
                <div class="form-group">
                  <label for="poliza">Seguros del paciente</label>
                  <v-select
                    v-model="selectedPoliza"
                    :value="form.id_poliza"
                    :options="polizas"
                    label="display"
                    @input="setSelectedPoliza"
                  ></v-select>
                  <small
                    v-if="errores.id_poliza !== ''"
                    id="polizaHelp"
                    class="text-danger"
                  >{{ errores.id_poliza[0] }}</small>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="titular_afiliado">Titular/Afiliado</label>
                  <input
                    type="text"
                    :class="'form-control'"
                    :readonly="true"
                    id="titular_afiliado"
                    v-model="form.titular_afiliado"
                  />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 mt-1">
                <div class="form-group">
                  <label for="area">Especialidad</label>
                  <v-select
                    v-model="selectedEspecialidad"
                    :value="form.id_especialidad"
                    :options="especialidades"
                    label="display"
                    @input="setselectedEspecialidad"
                  ></v-select>
                  <small
                    v-if="errores.id_especialidad !== ''"
                    id="areaHelp"
                    class="text-danger"
                  >{{ errores.id_especialidad[0] }}</small>
                </div>
              </div>
              <div
                class="col-lg-4 col-md-4 col-sm-4 mt-1"
                v-if="
                                    form.id_especialidad != null && form.id_especialidad != ''
                                "
              >
                <div class="form-group">
                  <label for="medico">Medico</label>
                  <v-select
                    v-model="selectedMedico"
                    :value="form.id_doctor"
                    :options="medicos"
                    label="display"
                    @input="setSelectedMedico"
                  ></v-select>
                  <small
                    v-if="errores.id_doctor !== ''"
                    id="medicoHelp"
                    class="text-danger"
                  >{{ errores.id_doctor[0] }}</small>
                </div>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label">
                  <input
                    type="radio"
                    class="form-check-input"
                    value="S"
                    name="optradio"
                    v-model="acompanante"
                  />Viene Solo
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label">
                  <input
                    type="radio"
                    class="form-check-input"
                    value="A"
                    name="optradio"
                    v-model="acompanante"
                  />Viene Acompañado
                </label>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 mt-1" v-if="acompanante=='A'">
                <div class="form-group">
                  <label for="area">Acompañante</label>
                  <v-select
                    v-model="selectedAcompanante"
                    :value="form.id_acompanante"
                    :options="acompanantes"
                    label="display"
                    @input="setselectedAcompanante"
                  ></v-select>
                  <small
                    v-if="errores.id_especialidad !== ''"
                    id="areaHelp"
                    class="text-danger"
                  >{{ errores.id_especialidad[0] }}</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizar()"
                  >
                    {{
                    objetoMod === null
                    ? "Ingresar Emergencia"
                    : "Modificar Emergencia"
                    }}
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <modal
      :clickToClose="false"
      :width="'70%'"
      height="auto"
      :scrollable="true"
      name="listaUsuarios"
    >
      <lista-usuarios
        :es-paciente-consulta="true"
        @cerrarModalListaUsuario="cerrarModalListaUsuario"
        @seleccionarUsuario="seleccionarUsuario"
        ref="listaUsuarios"
      ></lista-usuarios>
    </modal>
  </div>
</template>
<script>
export default {
  props: {
    objetoMod: {
      type: Object
    },
    especialidades: {
      type: Array
    },
    acompanantes: {
      type: Array
    }
  },
  data: function() {
    return {
      existenErroresForm: false,
      polizas: [],
      medicos: [],
      selectedMedico: "",
      selectedEspecialidad: "",
      acompanante: "S",
      selectedAcompanante: "",
      selectedPoliza: "",
      errores: {
        nombre: "",
        id_poliza: "",
        id_especialidad: "",
        id_doctor: ""
      },
      form: {
        id_paciente: "",
        codigo_cita: "",
        titular_afiliado: "",
        id_poliza: "",
        id_especialidad: "",
        id_acompanante: "",
        id_doctor: 1288,
        estado: "E" //Emergencia
      },
      datos_paciente_mostrar: "",
      tipos: [
        {
          display: "PUBLICO",
          value: "PU"
        },
        {
          display: "PRIVADO",
          value: "PR"
        }
      ],
      selectedTipo: "Publico"
    };
  },
  mounted: function() {
    if (this.$props.objetoMod !== null) {
      //let objeto = this.$props.objetoMod;
      //this.form = objeto;
      //this.selectedTipo = objeto.ASEGURADORA_TIPO_NOM;
    }
    //this.form.tipo = "PU";
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
        .admistracion_de_citas.citas.ingreso_consulta_externa.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.aseguradoras.crear_aseguradoras.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    loadDoctors() {
      let getDoctor = {
        especialidad: this.form.id_especialidad
      };
      let that = this;
      let url =
        "/gestion_hospitalaria/personal_medico/cargar_medicos_emergencias";
      var loader = that.$loading.show();
      axios
        .post(url, getDoctor)
        .then(function(response) {
          let doctores = [];

          for (let i = 0; i < response.data.length; i++) {
            let objeto = {
              display: response.data[i].user.US_NOM,
              value: response.data[i].USER_ID
            };
            doctores.push(objeto);
          }
          that.medicos = doctores;

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
    },
    setSelectedMedico(value) {
      if (value !== null) {
        this.form.id_doctor = value.value;
      } else {
        this.form.id_doctor = "";
      }
    },
    validarFormulario() {
      if (
        this.form.id_paciente == "" ||
        this.form.id_paciente == null ||
        this.form.id_paciente == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione un usuario"
        });
        this.existenErroresForm = true;
        return;
      }
      if (
        this.form.id_poliza == "" ||
        this.form.id_poliza == null ||
        this.form.id_poliza == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione el seguro del usuario"
        });
        this.existenErroresForm = true;
        return;
      }
      if (
        this.form.id_especialidad == "" ||
        this.form.id_especialidad == null ||
        this.form.id_especialidad == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione una especialidad"
        });
        this.existenErroresForm = true;
        return;
      }
      if (this.acompanante == "A") {
        if (
          this.form.id_acompanante == "" ||
          this.form.id_acompanante == null ||
          this.form.id_acompanante == undefined
        ) {
          this.$swal({
            icon: "info",
            title: "Existen validaciones del formulario que debe completar",
            text: "Seleccione un acompañante"
          });
          this.existenErroresForm = true;
          return;
        }
      }
      if (
        this.form.id_doctor == "" ||
        this.form.id_doctor == null ||
        this.form.id_doctor == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione un Medico"
        });
        this.existenErroresForm = true;
        return;
      }
    },
    setSelectedPoliza(value) {
      if (value !== null) {
        this.form.id_poliza = value.value;
        this.form.titular_afiliado = value.titular;
      } else {
        this.form.id_poliza = "";
        this.form.titular_afiliado = "";
      }
    },
    setselectedAcompanante(value) {
      if (value !== null) {
        this.form.id_acompanante = value.value;
      } else {
        this.form.id_acompanante = "";
      }
    },
    setselectedEspecialidad(value) {
      if (value !== null) {
        this.form.id_especialidad = value.value;
        this.loadDoctors();
      } else {
        this.form.id_especialidad = "";
      }
    },

    seleccionarUsuario(usuario) {
      let cedulaObject = usuario.identificaciones.find(
        element => element.ID_COD === "CEDULA"
      );
      if (cedulaObject == null || cedulaObject == undefined) {
        cedulaObject = usuario.identificaciones.find(
          element => element.ID_COD === "PASAPORTE "
        );
      }
      if (cedulaObject == null || cedulaObject == undefined) {
        cedulaObject = usuario.identificaciones.find(
          element => element.ID_COD === "17-DIGITOS "
        );
      }
      this.datos_paciente_mostrar =
        cedulaObject.USID_CODIGO +
        " - " +
        usuario.US_NOM +
        " " +
        usuario.US_APELL;
      // Se procede a cargar los seguros del usuario
      let polizas = [];
      for (let i = 0; i < usuario.polizas.length; i++) {
        polizas.push({
          display: usuario.polizas[i].aseguradora.ASEGURADORA_NOM,
          value: usuario.polizas[i].POLIZA_COD,
          titular: usuario.polizas[i].POLIZA_TITULAR_NOM
        });
      }
      this.polizas = polizas;
      this.form.id_paciente = usuario.id;
      this.$modal.hide("listaUsuarios");
    },
    cerrarModalListaUsuario() {
      this.$modal.hide("listaUsuarios");
    },
    mostrarModalUsuarios() {
      this.$modal.show("listaUsuarios");
    },
    setSelected(value) {
      if (value !== null) {
        this.form.tipo = value.value;
      } else {
        this.form.tipo = "";
      }
    },
    guardarActualizar: function() {
      this.existenErroresForm = false;
      this.validarFormulario();
      if (this.existenErroresForm) {
        return;
      }
      let that = this;
      that.errores = {
        nombre: "",
        id_poliza: "",
        id_especialidad: ""
      };

      let url = "";
      let mensaje = "";
      //if (this.$props.objetoMod !== null) {
      url = "/gestion_hospitalaria/administracion_cita/crear_cita";
      mensaje = "Datos actualizados correctamente.";
      //}
      //else {
      //   url = "/gestion_hospitalaria/generalidades/guardar_aseguradora";
      //   mensaje = "Datos guardados correctamente.";
      // }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarDatos");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Datos actualizados correctamente."
          });
        })
        .catch(error => {
          //Errores de validación
          if (error.response.status === 422) {
            // that.errores.nombre =
            //   error.response.data.errors.nombre != undefined
            //     ? error.response.data.errors.nombre
            //     : "";
            // that.errores.nombre_contacto =
            //   error.response.data.errors.nombre_contacto != undefined
            //     ? error.response.data.errors.nombre_contacto
            //     : "";
            // that.errores.telefono_contacto =
            //   error.response.data.errors.telefono_contacto != undefined
            //     ? error.response.data.errors.telefono_contacto
            //     : "";
            // that.errores.email_contacto =
            //   error.response.data.errors.email_contacto != undefined
            //     ? error.response.data.errors.email_contacto
            //     : "";
            // that.errores.web_page =
            //   error.response.data.errors.web_page != undefined
            //     ? error.response.data.errors.web_page
            //     : "";
            // that.errores.tipo =
            //   error.response.data.errors.tipo != undefined
            //     ? error.response.data.errors.tipo
            //     : "";
            // that.errores.observacion =
            //   error.response.data.errors.observacion != undefined
            //     ? error.response.data.errors.observacion
            //     : "";
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
