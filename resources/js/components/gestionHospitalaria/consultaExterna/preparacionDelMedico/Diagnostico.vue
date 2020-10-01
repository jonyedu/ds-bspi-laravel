<template>
    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Diagnóstico</h5>
            </div>
            <div class="card-body">
                <form role="form">
                    <!-- Seccion para realizar la seleccion del diagnostico principal -->
                    <div class="row">
                        <div
                            class="col-lg-12 col-md-12 col-sm-12 alert alert-primary"
                            role="alert"
                        >
                            <b>Tenga en consideración lo siguiente</b><br>
                            *Presuntivo es un diagnóstico basado es una suposición.<br>
                            *Definitivo es un diagnóstico concreto.
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 mt-2">
                            <div class="form-inline">
                                <div class="btn-group" role="group">
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        :disabled="$props.readOnly"
                                        @click="abrirModalDiagnostico(1)"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                                <input
                                    style="display:flex;flex-grow:1 "
                                    type="text"
                                    :class="'form-control'"
                                    :readonly="true"
                                    id="acompanante"
                                    placeholder="(*) Seleccione el diagnóstico Principal"
                                    v-model="form.frm_diagnostico_principal"
                                />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline1"
                                    name="tipo1"
                                    @click="activarDesactivarPrincipal(1)"
                                    value="1"
                                    v-model="form.frm_seleccion_radio_principal"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline1"
                                    >Presuntivo</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline2"
                                    name="tipo1"
                                    value="0"
                                    @click="activarDesactivarPrincipal(0)"
                                    v-model="form.frm_seleccion_radio_principal"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline2"
                                    >Definitivo</label
                                >
                            </div>
                        </div>
                    </div>
                    <!-- Fin Seccion para realizar la seleccion del diagnostico principal -->
                    <!-- Seccion para realizar la seleccion del diagnostico asociado 1 -->
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 mt-2">
                            <div class="form-inline">
                                <div class="btn-group" role="group">
                                    <button
                                        :disabled="$props.readOnly"
                                        type="button"
                                        class="btn btn-success"
                                        @click="abrirModalDiagnostico(2)"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                                <input
                                    style="display:flex;flex-grow:1 "
                                    type="text"
                                    :class="'form-control'"
                                    :readonly="true"
                                    id="acompanante"
                                    placeholder="Seleccione el diagnóstico Asociado (1)"
                                    v-model="form.frm_diagnostico_uno"
                                />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline3"
                                    name="tipo2"
                                    @click="activarDesactivarUno(1)"
                                    value="1"
                                    v-model="form.frm_seleccion_radio_uno"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline3"
                                    >Presuntivo</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline4"
                                    name="tipo2"
                                    value="0"
                                    @click="activarDesactivarUno(0)"
                                    v-model="form.frm_seleccion_radio_uno"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline4"
                                    >Definitivo</label
                                >
                            </div>
                        </div>
                    </div>
                    <!-- Fin Seccion para realizar la seleccion del diagnostico asociado 1 -->
                    <!-- Seccion para realizar la seleccion del diagnostico asociado 2 -->
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 mt-2">
                            <div class="form-inline">
                                <div class="btn-group" role="group">
                                    <button
                                        :disabled="$props.readOnly"
                                        type="button"
                                        class="btn btn-warning"
                                        @click="abrirModalDiagnostico(3)"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                                <input
                                    style="display:flex;flex-grow:1 "
                                    type="text"
                                    :class="'form-control'"
                                    :readonly="true"
                                    id="acompanante"
                                    placeholder="Seleccione el diagnóstico Asociado (2)"
                                    v-model="form.frm_diagnostico_dos"
                                />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline5"
                                    name="tipo3"
                                    @click="activarDesactivarDos(1)"
                                    value="1"
                                    v-model="form.frm_seleccion_radio_dos"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline5"
                                    >Presuntivo</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline6"
                                    name="tipo3"
                                    value="0"
                                    @click="activarDesactivarDos(0)"
                                    v-model="form.frm_seleccion_radio_dos"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline6"
                                    >Definitivo</label
                                >
                            </div>
                        </div>
                    </div>
                    <!-- Fin Seccion para realizar la seleccion del diagnostico asociado 2 -->
                    &nbsp;
                    <!-- Inicio seccion Notas de Evolución -->
                    <div class="card card-warning">
                        <div
                            class="card-header"
                            style="background-color:#ECECEC;color:#000000;"
                        >
                            <h6 class="card-title">Notas de Evolución</h6>
                        </div>
                        <div class="card-body">
                            <form role="form">
                                <div class="row">
                                    <!--Inicio Signos - Sintomas Actual  -->
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label
                                                ><label class="text-danger"
                                                    >(*)</label
                                                >
                                                Signos - Síntomas Actual</label
                                            >
                                            <textarea
                                                :disabled="$props.readOnly"
                                                type="text"
                                                class="form-control"
                                                placeholder="Signos - Síntomas Actual...."
                                                rows="4"
                                                v-model="form.frm_signo_sintoma"
                                            />
                                        </div>
                                    </div>
                                    <!--Fin Signos - Sintomas Actual  -->
                                    <!--Inicio Plan -->
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label
                                                ><label class="text-danger"
                                                    >(*)</label
                                                >
                                                Plan</label
                                            >
                                            <textarea
                                                :disabled="$props.readOnly"
                                                type="text"
                                                class="form-control"
                                                placeholder="Plan...."
                                                rows="4"
                                                v-model="form.frm_plan"
                                            />
                                        </div>
                                    </div>
                                    <!--Fin Signos - Sintomas Actual  -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Fin seccion Notas de Evolución -->
                </form>
            </div>
        </div>
        <modal
            :width="'60%'"
            height="auto"
            :scrollable="true"
            name="diagnostico"
        >
            <lista-diagnostico
                :opc="opc"
                ref="diagnostico"
                @handleSeleccionarClick="handleSeleccionarClick"
            ></lista-diagnostico>
        </modal>
    </div>
