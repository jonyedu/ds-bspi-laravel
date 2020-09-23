<template>
    <div class="row">
        <h1 class="mt-2">Farmacia</h1>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <button
                                    class="btn btn-primary"
                                    @click="nuevoFarmacia()"
                                >
                                    Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <vuetable-component
                                :anular-button="true"
                                :modificar-button="true"
                                :info-button="false"
                                :columns-data="columns"
                                :rows-data="farmacia"
                                @handleModificarClick="modificarFarmacia"
                                @handleAnularClick="anularFarmaciaConfirmacion"
                                @handleInfoClick="abrirModalInformacion"
                            ></vuetable-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal
            :width="'70%'"
            :height="'auto'"
            :scrollable="true"
            name="crearFarmacia"
        >
            <crear-farmacia
                :farmacia-mod="farmaciaMod"
                @recargarfarmacia="cargarFarmacia"
                @cerrarModalCrearFarmacia="cerrarModalCrearFarmacia"
                ref="crearFarmacia"
            ></crear-farmacia>
        </modal>
        <modal
            :width="'70%'"
            height="auto"
            :scrollable="true"
            name="infoFarmacia"
        >
            <info-farmacia
                :farmacia="farmaciaInfo"
                ref="crearFarmacia"
            ></info-farmacia>
        </modal>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            farmaciaMod: null,
            url_data: "",
            farmaciaInfo: "",
            errores: {},
            form: {},
            farmacia: [],
            columns: [
                {
                    label: "Nombre",
                    field: "FARMACIA_NOM",
                    type: "String"
                },
                {
                    label: "Observaciones",
                    field: "FARMACIA_OBS",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        this.cargarFarmacia();
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organizacion_bspi.organizacion_bspi
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
            .generalidades.organizacion_bspi.organizacion_bspi
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        abrirModalInformacion(value) {
            this.farmaciaInfo = value;
            this.$modal.show("infoFarmacia");
        },
        modificarFarmacia(value) {
            this.farmaciaMod = value;
            this.abrirModalCrearFarmacia();
        },
        anularFarmaciaConfirmacion(value) {
            let that = this;
            this.$swal({
                title: "¿Desea anular el elemento seleccionado?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar"
            }).then(result => {
                if (result.value) {
                    that.anularFarmacia(value.FARMACIA_COD);
                }
            });
        },
        anularFarmacia(id) {
            let that = this;
            let url =
                "/gestion_hospitalaria/administracion_farmacia/eliminar_farmacia/" +
                id;
            var loader = that.$loading.show();
            axios
                .delete(url)
                .then(function(response) {
                    loader.hide();
                    that.cargarFarmacia();
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente",
                        text: "Dato anulado correctamente."
                    });
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
        cerrarModalCrearFarmacia: function() {
            this.$modal.hide("crearFarmacia");
            this.cargarFarmacia();
        },
        nuevoFarmacia: function() {
            this.farmaciaMod = null;
            this.abrirModalCrearFarmacia();
        },
        abrirModalCrearFarmacia: function() {
            this.$modal.show("crearFarmacia");
        },
        cargarFarmacia: function() {
            let that = this;
            let url =
                "/gestion_hospitalaria/administracion_farmacia/cargar_farmacia";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    let farmacia = [];
                    for (let i = 0; i < response.data.farmacia.length; i++) {
                      let objeto = {
                        FARMACIA_COD: response.data.farmacia[i].FARMACIA_COD,
                        FARMACIA_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.farmacia[i].FARMACIA_NOM),
                        FARMACIA_TELF: response.data.farmacia[i].FARMACIA_TELF,
                        FARMACIA_DIREC: response.data.farmacia[i].FARMACIA_DIREC,
                        FARMACIA_EMAIL: response.data.farmacia[i].FARMACIA_EMAIL,
                        FARMACIA_WEB_PAGE: response.data.farmacia[i].FARMACIA_WEB_PAGE,
                        FARMACIA_OBS: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.farmacia[i].FARMACIA_OBS)
                      }
                      farmacia.push(objeto);                       
                    }
                    that.farmacia = farmacia;
                    loader.hide();
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
        }
    }
};
</script>
