<template>
    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Evolución</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <!--Evolucion  -->
                        <div class="col-sm-12">
                            <!-- Evolucion -->
                            <div class="form-group">
                                <label><span class="text-danger">(*)</span> Evolución</label>
                                <textarea
                                    :readonly="readOnly || tipoPersonal != 1"
                                    type="text"
                                    :class="
                                        errores.err_evolucion === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    placeholder="Evolución del Paciente...."
                                    rows="3"
                                    v-model="form.frm_evolucion"
                                />
                                <small
                                    v-if="errores.err_evolucion !== ''"
                                    id="observacionHelp"
                                    class="text-danger"
                                    >{{ errores.err_evolucion[0] }}</small
                                >
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
        tipoPersonal: {
            type: Number,
            required: false
        },
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
            errores: {
                err_evolucion: ""
            },
            form: {
                frm_evolucion: "",
                frm_fecha_transaccion: "",
                frm_hora_transaccion: ""
            }
        };
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
            this.cargarEvolucion();
            this.obtenerFechaHoraActual();
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
        obtenerFechaHoraActual: function() {
            var date = new Date();
            //Año
            var y = date.getFullYear();
            //Mes
            var m = date.getMonth() + 1;
            //Día
            var d = date.getDate();

            //Hora
            var h = date.getHours();
            //Minuto
            var mi = date.getMinutes();
            //Segundo
            var s = date.getSeconds();
            //Lo ordenas a gusto.
            var fechaActual = y + "-" + m + "-" + d;
            var horaActual = h + ":" + mi + ":" + s;
            this.form.frm_fecha_transaccion = fechaActual;
            this.form.frm_hora_transaccion = horaActual;
        },
        //Metodo para cargar los datos de evolucion del paciente mediante el cod cita
        cargarEvolucion: function() {
            if (this.$props.idCita > 0) {
                let that = this;
                let idCita = this.$props.idCita;
                let url =
                    "/gestion_hospitalaria/consulta_externa/cargar_evolucion/" +
                    idCita;
                var loader = that.$loading.show();
                axios
                    .get(url)
                    .then(function(response) {
                        that.validarGuardarModificar = 0;
                        (that.errores = {
                            err_evolucion: ""
                        }),
                            (that.form = {
                                frm_evolucion: "",
                                frm_fecha_transaccion: "",
                                frm_hora_transaccion: ""
                            });
                        that.obtenerFechaHoraActual();
                        if (
                            response.data.evolucion.PRESCRIPCION_EVOLUCION ==
                                "" ||
                            response.data.evolucion.PRESCRIPCION_EVOLUCION ==
                                null
                        ) {
                            that.validarGuardarModificar = 0;
                            loader.hide();
                        } else {
                            that.validarGuardarModificar = 1;
                            that.form.frm_evolucion = response.data.evolucion.PRESCRIPCION_EVOLUCION;
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
        //Metodo para guardar o modificar los datos de Evolucion
        guardarModificarEvolucion: function(opc) {
            if (this.$props.idCita > 0) {
                let idCita = this.$props.idCita;
                let that = this;
                let mensaje = "";
                let url =
                    "/gestion_hospitalaria/consulta_externa/guardar_modificar_evolucion/" +
                    idCita;
                if (opc == 1) {
                    //Modificar
                    mensaje = "Datos modificados correctamente.";
                } else {
                    //Guardar
                    mensaje = "Datos guardados correctamente.";
                }
                that.errores = {
                    err_evolucion: ""
                };
                var loader = that.$loading.show();
                axios
                    .post(url, this.form)
                    .then(function(response) {
                        loader.hide();
                        that.$swal({
                            icon: "success",
                            title: "Proceso realizado exitosamente",
                            text: mensaje
                        });
                        that.cargarEvolucion();
                    })
                    .catch(error => {
                        that.$swal({
                            icon: "error",
                            title: "Error al procesar los datos",
                            text: error
                        });
                        if (error.response.status == 422) {
                            if (
                                error.response.data.errors.frm_evolucion != null
                            ) {
                                that.errores.err_evolucion =
                                    error.response.data.errors.frm_evolucion;
                            }
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
