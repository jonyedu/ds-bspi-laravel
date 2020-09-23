<template>
    <div class="row">
        <h1 class="mt-4">CARGOS EN ORGANISMOS</h1>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <button
                                    class="btn btn-primary"
                                    @click="nuevoCargo()"
                                >
                                    Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <vuetable-component
                                :anular-button="true"
                                :modificar-button="true"
                                :titulo-data="
                                    'Lista de Cargos de Organismos Vinculantes con la BSPI'
                                "
                                :columns-data="columns"
                                :rows-data="cargos"
                                @handleModificarClick="modificarCargo"
                                @handleAnularClick="anularCargoConfirmacion"
                            ></vuetable-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal
            :width="'65%'"
            height="auto"
            :scrollable="true"
            name="crearCargoBspi"
        >
            <crear-cargos-vinculantes-con-la-bspi
                :cargo-mod="cargoMod"
                @recargarCargos="cargarCargos"
                @cerrarModalCrearCargo="cerrarModalCrearCargo"
                ref="crearCargoBspi"
            ></crear-cargos-vinculantes-con-la-bspi>
        </modal>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            cargoMod: null,
            errores: {},
            form: {},
            cargos: [],
            columns: [
                {
                    label: "Nombre",
                    field: "CARGOORG_NOM",
                    type: "String"
                },
                {
                    label: "Activo",
                    field: "CARGOORG_ACTIVO",
                    type: "String"
                },
                {
                    label: "Observaciones",
                    field: "CARGOORG_OBS",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.cargos_en_organismo_bspi.cargo_en_organismo_bspi
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        this.cargarCargos();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.cargos_en_organismo_bspi.cargo_en_organismo_bspi
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        modificarCargo(value) {
            this.cargoMod = value;
            this.abrirModalCrearCargo();
        },
        anularCargoConfirmacion(value) {
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
                    that.anularCargo(value.CARGOORG_COD);
                }
            });
        },
        anularCargo(id) {
            let that = this;
            let url = "/datos_generales/generalidades/eliminar_cargo/" + id;
            var loader = that.$loading.show();
            axios
                .delete(url)
                .then(function(response) {
                    that.cargarCargos();
                    loader.hide();
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
        cerrarModalCrearCargo: function() {
            this.$modal.hide("crearCargoBspi");
        },
        nuevoCargo: function() {
            this.cargoMod = null;
            this.abrirModalCrearCargo();
        },
        abrirModalCrearCargo: function() {
            this.$modal.show("crearCargoBspi");
        },
        cargarCargos: function() {
            let that = this;
            let url = "/datos_generales/generalidades/cargar_cargos";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    let cargos = [];
                    cargos = response.data.cargos;

                    that.cargos = cargos;
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
        }
    }
};
</script>
