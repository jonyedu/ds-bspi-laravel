<template>
    <div class="row">
        <h1 class="mt-4">TIPOS DE ORGANISMOS</h1>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <button
                                    class="btn btn-primary"
                                    @click="nuevoTipo()"
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
                                :titulo-data="'Lista de Tipos BSPI'"
                                :columns-data="columns"
                                :rows-data="tipos"
                                @handleModificarClick="modificarTipo"
                                @handleAnularClick="anularTipoConfirmacion"
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
            name="crearTipoBspi"
        >
            <crear-tipo-bspi
                :tipo-mod="tipoMod"
                @recargartipos="cargarTipos"
                @cerrarModalCrearTipos="cerrarModalCrearTipos"
                ref="crearTipoBspi"
            ></crear-tipo-bspi>
        </modal>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            tipoMod: null,
            url_data: "",
            errores: {},
            form: {},
            tipos: [],
            columns: [
                {
                    label: "Nombre",
                    field: "TIPOORG_NOM",
                    type: "String"
                },
                {
                    label: "Activo",
                    field: "TIPOORG_ACTIVO",
                    type: "String"
                },
                {
                    label: "Observaciones",
                    field: "TIPOORG_OBS",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        this.cargarTipos();
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.tipos_bspi.tipos_bspi.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.tipos_bspi.tipos_bspi.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        modificarTipo(value) {
            this.tipoMod = value;
            this.abrirModalCrearTipo();
        },
        anularTipoConfirmacion(value) {
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
                    that.anularTipo(value.TIPOORG_COD);
                }
            });
        },
        anularTipo(id) {
            let that = this;
            let url =
                "/datos_generales/generalidades/eliminar_tiposdeorganismos/" +
                id;
            var loader = that.$loading.show();
            axios
                .delete(url)
                .then(function(response) {
                    loader.hide();
                    that.cargarTipos();
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
        cerrarModalCrearTipos: function() {
            this.$modal.hide("crearTipoBspi");
        },
        nuevoTipo: function() {
            this.tipoMod = null;
            this.abrirModalCrearTipo();
        },
        abrirModalCrearTipo: function() {
            this.$modal.show("crearTipoBspi");
        },
        cargarTipos: function() {
            let that = this;
            let url = "/datos_generales/generalidades/cargar_tiposdeorganismos";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    let tipos = [];
                    tipos = response.data.tipos;

                    that.tipos = tipos;
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
