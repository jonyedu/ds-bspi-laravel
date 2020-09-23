<template>
    <div class="row">
        <!-- Seccion del Titulo -->
        <div class="col-md-12">
            <h1 class="float-left">
                Preparación -
                <span v-text="titulo_seleccionado"></span>
            </h1>
            <a href="/LeonBecerra/gestion_hospitalaria/agenda">
                <button
                    v-if="hideBackButton"
                    class="float-right btn btn-warning mt-2"
                >
                    Regresar a Agenda
                </button>
            </a>
        </div>
        <div
            class="col-lg-12 col-md-12 col-sm-12"
            style="max-height:600px;"
        >
            <div style="overflow-y:scroll;height:600px">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div
                                class="col-lg-12 col-md-12 col-sm-12 text-center"
                            >
                                <div class="btn-group" role="group">
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="
                                            mostrarComponenteSignosVitales()
                                        "
                                    >
                                        Signos Vitales
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="
                                            mostrarComponenteMotivoAntecedentes()
                                        "
                                    >
                                        Motivo/Antecedentes
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="
                                            mostrarComponenteExamenFisico()
                                        "
                                    >
                                        Examen Físico
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="
                                            mostrarComponenteDiagnostico()
                                        "
                                    >
                                        Diagnostico
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="
                                            mostrarComponentePrescripcion()
                                        "
                                    >
                                        Prescripción
                                    </button>
                                                                        <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="mostrarComponenteEvolucion()"
                                    >
                                        Evolución
                                    </button>
                                    <button
                                        v-if="false"
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="
                                            mostrarComponenteLaboratorioClinico()
                                        "
                                    >
                                        Laboratorio Clinico
                                    </button>
                                    <button
                                        v-if="false"
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="
                                            mostrarComponenteImageneologia()
                                        "
                                    >
                                        Imageneologia
                                    </button>
                                    <button
                                        v-if="false"
                                        type="button"
                                        class="btn btn-outline-primary"
                                        @click="mostrarComponenteFirma()"
                                    >
                                        Firma
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div
                                class="col-lg-12 col-md-12 col-sm-12"
                                v-if="
                                    componente_seleccionado ==
                                        'SignosVitales'
                                "
                            >
                                <signo-vitales
                                    :readOnly="true"
                                    :id-cita="idCitaModal"
                                    ref="SignosVitalesModal"
                                    @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                                >
                                </signo-vitales>
                            </div>
                            <div
                                class="col-lg-12 col-md-12 col-sm-12"
                                v-else-if="
                                    componente_seleccionado == 'Evolucion'
                                "
                            >
                                <evolucion
                                    :tipo-personal="tipoPersonal"
                                    :id-cita="idCitaModal"
                                    ref="Evolucion"
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
                                    :readOnly="true"
                                    :id-cita="idCitaModal"
                                    ref="MotivoAntecedentesModal"
                                    @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                                ></motivo-antecedente>
                            </div>
                            <div
                                class="col-lg-12 col-md-12 col-sm-12"
                                v-else-if="
                                    componente_seleccionado ==
                                        'ExamenFisico'
                                "
                            >
                                <examen-fisico
                                    :readOnly="true"
                                    :id-cita="idCitaModal"
                                    ref="ExamenFisicoModal"
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
                                    :readOnly="true"
                                    :id-cita="idCitaModal"
                                    ref="DiagnosticoModal"
                                    @validarGuardarModificar="
                                        respuestaGuardarModificar = $event
                                    "
                                ></diagnostico>
                            </div>
                            <div
                                class="col-lg-12 col-md-12 col-sm-12"
                                v-else-if="
                                    componente_seleccionado ==
                                        'Prescripcion'
                                "
                            >
                                <prescripcion :id-cita="idCitaModal"
                                :es-modal-historia-clinica="true"
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
                                    componente_seleccionado ==
                                        'Imageneologia'
                                "
                            >
                                <imageneologia></imageneologia>
                            </div>
                            <div
                                class="col-lg-12 col-md-12 col-sm-12"
                                v-else-if="
                                    componente_seleccionado == 'Firma'
                                "
                            >
                                <firma></firma>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        idCitaModalProp: {
            type: Number
        }
    },
    data: function() {
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
                    type: "String"
                },
                {
                    label: "Motivos",
                    field: "MOTIVO_MOSTRAR",
                    type: "String"
                }
            ],
            columnsEstadoCita: [
                {
                    label: "Tipo de Consulta",
                    field: "ESTADO_CITA_NOM",
                    type: "String"
                },
                {
                    label: "Doctor/a",
                    field: "NOMBRE_DOCTOR",
                    type: "String"
                },
                {
                    label: "Fecha",
                    field: "ESTADOCITA_FECHA",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        this.getTipoPersonal();
         this.idCita = this.$route.params.citaId;
         if(this.$props.idCitaModalProp!=null && this.$props.idCitaModalProp!=''){
             this.idCita =this.$props.idCitaModalProp;
             this.idCitaModal=this.$props.idCitaModalProp;
         }
        if (this.idCita == null) {
            this.hideBackButton = false;
        } else {
            this.hideBackButton = true;
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
    beforeDestroy: function() {
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
        muestraEstadoCitas(value) {
            this.cargarEstadoCita(value.CITA_COD);
            this.$modal.show("infoCitas");
        },
        muestraConsultaExterna(value) {
            //this.componente_seleccionado = "SignosVitales";
            if(value.ESTADOCITA_TIPO=='C'){
                this.$modal.show("datosConsultaExterna");
                this.idCitaModal = this.idCita;
            }else{
                if(value.ESTADOCITA_TIPO=='E'){
                    this.$swal({
                        icon: "warning",
                        title: "Información",
                        text: "La funcionalidad de visualización emergencia se encuentra en desarrollo."
                    });
                }else{
                     this.$swal({
                        icon: "warning",
                        title: "Información",
                        text: "La funcionalidad se encuentra en desarrollo."
                    });
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
        getTipoPersonal() {
            let that = this;
            let url =
                "/gestion_hospitalaria/personalMedico/verTipoPersonalMedico";
            axios
                .get(url)
                .then(function(response) {
                    that.tipoPersonal = response.data.tipoMedico;
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
                this.$refs.MotivoAntecedentes.guardarModificarMotivoAntecedente(
                    opc
                );
            } else if (this.componente_seleccionado == "Diagnostico") {
                this.$refs.Diagnostico.guardarModificarDiagnostico(opc);
            } else if (this.componente_seleccionado == "Prescripcion") {
                this.$refs.Prescripcion.guardarModificarPrescripcion(opc);
            } else {
                this.$swal({
                    icon: "error",
                    title: "Error al Procesar",
                    text:
                        "Vaya a 'Nuevo' y seleccione un paciente para continuar!! "
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
                    .then(function(response) {
                        let citasDeUsuario = [];
                        for (let i = 0; i < response.data.citas.length; i++) {
                            let objeto = {};
                            objeto.CITA_COD = response.data.citas[i].CITA_COD;
                            objeto.FECHA_CITA =
                                response.data.citas[i].FECHA_CITA;
                            objeto.MOTIVO_MOSTRAR =
                                response.data.citas[i].MOTIVO_MOSTRAR;
                            citasDeUsuario.push(objeto);
                        }
                        that.citasDeUsuario = citasDeUsuario;
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
                    .then(function(response) {
                        let estadoCita = [];
                        for (
                            let i = 0;
                            i < response.data.estadoCita.length;
                            i++
                        ) {
                            let objeto = {};
                            objeto.ESTADO_CITA_NOM =response.data.estadoCita[i].ESTADO_CITA_NOM;
                            objeto.ESTADOCITA_FECHA= response.data.estadoCita[i].ESTADOCITA_FECHA;
                            objeto.NOMBRE_DOCTOR = response.data.estadoCita[i].doctor!=null?response.data.estadoCita[i].doctor.user.name:'';
                            objeto.ESTADOCITA_TIPO= response.data.estadoCita[i].ESTADOCITA_TIPO;
                            estadoCita.push(objeto);
                        }
                        that.estadoCita = estadoCita;
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
            this.titulo_seleccionado = "Evolucion";
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
            this.titulo_seleccionado = "Diagnostico";
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
        }
    }
};
</script>
