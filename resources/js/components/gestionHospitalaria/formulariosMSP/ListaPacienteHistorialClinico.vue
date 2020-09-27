<template>
    <div class="col-md-12">
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Pacientes con Historial Clínico</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <vuetable-component
                                :anular-button="false"
                                :modificar-button="true"
                                :columns-data="columns"
                                :rows-data="pacienteArray"
                                @handleModificarClick="formularioMSP"
                            >
                            </vuetable-component>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <modal
            :width="'70%'"
            :height="'auto'"
            :scrollable="true"
            name="formularioMSP"
        >
            <generar-formulario-msp
                :paciente-mod="pacienteMod"
                @cerrarModalCrearFormularioMSP="cerrarModalFormularioMSP"
                ref="formularioMSP"
            ></generar-formulario-msp>
        </modal>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            pacienteMod: null,
            pacienteArray: [],
            columns: [
                {
                    label: "Nombre y Apellido",
                    field: "FULL_NAME",
                    type: "String"
                },
                {
                    label: "# Identificación",
                    field: "FULL_IDENTIFICATION",
                    type: "String"
                },
                {
                    label: "# Historia Clínica",
                    field: "US_HISTORIACLINICACOD",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.signos_vitales.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        this.cargarHistoriaClinica();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.signos_vitales.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        cargarHistoriaClinica: function() {
            let that = this;
            let url =
                "/gestion_hospitalaria/formulario_msp/cargar_paciente_historia_clinico";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    if (response.data.formularioMSP == null) {
                        loader.hide();
                    } else {
                        //Obtenemos los pacientes con historial clinico
                        let formularioMSP = [];
                        response.data.formularioMSP.forEach(formulariosMSP => {
                            let objeto = {};
                            objeto.id = formulariosMSP.id;
                            objeto.FULL_NAME = that.$funcionesGlobales.toCapitalFirstAllWords(formulariosMSP.FULL_NAME);
                            objeto.FULL_IDENTIFICATION = formulariosMSP.FULL_IDENTIFICATION;
                            objeto.US_HISTORIACLINICACOD = formulariosMSP.US_HISTORIACLINICACOD;
                            formularioMSP.push(objeto);
                        });
                        that.pacienteArray = formularioMSP;
                        loader.hide();
                    }
                })
                .catch(error => {
                    //Errores
                    loader.hide();
                });
        },
        formularioMSP(value) {
            this.pacienteMod = value;
            this.abrirModalFormularioMSP();
        },
        abrirModalFormularioMSP: function() {
            this.$modal.show("formularioMSP");
        },
        cerrarModalFormularioMSP: function() {
            this.$modal.hide("crearFarmacia");
            this.cargarFarmacia();
        }
    }
};
</script>
