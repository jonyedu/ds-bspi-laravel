<template>
    <div class="row m-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-4">Farmacia</h5>
            </center>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-md-12 col-sm-12 p-5">
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="nombre"
                                        ><span class="text-danger">(*)</span
                                        >Nombre</label
                                    >
                                    <input
                                        type="text"
                                        :readonly="farmaciaMod !== null"
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
                                    <label for="contacto">Teléfono</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="contacto"
                                        placeholder="Ingrese el teléfono"
                                        v-model="form.frm_telefono"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input
                                        type="text"
                                        id="telefono"
                                        class="form-control"
                                        placeholder="Ingrese dirección"
                                        v-model="form.frm_direccion"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="correo"
                                        ><span class="text-danger">(*)</span
                                        >Correo Electrónico</label
                                    >
                                    <input
                                        type="text"
                                        :class="
                                            errores.err_email === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        placeholder="Ingrese correo electrónico"
                                        v-model="form.frm_email"
                                    />
                                    <small
                                        v-if="errores.err_email !== ''"
                                        id="correoHelp"
                                        class="text-danger"
                                        >{{ errores.err_email[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="webpage">Página Web</label>
                                    <input
                                        type="text"
                                        id="webpage"
                                        class="form-control"
                                        placeholder="Ingrese página web"
                                        v-model="form.frm_pagina_web"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <input
                                        type="text"
                                        id="observacion"
                                        class="form-control"
                                        placeholder="Ingrese observación"
                                        v-model="form.frm_observacion"
                                    />
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
                                        @click="guardarActualizarFarmacia()"
                                    >
                                        {{
                                            farmaciaMod === null
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
        farmaciaMod: {
            type: Object
        }
    },
    data: function() {
        return {
            errores: {
                err_nombre: "",
                err_email: ""
            },
            form: {
                frm_codigo: "",
                frm_nombre: "",
                frm_telefono: "",
                frm_direccion: "",
                frm_email: "",
                frm_observacion: "",
                frm_pagina_web: ""
            }
        };
    },
    mounted: function() {
        if (this.$props.farmaciaMod !== null) {
            var farmacia = this.$props.farmaciaMod;
            this.form.frm_codigo = farmacia.FARMACIA_COD;
            this.form.frm_nombre = farmacia.FARMACIA_NOM;
            this.form.frm_telefono = farmacia.FARMACIA_TELF;
            this.form.frm_direccion = farmacia.FARMACIA_DIREC;
            this.form.frm_email = farmacia.FARMACIA_EMAIL;
            this.form.frm_observacion = farmacia.FARMACIA_OBS;
            this.form.frm_pagina_web = farmacia.FARMACIA_WEB_PAGE;
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
                err_email: ""
            };
            this.form = {
                frm_codigo: "",
                frm_nombre: "",
                frm_telefono: "",
                frm_direccion: "",
                frm_email: "",
                frm_observacion: "",
                frm_pagina_web: ""
            };
        },
        guardarActualizarFarmacia: function() {
            let that = this;
            let url = "";
            let mensaje = "";
            //if()
            if (this.$props.farmaciaMod !== null) {
                url =
                    "/gestion_hospitalaria/administracion_farmacia/modificar_farmacia";
                mensaje = "Datos actualizados correctamente.";
            } else {
                url =
                    "/gestion_hospitalaria/administracion_farmacia/guardar_farmacia";
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarFarmacia");
                    that.$emit("cerrarModalCrearFarmacia");
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
                        /* that.errores = {
                            err_nombre: "",
                            err_email: ""
                        }; */
                        if (error.response.data.errors.frm_nombre != null) {
                            that.errores.err_nombre =
                                error.response.data.errors.frm_nombre;
                        }
                        if (error.response.data.errors.frm_email != null) {
                            that.errores.err_email =
                                error.response.data.errors.frm_email;
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
