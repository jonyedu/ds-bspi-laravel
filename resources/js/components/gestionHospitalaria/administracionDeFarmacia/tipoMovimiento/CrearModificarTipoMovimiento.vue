<template>
    <div class="row m-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-4">Tipo de Movimiento</h5>
            </center>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-md-12 col-sm-12 p-5">
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="nombre"><span class="text-danger">(*)</span> Nombre</label>
                                    <input
                                        type="text"
                                        :class="
                                            errores.err_nombre === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="cicloInicial"
                                        placeholder="Ingrese un nombre"
                                        v-model="form.frm_nombre"
                                    />
                                    <small
                                        v-if="errores.err_nombre !== ''"
                                        id="correoHelp"
                                        class="text-danger"
                                        >{{ errores.err_nombre[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <input
                                        type="text"
                                        id="observacion"
                                        class="form-control"
                                        placeholder="Ingrese su observación"
                                        v-model="form.frm_observacion"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="observacion"><span class="text-danger">(*)</span> Abreviatura</label>
                                    <input
                                        :readonly="tipoMovimientoMod !== null"
                                        type="text"
                                        :class="
                                            errores.err_abreviatura === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="observacion"
                                        class="form-control"
                                        placeholder="Ingrese abreviatura"
                                        v-model="form.frm_abreviatura"
                                    />
                                    <small
                                        v-if="errores.err_abreviatura !== ''"
                                        id="correoHelp"
                                        class="text-danger"
                                        >{{ errores.err_abreviatura[0] }}</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1"
                            >
                                <div class="form-inline">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block"
                                        @click="
                                            guardarActualizarTipoMovimiento()
                                        "
                                    >
                                        {{
                                            tipoMovimientoMod === null
                                                ? "Guardar"
                                                : "Modificar"
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
        tipoMovimientoMod: {
            type: Object
        }
    },
    data: function() {
        return {
            errores: {
                err_nombre: "",
                err_email: "",
                err_abreviatura: ""
            },
            form: {
                frm_codigo: "",
                frm_nombre: "",
                frm_observacion: "",
                frm_abreviatura: ""
            }
        };
    },
    mounted: function() {
        if (this.$props.tipoMovimientoMod !== null) {
            var tipoMovimiento = this.$props.tipoMovimientoMod;
            this.form.frm_codigo = tipoMovimiento.TIPOMOVIMIENTO_COD;
            this.form.frm_nombre = tipoMovimiento.TIPOMOVIMIENTO_NOMBRE;
            this.form.frm_observacion = tipoMovimiento.TIPOMOVIMIENTO_OBS;
            this.form.frm_abreviatura =
                tipoMovimiento.TIPOMOVIMIENTO_ABREVIATURA;
        }
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organizacion_bspi.crear_organizacion_bspi
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organizacion_bspi.crear_organizacion_bspi
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        limpiarForm() {
            this.errores = {
                err_nombre: "",
                err_email: "",
                err_abreviatura: ""
            };
            this.form = {
                frm_codigo: "",
                frm_nombre: "",
                frm_observacion: "",
                frm_abreviatura: ""
            };
        },
        guardarActualizarTipoMovimiento: function() {
            let that = this;
            let url = "";
            let mensaje = "";
            //if()
            if (this.$props.tipoMovimientoMod !== null) {
                url =
                    "/gestion_hospitalaria/administracion_farmacia/modificar_tipo_movimiento";
                mensaje = "Datos actualizados correctamente.";
            } else {
                url =
                    "/gestion_hospitalaria/administracion_farmacia/guardar_tipo_movimiento";
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarTipoMovimiento");
                    that.$emit("cerrarModalCrearTipoMovimiento");
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente",
                        text: that.mensaje
                    });
                    that.limpiarForm();
                })
                .catch(error => {
                    //Errores de validación
                    if (error.response.status === 422) {
                        this.errores = {
                            err_nombre: "",
                            err_email: "",
                            err_abreviatura: ""
                        };
                        if (error.response.data.errors.frm_nombre != null) {
                            that.errores.err_nombre =
                                error.response.data.errors.frm_nombre;
                        }
                        if (
                            error.response.data.errors.frm_abreviatura != null
                        ) {
                            that.errores.err_abreviatura =
                                error.response.data.errors.frm_abreviatura;
                        }
                        loader.hide();
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
