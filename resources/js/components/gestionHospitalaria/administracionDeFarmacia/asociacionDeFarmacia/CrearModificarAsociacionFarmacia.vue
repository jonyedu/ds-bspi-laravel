<template>
    <div class="row m-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-4">Asociación de Farmacia</h5>
            </center>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-md-12 col-sm-12 p-5">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tipo"><label class="text-danger">(*)</label> Tipo Hospital</label>
                                    <v-select
                                        v-model="selectedHospital"
                                        :value="form.frm_hospital_cod"
                                        :options="hospital"
                                        label="display"
                                        @input="setSelectedHospital"
                                    >
                                        <template slot="no-options">
                                            No se ha encontrado ningun dato
                                        </template>
                                    </v-select>
                                    <small
                                        v-if="errores.err_hospital_cod !== ''"
                                        id="tipoHelp"
                                        class="text-danger"
                                        >{{ errores.err_hospital_cod[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tipo"><label class="text-danger">(*)</label> Tipo Farmacia</label>
                                    <v-select
                                        v-model="selectedFarmacia"
                                        :value="form.frm_farmacia_cod"
                                        :options="farmacia"
                                        label="display"
                                        @input="setSelectedFarmacia"
                                    >
                                        <template slot="no-options">
                                            No se ha encontrado ningun dato
                                        </template>
                                    </v-select>
                                    <small
                                        v-if="errores.err_farmacia_cod !== ''"
                                        id="tipoHelp"
                                        class="text-danger"
                                        >{{ errores.err_farmacia_cod[0] }}</small
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
                                            guardarActualizarAsociacionFarmacia()
                                        "
                                    >
                                        {{
                                            asociacionFarmaciaMod == null
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
        asociacionFarmaciaMod: {
            type: Object
        }
    },
    data: function() {
        return {
            hospital: [],
            farmacia: [],
            selectedHospital: "",
            selectedFarmacia: "",
            errores: {
                err_hospital_cod: "",
                err_farmacia_cod: ""
            },
            form: {
                frm_hosp_farm_cod: "",
                frm_hospital_cod: "",
                frm_farmacia_cod: ""
            }
        };
    },
    mounted: function() {
        this.setSelectedHospital();
        this.setSelectedFarmacia();
        if (this.$props.asociacionFarmaciaMod !== null) {
            var asociacionFarmacia = this.$props.asociacionFarmaciaMod;
            this.form.frm_hosp_farm_cod = asociacionFarmacia.HOSP_FARM_COD;
            /* Hospital */
            this.form.frm_hospital_cod = asociacionFarmacia.HOSPITAL_COD;
            this.selectedHospital = asociacionFarmacia.HOSPITAL_NOM;            
            /* Farmacia */
            this.selectedFarmacia = asociacionFarmacia.FARMACIA_NOM;
            this.form.frm_farmacia_cod = asociacionFarmacia.FARMACIA_COD;
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
        guardarActualizarAsociacionFarmacia: function() {
            let that = this;
            let url = "";
            let mensaje = "";
            //if()
            if (this.$props.asociacionFarmaciaMod !== null) {
                url =
                    "/gestion_hospitalaria/administracion_farmacia/modificar_asociacion_farmacia";
                mensaje = "Datos actualizados correctamente.";
            } else {
                url =
                    "/gestion_hospitalaria/administracion_farmacia/guardar_asociacion_farmacia";
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarAsociacionFarmacia");
                    that.$emit("cerrarModalCrearAsociacionFarmacia");
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente",
                        text: that.mensaje
                    });
                    //that.limpiarForm();
                })
                .catch(error => {
                    //Errores de validación
                    if (error.response.status === 421) {
                        loader.hide();
                        that.$swal({
                            icon: "error",
                            title: "Existen errores",
                            text: error.response.data.msg
                        });
                    }
                    if (error.response.status === 422) {
                        if (
                            error.response.data.errors.frm_hospital_cod != null
                        ) {
                            that.errores.err_hospital_cod =
                                error.response.data.errors.frm_hospital_cod;
                        }
                        if (
                            error.response.data.errors.frm_farmacia_cod != null
                        ) {
                            that.errores.err_farmacia_cod =
                                error.response.data.errors.frm_farmacia_cod;
                        }
                        loader.hide();
                    }
                });
        },
        setSelectedHospital(value) {
            let that = this;
            var loader = that.$loading.show();
            let url = "/gestion_hospitalaria/hospitales/cargar_hospitales";
            if (value != null) {
                this.form.frm_hospital_cod = value.hospital_cod;
            }
            axios
                .get(url)
                .then(function(response) {
                    let hospital = [];
                    response.data.datos.forEach(hospitales => {
                        let objeto = {};
                        objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(hospitales.HOSPITAL_NOM);
                        objeto.hospital_cod = hospitales.HOSPITAL_COD;
                        hospital.push(objeto);
                    });
                    that.hospital = hospital;
                    loader.hide();
                })
                .catch(error => {
                    //Errores
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                    loader.hide();
                });
        },
        setSelectedFarmacia(value) {
            if (this.$props.asociacionFarmaciaMod == null) {
                //this.limpiarSeleccionados();
            }
            let that = this;
            var loader = that.$loading.show();
            let url =
                "/gestion_hospitalaria/administracion_farmacia/cargar_farmacia";
            if (value != null) {
                this.form.frm_farmacia_cod = value.farmacia_cod;
            }
            axios
                .get(url)
                .then(function(response) {
                    let farmacia = [];
                    response.data.farmacia.forEach(farmacias => {
                        let objeto = {};
                        objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(farmacias.FARMACIA_NOM);
                        objeto.farmacia_cod = farmacias.FARMACIA_COD;
                        farmacia.push(objeto);
                    });
                    that.farmacia = farmacia;
                    loader.hide();
                })
                .catch(error => {
                    //Errores
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                    loader.hide();
                });
        },
        limpiarSeleccionados() {
            this.selectedHospital = "";
            this.selectedFarmacia = "";
        }
    }
};
</script>
