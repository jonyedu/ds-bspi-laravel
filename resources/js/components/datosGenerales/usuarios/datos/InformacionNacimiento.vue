<template>
    <div class="row mt-2">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="fecha_nacimiento"><span class="text-danger">(*)</span> Fecha de nacimiento</label>
                <input
                    type="date"
                    :class="
                        errorInformacionNacimiento.fecha_nacimiento === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="fecha_nacimiento"
                    placeholder="Ingrese su fecha de nacimiento"
                    v-model="dataInformacionNacimiento.fecha_nacimiento"
                />
                <small
                    v-if="errorInformacionNacimiento.fecha_nacimiento !== ''"
                    id="fecha_nacimientoHelp"
                    class="text-danger"
                    >{{ errorInformacionNacimiento.fecha_nacimiento[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="lugar_nacimiento">Lugar de nacimiento</label>
                <input
                    type="text"
                    :class="
                        errorInformacionNacimiento.lugar_nacimiento === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="lugar_nacimiento"
                    placeholder="Ingrese su lugar de nacimiento"
                    v-model="dataInformacionNacimiento.lugar_nacimiento"
                />
                <small
                    v-if="errorInformacionNacimiento.lugar_nacimiento !== ''"
                    id="lugar_nacimientoelp"
                    class="text-danger"
                    >{{ errorInformacionNacimiento.lugar_nacimiento[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="pais">País</label>
                <v-select
                    v-model="dataInformacionNacimiento.paisNombre"
                    :value="dataInformacionNacimiento.pais"
                    :options="paises"
                    label="display"
                    @input="setSelectedPais"
                    @search="cargarPaises"
                >
                    <template slot="no-options"
                        >Escriba el nombre de un país</template
                    >
                </v-select>
                <small
                    v-if="errorInformacionNacimiento.pais !== ''"
                    id="paisHelp"
                    class="text-danger"
                    >{{ errorInformacionNacimiento.pais[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="parroquia">Parroquia</label>
                <input
                    type="text"
                    :class="
                        errorInformacionNacimiento.parroquia === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="parroquia"
                    placeholder="Ingrese su parroquia"
                    v-model="dataInformacionNacimiento.parroquia"
                />
                <small
                    v-if="errorInformacionNacimiento.parroquia !== ''"
                    id="parroquiaHelp"
                    class="text-danger"
                    >{{ errorInformacionNacimiento.parroquia[0] }}</small
                >
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        dataInformacionNacimiento: {
            type: Object
        },
        errorInformacionNacimiento: {
            type: Object
        }
    },
    data: function() {
        return {
            paises: []
        };
    },
    watch: {
        "dataInformacionNacimiento.fecha_nacimiento"(value) {
            this.$emit("actualizarData", "fecha_nacimiento", value);
        },
        "dataInformacionNacimiento.lugar_nacimiento"(value) {
            this.$emit("actualizarData", "lugar_nacimiento", value);
        },
        "dataInformacionNacimiento.parroquia"(value) {
            this.$emit("actualizarData", "parroquia", value);
        }
    },
    mounted: function() {
        this.cargarPaises();
    },
    methods: {
        setSelectedPais(value) {
            this.$emit("actualizarData", "pais", value.value);
            this.$emit("actualizarData", "paisNombre", value.display);
        },

        cargarPaises() {
            let that = this;
            let url = "/datos_generales/generalidades/cargar_paises";
            axios
                .get(url)
                .then(function(response) {
                    let paises = [];
                    for (let i = 0; i < response.data.paises.length; i++) {
                        let objeto = {};
                        objeto.value = response.data.paises[i].PAIS_COD;
                        objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(response.data.paises[i].PAIS_NOM);
                        paises.push(objeto);
                    }
                    that.paises = paises;
                })
                .catch(error => {
                    //Errores
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
