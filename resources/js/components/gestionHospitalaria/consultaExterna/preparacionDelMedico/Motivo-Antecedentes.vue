<template>
    <div class="col-md-12">
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Motivo / Antecedentes</h5>
            </div>
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <!--Inicio Motivo de Consulta  -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Motivo de Consulta</label
                                >
                                <textarea
                                    :disabled="$props.readOnly"
                                    :readonly="tipoPersonal != 1"
                                    type="text"
                                    class="form-control"
                                    placeholder="Motivo de Consulta...."
                                    rows="4"
                                    v-model="form.frm_motivo_consulta"
                                />
                            </div>
                        </div>
                        <!--Fin Motivo de Consulta  -->
                        <!--Inicio Antecedentes Personales  -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Antecedentes Personales</label
                                >
                                <textarea
                                    :disabled="$props.readOnly"
                                    :readonly="tipoPersonal != 1"
                                    type="text"
                                    class="form-control"
                                    placeholder="Antecedentes Personales...."
                                    rows="4"
                                    v-model="form.frm_antecedentePersonal"
                                />
                            </div>
                            <!--Inicio Antecedentes Familiares-->
                            <div class="form-group">
                                <label>Antecedentes Familiares</label>
                                <div class="card-body">
                                    <form role="form">
                                        <div class="row">
                                            <!-- Inicio de los radio -->
                                            <!--Inicio Cardiopatía-->
                                            <div class="col-sm-3">
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1 ||
                                                                $props.readOnly
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline1"
                                                        value="1"
                                                        @click="
                                                            validarChkCardiopatia()
                                                        "
                                                        v-model="
                                                            chk.chk_cardiopatia
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline1"
                                                        >1. Cardiopatía</label
                                                    >
                                                </div>
                                            </div>
                                            <!--Fin Cardiopatía-->
                                            <!--Inicio Diabetes-->
                                            <div class="col-sm-3">
                                                <div></div>
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline2"
                                                        @click="
                                                            validarChkDiabete()
                                                        "
                                                        v-model="
                                                            chk.chk_diabete
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline2"
                                                        >2. Diabetes</label
                                                    >
                                                </div>
                                            </div>
                                            <!--Fin Diabetes-->
                                            <!--Inicio Enf. C. Vascular-->
                                            <div class="col-sm-3">
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline3"
                                                        @click="
                                                            validarChkEnfVascular()
                                                        "
                                                        v-model="
                                                            chk.chk_enfVascular
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline3"
                                                    >
                                                        3. Enf. C. Vascular
                                                    </label>
                                                </div>
                                            </div>
                                            <!--Inicio Hipertensión-->
                                            <div class="col-sm-3">
                                                <div></div>
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline4"
                                                        @click="
                                                            validarChkHipertension()
                                                        "
                                                        v-model="
                                                            chk.chk_hipertension
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline4"
                                                        >4. Hipertensión</label
                                                    >
                                                </div>
                                            </div>
                                            <!--Fin Hipertensión-->
                                            <!--Inicio Cancer-->
                                            <div class="col-sm-3">
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline5"
                                                        @click="
                                                            validarChkCancer()
                                                        "
                                                        v-model="chk.chk_cancer"
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline5"
                                                        >5. Cáncer</label
                                                    >
                                                </div>
                                            </div>
                                            <!--Fin Cancer-->
                                            <!--Inicio Tuberculosis-->
                                            <div class="col-sm-3">
                                                <div></div>
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline6"
                                                        @click="
                                                            validarChkTuberculosi()
                                                        "
                                                        v-model="
                                                            chk.chk_tuberculosi
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline6"
                                                        >6. Tuberculosis</label
                                                    >
                                                </div>
                                            </div>
                                            <!--Fin Tuberculosis-->
                                            <!--Inicio Enf. Mental-->
                                            <div class="col-sm-3">
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline7"
                                                        @click="
                                                            validarChkEnfMental()
                                                        "
                                                        v-model="
                                                            chk.chk_enfMental
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline7"
                                                        >7. Enf. Mental</label
                                                    >
                                                </div>
                                            </div>
                                            <!--Fin Enf. Mental-->
                                            <!--Inicio Enf. Infecciosa-->
                                            <div class="col-sm-3">
                                                <div></div>
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline8"
                                                        @click="
                                                            validarChkEnfInfecciosa()
                                                        "
                                                        v-model="
                                                            chk.chk_enfInfecciosa
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline8"
                                                    >
                                                        8. Enf. Infecciosa
                                                    </label>
                                                </div>
                                            </div>
                                            <!--Fin Enf. Infecciosa-->
                                            <!--Inicio Malfomación-->
                                            <div class="col-sm-3">
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline9"
                                                        @click="
                                                            validarChkMalfomacion()
                                                        "
                                                        v-model="
                                                            chk.chk_malfomacion
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline9"
                                                        >9. Mal Formación</label
                                                    >
                                                </div>
                                            </div>
                                            <!--Fin Malfomación-->
                                            <!--Inicio Otro-->
                                            <div class="col-sm-3">
                                                <div
                                                    class="custom-control custom-checkbox custom-control-inline"
                                                >
                                                    <input
                                                        :disabled="
                                                            tipoPersonal != 1
                                                        "
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="defaultInline10"
                                                        @click="
                                                            validarChkOtro()
                                                        "
                                                        v-model="chk.chk_otro"
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="defaultInline10"
                                                        >10. Otro</label
                                                    >
                                                </div>
                                            </div>
                                            <!--Fin Otro-->
                                            <!-- Fin de los radio -->
                                        </div>
                                    </form>
                                    <div
                                        v-if="$props.readOnly"
                                        style="position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"
                                    ></div>
                                </div>
                            </div>
                            <!--Fin Antecedentes Familiares-->
                        </div>
                        <!--Fin Antecedentes Personales-->
                        <!--Inicio Enfermedad Actual o Problemas-->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Enfermedad Actual o Problemas</label
                                >
                                <textarea
                                    :readonly="
                                        tipoPersonal != 1 || $props.readOnly
                                    "
                                    type="text"
                                    class="form-control"
                                    placeholder="Enfermedad Actual o Problema...."
                                    rows="4"
                                    v-model="form.frm_enfermedadActualProblema"
                                />
                            </div>
                        </div>
                        <!--Fin Enfermedad Actual o Problemas-->
                        <!--Inicio  REVISION ACTUAL DE ORGANOS Y SISTEMAS-->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Revisión Actual de Órganos y Sistema</label
                                >
                                <textarea
                                    type="text"
                                    :readonly="
                                        tipoPersonal != 1 || $props.readOnly
                                    "
                                    class="form-control"
                                    placeholder="Revisión Actual de Órganos y Sistemas...."
                                    rows="4"
                                    v-model="
                                        form.frm_revisionActualOrganoSistema
                                    "
                                />
                            </div>
                        </div>
                        <!--Fin  REVISION ACTUAL DE ORGANOS Y SISTEMAS-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        idCita: {
            type: Number
        },
        tipoPersonal: {
            type: Number,
            required: false
        },
        readOnly: {
            type: Boolean,
            default: false
        }
    },
    data: function() {
        return {
            validarGuardarModificar: 0,
            chk: {
                chk_cardiopatia: false,
                chk_diabete: false,
                chk_enfVascular: false,
                chk_hipertension: false,
                chk_cancer: false,
                chk_tuberculosi: false,
                chk_enfMental: false,
                chk_enfInfecciosa: false,
                chk_malfomacion: false,
                chk_otro: false
            },
            form: {
                frm_motivo_consulta: "",
                frm_antecedentePersonal: "",
                frm_enfermedadActualProblema: "",
                frm_revisionActualOrganoSistema: "",
                frm_cardiopatia: 0,
                frm_diabete: 0,
                frm_enfVascular: 0,
                frm_hipertension: 0,
                frm_cancer: 0,
                frm_tuberculosi: 0,
                frm_enfMental: 0,
                frm_enfInfecciosa: 0,
                frm_malfomacion: 0,
                frm_otro: 0
            }
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.motivo_antecedentes.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        if (this.$props.idCita != null) {
            this.cargarMotivoAntecedente();
        }
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.motivo_antecedentes.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        //Metodos para validar los checkbox
        validarChkCardiopatia() {
            //1.) Cardiopatía
            if (this.chk.chk_cardiopatia) {
                this.form.frm_cardiopatia = 0;
            } else {
                this.form.frm_cardiopatia = 1;
            }
        },
        validarChkDiabete() {
            //2.) Diabetes
            if (this.chk.chk_diabete) {
                this.form.frm_diabete = 0;
            } else {
                this.form.frm_diabete = 1;
            }
        },
        validarChkEnfVascular() {
            //3.) Enf. C. Vascular
            if (this.chk.chk_enfVascular) {
                this.form.frm_enfVascular = 0;
            } else {
                this.form.frm_enfVascular = 1;
            }
        },
        validarChkHipertension() {
            //4.) Hipertensión
            if (this.chk.chk_hipertension) {
                this.form.frm_hipertension = 0;
            } else {
                this.form.frm_hipertension = 1;
            }
        },
        validarChkCancer() {
            //5.) Cáncer
            if (this.chk.chk_cancer) {
                this.form.frm_cancer = 0;
            } else {
                this.form.frm_cancer = 1;
            }
        },
        validarChkTuberculosi() {
            //6.) Tuberculosis
            if (this.chk.chk_tuberculosi) {
                this.form.frm_tuberculosi = 0;
            } else {
                this.form.frm_tuberculosi = 1;
            }
        },
        validarChkEnfMental() {
            //7.) Enf. Mental
            if (this.chk.chk_enfMental) {
                this.form.frm_enfMental = 0;
            } else {
                this.form.frm_enfMental = 1;
            }
        },
        validarChkEnfInfecciosa() {
            //8.) Enf. Infecciosa
            if (this.chk.chk_enfInfecciosa) {
                this.form.frm_enfInfecciosa = 0;
            } else {
                this.form.frm_enfInfecciosa = 1;
            }
        },
        validarChkMalfomacion() {
            //9.) Malfomación
            if (this.chk.chk_malfomacion) {
                this.form.frm_malfomacion = 0;
            } else {
                this.form.frm_malfomacion = 1;
            }
        },
        validarChkOtro() {
            //10.) Otro
            if (this.chk.chk_otro) {
                this.form.frm_otro = 0;
            } else {
                this.form.frm_otro = 1;
            }
        },
        //Metodo para cargar el motivo antecedente del paciente mediantes el cod cita
        cargarMotivoAntecedente: function() {
            let that = this;
            let url =
                "/gestion_hospitalaria/consulta_externa/cargar_motivo_antecedente/" +
                that.$props.idCita;
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    //Obtiene los datos de Motivo Antecedentes
                    if (response.data.motivoAntecedente == null) {
                        that.validarGuardarModificar = 0;
                        loader.hide();
                    } else {
                        that.validarGuardarModificar = 1;
                        that.form.frm_motivo_consulta = response.data.motivoAntecedente.ANTECEDENTE_MOTIVO_CONSULTA;
                        //valido los valores de la BD para asignar a los Checkbox
                        //1.) Cardiopatía
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_CARDIOPATIA == 1
                        ) {
                            that.chk.chk_cardiopatia = true;
                            that.form.frm_cardiopatia = 1;
                        }
                        //2.) Diabetes
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_DIABETES == 1
                        ) {
                            that.chk.chk_diabete = true;
                            that.form.frm_diabete = 1;
                        }
                        //3.) Enf. C. Vascular
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_ENFC_VASCULAR == 1
                        ) {
                            that.chk.chk_enfVascular = true;
                            that.form.frm_enfVascular = 1;
                        }
                        //4.) Hipertensión
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_HIPERTENSION == 1
                        ) {
                            that.chk.chk_hipertension = true;
                            that.form.frm_hipertension = 1;
                        }
                        //5.) Cáncer
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_CANCER == 1
                        ) {
                            that.chk.chk_cancer = true;
                            that.form.frm_cancer = 1;
                        }
                        //6.) Tuberculosis
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_TUBERCULOSIS == 1
                        ) {
                            that.chk.chk_tuberculosi = true;
                            that.form.frm_tuberculosi = 1;
                        }
                        //7.) Enf. Mental
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_ENFMENTAL == 1
                        ) {
                            that.chk.chk_enfMental = true;
                            that.form.frm_enfMental = 1;
                        }
                        //8.) Enf. Infecciosa
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_ENFINFECCIOSA == 1
                        ) {
                            that.chk.chk_enfInfecciosa = true;
                            that.form.frm_enfInfecciosa = 1;
                        }
                        //9.) Malfomación
                        if (
                            response.data.motivoAntecedente
                                .ANTECEDENTE_MALFORMACION == 1
                        ) {
                            that.chk.chk_malfomacion = true;
                            that.form.frm_malfomacion = 1;
                        }
                        //10.) Otro
                        if (
                            response.data.motivoAntecedente.ANTECEDENTE_OTRA ==
                            1
                        ) {
                            that.chk.chk_otro = true;
                            that.form.frm_otro = 1;
                        }
                        that.form.frm_antecedentePersonal = response.data.motivoAntecedente.ANTECEDENTE_PERSONALES;
                        that.form.frm_enfermedadActualProblema = response.data.motivoAntecedente.ANTECEDENTE_ENFERMEDAD_ACTUAL_PROBLEMA;
                        that.form.frm_revisionActualOrganoSistema = response.data.motivoAntecedente.ANTECEDENTE_REVISION_ACTUAL_ORGANO_SISTEMA;
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
        //Metodo para guardar o modificar los datos de motivo antecedente
        guardarModificarMotivoAntecedente: function(opc) {
            //Se comprueba que los campos motivo antecedente, Enfermedad Actual o Problemas,Antecedentes Personales Motivo de Consulta esten llenos.
            if (
                this.form.frm_motivo_consulta == "" ||
                this.form.frm_motivo_consulta == null
            ) {
                this.$swal({
                    icon: "warning",
                    title: "Existen campos requeridos.",
                    text: "Motivo Consulta no puede ser vacio."
                });
                return;
            }
            if (
                this.form.frm_antecedentePersonal == "" ||
                this.form.frm_antecedentePersonal == null
            ) {
                this.$swal({
                    icon: "warning",
                    title: "Existen campos requeridos.",
                    text: "Antecedentes Personales no puede ser vacio."
                });
                return;
            }
            if (
                this.form.frm_enfermedadActualProblema == "" ||
                this.form.frm_enfermedadActualProblema == null
            ) {
                this.$swal({
                    icon: "warning",
                    title: "Existen campos requeridos.",
                    text: "Enfermedad Actual o Problemas no puede ser vacio."
                });
                return;
            }
            if (
                this.form.frm_revisionActualOrganoSistema == "" ||
                this.form.frm_revisionActualOrganoSistema == null
            ) {
                this.$swal({
                    icon: "warning",
                    title: "Existen campos requeridos.",
                    text:
                        "Revisión Actual de Organos y Sistema no puede ser vacio."
                });
                return;
            }

            if (this.$props.idCita > 0) {
                let idCita = this.$props.idCita;
                let url =
                    "/gestion_hospitalaria/consulta_externa/guardar_modificar_motivo_antecedente/" +
                    idCita;
                let that = this;
                if (opc == 1) {
                    that.mensaje = "Datos modificados correctamente.";
                } else {
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
                        that.cargarMotivoAntecedente();
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
                    });
            } else {
                let that = this;
                that.$swal({
                    icon: "error",
                    title: "Citas",
                    text: "No hay Citas Disponibles"
                });
            }
        }
    }
};
</script>
