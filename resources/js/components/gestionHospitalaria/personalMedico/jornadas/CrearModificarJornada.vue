<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Jornada</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="cargo">Trabajadores BSPI</label>
                  <input
                    class="col-lg-12 col-md-12 col-sm-12"
                    v-model="selectedUsuario"
                    label="USER_NOM"
                    @input="setSelectedUser"
                    disabled
                  />
                  <template slot="no-options">
                    No se ha encontrado ningun
                    dato
                  </template>

                  <small
                    v-if="errores.usuario !== ''"
                    id="cargoHelp"
                    class="text-danger"
                  >{{ errores.usuario[0] }}</small>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Desde</label>
                  <br />
                  <v-time
                    @change="changeTimeInicio"
                    v-model="form.hora_inicio"
                    placeholder="Hora inicio"
                  ></v-time>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Hasta</label>
                  <br />
                  <v-time
                    @change="changeTimeCierre"
                    v-model="form.hora_cierre"
                    placeholder="Hora Fin"
                  ></v-time>
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
            <div class="row mt-2">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="lunes">Lunes</label>
                  <input type="checkbox" id="lunes" value="lunes" v-model="form.lunes" />

                  <label class="ml-3" for="martes">Martes</label>
                  <input type="checkbox" id="martes" value="martes" v-model="form.martes" />
                  <label class="ml-3" for="miercoles">Miercoles</label>
                  <input type="checkbox" id="miercoles" value="miercoles" v-model="form.miercoles" />
                  <label class="ml-3" for="jueves">Jueves</label>
                  <input type="checkbox" id="jueves" value="jueves" v-model="form.jueves" />
                  <label class="ml-3" for="viernes">Viernes</label>
                  <input type="checkbox" id="viernes" value="viernes" v-model="form.viernes" />
                  <label class="ml-3" for="sabado">Sabado</label>
                  <input type="checkbox" id="sabado" value="sabado" v-model="form.sabado" />
                  <label class="ml-3" for="domingo">Domingo</label>
                  <input type="checkbox" id="domingo" value="domingo" v-model="form.domingo" />
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
                    jornadaMod===null?
                    "Guardar":
                    "Modificar"
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
    jornadaMod: {
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
      errores: {
        usuario: "",
        tipo: "",
        observacion: "",
        fecha_contrato: ""
      },
      checkedNames: [],
      form: {
        hora_inicio: "",
        hora_cierre: "",
        lunes: "",
        martes: "",
        miercoles: "",
        jueves: "",
        viernes: "",
        sabado: "",
        domingo: "",
        observacion: "",

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
      .personalMedico.jornadas.crear_modificar_jornada.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.jornadas.crear_modificar_jornada.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    onFileSelected(event) {
      if (event.target.files[0]["type"] === "application/pdf") {
        this.pdfContrato = event.target.files[0];
      } else {
        this.$swal({
          icon: "error",
          title: "Error de Archivo",
          text: "Solo archivos de formato: .pdf !"
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

    guardarActualizar: function(pathContrato) {
      let that = this;
      that.errores = {
        nombre: "",
        hospital: "",
        observacion: ""
      };
      let url;
      let mensaje = "";
      if (this.$props.jornadaMod !== null) {
        url = "/gestion_hospitalaria/jornadas/modificar_jornadas";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/jornadas/guardar_jornadas";
        mensaje = "Datos guardados correctamente.";
      }

      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarJornadas");
          that.$emit("cerrarModalCrearJornada");
          if (
            response.data.mensaje ===
            "Jornada enviada tiene cruce con otro horario!"
          ) {
            that.$swal({
              icon: "error",
              title: "Cruce de Horario",
              text:
                "La jornada que intento ingresar tiene cruce con otra jornada."
            });
          } else {
            that.$swal({
              icon: "success",
              title: "Proceso realizado exitosamente",
              text: "Datos actualizados correctamente."
            });
          }

          //that.limpiarForm();
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
