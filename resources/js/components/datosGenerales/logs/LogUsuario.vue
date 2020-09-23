<template>
    <div class="row">
        <h1 class="mt-4">LOGS USUARIO</h1>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <vuetable-component
                                :anular-button="false"
                                :modificar-button="false"
                                :infor_button="false"
                                :titulo-data="'Log Usuario'"
                                :columns-data="columns"
                                :rows-data="logs"
                            ></vuetable-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            logs: [],
            columns: [
                {
                    label: "Código Usuario",
                    field: "US_COD",
                    type: "String"
                },
                {
                    label: "Nombre",
                    field: "US_NOM",
                    type: "String"
                },
                {
                    label: "Modulo",
                    field: "MODULO_NOM",
                    type: "String"
                },
                {
                    label: "Formulario",
                    field: "FORMULARIO_NOM",
                    type: "String"
                },
                {
                    label: "Accion",
                    field: "ACCION",
                    type: "String"
                },
                {
                    label: "Fecha",
                    field: "created_at",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        this.cargarLogs();
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales.logs
            .log_usuario.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales.logs
            .log_usuario.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        cargarLogs: function() {
            let that = this;
            let url = "/datos_generales/logs/cargar_logs";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    let logs = [];
                    logs = response.data.logs;

                    that.logs = logs;
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
