<template>
    <div class="row m-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-4">CARGOS EN ORGANISMO</h5>
            </center>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-md-12 col-sm-12 p-5">
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input
                                        type="text"
                                        :readonly="cargoMod !== null"
                                        :class="
                                            errores.nombre === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="cicloInicial"
                                        placeholder="Ingrese un nombre"
                                        v-model="form.nombre"
                                    />
                                    <small
                                        v-if="errores.nombre !== ''"
                                        id="nombreHelp"
                                        class="text-danger"
                                        >{{ errores.nombre[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="rol">Activo</label>
                                    <v-select
                                        v-model="selectedActivo"
                                        :value="form.activo"
                                        :options="activos"
                                        label="id_tipo"
                                        @input="setSelected"
                                    >
                                        <template slot="no-options"
                                            >No se ha encontrado ningun
                                            dato</template
                                        >
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <input
                                        type="text"
                                        :class="
                                            errores.observacion === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="observacion"
                                        placeholder="Ingrese su observación"
                                        v-model="form.observacion"
                                    />
                                    <small
                                        v-if="errores.observacion !== ''"
                                        id="observacionHelp"
                                        class="text-danger"
                                        >{{ errores.observacion[0] }}</small
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
                                        @click="guardarActualizar()"
                                    >
                                        {{
                                            cargoMod === null
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
        cargoMod: {
            type: Object
        }
    },
    data: function() {
        return {
            errores: {
                nombre: "",
                activo: "",
                observacion: ""
            },
            form: {
                cargo_cod: "",
                nombre: "",
                activo: "",
                observacion: ""
            },
            activos: [
                {
                    id_tipo: "S"
                },
                {
                    id_tipo: "N"
                }
            ],
            selectedActivo: "S"
        };
    },
    mounted: function() {
        this.form.activo = "S";
        if (this.$props.cargoMod !== null) {
            let cargo = this.$props.cargoMod;
            this.form.cargo_cod = cargo.CARGOORG_COD;
            this.form.nombre = cargo.CARGOORG_NOM;
            this.form.activo = cargo.CARGOORG_ACTIVO;
            this.form.observacion = cargo.CARGOORG_OBS;
            this.selectedActivo = cargo.CARGOORG_ACTIVO;
        }
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.cargos_en_organismo_bspi.crear_cargo_organismo_bspi
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
            .generalidades.cargos_en_organismo_bspi.crear_cargo_organismo_bspi
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        setSelected(value) {
            if (value !== null) {
                this.form.activo = value.id_tipo;
            } else {
                this.form.activo = "";
            }
        },
        guardarActualizar: function() {
            let that = this;
            that.errores = {
                nombre: "",
                activo: "",
                observacion: ""
            };

            let url = "";
            let mensaje = "";
            if (this.$props.cargoMod !== null) {
                url = "/datos_generales/generalidades/modificar_cargos";
                mensaje = "Datos actualizados correctamente.";
            } else {
                url = "/datos_generales/generalidades/guardar_cargos";
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarCargos");
                    that.$emit("cerrarModalCrearCargo");
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente",
                        text: "Datos actualizados correctamente."
                    });
                })
                .catch(error => {
                    //Errores de validación
                    if (error.response.status === 422) {
                        that.errores.nombre =
                            error.response.data.errors.nombre != undefined
                                ? error.response.data.errors.nombre
                                : "";

                        that.errores.activo =
                            error.response.data.errors.activo != undefined
                                ? error.response.data.errors.activo
                                : "";
                        that.errores.observacion =
                            error.response.data.errors.observacion != undefined
                                ? error.response.data.errors.observacion
                                : "";
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
