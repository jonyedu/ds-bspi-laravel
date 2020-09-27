<template>
    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Examen Físico Regional</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <!-- Inicio de los radio -->
                        <!-- 1.) Cabeza -->
                        <div class="col-sm-2">
                            <div>
                                <label>1. Cabeza</label>
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline1"
                                    name="EXAMENFISICO_CABEZA"
                                    @click="activarDesactivarCabeza(1)"
                                    value="CP"
                                    v-model="form.seleccion_radio_cabesa"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline1"
                                    >CP</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline2"
                                    name="EXAMENFISICO_CABEZA"
                                    @click="activarDesactivarCabeza(0)"
                                    v-model="form.seleccion_radio_cabesa"
                                    value="SP"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline2"
                                    >SP</label
                                >
                            </div>
                        </div>
                        <!-- 2.) Cuello -->
                        <div class="col-sm-2">
                            <div>
                                <label>2. Cuello</label>
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline3"
                                    name="r2"
                                    value="CP"
                                    @click="activarDesactivarCuello(1)"
                                    v-model="form.seleccion_radio_cuello"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline3"
                                    >CP</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline4"
                                    name="r2"
                                    value="SP"
                                    @click="activarDesactivarCuello(0)"
                                    v-model="form.seleccion_radio_cuello"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline4"
                                    >SP</label
                                >
                            </div>
                        </div>
                        <!-- 3.) Torax -->
                        <div class="col-sm-2">
                            <div>
                                <label>3. Torax</label>
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline5"
                                    name="r3"
                                    value="CP"
                                    @click="activarDesactivarTorax(1)"
                                    v-model="form.seleccion_radio_torax"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline5"
                                    >CP</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline6"
                                    name="r3"
                                    value="SP"
                                    @click="activarDesactivarTorax(0)"
                                    v-model="form.seleccion_radio_torax"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline6"
                                    >SP</label
                                >
                            </div>
                        </div>
                        <!-- 4.) Abdomen -->
                        <div class="col-sm-2">
                            <div>
                                <label>4. Abdomen</label>
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline7"
                                    name="r4"
                                    value="CP"
                                    @click="activarDesactivarAbdomen(1)"
                                    v-model="form.seleccion_radio_abdomen"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline7"
                                    >CP</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline8"
                                    name="r4"
                                    value="SP"
                                    @click="activarDesactivarAbdomen(0)"
                                    v-model="form.seleccion_radio_abdomen"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline8"
                                    >SP</label
                                >
                            </div>
                        </div>
                        <!-- 5.) Pelvis -->
                        <div class="col-sm-2">
                            <div>
                                <label>5. Pelvis</label>
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline9"
                                    name="r5"
                                    value="CP"
                                    @click="activarDesactivarPelvis(1)"
                                    v-model="form.seleccion_radio_pelvi"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline9"
                                    >CP</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline10"
                                    name="r5"
                                    value="SP"
                                    @click="activarDesactivarPelvis(0)"
                                    v-model="form.seleccion_radio_pelvi"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline10"
                                    >SP</label
                                >
                            </div>
                        </div>
                        <!-- 6.) Extremides -->
                        <div class="col-sm-2">
                            <div>
                                <label>6. Extremidades</label>
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline11"
                                    name="r6"
                                    value="CP"
                                    @click="activarDesactivarExtremides(1)"
                                    v-model="form.seleccion_radio_extremides"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline11"
                                    >CP</label
                                >
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    :disabled="tipoPersonal != 1"
                                    type="radio"
                                    class="custom-control-input"
                                    id="defaultInline12"
                                    name="r6"
                                    value="SP"
                                    @click="activarDesactivarExtremides(0)"
                                    v-model="form.seleccion_radio_extremides"
                                />
                                <label
                                    class="custom-control-label"
                                    for="defaultInline12"
                                    >SP</label
                                >
                            </div>
                        </div>
                        <!-- Fin de los radio -->
                    </div>
                </form>
                <div
                    v-if="$props.readOnly"
                    style="position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"
                ></div>
            </div>
            <div class="card-body" v-if="cabeza == '1'">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><span class="text-danger">(*)</span> 1. Descripción de Cabeza</label>
                                <textarea
                                    :disabled="$props.readOnly"
                                    :readonly="tipoPersonal != 1"
                                    type="te"
                                    class="form-control"
                                    placeholder="Descripción de Cabeza...."
                                    rows="4"
                                    v-model="
                                        form.EXAMENFISICO_CABEZA_CP_DESCRIPCION
                                    "
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body" v-if="cuello == '1'">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><span class="text-danger">(*)</span> 2. Descripción de Cuello</label>
                                <textarea
                                    :disabled="$props.readOnly"
                                    :readonly="tipoPersonal != 1"
                                    type="te"
                                    class="form-control"
                                    placeholder="Descripción de Cuello...."
                                    rows="4"
                                    v-model="
                                        form.EXAMENFISICO_CUELLO_CP_DESCRIPCION
                                    "
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body" v-if="torax == '1'">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><span class="text-danger">(*)</span> 3. Descripción de Torax</label>
                                <textarea
                                    :disabled="$props.readOnly"
                                    :readonly="tipoPersonal != 1"
                                    type="te"
                                    class="form-control"
                                    placeholder="Descripción de Torax...."
                                    rows="4"
                                    v-model="
                                        form.EXAMENFISICO_TORAX_CP_DESCRIPCION
                                    "
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body" v-if="abdomen == '1'">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><span class="text-danger">(*)</span> 4. Descripción de Abdomen</label>
                                <textarea
                                    :disabled="$props.readOnly"
                                    :readonly="tipoPersonal != 1"
                                    type="te"
                                    class="form-control"
                                    placeholder="Descripción de Abdomen...."
                                    rows="4"
                                    v-model="
                                        form.EXAMENFISICO_ABDOMEN_CP_DESCRIPCION
                                    "
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body" v-if="pelvis == '1'">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><span class="text-danger">(*)</span> 5. Descripción de Pelvis</label>
                                <textarea
                                    :disabled="$props.readOnly"
                                    :readonly="tipoPersonal != 1"
                                    type="te"
                                    class="form-control"
                                    placeholder="Descripción de Pelvis...."
                                    rows="4"
                                    v-model="
                                        form.EXAMENFISICO_PELVIS_CP_DESCRIPCION
                                    "
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body" v-if="extremides == '1'">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label> <span class="text-danger">(*)</span> 6. Descripción de Extremidades</label>
                                <textarea
                                    :disabled="$props.readOnly"
                                    :readonly="tipoPersonal != 1"
                                    type="te"
                                    class="form-control"
                                    placeholder="Descripción de Extremidades...."
                                    rows="4"
                                    v-model="
                                        form.EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION
                                    "
                                />
                            </div>
                        </div>
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
            cabeza: 0,
            cuello: 0,
            torax: 0,
            abdomen: 0,
            pelvis: 0,
            extremides: 0,
            form: {
                seleccion_radio_cabesa: "SP",
                seleccion_radio_cuello: "SP",
                seleccion_radio_torax: "SP",
                seleccion_radio_abdomen: "SP",
                seleccion_radio_pelvi: "SP",
                seleccion_radio_extremides: "SP",
                EXAMENFISICO_CABEZA_CP: 0,
                EXAMENFISICO_CABEZA_SP: 0,
                EXAMENFISICO_CABEZA_CP_DESCRIPCION: "",
                EXAMENFISICO_CUELLO_CP: 0,
                EXAMENFISICO_CUELLO_SP: 0,
                EXAMENFISICO_CUELLO_CP_DESCRIPCION: "",
                EXAMENFISICO_TORAX_CP: 0,
                EXAMENFISICO_TORAX_SP: 0,
                EXAMENFISICO_TORAX_CP_DESCRIPCION: "",
                EXAMENFISICO_ABDOMEN_CP: 0,
                EXAMENFISICO_ABDOMEN_SP: 0,
                EXAMENFISICO_ABDOMEN_CP_DESCRIPCION: "",
                EXAMENFISICO_PELVIS_CP: 0,
                EXAMENFISICO_PELVIS_SP: 0,
                EXAMENFISICO_PELVIS_CP_DESCRIPCION: "",
                EXAMENFISICO_EXTREMIDADES_CP: 0,
                EXAMENFISICO_EXTREMIDADES_SP: 0,
                EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION: ""
            }
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.examen_fisico.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        if (this.$props.idCita != null) {
            this.cargarExamenFisico();
        }
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.examen_fisico.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        //Metodos para mostrar/ocultar los textarea cuando los checkbox se haya seleccionado
        activarDesactivarCabeza: function(opc) {
            let that = this;
            //Cabeza
            if (opc) {
                that.cabeza = 1;
                that.form.EXAMENFISICO_CABEZA_CP = 1;
                that.form.EXAMENFISICO_CABEZA_SP = 0;
            } else {
                that.cabeza = 0;
                that.form.EXAMENFISICO_CABEZA_CP = 0;
                that.form.EXAMENFISICO_CABEZA_SP = 1;
            }
        },
        activarDesactivarCuello: function(opc) {
            let that = this;
            if (opc == 1) {
                that.cuello = 1;
                that.form.EXAMENFISICO_CUELLO_CP = 1;
                that.form.EXAMENFISICO_CUELLO_SP = 0;
            } else {
                that.cuello = 0;
                that.form.EXAMENFISICO_CUELLO_CP = 0;
                that.form.EXAMENFISICO_CUELLO_SP = 1;
            }
        },
        activarDesactivarTorax: function(opc) {
            let that = this;
            if (opc == 1) {
                that.torax = 1;
                that.form.EXAMENFISICO_TORAX_CP = 1;
                that.form.EXAMENFISICO_TORAX_SP = 0;
            } else {
                that.torax = 0;
                that.form.EXAMENFISICO_TORAX_CP = 0;
                that.form.EXAMENFISICO_TORAX_SP = 1;
            }
        },
        activarDesactivarAbdomen: function(opc) {
            let that = this;
            if (opc == 1) {
                that.abdomen = 1;
                that.form.EXAMENFISICO_ABDOMEN_CP = 1;
                that.form.EXAMENFISICO_ABDOMEN_SP = 0;
            } else {
                that.abdomen = 0;
                that.form.EXAMENFISICO_ABDOMEN_CP = 0;
                that.form.EXAMENFISICO_ABDOMEN_SP = 1;
            }
        },
        activarDesactivarPelvis: function(opc) {
            let that = this;
            if (opc == 1) {
                that.pelvis = 1;
                that.form.EXAMENFISICO_PELVIS_CP = 1;
                that.form.EXAMENFISICO_PELVIS_SP = 0;
            } else {
                that.pelvis = 0;
                that.form.EXAMENFISICO_PELVIS_CP = 0;
                that.form.EXAMENFISICO_PELVIS_SP = 1;
            }
        },
        activarDesactivarExtremides: function(opc) {
            let that = this;
            if (opc == 1) {
                that.extremides = 1;
                that.form.EXAMENFISICO_EXTREMIDADES_CP = 1;
                that.form.EXAMENFISICO_EXTREMIDADES_SP = 0;
            } else {
                that.extremides = 0;
                that.form.EXAMENFISICO_EXTREMIDADES_CP = 0;
                that.form.EXAMENFISICO_EXTREMIDADES_SP = 1;
            }
        },
        //Metodo para cargar los datos del paciente de ExamenFisico mediante el cod cita
        cargarExamenFisico: function() {
            let that = this;
            let url =
                "/gestion_hospitalaria/consulta_externa/cargar_examen_fisico/" +
                that.$props.idCita;
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    //Obtiene los datos de examenFisico
                    if (response.data.examenFisico == null) {
                        that.validarGuardarModificar = 0;
                        loader.hide();
                    } else {
                        that.validarGuardarModificar = 1;
                        //Validar Cabeza
                        if (
                            response.data.examenFisico.EXAMENFISICO_CABEZA_CP ==
                            1
                        ) {
                            that.cabeza = 1;
                            that.form.seleccion_radio_cabesa = "CP";
                            that.form.EXAMENFISICO_CABEZA_CP = 1;
                        }
                        if (
                            response.data.examenFisico.EXAMENFISICO_CABEZA_SP ==
                            1
                        ) {
                            that.cabeza = 0;
                            that.form.seleccion_radio_cabesa = "SP";
                            that.form.EXAMENFISICO_CABEZA_SP = 1;
                        }
                        //Validar Cuello
                        if (
                            response.data.examenFisico.EXAMENFISICO_CUELLO_CP ==
                            1
                        ) {
                            that.cuello = 1;
                            that.form.seleccion_radio_cuello = "CP";
                            that.form.EXAMENFISICO_CUELLO_CP = 1;
                        }
                        if (
                            response.data.examenFisico.EXAMENFISICO_CUELLO_SP ==
                            1
                        ) {
                            that.cuello = 0;
                            that.form.seleccion_radio_cuello = "SP";
                            that.form.EXAMENFISICO_CUELLO_SP = 1;
                        }
                        //Validar Torax
                        if (
                            response.data.examenFisico.EXAMENFISICO_TORAX_CP ==
                            1
                        ) {
                            that.torax = 1;
                            that.form.seleccion_radio_torax = "CP";
                            that.form.EXAMENFISICO_TORAX_CP = 1;
                        }
                        if (
                            response.data.examenFisico.EXAMENFISICO_TORAX_SP ==
                            1
                        ) {
                            that.torax = 0;
                            that.form.seleccion_radio_torax = "SP";
                            that.form.EXAMENFISICO_TORAX_SP = 1;
                        }
                        //Validar Abdomen
                        if (
                            response.data.examenFisico
                                .EXAMENFISICO_ABDOMEN_CP == 1
                        ) {
                            that.abdomen = 1;
                            that.form.seleccion_radio_abdomen = "CP";
                            that.form.EXAMENFISICO_ABDOMEN_CP = 1;
                        }
                        //Validar Pelvis
                        if (
                            response.data.examenFisico.EXAMENFISICO_PELVIS_CP ==
                            1
                        ) {
                            that.pelvis = 1;
                            that.form.seleccion_radio_pelvi = "CP";
                            that.form.EXAMENFISICO_PELVIS_CP = 1;
                        }
                        if (
                            response.data.examenFisico.EXAMENFISICO_PELVIS_SP ==
                            1
                        ) {
                            that.pelvis = 0;
                            that.form.seleccion_radio_pelvi = "SP";
                            that.form.EXAMENFISICO_PELVIS_SP = 1;
                        }
                        //Validar Extremides
                        if (
                            response.data.examenFisico
                                .EXAMENFISICO_EXTREMIDADES_CP == 1
                        ) {
                            that.extremides = 1;
                            that.form.seleccion_radio_extremides = "CP";
                            that.form.EXAMENFISICO_EXTREMIDADES_CP = 1;
                        }
                        if (
                            response.data.examenFisico
                                .EXAMENFISICO_EXTREMIDADES_SP == 1
                        ) {
                            that.extremides = 0;
                            that.form.seleccion_radio_extremides = "SP";
                            that.form.EXAMENFISICO_EXTREMIDADES_SP = 1;
                        }
                        that.form.EXAMENFISICO_CABEZA_CP_DESCRIPCION = response.data.examenFisico.EXAMENFISICO_CABEZA_CP_DESCRIPCION;
                        that.form.EXAMENFISICO_CUELLO_CP_DESCRIPCION = response.data.examenFisico.EXAMENFISICO_CUELLO_CP_DESCRIPCION;
                        that.form.EXAMENFISICO_TORAX_CP_DESCRIPCION = response.data.examenFisico.EXAMENFISICO_TORAX_CP_DESCRIPCION;
                        that.form.EXAMENFISICO_ABDOMEN_CP_DESCRIPCION = response.data.examenFisico.EXAMENFISICO_ABDOMEN_CP_DESCRIPCION;
                        that.form.EXAMENFISICO_PELVIS_CP_DESCRIPCION = response.data.examenFisico.EXAMENFISICO_PELVIS_CP_DESCRIPCION;
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
                        title: "Existe un Error.",
                        text: error
                    });
                });
        },
        //Metodo para guardar o modificar los datos de Examen Fisico
        guardarModificarExamenFisico: function(opc) {
            if (this.$props.idCita > 0) {
                let idCita = this.$props.idCita;
                let url =
                    "/gestion_hospitalaria/consulta_externa/guardar_modificar_examen_fisico/" +
                    idCita;
                let that = this;
                if (opc == 1) {
                    //Modificar
                    that.mensaje = "Datos modificados correctamente.";
                } else {
                    //Guardar
                    that.mensaje = "Datos guardados correctamente.";
                }
                var loader = that.$loading.show();
                //Cuando los valores sean SP, me ayudaran a borrar la caja de texto de descripciones
                if (that.form.EXAMENFISICO_CABEZA_SP == 1) {
                    that.form.EXAMENFISICO_CABEZA_CP_DESCRIPCION = "";
                }
                if (that.form.EXAMENFISICO_CUELLO_SP == 1) {
                    that.form.EXAMENFISICO_CUELLO_CP_DESCRIPCION = "";
                }
                if (that.form.EXAMENFISICO_TORAX_SP == 1) {
                    that.form.EXAMENFISICO_TORAX_CP_DESCRIPCION = "";
                }
                if (that.form.EXAMENFISICO_ABDOMEN_SP == 1) {
                    that.form.EXAMENFISICO_ABDOMEN_CP_DESCRIPCION = "";
                }
                if (that.form.EXAMENFISICO_PELVIS_SP == 1) {
                    that.form.EXAMENFISICO_PELVIS_CP_DESCRIPCION = "";
                }
                if (that.form.EXAMENFISICO_EXTREMIDADES_SP == 1) {
                    that.form.EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION = "";
                }
                axios
                    .post(url, this.form)
                    .then(function(response) {
                        loader.hide();
                        that.$swal({
                            icon: "success",
                            title: "Proceso realizado exitosamente",
                            text: that.mensaje
                        });
                        that.cargarExamenFisico();
                    })
                    .catch(error => {
                        if (error.response.status === 421) {
                            that.$swal({
                                icon: "error",
                                title: "Existe un Error.",
                                text: error.response.data.msg
                            });
                        }
                        loader.hide();
                    });
            } else {
                let that = this;
                that.$swal({
                    icon: "error",
                    title: "Citas.",
                    text: "No hay Citas Disponibles."
                });
            }
        }
    }
};
</script>
