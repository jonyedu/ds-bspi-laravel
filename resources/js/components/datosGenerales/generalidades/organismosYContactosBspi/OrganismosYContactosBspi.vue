<template>
    <div class="row">
        <h1 class="mt-4">ORGANISMOS Y CONTACTOS</h1>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <button
                                    class="btn btn-primary"
                                    @click="nuevoOrganismoYContacto()"
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
                                :rows-data="organismosYContactos"
                                @handleModificarClick="
                                    modificarOrganismoYContacto
                                "
                                @handleAnularClick="
                                    anularOrganismoYContactoConfirmacion
                                "
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
            name="crearOrganismoYContactoBspi"
        >
            <crear-organismosYContactos-bspi
                :organismo-y-contacto-mod="organismoYContactoMod"
                :organismos="organismos"
                :cargos="cargos"
                :usuarios="usuarios"
                @recargarOrganismoYContacto="cargarOrganismosYContactos"
                @cerrarModalCrearOrganismoYContacto="
                    cerrarModalCrearOrganismoYContacto
                "
                ref="crearOrganizacionYContactoBspi"
            ></crear-organismosYContactos-bspi>
        </modal>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            organismoYContactoMod: null,
            errores: {},
            form: {
                cargo_cod: "",
                organismo_cod: "",
                usuario_cod: ""
            },
            organismosYContactos: [],
            organismos: [],
            cargos: [],
            usuarios: [],
            columns: [
                {
                    label: "Organismo",
                    field: "ORG_NOM",
                    type: "String"
                },
                {
                    label: "Cargo",
                    field: "CARGOORG_NOM",
                    type: "String"
                },
                {
                    label: "Usuario",
                    field: "name",
                    type: "String"
                },
                {
                    label: "Identificación Usuario",
                    field: "US_COD",
                    type: "String"
                },
                {
                    label: "Activo",
                    field: "ORGCONT_ACTIVO",
                    type: "String"
                },
                {
                    label: "Observaciones",
                    field: "ORGCONT_OBS",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organismo_y_contactos_bspi.organismo_y_contacto_bspi
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        this.cargarOrganismosYContactos();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organismo_y_contactos_bspi.organismo_y_contacto_bspi
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        modificarOrganismoYContacto(value) {
            this.organismoYContactoMod = value;
            this.abrirModalCrearOrganismoYContacto();
        },
        anularOrganismoYContactoConfirmacion(value) {
            this.form.cargo_cod = value.CARGOORG_COD;
            this.form.organismo_cod = value.ORG_COD;
            this.form.usuario_cod = value.US_COD;
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
                    that.anularOrganismoYContacto();
                }
            });
        },
        anularOrganismoYContacto() {
            let that = this;
            let url =
                "/datos_generales/generalidades/eliminar_organismosYContactos";
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    loader.hide();
                    that.cargarOrganismosYContactos();
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
        cerrarModalCrearOrganismoYContacto: function() {
            this.$modal.hide("crearOrganismoYContactoBspi");
        },
        nuevoOrganismoYContacto: function() {
            this.organismoYContactoMod = null;
            this.abrirModalCrearOrganismoYContacto();
        },
        abrirModalCrearOrganismoYContacto: function() {
            this.$modal.show("crearOrganismoYContactoBspi");
        },
        cargarOrganismosYContactos: function() {
            let that = this;
            let url =
                "/datos_generales/generalidades/cargar_organismosYContactos";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    let organismos = [];
                    let cargos = [];
                    let usuarios = [];
                    that.organismos = response.data.organismos;
                    that.cargos = response.data.cargos;
                    that.usuarios = response.data.users;
                    that.organismosYContactos =
                        response.data.organismosYContactos;
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
