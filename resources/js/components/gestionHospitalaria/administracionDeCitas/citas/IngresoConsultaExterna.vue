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
                    class="form-control"
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
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="fecha_cita">Fecha de cita</label>
                  <input
                    type="date"
                    :class="
                                            errores.fecha_cita === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="fecha_cita"
                    placeholder="Seleccione la fecha de cita"
                    v-model="fecha_cita"
                  />
                  <small
                    v-if="errores.fecha_cita !== ''"
                    id="fecha_citaHelp"
                    class="text-danger"
                  >{{ errores.fecha_cita[0] }}</small>
                </div>
              </div>
              <div
                class="col-lg-8 col-md-8 col-sm-12 mt-4"
                v-if="form.fecha_cita!='' && form.fecha_cita!=null"
              >
                <label>Desde</label>
                <v-time
                  @change="changeTimeInicio"
                  v-model="form.hora_inicio"
                  placeholder="Hora inicio"
                ></v-time>
                <span>Hasta</span>
                <v-time
                  @change="changeTimeCierre"
                  v-model="form.hora_cierre"
                  placeholder="Hora Fin"
                ></v-time>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 mt-1" v-if="horas_validas">
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
              <div class="col-lg-4 col-md-4 col-sm-12" v-if="acompanante=='A'">
                <div class="form-group">
                  <label for="acompanante">Acompañante</label>
                  <v-select
                    v-model="selectedAcompanante"
                    :value="form.id_acompanante"
                    :options="acompanantes"
                    label="display"
                    @input="setselectedAcompanante"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.id_acompanante !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.id_acompanante[0] }}</small>
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
                    ? "Ingresar Consulta Externa"
                    : "Modificar Consulta Externa"
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
  watch: {
    fecha_cita: function(val) {
      this.form.fecha_cita = val;
    }
  },
  data: function() {
    return {
      medicos: [],
      selectedMedico: "",
      existenErroresForm: false,
      selectedAcompanante: "",
      acompanante: "S",
      horas_validas: false,
      fecha_cita: "",
      selectedPoliza: "",
      selectedEspecialidad: "",
      hora_inicio_data: "",
      hora_cierre_data: "",
      errores: {
        nombre: "",
        id_poliza: "",
        fecha_cita: "",
        id_especialidad: "",
        id_acompanante: "",
        id_doctor: ""
      },
      form: {
        id_paciente: "",
        id_acompanante: "",
        codigo_cita: "",
        titular_afiliado: "",
        id_poliza: "",
        fecha_cita: "",
        id_especialidad: "",
        hora_inicio: "",
        hora_cierre: "",
        id_doctor: 1288,
        estado: "C" //Consulta Externa
      },
      datos_paciente_mostrar: "",
      polizas: [],
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
        .admistracion_de_citas.citas.ingreso_emergencia.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
        .admistracion_de_citas.citas.ingreso_emergencia.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    loadDoctors() {
      let getDoctor = {
        especialidad: this.form.id_especialidad,
        horaInicial: this.form.hora_inicio,
        horaFinal: this.form.hora_cierre,
        fecha: this.form.fecha_cita
      };
      let that = this;
      let url =
        "/gestion_hospitalaria/personal_medico/cargar_medicos_consulta_general";
      var loader = that.$loading.show();
      axios
        .post(url, getDoctor)
        .then(function(response) {
          let doctores = [];

          for (let i = 0; i < response.data.length; i++) {
            let objeto = {
              display: response.data[i].user.US_NOM+' '+response.data[i].user.US_APELL,
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
        this.form.fecha_cita == "" ||
        this.form.fecha_cita == null ||
        this.form.fecha_cita == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione una Fecha de cita"
        });
        this.existenErroresForm = true;
        return;
      }
      if (
        this.form.hora_inicio == "" ||
        this.form.hora_inicio == null ||
        this.form.hora_inicio == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione una Hora de Inicio"
        });
        this.existenErroresForm = true;
        return;
      }
      if (
        this.form.hora_cierre == "" ||
        this.form.hora_cierre == null ||
        this.form.hora_cierre == undefined
      ) {
        this.$swal({
          icon: "info",
          title: "Existen validaciones del formulario que debe completar",
          text: "Seleccione una Hora de Cierre"
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
    setselectedAcompanante(value) {
      if (value !== null) {
        this.form.id_acompanante = value.value;
      } else {
        this.form.id_acompanante = "";
      }
    },
    validarHoraInicio(hora, minuto) {
      //Se comprueba que la ohora de inicio no sea mayor a la de cierre
      let hora_inicio = parseInt(hora);
      let minuto_inicio = parseInt(minuto);
      let mensaje = "";
      if (this.hora_cierre_data == "" || this.hora_cierre_data == null) {
        return;
      }
      if (this.hora_cierre_data.H !== "" && this.hora_cierre_data.m !== "") {
        if (hora_inicio > parseInt(this.hora_cierre_data.H)) {
          mensaje = "La hora de inicio es mayor que la hora de cierre";
          return mensaje;
        }
        if (hora_inicio == parseInt(this.hora_cierre_data.H)) {
          if (minuto_inicio > parseInt(this.hora_cierre_data.m)) {
            mensaje =
              "Las horas son las mismas, sin embargo el minuto de inicio es mayor que el de cierre";
            return mensaje;
          }
        }
        this.horas_validas = true;
      } else {
        this.horas_validas = false;
        return mensaje;
      }
    },
    validarHoraCierre(hora, minuto) {
      //Se comprueba que la ohora de inicio no sea mayor a la de cierre
      let hora_cierre = parseInt(hora);
      let minuto_cierre = parseInt(minuto);
      let mensaje = "";
      if (this.hora_inicio_data == "" || this.hora_inicio_data == null) {
        return mensaje;
      }
      if (this.hora_inicio_data.H !== "" && this.hora_inicio_data.m !== "") {
        if (hora_cierre < parseInt(this.hora_inicio_data.H)) {
          mensaje = "La hora de cierre es menor que la hora de inicio";
          return mensaje;
        }
        if (hora_cierre == parseInt(this.hora_inicio_data.H)) {
          if (minuto_cierre < parseInt(this.hora_inicio_data.m)) {
            mensaje =
              "Las horas son las mismas, sin embargo el minuto de cierre es menor que el de inicio";
            return mensaje;
          }
        }
        this.horas_validas = true;
      } else {
        this.horas_validas = false;
        return mensaje;
      }
    },
    changeTimeInicio(value) {
      this.hora_inicio_data = value.data;
      let mensaje = this.validarHoraInicio(
        this.hora_inicio_data.H,
        this.hora_inicio_data.m
      );
      if (mensaje != "" && mensaje != undefined) {
        this.horas_validas = false;
        this.hora_inicio_data = "";
        this.form.hora_inicio = "";
        this.$swal({
          icon: "info",
          title: "Validación",
          text: mensaje
        });
      } else {
        this.form.hora_inicio = value.displayTime;
      }
    },
    changeTimeCierre(value) {
      this.hora_cierre_data = value.data;
      let mensaje = this.validarHoraCierre(
        this.hora_cierre_data.H,
        this.hora_cierre_data.m
      );
      if (mensaje != "" && mensaje != undefined) {
        this.horas_validas = false;
        this.hora_cierre_data = "";
        this.form.hora_cierre = "";
        this.$swal({
          icon: "info",
          title: "Validación",
          text: mensaje
        });
      } else {
        this.form.hora_cierre = value.displayTime;
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
        fecha_cita: "",
        id_especialidad: "",
        id_doctor: "",
        id_acompanante: "",
        estado: "C" //Consulta
      };
      let url = "";
      let mensaje = "";
      // if (this.$props.objetoMod !== null) {
      url = "/gestion_hospitalaria/administracion_cita/crear_cita";
      mensaje = "Datos actualizados correctamente.";
      // }
      //else {
      //     url = "/gestion_hospitalaria/generalidades/guardar_aseguradora";
      //     mensaje = "Datos guardados correctamente.";
      //   }
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