</template>
<script>
export default {
    props: {
        idCita: {
            type: Number
        },
        readOnly: {
            type: Boolean,
            default: false
        }
    },
    data: function() {
        return {
            validarGuardarModificar: 0,
            opc: 0,
            form: {
                frm_idCie_principal: null,
                frm_idCie_principal_modif: null,
                frm_clave_principal: null,
                frm_descripcion_principal: null,

                frm_idCie_uno: null,
                frm_idCie_uno_modif: null,
                frm_clave_uno: null,
                frm_descripcion_uno: null,

                frm_idCie_dos: null,
                frm_idCie_dos_modif: null,
                frm_clave_dos: null,
                frm_descripcion_dos: null,

                frm_diagnostico_principal: null,
                frm_diagnostico_uno: null,
                frm_diagnostico_dos: null,
                frm_signo_sintoma: "",
                frm_plan: "",

                frm_seleccion_radio_principal: 1,
                frm_tipo_presuntivo_principal: 1,
                frm_tipo_definitivo_principal: 0,

                frm_seleccion_radio_uno: 1,
                frm_tipo_presuntivo_uno: 1,
                frm_tipo_definitivo_uno: 0,

                frm_seleccion_radio_dos: 1,
                frm_tipo_presuntivo_dos: 1,
                frm_tipo_definitivo_dos: 0
            }
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.diagnostico.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        if (this.$props.idCita != null) {
            this.cargarDiagnostico();
        }
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.diagnostico.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        //Metodo para cargar los datos del paciente del Diagnostico mediante el cod cita
        cargarDiagnostico: function() {
            let that = this;
            let url =
                "/gestion_hospitalaria/consulta_externa/cargar_diagnostico/" +
                that.$props.idCita;
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    //Obtiene los datos de Diagnostico
                    if (response.data.diagnostico == "") {
                        that.validarGuardarModificar = 0;
                        loader.hide();
                    } else {
                        that.validarGuardarModificar = 1;
                        that.form.frm_signo_sintoma =
                            response.data.diagnostico[0].DIAGNOSTICO_SIGNOS_SINTOMAS;
                        that.form.frm_plan =
                            response.data.diagnostico[0].DIAGNOSTICO_PLAN;
                        if (response.data.diagnostico.length == 1) {
                            //Principal
                            if (
                                response.data.diagnostico[0]
                                    .DIAGNOSTICO_PRESUNTIVO == 1
                            ) {
                                that.form.frm_seleccion_radio_principal = 1;
                                that.form.frm_tipo_presuntivo_principal = 1;
                                that.form.frm_tipo_definitivo_principal = 0;
                            } else {
                                that.form.frm_seleccion_radio_principal = 0;
                                that.form.frm_tipo_presuntivo_principal = 0;
                                that.form.frm_tipo_definitivo_principal = 1;
                            }
                            that.form.frm_tipo_presuntivo;
                            that.form.frm_diagnostico_principal =
                                response.data.diagnostico[0].cie.FULL_NAME;
                            that.form.frm_idCie_principal =
                                response.data.diagnostico[0].CIE_COD;
                            that.form.frm_idCie_principal_modif =
                                response.data.diagnostico[0].CIE_COD;
                        } else if (response.data.diagnostico.length == 2) {
                            //Principal
                            if (
                                response.data.diagnostico[0]
                                    .DIAGNOSTICO_PRESUNTIVO == 1
                            ) {
                                that.form.frm_seleccion_radio_principal = 1;
                                that.form.frm_tipo_presuntivo_principal = 1;
                                that.form.frm_tipo_definitivo_principal = 0;
                            } else {
                                that.form.frm_seleccion_radio_principal = 0;
                                that.form.frm_tipo_presuntivo_principal = 0;
                                that.form.frm_tipo_definitivo_principal = 1;
                            }
                            that.form.frm_diagnostico_principal =
                                response.data.diagnostico[0].cie.FULL_NAME;
                            that.form.frm_idCie_principal =
                                response.data.diagnostico[0].CIE_COD;
                            that.form.frm_idCie_principal_modif =
                                response.data.diagnostico[0].CIE_COD;
                            //Uno
                            if (
                                response.data.diagnostico[1]
                                    .DIAGNOSTICO_PRESUNTIVO == 1
                            ) {
                                that.form.frm_seleccion_radio_uno = 1;
                                that.form.frm_tipo_presuntivo_uno = 1;
                                that.form.frm_tipo_definitivo_uno = 0;
                            } else {
                                that.form.frm_seleccion_radio_uno = 0;
                                that.form.frm_tipo_presuntivo_uno = 0;
                                that.form.frm_tipo_definitivo_uno = 1;
                            }
                            that.form.frm_diagnostico_uno =
                                response.data.diagnostico[1].cie.FULL_NAME;
                            that.form.frm_idCie_uno =
                                response.data.diagnostico[1].CIE_COD;
                            that.form.frm_idCie_uno_modif =
                                response.data.diagnostico[1].CIE_COD;
                        } else if (response.data.diagnostico.length == 3) {
                            //Principal
                            if (
                                response.data.diagnostico[0]
                                    .DIAGNOSTICO_PRESUNTIVO == 1
                            ) {
                                that.form.frm_seleccion_radio_principal = 1;
                                that.form.frm_tipo_presuntivo_principal = 1;
                                that.form.frm_tipo_definitivo_principal = 0;
                            } else {
                                that.form.frm_seleccion_radio_principal = 0;
                                that.form.frm_tipo_presuntivo_principal = 0;
                                that.form.frm_tipo_definitivo_principal = 1;
                            }
                            that.form.frm_diagnostico_principal =
                                response.data.diagnostico[0].cie.FULL_NAME;
                            that.form.frm_idCie_principal =
                                response.data.diagnostico[0].CIE_COD;
                            that.form.frm_idCie_principal_modif =
                                response.data.diagnostico[0].CIE_COD;
                            //Uno
                            if (
                                response.data.diagnostico[1]
                                    .DIAGNOSTICO_PRESUNTIVO == 1
                            ) {
                                that.form.frm_seleccion_radio_uno = 1;
                                that.form.frm_tipo_presuntivo_uno = 1;
                                that.form.frm_tipo_definitivo_uno = 0;
                            } else {
                                that.form.frm_seleccion_radio_uno = 0;
                                that.form.frm_tipo_presuntivo_uno = 0;
                                that.form.frm_tipo_definitivo_uno = 1;
                            }
                            that.form.frm_diagnostico_uno =
                                response.data.diagnostico[1].cie.FULL_NAME;
                            that.form.frm_idCie_uno =
                                response.data.diagnostico[1].CIE_COD;
                            that.form.frm_idCie_uno_modif =
                                response.data.diagnostico[1].CIE_COD;
                            //Dos
                            if (
                                response.data.diagnostico[2]
                                    .DIAGNOSTICO_PRESUNTIVO == 1
                            ) {
                                that.form.frm_seleccion_radio_dos = 1;
                                that.form.frm_tipo_presuntivo_dos = 1;
                                that.form.frm_tipo_definitivo_dos = 0;
                            } else {
                                that.form.frm_seleccion_radio_dos = 0;
                                that.form.frm_tipo_presuntivo_dos = 0;
                                that.form.frm_tipo_definitivo_dos = 1;
                            }
                            that.form.frm_diagnostico_dos =
                                response.data.diagnostico[2].cie.FULL_NAME;
                            that.form.frm_idCie_dos =
                                response.data.diagnostico[2].CIE_COD;
                            that.form.frm_idCie_dos_modif =
                                response.data.diagnostico[2].CIE_COD;
                        }
                        loader.hide();
                    }
                    that.$emit(
                        "validarGuardarModificar",
                        that.validarGuardarModificar
                    );
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
        //Metodos para definir el valor de los checkbox
        activarDesactivarPrincipal: function(opc) {
            let that = this;
            if (opc) {
                that.form.frm_tipo_presuntivo_principal = 1;
                that.form.frm_tipo_definitivo_principal = 0;
            } else {
                that.form.frm_tipo_presuntivo_principal = 0;
                that.form.frm_tipo_definitivo_principal = 1;
            }
        },
        activarDesactivarUno: function(opc) {
            let that = this;
            if (opc) {
                that.form.frm_tipo_presuntivo_uno = 1;
                that.form.frm_tipo_definitivo_uno = 0;
            } else {
                that.form.frm_tipo_presuntivo_uno = 0;
                that.form.frm_tipo_definitivo_uno = 1;
            }
        },
        activarDesactivarDos: function(opc) {
            let that = this;
            if (opc) {
                that.form.frm_tipo_presuntivo_dos = 1;
                that.form.frm_tipo_definitivo_dos = 0;
            } else {
                that.form.frm_tipo_presuntivo_dos = 0;
                that.form.frm_tipo_definitivo_dos = 1;
            }
        },
        //Metodo para abril el modal cuando se vaya a buscar el diagnostico
        abrirModalDiagnostico: function(opc) {
            this.$modal.show("diagnostico");
            this.opc = opc;
        },
        //Metodo para cerrar el modal cuando se haya seleccionado el diagnostico
        cerrarModalDiagnostico: function() {
            this.$modal.hide("diagnostico");
            this.validarDiagnostico();
        },
        //Metodo para obtener el dato seleccionado cuando se haya cerrado el modal
        handleSeleccionarClick(value) {
            this.$modal.hide("diagnostico");
            if (this.opc == 1) {
                this.form.frm_idCie_principal = value.id_cie_principal;
                this.form.frm_clave_principal = value.cie_clave_principal;
                this.form.frm_descripcion_principal =
                    value.cie_descripcion_principal;
                this.form.frm_diagnostico_principal =
                    this.form.frm_clave_principal +
                    " -" +
                    this.form.frm_descripcion_principal;
            } else if (this.opc == 2) {
                this.form.frm_idCie_uno = value.id_cie_uno;
                this.form.frm_clave_uno = value.cie_clave_uno;
                this.form.frm_descripcion_uno = value.cie_descripcion_uno;
                this.form.frm_diagnostico_uno =
                    this.form.frm_clave_uno +
                    " -" +
                    this.form.frm_descripcion_uno;
            } else if (this.opc == 3) {
                this.form.frm_idCie_dos = value.id_cie_dos;
                this.form.frm_clave_dos = value.cie_clave_dos;
                this.form.frm_descripcion_dos = value.cie_descripcion_dos;
                this.form.frm_diagnostico_dos =
                    this.form.frm_clave_dos +
                    " -" +
                    this.form.frm_descripcion_dos;
            }
            this.validarDiagnostico();
        },
        //Metodo para validar que los diagnostico seleccionado, no sea el mismo
        validarDiagnostico() {
            if (
                this.form.frm_idCie_principal == this.form.frm_idCie_uno &&
                this.form.frm_idCie_principal != null
            ) {
                if (
                    this.form.frm_diagnostico_principal != null &&
                    this.form.frm_diagnostico_uno == null
                ) {
                    this.form.frm_diagnostico_principal = null;
                    this.form.frm_idCie_principal = null;
                } else {
                    this.form.frm_diagnostico_uno = null;
                    this.form.frm_idCie_uno = null;
                }
                this.$swal({
                    icon: "error",
                    title: "Diagnostico",
                    text:
                        "No puede selecionar el mismo diagnostico. Vuelva a selecione el diagnostico."
                });
            }
            if (
                this.form.frm_idCie_uno == this.form.frm_idCie_dos &&
                this.form.frm_idCie_uno != null
            ) {
                if (
                    this.form.frm_diagnostico_uno != null &&
                    this.form.frm_diagnostico_dos == null
                ) {
                    this.form.frm_diagnostico_uno = null;
                    this.form.frm_idCie_uno = null;
                } else {
                    this.form.frm_diagnostico_dos = null;
                    this.form.frm_idCie_dos = null;
                }
                this.$swal({
                    icon: "error",
                    title: "Diagnostico",
                    text:
                        "No puede selecionar el mismo diagnostico. Vuelva a selecione el diagnostico."
                });
            }
            if (
                this.form.frm_idCie_dos == this.form.frm_idCie_principal &&
                this.form.frm_idCie_dos != null
            ) {
                if (
                    this.form.frm_diagnostico_dos != null &&
                    this.form.frm_diagnostico_principal == null
                ) {
                    this.form.frm_diagnostico_principal = null;
                    this.form.frm_idCie_principal = null;
                } else {
                    this.form.frm_diagnostico_dos = null;
                    this.form.frm_idCie_dos = null;
                }
                this.$swal({
                    icon: "error",
                    title: "Diagnostico",
                    text:
                        "No puede selecionar el mismo diagnostico. Vuelva a selecione el diagnostico."
                });
            }
        },
        //Metodo para guardar o modificar los datos de Diagnostico
        guardarModificarDiagnostico: function(opc) {
            let that = this;
            if (
                that.form.frm_idCie_principal == null ||
                that.form.frm_idCie_principal == ""
            ) {
                that.$swal({
                    icon: "warning",
                    title: "Existen campos requeridos.",
                    text:
                        "Debe haber seleccionar por lo menos el Diagnostico principal para continuar."
                });
                return;
            }
            if (
                that.form.frm_signo_sintoma == null ||
                that.form.frm_signo_sintoma == ""
            ) {
                that.$swal({
                    icon: "warning",
                    title: "Existen campos requeridos.",
                    text: "Signos - Sintomas Actual no puede ser vacio."
                });
                return;
            }
            if (that.form.frm_plan == null || that.form.frm_plan == "") {
                that.$swal({
                    icon: "warning",
                    title: "Existen campos requeridos.",
                    text: "Plan no puede ser vacio."
                });
                return;
            }
            if (this.$props.idCita > 0) {
                let idCita = this.$props.idCita;
                let url =
                    "/gestion_hospitalaria/consulta_externa/guardar_modificar_diagnostico/" +
                    idCita;
                if (opc == 1) {
                    //Modificar
                    that.mensaje = "Datos modificados correctamente.";
                } else {
                    //Guardar
                    that.mensaje = "Datos guardados correctamente.";
                }
                var loader = that.$loading.show();
                axios
                    .post(url, this.form)
                    .then(function(response) {
                        loader.hide();
                        that.$swal({
                            icon: "success",
                            title: "Proceso realizado exitosamente",
                            text: that.mensaje
                        });
                    })
                    .catch(error => {
                        if (error.response.status === 421) {
                            that.$swal({
                                icon: "error",
                                title: "Existe un error",
                                text: error.response.data.msg
                            });
                        }
                        loader.hide();
                        that.cargarDiagnostico();
                    });
            } else {
                let that = this;
                that.$swal({
                    icon: "error",
                    title: "Citas",
                    text: "No hay Citas Disponibles"
                });
            }
            this.cargarDiagnostico();
        }
    }
};
</script>
