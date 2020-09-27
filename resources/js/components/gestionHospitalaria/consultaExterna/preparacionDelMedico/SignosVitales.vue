<template>
    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Detalles del Paciente</h5>
            </div>
            <!-- /.card-header -->
            <div
                class="card-body"
                @click.left="calcularSuperficieCorporal"
                @keyup.tab="calcularSuperficieCorporal"
            >
                <form role="form">
                    <div class="row">
                        <!-- Inicio Detalles Personales -->
                        <!--Paciente  -->
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Paciente</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.paciente"
                                    disabled
                                />
                            </div>
                        </div>
                        <!-- Titular -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Titular</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.titular"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--Fecha Nacimiento  -->
                        <div class="col-sm-6">
                            <!-- textarea -->
                            <div class="form-group">
                                <label>Fecha Nacimiento</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="form.fecha_nacimiento"
                                    disabled
                                />
                            </div>
                        </div>
                        <!--Edad  -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Edad</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="form.edad"
                                    disabled
                                />
                            </div>
                        </div>
                        <!-- Fin Detalles Personales -->
                        <!-- Inicio Discapacidad -->
                        <div class="col-sm-12 text-center">
                            <div
                                class="card-header"
                                style="background-color:#C2C2C2;color:#000000;"
                            >
                                <h5 class="card-title">Discapacidad</h5>
                            </div>
                        </div>
                        <!--Discapacidad  -->
                        <div class="col-sm-4">
                            <!-- textarea -->
                            <div class="form-group">
                                <label>Tipo de Discapacidad</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.tipo_discapacidad"
                                    disabled
                                />
                            </div>
                        </div>
                        <!--Discapacidad  -->
                        <div class="col-sm-4">
                            <!-- textarea -->
                            <div class="form-group">
                                <label>Discapacidad</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.discapacidad"
                                    disabled
                                />
                            </div>
                        </div>
                        <!--Grado de Discapacidad  -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Grado de Discapacidad</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.grado_discapacidad"
                                    disabled
                                />
                            </div>
                        </div>
                        <!-- Fin Discapacidad -->
                        <!-- Inicio de Signos Vitales -->
                        <!-- Signos Vitales -->
                        <div class="col-sm-12 text-center">
                            <div
                                class="card-header"
                                style="background-color:#C2C2C2;color:#000000;"
                            >
                                <h5 class="card-title">Signos Vitales</h5>
                            </div>
                        </div>
                        <!--Temperatura (°C)  -->
                        <div class="col-sm-4">
                            <!-- textarea -->
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Temperatura(°C)</label
                                >
                                <input
                                    :readonly="
                                        tipoPersonal == 1 || $props.readOnly
                                    "
                                    type="number"
                                    :class="
                                        errores.temperatura === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    class="form-control"
                                    v-model="form.temperatura"
                                />
                                <small
                                    v-if="errores.temperatura !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.temperatura[0] }}</small
                                >
                            </div>
                        </div>
                        <!--Pulso (xMin)  -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span> Pulso
                                    (xMin)</label
                                >
                                <input
                                    :readonly="
                                        tipoPersonal == 1 || $props.readOnly
                                    "
                                    type="number"
                                    :class="
                                        errores.pulso === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    class="form-control"
                                    v-model="form.pulso"
                                />
                                <small
                                    v-if="errores.pulso !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.pulso[0] }}</small
                                >
                            </div>
                        </div>
                        <!--Presion Arterial (MinGr)  -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Presion Arterial (MinGr)</label
                                >
                                <input
                                    :readonly="
                                        tipoPersonal == 1 || $props.readOnly
                                    "
                                    type="text"
                                    :class="
                                        errores.presion_arterial === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    class="form-control"
                                    v-model="form.presion_arterial"
                                />
                                <small
                                    v-if="errores.presion_arterial !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.presion_arterial[0] }}</small
                                >
                            </div>
                        </div>
                        <!--Respiracion (30xMin)  -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Respiracion (30xMin)</label
                                >
                                <input
                                    :readonly="
                                        tipoPersonal == 1 || $props.readOnly
                                    "
                                    type="number"
                                    :class="
                                        errores.respiracion === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    class="form-control"
                                    v-model="form.respiracion"
                                />
                                <small
                                    v-if="errores.respiracion !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.respiracion[0] }}</small
                                >
                            </div>
                        </div>
                        <!--Peso (Kg)  -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span> Peso
                                    (Kg)</label
                                >
                                <input
                                    :readonly="
                                        tipoPersonal == 1 || $props.readOnly
                                    "
                                    @keyup.enter="calcularSuperficieCorporal"
                                    type="number"
                                    :class="
                                        errores.peso === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    class="form-control"
                                    v-model="form.peso"
                                />
                                <small
                                    v-if="errores.peso !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.peso[0] }}</small
                                >
                            </div>
                        </div>
                        <!--Estatura (Cm)  -->
                        <div class="col-sm-4" v-if="true == false">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Estatura (Cm)</label
                                >
                                <input
                                    :readonly="
                                        tipoPersonal == 1 || $props.readOnly
                                    "
                                    type="number"
                                    :class="
                                        errores.estatura === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    class="form-control"
                                    v-model="form.estatura"
                                />
                                <small
                                    v-if="errores.estatura !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.estatura[0] }}</small
                                >
                            </div>
                        </div>
                        <!--Talla (Cm)  -->
                        <div class="col-sm-4">
                            <!-- numberarea -->
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span> Talla
                                    (Cm)</label
                                >
                                <input
                                    :readonly="
                                        tipoPersonal == 1 || $props.readOnly
                                    "
                                    @keyup.enter="calcularSuperficieCorporal"
                                    type="number"
                                    :class="
                                        errores.talla === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    class="form-control"
                                    v-model="form.talla"
                                />
                                <small
                                    v-if="errores.talla !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.talla[0] }}</small
                                >
                            </div>
                        </div>
                        <!--Superficie Corporal (m2)  -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label
                                    ><span class="text-danger">(*)</span>
                                    Superficie Corporal (m²)</label
                                >
                                <input
                                    :readonly="
                                        tipoPersonal == 1 || $props.readOnly
                                    "
                                    type="number"
                                    :class="
                                        errores.superficie_corporal === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    class="form-control"
                                    v-model="form.superficie_corporal"
                                />
                                <small
                                    v-if="errores.superficie_corporal !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.superficie_corporal[0] }}</small
                                >
                            </div>
                        </div>
                        <!-- Fin de Signos Vitales -->
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
        readOnly: {
            type: Boolean,
            default: false
        },
        tipoPersonal: {
            type: Number,
            required: false
        }
    },
    data: function() {
        return {
            validarGuardarModificar: 0,
            mensaje: "",
            errores: {
                temperatura: "",
                pulso: "",
                presion_arterial: "",
                respiracion: "",
                peso: "",
                estatura: "",
                talla: "",
                superficie_corporal: ""
            },
            form: {
                id_infomacion_inicial: "",
                paciente: "",
                titular: "",
                fecha_nacimiento: "",
                edad: "",
                tipo_discapacidad: "",
                discapacidad: "",
                grado_discapacidad: 0,
                temperatura: "0",
                pulso: "0",
                presion_arterial: "0",
                respiracion: "0",
                peso: "0",
                estatura: "0",
                talla: "0",
                superficie_corporal: "0",
                fecha: ""
            }
        };
    },
    watch: {
        idCita: function(val) {
            this.cargarDetallesPaciente();
            this.obtenerFechaActual();
        }
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.signos_vitales.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        if (this.$props.idCita != null) {
            this.cargarDetallesPaciente();
        }
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.signos_vitales.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        //Metodo para obtener la fecha y hora actual y añadir al input de fecha
        obtenerFechaActual: function() {
            var date = new Date();
            //Año
            var y = date.getFullYear();
            //Mes
            var m = date.getMonth() + 1;
            //Día
            var d = date.getDate();

            //Lo ordenas a gusto.
            var fechaActual = y + "-" + m + "-" + d;
            this.form.fecha = fechaActual;
        },
        //Metodo para obtener la superficie corporal mediante el peso y talla
        calcularSuperficieCorporal: function() {
            if (this.form.peso == "0" && this.form.talla == "0") {
                this.form.superficie_corporal = "0";
            } else {
                var resultado = Math.sqrt(
                    (this.form.peso * this.form.talla) / 3600
                );
                var superficie_corporal = resultado.toFixed(2);
                this.form.superficie_corporal = superficie_corporal;
            }
        },
        //Metodo para obtener los datos del paciente mediante el cod cita
        cargarDetallesPaciente: function() {
            if (this.$props.idCita > 0) {
                let that = this;
                let idCita = this.$props.idCita;
                let url =
                    "/gestion_hospitalaria/consulta_externa/cargar_detalle_paciente/" +
                    idCita;
                var loader = that.$loading.show();
                axios
                    .get(url)
                    .then(function(response) {
                        that.validarGuardarModificar = 0;
                        (that.errores = {
                            temperatura: "",
                            pulso: "",
                            presion_arterial: "",
                            respiracion: "",
                            peso: "",
                            estatura: "",
                            talla: "",
                            superficie_corporal: ""
                        }),
                            (that.form = {
                                id_infomacion_inicial: "",
                                paciente: "",
                                titular: "",
                                fecha_nacimiento: "",
                                edad: "",
                                tipo_discapacidad: "",
                                discapacidad: "",
                                grado_discapacidad: 0,
                                temperatura: "0",
                                pulso: "0",
                                presion_arterial: "0",
                                respiracion: "0",
                                peso: "0",
                                estatura: "0",
                                talla: "0",
                                superficie_corporal: "0",
                                fecha: ""
                            });
                        that.obtenerFechaActual();
                        if (response.data.datos == null) {
                            that.validarGuardarModificar = 0;
                            loader.hide();
                        } else {
                            //Calculamos la edad del paciente
                            var hoy = new Date();
                            var fechaNacimiento = new Date(
                                response.data.datos.paciente.US_FNAC
                            );
                            var edad =
                                hoy.getFullYear() -
                                fechaNacimiento.getFullYear();
                            var diferenciaMeses =
                                hoy.getMonth() - fechaNacimiento.getMonth();
                            if (
                                diferenciaMeses < 0 ||
                                (diferenciaMeses === 0 &&
                                    hoy.getDate() < fechaNacimiento.getDate())
                            ) {
                                edad--;
                            }
                            //Fin
                            //Obtenemos los datos personales del paciente
                            that.form.paciente = that.$funcionesGlobales.toCapitalFirstAllWords(
                                response.data.datos.paciente.FULL_NAME
                            );
                            that.form.titular = that.$funcionesGlobales.toCapitalFirstAllWords(
                                response.data.datos.paciente.FULL_NAME
                            );
                            that.form.fecha_nacimiento =
                                response.data.datos.paciente.US_FNAC;
                            that.form.edad = edad;
                            if (
                                response.data.datos.paciente
                                    .US_PORC_DISCAPACIDAD > 0
                            ) {
                                that.form.tipo_discapacidad = that.$funcionesGlobales.toCapitalFirstAllWords(
                                    response.data.datos.paciente.discapacidad
                                        .DISCAPACIDAD_NOM
                                );
                                that.form.discapacidad = "S";
                                that.form.grado_discapacidad =
                                    response.data.datos.paciente
                                        .US_PORC_DISCAPACIDAD + "%";
                            } else {
                                that.form.tipo_discapacidad = "No Aplica";
                                that.form.discapacidad = "No Aplica";
                                that.form.grado_discapacidad = "0%";
                            }
                            //Fin
                            if (
                                response.data.datos.informacion_inicial != null
                            ) {
                                //Obtenemos los datos de signos vitales
                                that.validarGuardarModificar = 1;
                                that.form.id_infomacion_inicial =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_COD;
                                that.form.temperatura =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_TEMPERATURA;
                                that.form.pulso =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_PULSO;
                                that.form.presion_arterial =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_PRESION_ARTERIAL;
                                that.form.respiracion =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_RESPIRACION;
                                that.form.peso =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_PESO;
                                that.form.estatura =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_ESTATURA;
                                that.form.talla =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_TALLA;
                                that.form.superficie_corporal =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_SUPERFICIE_CORPORAL;
                                that.form.fecha =
                                    response.data.datos.informacion_inicial.INFORMACIONINICIAL_FECHA;
                                loader.hide();
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
                    });
            } else {
                let that = this;
                that.$swal({
                    icon: "error",
                    title: "Citas",
                    text: "No hay Citas Disponibles"
                });
            }
        },
        //Metodo para guardar o modificar los datos de signos vitales
        guardarModificarSignosVitales: function(opc) {
            if (this.$props.idCita > 0) {
                let idCita = this.$props.idCita;
                let that = this;
                let url =
                    "/gestion_hospitalaria/consulta_externa/guardar_modificar_signo_vital/" +
                    idCita;
                if (opc == 1) {
                    that.mensaje = "Datos modificados correctamente.";
                } else {
                    that.mensaje = "Datos guardados correctamente.";
                }
                that.errores = {
                    temperatura: "",
                    pulso: "",
                    presion_arterial: "",
                    respiracion: "",
                    peso: "",
                    estatura: "",
                    talla: "",
                    superficie_corporal: ""
                };
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
                        that.cargarDetallesPaciente();
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            if (
                                error.response.data.errors.temperatura != null
                            ) {
                                that.errores.temperatura =
                                    error.response.data.errors.temperatura;
                            }
                            if (error.response.data.errors.pulso != null) {
                                that.errores.pulso =
                                    error.response.data.errors.pulso;
                            }
                            if (
                                error.response.data.errors.presion_arterial !=
                                null
                            ) {
                                that.errores.presion_arterial =
                                    error.response.data.errors.presion_arterial;
                            }
                            if (
                                error.response.data.errors.respiracion != null
                            ) {
                                that.errores.respiracion =
                                    error.response.data.errors.respiracion;
                            }
                            if (error.response.data.errors.peso != null) {
                                that.errores.peso =
                                    error.response.data.errors.peso;
                            }
                            if (error.response.data.errors.estatura != null) {
                                that.errores.estatura =
                                    error.response.data.errors.estatura;
                            }
                            if (error.response.data.errors.talla != null) {
                                that.errores.talla =
                                    error.response.data.errors.talla;
                            }
                            if (
                                error.response.data.errors
                                    .superficie_corporal != null
                            ) {
                                that.errores.superficie_corporal =
                                    error.response.data.errors.superficie_corporal;
                            }
                            that.$swal({
                            icon: "error",
                            title: "Error al procesar la información.",
                            text: "Error de validación de datos."
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
