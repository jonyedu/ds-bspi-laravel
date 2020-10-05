<template>
    <div class="card col-lg-12 col-md-12 col-sm-12  p-3">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="fecha_cita">Fecha de cita</label>
                    <input
                        :readonly="objetoMod != null"
                        type="date"
                        :min="'2020-06-04'"
                        :class="'form-control'"
                        id="fecha_cita"
                        placeholder="Seleccione la fecha de cita"
                        v-model="fecha_cita"
                    />
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                <label>Desde</label>
                <v-time
                    :disabled="objetoMod != null"
                    @change="changeTimeInicio"
                    v-model="form.hora_inicio"
                    placeholder="Hora Inicio"
                ></v-time>
                <span>Hasta</span>
                <v-time
                    :disabled="objetoMod != null"
                    @change="changeTimeCierre"
                    v-model="form.hora_cierre"
                    placeholder="Hora Fin"
                ></v-time>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mt-2" v-if="horas_validas">
                <div class="form-group">
                    <label for="area">Especialidad</label>
                    <v-select
                        v-model="selectedEspecialidad"
                        :value="form.id_especialidad"
                        :options="especialidades"
                        label="display"
                        @input="setselectedEspecialidad"
                        v-bind:class="{ disabled: objetoMod != null }"
                    ></v-select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mt-2" v-if="horas_validas">
                <div class="form-group">
                    <label for="medico">Médico</label>
                    <v-select
                        v-model="selectedMedico"
                        :value="form.id_doctor"
                        :options="medicos"
                        label="display"
                        @input="setSelectedMedico"
                        v-bind:class="{ disabled: objetoMod != null }"
                    ></v-select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                <div class="form-inline">
                    <button
                        :disabled="objetoMod != null"
                        type="button"
                        class="btn btn-success btn-block"
                        @click="guardarActualizar()"
                    >
                        Ingresar Consulta Externa
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        codigoCita: {
            type: Number
        },
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
            fecha_actual: new Date().toISOString().split("T")[0],
            medicos: [],
            selectedMedico: "",
            existenErroresForm: false,
            horas_validas: false,
            fecha_cita: "",
            selectedEspecialidad: "",
            hora_inicio_data: "",
            hora_cierre_data: "",
            form: {
                codigo_cita: "",
                fecha_cita: "",
                id_especialidad: "",
                hora_inicio: "",
                hora_cierre: "",
                id_doctor: "",
                estado: "C" //Consulta Externa
            },
            datos_paciente_mostrar: ""
        };
    },
    mounted: function() {
        if (this.$props.objetoMod !== null) {
            let objeto = this.$props.objetoMod;
            this.form.codigo_cita = objeto.CITA_COD;
            this.form.fecha_cita = objeto.ESTADOCITA_FECHA;
            this.fecha_cita = objeto.ESTADOCITA_FECHA;
            this.form.id_especialidad = objeto.ESPECIALIDAD_COD;
            this.form.hora_inicio = objeto.ESTADOCITA_HORA_INICIAL;
            this.form.hora_cierre = objeto.ESTADOCITA_HORA_FINAL;
            this.form.id_doctor = objeto.CITA_DOCTOR_COD;
            this.selectedEspecialidad = objeto.especialidad.ESPECIALIDAD_NOM;
            this.selectedMedico = objeto.doctor.user.FULL_NAME;
        }
        this.form.codigo_cita = this.$props.codigoCita;
        //this.form.tipo = "PU";
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .administracion_de_hospital.admisiones.derivacion_consulta_externa
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .administracion_de_hospital.admisiones.derivacion_consulta_externa
            .nombre_formulario;
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
                            display: that.$funcionesGlobales.toCapitalFirstAllWords(
                                response.data[i].user.US_NOM +
                                    " " +
                                    response.data[i].user.US_APELL
                            ),
                            value:
                                response.data[i].TRABAJADORESPERSONALSALUD_COD
                        };
                        doctores.push(objeto);
                    }
                    that.medicos = doctores;

                    loader.hide();
                })
                .catch(error => {
                    //Errores
                    loader.hide();
                    if (error.response.status == 421) {
                        that.$swal({
                            icon: "info",
                            title: "Información",
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
        setSelectedMedico(value) {
            if (value !== null) {
                this.form.id_doctor = value.value;
            } else {
                this.form.id_doctor = "";
            }
        },
        //Funcion para añadir el 0 al mes y día de la fecha
        addZero(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        },
        validarFormulario() {
            if (
                this.form.fecha_cita == "" ||
                this.form.fecha_cita == null ||
                this.form.fecha_cita == undefined
            ) {
                this.$swal({
                    icon: "info",
                    title:
                        "Existen validaciones del formulario que debe completar.",
                    text: "Seleccione una fecha de cita."
                });
                this.existenErroresForm = true;
                return;
            }
            //Validar que la fechacita no sea de menor a la fecha actual
            var hoy = new Date();
            var dd = hoy.getDate();
            var mm = hoy.getMonth() + 1;
            var yyyy = hoy.getFullYear();
            dd = this.addZero(dd);
            mm = this.addZero(mm);
            var fechaActual = yyyy + "-" + mm + "-" + dd;

            if (this.form.fecha_cita < fechaActual) {
                this.$swal({
                    icon: "info",
                    title:
                        "Existen validaciones del formulario que debe completar.",
                    text: "La fecha de la cita no es correcta."
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
                    title:
                        "Existen validaciones del formulario que debe completar.",
                    text: "Seleccione una hora de inicio."
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
                    title:
                        "Existen validaciones del formulario que debe completar.",
                    text: "Seleccione una hora de cierre."
                });
                this.existenErroresForm = true;
                return;
            }
            //Validar que la hora sea de la cita, sea mayor a la hora actual
            if (this.form.fecha_cita <=  fechaActual) {
                var h = hoy.getHours();
                var m = hoy.getMinutes();
                var hora_actual = h + ":" + m;
                if (this.form.hora_inicio < hora_actual) {
                    this.$swal({
                        icon: "info",
                        title:"Existen validaciones del formulario que debe completar.",
                        text: "La hora 'desde' no es correcta."
                    });
                    this.existenErroresForm = true;
                    return;
                }
            }
            if (
                this.form.id_especialidad == "" ||
                this.form.id_especialidad == null ||
                this.form.id_especialidad == undefined
            ) {
                this.$swal({
                    icon: "info",
                    title:
                        "Existen validaciones del formulario que debe completar",
                    text: "Seleccione una especialidad"
                });
                this.existenErroresForm = true;
                return;
            }
            if (
                this.form.id_doctor == "" ||
                this.form.id_doctor == null ||
                this.form.id_doctor == undefined
            ) {
                this.$swal({
                    icon: "info",
                    title:
                        "Existen validaciones del formulario que debe completar",
                    text: "Seleccione un Médico"
                });
                this.existenErroresForm = true;
                return;
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
            if (
                this.hora_cierre_data.H !== "" &&
                this.hora_cierre_data.m !== ""
            ) {
                if (hora_inicio > parseInt(this.hora_cierre_data.H)) {
                    mensaje =
                        "La hora de inicio es mayor que la hora de cierre.";
                    return mensaje;
                }
                if (hora_inicio == parseInt(this.hora_cierre_data.H)) {
                    if (minuto_inicio > parseInt(this.hora_cierre_data.m)) {
                        mensaje =
                            "Las horas son las mismas, sin embargo el minuto de inicio es mayor que el de cierre.";
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
            if (
                this.hora_inicio_data.H !== "" &&
                this.hora_inicio_data.m !== ""
            ) {
                if (hora_cierre < parseInt(this.hora_inicio_data.H)) {
                    mensaje =
                        "La hora de cierre es menor que la hora de inicio.";
                    return mensaje;
                }
                if (hora_cierre == parseInt(this.hora_inicio_data.H)) {
                    if (minuto_cierre < parseInt(this.hora_inicio_data.m)) {
                        mensaje =
                            "Las horas son las mismas, sin embargo el minuto de cierre es menor que el de inicio.";
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
                this.$swal({
                    icon: "info",
                    title: "Validación.",
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
                    title: "Validación.",
                    text: mensaje
                });
            } else {
                this.form.hora_cierre = value.displayTime;
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

        guardarActualizar: function() {
            this.existenErroresForm = false;
            this.validarFormulario();
            if (this.existenErroresForm) {
                return;
            }
            let that = this;
            let url = "";
            let mensaje = "";
            url = "/gestion_hospitalaria/administracion_cita/crear_cita";
            mensaje = "Datos actualizados correctamente.";
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarDatosConsultaExterna");
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente.",
                        text: "Datos actualizados correctamente."
                    });
                })
                .catch(error => {
                    //Errores de validación
                    if (error.response.status === 421) {
                        that.$swal({
                            icon: "error",
                            title: "Existen errores",
                            text: error.response.data.mensaje
                        });
                    } else {
                        that.$swal({
                            icon: "error",
                            title: "Existen errores.",
                            text: error
                        });
                    }
                    loader.hide();
                });
        }
    }
};
</script>
