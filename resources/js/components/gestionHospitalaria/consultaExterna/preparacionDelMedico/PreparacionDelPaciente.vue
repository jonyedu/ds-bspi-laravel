<template>
  <div class="row">
    <!-- Seccion del Titulo -->
    <div class="col-md-12">
      <h1 class="float-left">
        Preparación -
        <span v-text="titulo_seleccionado"></span>
      </h1>
      <a href="/LeonBecerra/gestion_hospitalaria/agenda">
        <button v-if="hideBackButton" class="float-right btn btn-warning mt-2">Regresar a Agenda</button>
      </a>
    </div>

    <!-- Seccion de los menu de botones: Historial clínico, Nueva, Guardar, etc y la Tabla Historial Clinico-->
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <!-- Inicio para mostrar la tabla Historial Clinico -->
            <div v-if="tipoPersonal == 1" class="col-lg-2 col-md-2 col-sm-2 text-left">
              <template v-if="mostarTable == 0">
                <button
                  type="button"
                  class="btn btn-outline-dark btn-sm"
                  @click="
                                        mostrarOcultarComponenteHistorial(1)
                                    "
                >
                  <template>
                    <div>
                      <i class="fas fa-eye"></i>Historial
                      clínico
                    </div>
                  </template>
                </button>
              </template>
              <template v-else>
                <button
                  type="button"
                  class="btn btn-outline-dark btn-sm"
                  @click="
                                        mostrarOcultarComponenteHistorial(0)
                                    "
                >
                  <template>
                    <div>
                      <i class="fa fa-eye-slash"></i>
                    </div>
                  </template>
                </button>
              </template>
            </div>
            <!-- Fin para mostrar la tabla Historial Clinico -->

            <!-- Lista de Butones Nueva, Modificar, Guardar, Imprimir, H.C. Digital -->
            <div
              :class="tipoPersonal==1?'col-lg-10 col-md-10 col-sm-10 text-right':'col-lg-12 col-md-12 col-sm-12 text-right'"
            >
              <div class="btn-group" role="group">
                <button
                  v-if="tipoPersonal != 1"
                  type="button"
                  class="btn btn-outline-primary"
                  @click="mostrarModalListaCitas()"
                >Nuevo</button>
                <template v-if="respuestaGuardarModificar == 1">
                  <button
                    type="button"
                    class="btn btn-outline-danger"
                    @click="llamarMetodoGuardar(1)"
                  >Modificar</button>
                </template>
                <template v-else>
                  <button
                    type="button"
                    class="btn btn-outline-danger"
                    @click="llamarMetodoGuardar(0)"
                  >Guardar</button>
                </template>
                <template
                  v-if="
                                        respuestaGuardarModificar &&
                                            respuestaImprimir
                                    "
                >
                  <button
                    type="button"
                    class="btn btn-outline-success"
                    @click="llamarMetodoImprimir()"
                  >Imprimir</button>
                </template>
              </div>
            </div>
            <!-- Fin de Butones Nueva, Modificar, Guardar, Imprimir, H.C. Digital -->
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Seccion de los menu de botones: Historial clínico, Nueva, Guardar, etc y la Tabla Historial Clinico-->
    &nbsp;
    <!-- Seccion de la Tabla donde muestra el Historial Clinico -->
    <div class="col-lg-12 col-md-12 col-sm-12" v-if="mostarTable == 1">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
              <h5>Historia Digital de Pacientes</h5>
              <vuetable-component
                :anular-button="false"
                :modificar-button="false"
                :columns-data="columnsCitasDeUsuario"
                :rows-data="citasDeUsuario"
                @handleRowClick="muestraEstadoCitas"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Seccion de la Tabla donde muestra el Historial Clinico -->
    &nbsp;
    <!-- Seccion donde muestra los submenus: Signos Vitales, Motivo/Antecedentes, Examen Físico, Diagnostico, Prescripción, Evolución, Laboratorio Clinico, Imageneologia, Firma -->
    <div class="col-lg-12 col-md-12 col-sm-12" style="max-height:600px;" v-if="idCita != null">
      <div style="overflow-y:scroll;height:600px">
        <div class="card">
          <div class="card-body">
            <!-- Seccion de los Botones: Signos Vitales, Motivo/Antecedentes, Examen Físico, Diagnostico, Prescripción, Evolución, Laboratorio Clinico, Imageneologia, Firma  -->
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <div class="btn-group" role="group">
                  <button
                    type="button"
                    class="btn btn-outline-primary"
                    @click="
                                            mostrarComponenteSignosVitales()
                                        "
                  >Signos Vitales</button>
                  <button
                    v-if="tipoPersonal == 1"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="
                                            mostrarComponenteMotivoAntecedentes()
                                        "
                  >Motivo/Antecedentes</button>
                  <button
                    v-if="tipoPersonal == 1"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="mostrarComponenteExamenFisico()"
                  >Examen Físico</button>
                  <button
                    v-if="tipoPersonal == 1"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="mostrarComponenteDiagnostico()"
                  >Diagnóstico</button>
                  <button
                    v-if="tipoPersonal == 1"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="mostrarComponenteEvolucion()"
                  >Evolución</button>
                  <button
                    v-if="tipoPersonal == 1"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="mostrarComponentePrescripcion()"
                  >Prescripción</button>
                  <button
                    v-if="tipoPersonal == 1 && false"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="
                                            mostrarComponenteLaboratorioClinico()
                                        "
                  >Laboratorio Clinico</button>
                  <button
                    v-if="tipoPersonal == 1 && false"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="
                                            mostrarComponenteImageneologia()
                                        "
                  >Imageneologia</button>
                  <button
                    v-if="tipoPersonal == 1 && false"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="mostrarComponenteFirma()"
                  >Firma</button>
                  <button
                    v-if="tipoPersonal == 1"
                    type="button"
                    class="btn btn-outline-primary"
                    @click="terminarConsultaExterna()"
                  >Terminar Consulta Externa</button>
                </div>
              </div>
            </div>
            <!-- Fin Seccion de los Botones: Signos Vitales, Motivo/Antecedentes, Examen Físico, Diagnostico, Prescripción, Evolución, Laboratorio Clinico, Imageneologia, Firma  -->
            <!-- Seccion donde muestra el componente seleccionado de los botones -->
            <div class="row mt-3">
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-if="
                                    componente_seleccionado == 'SignosVitales'
                                "
              >
                <signo-vitales
                  :id-cita="idCita"
                  :tipo-personal="tipoPersonal"
                  ref="SignosVitales"
                  @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                ></signo-vitales>
              </div>
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-else-if="
                                    componente_seleccionado == 'Evolucion'
                                "
              >
                <evolucion
                  :id-cita="idCita"
                  ref="Evolucion"
                  :tipo-personal="tipoPersonal"
                  @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                ></evolucion>
              </div>
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-else-if="
                                    componente_seleccionado ==
                                        'Motivo-Antecedentes'
                                "
              >
                <motivo-antecedente
                  :id-cita="idCita"
                  :tipo-personal="tipoPersonal"
                  ref="MotivoAntecedentes"
                  @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                ></motivo-antecedente>
              </div>
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-else-if="
                                    componente_seleccionado == 'ExamenFisico'
                                "
              >
                <examen-fisico
                  :id-cita="idCita"
                  :tipo-personal="tipoPersonal"
                  ref="ExamenFisico"
                  @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                ></examen-fisico>
              </div>
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-else-if="
                                    componente_seleccionado == 'Diagnostico'
                                "
              >
                <diagnostico
                  :id-cita="idCita"
                  ref="Diagnostico"
                  @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                ></diagnostico>
              </div>
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-else-if="
                                    componente_seleccionado == 'Prescripcion'
                                "
              >
                <prescripcion
                  :id-cita="idCita"
                  ref="Prescripcion"
                  @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                  @validarImprimir="
                                        respuestaImprimir = $event
                                    "
                ></prescripcion>
              </div>
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-else-if="
                                    componente_seleccionado ==
                                        'LaboratorioClinico'
                                "
              >
                <laboratorio-clinico></laboratorio-clinico>
              </div>
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-else-if="
                                    componente_seleccionado == 'Imageneologia'
                                "
              >
                <imageneologia></imageneologia>
              </div>
              <div
                class="col-lg-12 col-md-12 col-sm-12"
                v-else-if="componente_seleccionado == 'Firma'"
              >
                <firma></firma>
              </div>
            </div>
            <!-- Fin Seccion donde muestra el componente seleccionado de los botones -->
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Seccion donde muestra los submenus: Signos Vitales, Motivo/Antecedentes, Examen Físico, Diagnostico, Prescripción, Evolución, Laboratorio Clinico, Imageneologia, Firma -->
    
    <!-- Seccion donde muestra la imagen cuando no se haya aun seleccionado un paciente -->
    <div class="col-lg-12 col-md-12 col-sm-12" style="max-height:600px;margin-top:65px" v-if="idCita == null">
      <img src="/icon/Business.jpg" height="100%" width="25%" style="display:block;margin:auto;" alt="Logo">
    </div>
    <!-- Fin Seccion donde muestra la imgane cuando no se haya aun seleccionado un paciente -->
    
    <!-- Seccion donde muestra la lista de los pacientes que tienen una cita -->
    <modal :width="'65%'" height="auto" :scrollable="true" name="listaConsultaExterna">
      <lista-cita-consulta-externa
        ref="listaConsultaExterna"
        @handleSeleccionarClick="handleSeleccionarClick"
      ></lista-cita-consulta-externa>
    </modal>
    <!-- Fin Seccion donde muestra la lista de los pacientes que tienen una cita -->

    <!-- Esto que es?  -->
    <!-- Seccion donde muestra la tabla de Estado Cita -->
    <modal :width="'65%'" height="auto" :scrollable="true" name="infoCitas">
      <div class="col-lg-12 col-md-12 col-sm-12" v-if="mostarTable == 1">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <h5>Información</h5>
                <vuetable-component
                  :anular-button="false"
                  :modificar-button="false"
                  :columns-data="columnsEstadoCita"
                  :rows-data="estadoCita"
                  @handleRowClick="muestraConsultaExterna"
                ></vuetable-component>
              </div>
            </div>
          </div>
        </div>
      </div>
    </modal>
    <!-- Fin Seccion donde muestra la tabla de Estado Cita -->

    <!-- Esto que es?  -->
    <modal :width="'70%'" height="auto" :scrollable="true" name="datosConsultaExterna">
      <visualizacion-preparacion :id-cita-modal-prop="idCitaModal"></visualizacion-preparacion>
    </modal>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      respuestaImprimir: 0,
      respuestaGuardarModificar: 0,
      idCita: null,
      idCitaModal: null,
      userId: null,
      hideBackButton: false,
      tipoPersonal: "",
      estadoCita: [],
      citasDeUsuario: [],
      ultimo_codigo_atencion: "",
      mostarTable: 0,
      titulo_seleccionado: "Signos Vitales",
      componente_seleccionado: "SignosVitales",
      columnsCitasDeUsuario: [
        {
          label: "Fecha",
          field: "FECHA_CITA",
          type: "String",
        },
        {
          label: "Motivos",
          field: "MOTIVO_MOSTRAR",
          type: "String",
        },
      ],
      columnsEstadoCita: [
        {
          label: "Tipo de Consulta",
          field: "ESTADO_CITA_NOM",
          type: "String",
        },
        {
          label: "Doctor/a",
          field: "NOMBRE_DOCTOR",
          type: "String",
        },
        {
          label: "Fecha",
          field: "ESTADOCITA_FECHA",
          type: "String",
        },
      ],
    };
  },
  mounted: function () {
    this.getTipoPersonal();
    this.idCita = this.$route.params.citaId;
    //this.userId = this.$route.params.userId;
    if (this.idCita == null) {
      this.hideBackButton = false;
    } else {
      this.hideBackButton = true;
      this.getPaciente();
    }

    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .admistracion_de_citas.citas.consulta_externa.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarEstadoCita();
  },
  beforeDestroy: function () {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .admistracion_de_citas.citas.consulta_externa.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    terminarConsultaExterna() {
      let that = this;
      this.$swal({
        title: "¿Desea terminar la consulta externa?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          //Se procede a terminar la cita
          this.terminarCita();
        }
      });
    },
    getPaciente() {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_cita/cita_paciente/" +
        that.idCita;
      axios
        .get(url)
        .then(function (response) {
          that.userId = response.data.paciente;
        })
        .catch((error) => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
        });
    },
    muestraEstadoCitas(value) {
      this.cargarEstadoCita(value.CITA_COD);
      this.$modal.show("infoCitas");
    },
    muestraConsultaExterna(value) {
      //this.componente_seleccionado = "SignosVitales";
      if (value.ESTADOCITA_TIPO == "C") {
        this.$modal.show("datosConsultaExterna");
        this.idCitaModal = this.idCita;
      } else {
        if (value.ESTADOCITA_TIPO == "E") {
          /* this.$swal({
            icon: "warning",
            title: "Información",
            text:
              "La funcionalidad de visualización emergencia se encuentra en desarrollo.",
          }); */
        } else {
          /* this.$swal({
            icon: "warning",
            title: "Información",
            text: "La funcionalidad se encuentra en desarrollo.",
          }); */
        }
      }
    },
    mostrarModalListaCitas() {
      this.mostrarOcultarComponenteHistorial(0);
      this.$modal.show("listaConsultaExterna");
    },
    llamarMetodoImprimir() {
      if (this.componente_seleccionado == "Prescripcion") {
        this.$refs.Prescripcion.imprimirPdfPrescripcion();
      }
    },
    terminarCita() {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_cita/terminar_cita/" +
        that.idCita;
      axios
        .post(url)
        .then(function (response) {
          that.$swal({
            icon: "success",
            title: "Transacción realizada correctamente.",
            text: "Consulta externa terminada con éxito.",
          });
        })
        .catch((error) => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
        });
    },
    getTipoPersonal() {
      let that = this;
      let url = "/gestion_hospitalaria/personalMedico/verTipoPersonalMedico";
      axios
        .get(url)
        .then(function (response) {
          that.tipoPersonal = response.data.tipoMedico;
        })
        .catch((error) => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
        });
    },
    /* mostrarModalListaCitas() {
          this.$modal.show("listaConsultaExterna");
        }, */
    handleSeleccionarClick(value) {
      this.userId = value.codigo_paciente;
      this.idCita = value.codigo_cita;
      this.componente_seleccionado = "SignosVitales";
      this.$modal.hide("listaConsultaExterna");
      if (this.$refs.SignosVitales != null) {
        this.$refs.SignosVitales.cargarDetallesPaciente();
      }
    },
    llamarMetodoGuardar(opc) {
      if (
        this.componente_seleccionado == "SignosVitales" &&
        this.$refs.SignosVitales != null
      ) {
        this.$refs.SignosVitales.guardarModificarSignosVitales(opc);
      } else if (this.componente_seleccionado == "Evolucion") {
        this.$refs.Evolucion.guardarModificarEvolucion(opc);
      } else if (this.componente_seleccionado == "ExamenFisico") {
        this.$refs.ExamenFisico.guardarModificarExamenFisico(opc);
      } else if (this.componente_seleccionado == "Motivo-Antecedentes") {
        this.$refs.MotivoAntecedentes.guardarModificarMotivoAntecedente(opc);
      } else if (this.componente_seleccionado == "Diagnostico") {
        this.$refs.Diagnostico.guardarModificarDiagnostico(opc);
      } else if (this.componente_seleccionado == "Prescripcion") {
        this.$refs.Prescripcion.guardarModificarPrescripcion(opc);
      } else {
        this.$swal({
          icon: "error",
          title: "Error al Procesar",
          text: "Vaya a 'Nuevo' y seleccione un paciente para continuar!! ",
        });
      }
    },
    llamarMetodoImprimir() {
      if (this.componente_seleccionado == "Prescripcion") {
        this.$refs.Prescripcion.imprimirPdfPrescripcion();
      }
    },
    cargarCitas() {
      let that = this;
      if (that.idCita > 0) {
        let url =
          "/gestion_hospitalaria/administracion_cita/cargar_citas_usuario/" +
          that.userId;
        var loader = that.$loading.show();
        axios
          .get(url)
          .then(function (response) {
            let citasDeUsuario = [];
            for (let i = 0; i < response.data.citas.length; i++) {
              let objeto = {};
              objeto.CITA_COD = response.data.citas[i].CITA_COD;
              objeto.FECHA_CITA = response.data.citas[i].FECHA_CITA;
              objeto.MOTIVO_MOSTRAR = response.data.citas[i].MOTIVO_MOSTRAR;
              citasDeUsuario.push(objeto);
            }
            that.citasDeUsuario = citasDeUsuario;
            loader.hide();
          })
          .catch((error) => {
            //Errores
            loader.hide();
            that.$swal({
              icon: "error",
              title: "Existe un error",
              text: error,
            });
          });
      }
    },
    cargarEstadoCita() {
      let that = this;
      if (that.idCita > 0) {
        let url =
          "/gestion_hospitalaria/administracion_cita/cargar_estado_citas/" +
          that.idCita;
        var loader = that.$loading.show();
        axios
          .get(url)
          .then(function (response) {
            let estadoCita = [];
            for (let i = 0; i < response.data.estadoCita.length; i++) {
              let objeto = {};
              objeto.ESTADO_CITA_NOM =
                response.data.estadoCita[i].ESTADO_CITA_NOM;
              objeto.ESTADOCITA_FECHA =
                response.data.estadoCita[i].ESTADOCITA_FECHA;
              objeto.NOMBRE_DOCTOR =
                response.data.estadoCita[i].doctor != null
                  ? response.data.estadoCita[i].doctor.user.name
                  : "";
              objeto.ESTADOCITA_TIPO =
                response.data.estadoCita[i].ESTADOCITA_TIPO;
              estadoCita.push(objeto);
            }
            that.estadoCita = estadoCita;
            loader.hide();
          })
          .catch((error) => {
            //Errores
            loader.hide();
            that.$swal({
              icon: "error",
              title: "Existe un error",
              text: error,
            });
          });
      }
    },
    mostrarComponenteSignosVitales() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Signos Vitales";
      this.componente_seleccionado = "SignosVitales";
      this.respuestaGuardarModificar = 0;
      if (this.$refs.SignosVitales != null) {
        this.$refs.SignosVitales.cargarDetallesPaciente();
      }
    },
    mostrarComponenteMotivoAntecedentes() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Motivo/Antecedentes";
      this.componente_seleccionado = "Motivo-Antecedentes";
      this.respuestaGuardarModificar = 0;
      if (this.$refs.MotivoAntecedentes != null) {
        this.$refs.MotivoAntecedentes.cargarMotivoAntecedente();
      }
    },
    mostrarComponenteEvolucion() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Evolución";
      this.componente_seleccionado = "Evolucion";
      this.respuestaGuardarModificar = 0;
      if (this.$refs.Evolucion != null) {
        this.$refs.Evolucion.cargarEvolucion();
      }
    },
    mostrarComponenteExamenFisico() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Examen Físico";
      this.componente_seleccionado = "ExamenFisico";
      this.respuestaGuardarModificar = 0;
      if (this.$refs.ExamenFisico != null) {
        this.$refs.ExamenFisico.cargarExamenFisico();
      }
    },
    mostrarComponenteDiagnostico() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Diagnóstico";
      this.componente_seleccionado = "Diagnostico";
      if (this.$refs.Diagnostico != null) {
        this.$refs.Diagnostico.cargarDiagnostico();
      }
    },
    mostrarComponentePrescripcion() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Prescripción";
      this.componente_seleccionado = "Prescripcion";
      if (this.$refs.Prescripcion != null) {
        this.$refs.Prescripcion.cargarPrescripcion();
      }
    },
    mostrarComponenteLaboratorioClinico() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Laboratorio Clínico";
      this.componente_seleccionado = "LaboratorioClinico";
    },
    mostrarComponenteImageneologia() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Imageneología";
      this.componente_seleccionado = "Imageneologia";
    },
    mostrarComponenteFirma() {
      this.respuestaImprimir = 0;
      this.titulo_seleccionado = "Firma";
      this.componente_seleccionado = "Firma";
    },
    mostrarOcultarComponenteHistorial(opc) {
      if (opc) {
        this.mostarTable = 1;
        this.cargarCitas();
      } else {
        this.mostarTable = 0;
      }
    },
  },
};
</script>
