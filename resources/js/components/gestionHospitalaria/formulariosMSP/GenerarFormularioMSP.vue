<template>
    <div class="col-md-12 mt-4 mb-4">
        <!-- Seccion de Consulta Externa -->
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Consulta Externa</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <!--Formulario 002  -->
                        <div class="col-sm-4">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                @click="imprimirPdfFormularioMSP002()"
                                style="height: 150px;width:100%;"
                            >
                                Formulario 002
                            </button>
                        </div>
                        <div class="col-sm-4" v-if="bandera">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                style="height: 150px;width:100%;"
                            >
                                Formulario ???
                            </button>
                        </div>
                        <div class="col-sm-4" v-if="bandera">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                style="height: 150px;width:100%;"
                            >
                                Formulario ???
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        &nbsp;
        <!-- Seccion de Emergencia -->
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Emergencia</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <!--Formulario 002  -->
                        <div class="col-sm-4" v-if="bandera">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                style="height: 150px;width:100%;"
                            >
                                Formulario ???
                            </button>
                        </div>
                        <div class="col-sm-4" v-if="bandera">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                style="height: 150px;width:100%;"
                            >
                                Formulario ???
                            </button>
                        </div>
                        <div class="col-sm-4" v-if="bandera">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                style="height: 150px;width:100%;"
                            >
                                Formulario ???
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        pacienteMod: {
            type: Object
        }
    },
    data: function() {
        return {
            bandera: false,
            errores: {},
            form: {}
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
        imprimirPdfFormularioMSP002: function() {
            window.open(
                "/gestion_hospitalaria/formulario_msp/cargar_pdf_formulario_msp_002/" +
                    this.$props.pacienteMod.id
            );
        }
    }
};
</script>
