<template>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1 class="mt-4">DIAGNOSTICO</h1>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="usuario">CIE 10 Grupo</label>
                                <v-select
                                    v-model="selectedGrupo"
                                    :value="form.codigo_grupo"
                                    :options="grupos"
                                    label="CIE_DESCRIPCION"
                                    @input="setSelectedGrupo"
                                >
                                    <template slot="no-options">
                                        No se ha encontrado ningun dato
                                    </template>
                                </v-select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="usuario">CIE 10 Sub grupo</label>
                                <v-select
                                    v-model="selectedSubGrupo"
                                    :value="form.codigo_sub_grupo"
                                    :options="subGrupos"
                                    label="CIE_DESCRIPCION"
                                    @input="setSelectedSubGrupo"
                                >
                                    <template slot="no-options">
                                        No se ha encontrado ningun dato
                                    </template>
                                </v-select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <vuetable-component
                                :seleccionar-button="seleccionarButton"
                                :anular-button="false"
                                :modificar-button="false"
                                :columns-data="columns"
                                :rows-data="cie"
                                @handleSeleccionarClick="handleSeleccionarClick"
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
    props: {
        seleccionarButton: {
            type: Boolean,
            default: true
        },
        opc: {
            type: Number
        }
    },
    data: function() {
        return {
            selectedGrupo: "",
            selectedSubGrupo: "",
            grupos: [],
            subGrupos: [],
            cie: [],
            objetoMod: null,
            form: {
                codigo_grupo: "",
                codigo_sub_grupo: ""
            },
            columns: [
                {
                    label: "Clave",
                    field: "cie_clave",
                    type: "String"
                },
                {
                    label: "Descripcion",
                    field: "cie_descripcion",
                    type: "String"
                }
            ]
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.lista_diagnostico.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        this.cargarCieGrupos();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.lista_diagnostico.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        setSelectedGrupo(value) {
            if (value !== null) {
                this.form.codigo_grupo = value.CIE_COD;
                let that = this;
                let url =
                    "/gestion_hospitalaria/consulta_externa/cargar_cie_sub_grupos/" +
                    value.CIE_CLAVE;
                var loader = that.$loading.show();
                axios
                    .get(url)
                    .then(function(response) {
                        that.subGrupos = response.data.subGrupos;
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
            } else {
                this.form.codigo_grupo = "";
            }
        },
        setSelectedSubGrupo(value) {
            if (value !== null) {
                this.form.codigo_sub_grupo = value.CIE_COD;
                this.cargarCie(value.CIE_CLAVE);
            } else {
                this.form.codigo_sub_grupo = "";
            }
        },
        handleSeleccionarClick(value) {
            this.$emit("handleSeleccionarClick", value);
        },
        modificar(value) {
            this.objetoMod = value;
            this.abrirModalCrear();
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
        cargarCieGrupos() {
            let that = this;
            let url =
                "/gestion_hospitalaria/consulta_externa/cargar_cie_grupos";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    that.grupos = response.data.grupos;
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
        },
        cargarCie(value) {
            let that = this;
            let url =
                "/gestion_hospitalaria/consulta_externa/cargar_cie/" + value;
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    let cie = [];
                    for (let i = 0; i < response.data.cie.length; i++) {
                        let objeto = {};

                        objeto.cie_clave = response.data.cie[i].CIE_CLAVE;
                        objeto.cie_descripcion =
                            response.data.cie[i].CIE_DESCRIPCION;

                        if (that.$props.opc == 1) {
                            objeto.id_cie_principal =
                                response.data.cie[i].CIE_COD;
                            objeto.cie_clave_principal =
                                response.data.cie[i].CIE_CLAVE;
                            objeto.cie_descripcion_principal =
                                response.data.cie[i].CIE_DESCRIPCION;
                        }
                        if (that.$props.opc == 2) {
                            objeto.id_cie_uno = response.data.cie[i].CIE_COD;
                            objeto.cie_clave_uno =
                                response.data.cie[i].CIE_CLAVE;
                            objeto.cie_descripcion_uno =
                                response.data.cie[i].CIE_DESCRIPCION;
                        }
                        if (that.$props.opc == 3) {
                            objeto.id_cie_dos = response.data.cie[i].CIE_COD;
                            objeto.cie_clave_dos =
                                response.data.cie[i].CIE_CLAVE;
                            objeto.cie_descripcion_dos =
                                response.data.cie[i].CIE_DESCRIPCION;
                        }
                        cie.push(objeto);
                    }
                    that.cie = cie;
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
