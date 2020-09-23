<template>
    <div class="row">
        <h1 class="mt-4">ORGANISMOS</h1>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <button
                                    class="btn btn-primary"
                                    @click="nuevoOrganismo()"
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
                                    'Lista de Organismos Vinculantes con la BSPI'
                                "
                                :columns-data="columns"
                                :rows-data="organismos"
                                @handleModificarClick="modificarOrganismo"
                                @handleAnularClick="anularOrganismoConfirmacion"
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
            name="crearOrganismoBspi"
        >
            <crear-organismos-vinculantes-con-la-bspi
                :organismo-mod="organismoMod"
                @recargarOrganismo="cargarOrganismos"
                @cerrarModalCrearOrganismo="cerrarModalCrearOrganismo"
                ref="crearOrganizacionBspi"
            ></crear-organismos-vinculantes-con-la-bspi>
        </modal>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            organismoMod: null,
            errores: {},
            form: {},
            organismos: [],
            columns: [
                {
                    label: "Nombre",
                    field: "ORG_NOM",
                    type: "String"
                },
                {
                    label: "Tipo Organismo",
                    field: "TIPOORG_NOM",
                    type: "String"
                },
                {
                    label: "País",
                    field: "PAIS_NOM",
                    type: "String"
                },
                {
                    label: "Dirección",
                    field: "ORG_DIR",
                    type: "String"
                },
                {
                    label: "Telefono",
                    field: "ORG_TELF",
                    type: "String"
                },
                {
                    label: "Celular",
                    field: "ORG_CEL",
                    type: "String"
                },
                {
                    label: "Email",
                    field: "ORG_EMAIL",
                    type: "String"
                },
                {
                    label: "Activo",
                    field: "ORG_ACTIVO",
                    type: "String"
                },
                {
                    label: "Observaciones",
                    field: "ORG_OBS",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organismos_vinculantes_con_la_bspi
            .organismo_vinculantes_con_la_bspi.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        this.cargarOrganismos();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organismos_vinculantes_con_la_bspi
            .organismo_vinculantes_con_la_bspi.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        modificarOrganismo(value) {
            this.organismoMod = value;
            this.abrirModalCrearOrganismo();
        },
        anularOrganismoConfirmacion(value) {
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
                    that.anularOrganismo(value.ORG_COD);
                }
            });
        },
        anularOrganismo(id) {
            let that = this;
            var loader = that.$loading.show();
            let url =
                "/datos_generales/generalidades/eliminar_organismos/" + id;
            axios
                .delete(url)
                .then(function(response) {
                    loader.hide();
                    that.cargarOrganismos();
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
        cerrarModalCrearOrganismo: function() {
            this.$modal.hide("crearOrganismoBspi");
        },
        nuevoOrganismo: function() {
            this.organismoMod = null;
            this.abrirModalCrearOrganismo();
        },
        abrirModalCrearOrganismo: function() {
            this.$modal.show("crearOrganismoBspi");
        },
        cargarOrganismos: function() {
            let that = this;
            let url = "/datos_generales/generalidades/cargar_organismos";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    let organismos = [];

                    for (let i = 0; i < response.data.organismos.length; i++) {
                        let objeto = {};
                        objeto.ORG_COD = response.data.organismos[i].ORG_COD;
                        objeto.ORG_NOM = response.data.organismos[i].ORG_NOM;
                        objeto.ORG_ACTIVO =
                            response.data.organismos[i].ORG_ACTIVO;
                        objeto.TIPOORG_COD =
                            response.data.organismos[i].TIPOORG_COD;

                        objeto.TIPOORG_NOM =
                            response.data.organismos[i].tipo_organismo !== null
                                ? response.data.organismos[i].tipo_organismo
                                      .TIPOORG_NOM
                                : "";
                        objeto.PAIS_COD = response.data.organismos[i].PAIS_COD;
                        objeto.PAIS_NOM =
                            response.data.organismos[i].pais !== null
                                ? response.data.organismos[i].pais.PAIS_NOM
                                : "";
                        objeto.ORG_DIR = response.data.organismos[i].ORG_DIR;
                        objeto.ORG_TELF = response.data.organismos[i].ORG_TELF;
                        objeto.ORG_CEL = response.data.organismos[i].ORG_CEL;
                        objeto.ORG_EMAIL =
                            response.data.organismos[i].ORG_EMAIL;
                        objeto.ORG_OBS = response.data.organismos[i].ORG_OBS;
                        organismos.push(objeto);
                    }
                    that.organismos = organismos;
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
