<template>
    <div class="row">
        <h1 class="mt-4">ASEGURADORAS</h1>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <button
                                    class="btn btn-primary"
                                    @click="nuevo()"
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
                                :columns-data="columns"
                                :rows-data="datos"
                                @handleModificarClick="modificar"
                                @handleAnularClick="anularConfirmacion"
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
            name="crearModal"
        >
            <crear-aseguradoras
                :objeto-mod="objetoMod"
                @recargarDatos="cargarDatos"
                @cerrarModalCrear="cerrarModalCrear"
                ref="crearModal"
            ></crear-aseguradoras>
        </modal>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            objetoMod: null,
            datos: [],
            columns: [
                {
                    label: "Nombre",
                    field: "nombre",
                    type: "String"
                },
                 {
                    label: "Nombre Contacto",
                    field: "nombre_contacto",
                    type: "String"
                },
                 {
                    label: "Telefono Contacto",
                    field: "telefono_contacto",
                    type: "String"
                },
                 {
                    label: "Email Contacto",
                    field: "email_contacto",
                    type: "String"
                },
                 {
                    label: "Tipo",
                    field: "ASEGURADORA_TIPO_NOM",
                    type: "String"
                },

                {
                    label: "Observación",
                    field: "observacion",
                    type: "String"
                },
                {
                    label: "Página Web",
                    field: "web_page",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .generalidades.aseguradoras.aseguradoras
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        this.cargarDatos();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .generalidades.aseguradoras.aseguradoras
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        modificar(value) {
            this.objetoMod = value;
            this.abrirModalCrear();
        },
        anularConfirmacion(value) {
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
                    that.anular(value.codigo);
                }
            });
        },
        anular(id) {
            let that = this;
            let url = "/gestion_hospitalaria/generalidades/eliminar_aseguradora/" + id;
            var loader = that.$loading.show();
            axios
                .delete(url)
                .then(function(response) {
                    that.cargarDatos();
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
        cerrarModalCrear: function() {
            this.$modal.hide("crearModal");
        },
        nuevo: function() {
            this.objetoMod = null;
            this.abrirModalCrear();
        },
        abrirModalCrear: function() {
            this.$modal.show("crearModal");
        },
        cargarDatos: function() {
            let that = this;
            let url = "/gestion_hospitalaria/generalidades/cargar_aseguradoras";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    let datos = [];
                    datos = response.data.datos;

                    that.datos = datos;
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
