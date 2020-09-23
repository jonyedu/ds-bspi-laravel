<template>
    <div class="row mt-2">
        <div class="form-inline col-sm-12 col-md-12 col-sm-12">
            <input
                class="form-check-input"
                type="radio"
                name="tipoConsulta"
                id="tipoConsulta"
                value="A"
                v-model="tipoConsulta"
                @input="handleChangeRadio"
            />
            <label class="form-check-label" for="tipoConsulta"
                >Admisiones Actuales</label
            >
            <input
                class="form-check-input ml-2"
                type="radio"
                name="tipoConsulta"
                id="tipoConsulta"
                value="H"
                v-model="tipoConsulta"
                @input="handleChangeRadio"
            />
            <label class="form-check-label" for="tipoConsulta"
                >Admisiones Históricas</label
            >
        </div>
        <div
            class="col-lg-8 col-md-8 col-sm-12 mt-2"
            v-if="tipoConsulta == 'H'"
        >
            <div class="form-inline">
                <label class="mr-2" for="fecha_desde">Fecha Desde</label>
                <input
                    type="date"
                    :class="
                        errores.fechaDesde === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="fecha_desde"
                    placeholder="Seleccione la fecha de inicio"
                    v-model="fechaDesde"
                />
                <small
                    v-if="errores.fechaDesde !== ''"
                    id="fecha_desdeHelp"
                    class="text-danger"
                    >{{ errores.fechaDesde[0] }}</small
                >

                <label class="ml-4 mr-2" for="fecha_hasta">Fecha Hasta</label>
                <input
                    type="date"
                    :class="
                        errores.fechaHasta === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="fecha_hasta"
                    placeholder="Seleccione la fecha de fin"
                    v-model="fechaHasta"
                />
                <small
                    v-if="errores.fechaHasta !== ''"
                    id="fecha_hastaHelp"
                    class="text-danger"
                    >{{ errores.fechaHasta[0] }}</small
                >
                <button
                    type="button"
                    class="btn btn-success ml-2"
                    @click="consultarAdmisionesFecha()"
                >
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
            <vuetable-component
                :anular-button="false"
                :modificar-button="!esModal"
                :derivar-button="derivarButton"
                :generar-ticket-button="esConsultaExterna || esEmergencia"
                :columns-data="columns"
                :rows-data="admisiones"
                @handleModificarClick="modificarAdmision"
                @handleDerivarClick="abrirModalDerivar"
                @handleGenerarTicket="handleGenerarTicket"
            ></vuetable-component>
        </div>
        <div>
            <modal
                :width="'65%'"
                height="auto"
                :scrollable="true"
                name="derivacion"
            >
                <derivacion
                    :objeto-consulta-externa="objetoConsultaExterna"
                    :objeto-emergencia="objetoEmergencia"
                    :codigo-cita="paciente != null ? paciente.codidoCita : 0"
                    :paciente="paciente"
                    :especialidades="especialidades"
                    :es-consulta-externa="esConsultaExterna || esAdmision"
                    :es-emergencia="esEmergencia || esAdmision"
                    @recargarDatosEmergencia="recargarDatosEmergencia"
                    @recargarDatosConsultaExterna="recargarDatosConsultaExterna"
                    ref="derivacion"
                ></derivacion>
            </modal>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        esModal: {
            type: Boolean,
            default: false
        },
        derivarButton: {
            type: Boolean,
            default: true
        },
        esConsultaExterna: {
            type: Boolean,
            default: false
        },
        esEmergencia: {
            type: Boolean,
            default: false
        },
        esAdmision: {
            type: Boolean,
            default: true
        }
    },
    data: function() {
        return {
            paciente: null,
            objetoEmergencia: null,
            objetoConsultaExterna: null,
            errores: {
                fechaDesde: "",
                fechaHasta: ""
            },
            especialidades: [],
            tipoConsulta: "A",
            fechaDesde: "",
            fechaHasta: "",
            admisiones: [],
            columns: [
                {
                    label: "Paciente",
                    field: "paciente_nombre",
                    type: "String"
                },
                {
                    label: "Identificación",
                    field: "US_IDENT_HTML"
                },
                {
                    label: "Fecha Admisión",
                    field: "fecha_admision",
                    type: "String"
                },
                {
                    label: "Estado Actual",
                    field: "estado_actual",
                    type: "String"
                },
                {
                    label: "Fecha Cambio Ultimo Estado",
                    field: "fecha_cambio_ultimo",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        this.titulo_seleccionado = "Lista";
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .administracion_de_hospital.admisiones.lista_admisiones
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );

        this.cargarDatosIniciales();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .administracion_de_hospital.admisiones.lista_admisiones
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        handleGenerarTicket(data) {
            if (data.estado_actual == "Admisión") {
                this.$swal({
                    icon: "info",
                    title: "Validaciones Del Formulario",
                    text:
                        "El registro de tipo admisión no puede generar ticket, solo emergencia o consulta externa."
                });
                return;
            }
            let tipo = "";
            if (data.estado_actual == "Consulta Externa") {
                tipo = "C";
            } else if (data.estado_actual == "Emergencia") {
                tipo = "E";
            }
            if (tipo == "") {
                this.$swal({
                    icon: "info",
                    title: "Validaciones Del Formulario",
                    text: "El tipo de registro no es valido para generar ticket"
                });
                return;
            }

            //Se procede a generar el ticket
            let that = this;
            let url =
                "/gestion_hospitalaria/administracion_cita/imprimir_ticket/" +
                data.codidoCita +
                "/" +
                tipo;
            window.open(url);
        },
        recargarDatosEmergencia() {
            this.consultarAdmisionesFecha();
            this.$modal.hide("derivacion");
        },
        recargarDatosConsultaExterna() {
            this.consultarAdmisionesFecha();
            this.$modal.hide("derivacion");
        },
        modificarAdmision(value) {
            this.$emit("modificarAdmision", value);
        },

        abrirModalDerivar(value) {
            this.objetoEmergencia = null;
            this.objetoConsultaExterna = null;
            this.paciente = value;
            //Se procede a cargar la ultima instancia de la cita del paciente.
            let that = this;
            let url =
                "/gestion_hospitalaria/administracion_cita/cargar_ultimo_estado_cita/" +
                this.paciente.codidoCita;
            axios
                .get(url)
                .then(function(response) {
                    that.paciente.ultimo_estado_cita = response.data.dato;
                    let paciente = that.paciente;
                    if (paciente.ultimo_estado_cita != null) {
                        if (
                            paciente.ultimo_estado_cita.ESTADOCITA_TIPO == "C"
                        ) {
                            that.objetoConsultaExterna =
                                paciente.ultimo_estado_cita;
                        } else {
                            if (
                                paciente.ultimo_estado_cita.ESTADOCITA_TIPO ==
                                "E"
                            ) {
                                that.objetoEmergencia =
                                    paciente.ultimo_estado_cita;
                            }
                        }
                    }
                    that.$modal.show("derivacion");
                })
                .catch(error => {
                    //Errores
                    if (error.response.status === 403) {
                        that.$swal({
                            icon: "info",
                            title: "Validaciones Del Formulario",
                            text: error.response.data.mensaje
                        });
                    } else {
                        that.$swal({
                            icon: "error",
                            title: "Existen errores",
                            text: error
                        });
                    }
                });
        },
        consultarAdmisionesFecha() {
            //validacion
            let that = this;
            let url =
                "/gestion_hospitalaria/administracion_cita/cargar_admisiones_por_fecha";
            var loader = that.$loading.show();
            let formulario = "A";
            if (that.esConsultaExterna) {
                formulario = "C";
            }
            if (that.esEmergencia) {
                formulario = "E";
            }
            let parametros = {
                fechaDesde: that.fechaDesde,
                fechaHasta: that.fechaHasta,
                tipo_consulta: that.tipoConsulta,
                formulario: formulario
            };
            axios
                .post(url, parametros)
                .then(function(response) {
                    let admisiones = [];
                    response.data.datos.forEach(admision => {
                        let objeto = {};
                        objeto.codidoCita = admision.CITA_COD;
                        objeto.userObject = { id: admision.USER_ID };
                        objeto.codigo_usuario = admision.USER_ID;
                        if (admision.paciente != null) {
                            objeto.paciente_nombre = that.$funcionesGlobales.toCapitalFirstAllWords(
                                admision.paciente.FULL_NAME
                            );
                            objeto.nombre_paciente = that.$funcionesGlobales.toCapitalFirstAllWords(
                                admision.paciente.FULL_NAME_IDENTIFICATION
                            );
                        }

                        objeto.fecha_admision = admision.created_at;
                        objeto.estado_actual =
                            admision.estados_cita[
                                admision.estados_cita.length - 1
                            ].ESTADO_CITA_NOM;
                        objeto.fecha_cambio_ultimo =
                            admision.estados_cita[
                                admision.estados_cita.length - 1
                            ].created_at;
                        objeto.acompanante = "S";
                        objeto.acompanante_nombre = "";
                        objeto.id_acompanante = "";
                        objeto.US_COD = admision.paciente.US_COD;
                        let coberturaPolizas = [];
                        admision.cobertura_polizas.forEach(poliza => {
                            coberturaPolizas.push({
                                codigo_poliza: poliza.POLIZA_COD,
                                codigo_usuario_beneficiario:
                                    poliza.BENEFICIARIO_COD,
                                poliza_nombre_mostrar:
                                    poliza.poliza.FULL_NAME_POLIZA,
                                beneficiario_nombre_mostrar:
                                    poliza.beneficiario.usuario_beneficiario
                                        .FULL_NAME_IDENTIFICATION,
                                porcentaje: parseFloat(
                                    parseFloat(
                                        poliza.COBERTURAPOLIZA_PORCENTAJE
                                    ).toFixed(2)
                                )
                            });
                        });
                        objeto.coberturaPolizas = coberturaPolizas;
                        let cedulaObject = admision.paciente.identificaciones.find(
                            element => element.ID_COD === "CEDULA"
                        );
                        if (cedulaObject == null || cedulaObject == undefined) {
                            cedulaObject = admision.paciente.identificaciones.find(
                                element => element.ID_COD === "PASAPORTE "
                            );
                        }
                        if (cedulaObject == null || cedulaObject == undefined) {
                            cedulaObject = admision.paciente.identificaciones.find(
                                element => element.ID_COD === "17-DIGITOS "
                            );
                        }
                        objeto.US_CED =
                            cedulaObject !== null && cedulaObject !== undefined
                                ? cedulaObject.USID_CODIGO
                                : "";
                        if (admision.CITA_ACOMPAÑANTE_COD != null) {
                            objeto.acompanante = "A";
                            objeto.acompanante_nombre =
                                admision.acompanante.FULL_NAME_IDENTIFICACION;
                            objeto.id_acompanante =
                                admision.CITA_ACOMPAÑANTE_COD;
                        }
                        admisiones.push(objeto);
                    });

                    that.admisiones = admisiones;
                    loader.hide();
                })
                .catch(error => {
                    //Errores
                    loader.hide();
                    if (error.response.status == 421) {
                        that.$swal({
                            icon: "error",
                            title: "Existe un error",
                            text: error.response.data.msg
                        });
                    } else {
                        that.$swal({
                            icon: "error",
                            title: "Existe un error",
                            text: error
                        });
                    }
                });
        },
        handleChangeRadio() {
            if (this.tipoConsulta != "A") {
                this.tipoConsulta = "A";
                this.consultarAdmisionesFecha();
            }
        },
        async cargarDatosIniciales() {
            var loader = this.$loading.show();
            await this.consultarAdmisionesFecha();
            await this.cargarEspecialidades();
            loader.hide();
        },
        cargarEspecialidades() {
            let that = this;
            let url =
                "/gestion_hospitalaria/personal_medico/cargar_especialidades_lista";

            axios
                .get(url)
                .then(function(response) {
                    let especialidades = [];

                    for (let i = 0; i < response.data.datos.length; i++) {
                        let objeto = {
                            display: response.data.datos[i].nombre,
                            value: response.data.datos[i].codigo
                        };
                        especialidades.push(objeto);
                    }
                    that.especialidades = especialidades;
                })
                .catch(error => {
                    //Errores
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                });
        }
    }
};
</script>
