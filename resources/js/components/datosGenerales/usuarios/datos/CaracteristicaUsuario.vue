<template>
    <div>
        <div class="row mt-2">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="estatura_metros">Estatura Metros</label>
                    <input
                        type="text"
                        :class="
                            errorInformacionCaracteristicaUsuario.estatura_metros ===
                            ''
                                ? 'form-control'
                                : 'form-control is-invalid'
                        "
                        id="estatura_metros"
                        placeholder="Ingrese la estatura"
                        v-model="
                            dataInformacionCaracteristicaUsuario.estatura_metros
                        "
                    />
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.estatura_metros !==
                                ''
                        "
                        id="bstatura_metrosHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario
                                .estatura_metros[0]
                        }}</small
                    >
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="peso_kg">Peso Kg</label>
                    <input
                        type="text"
                        :class="
                            errorInformacionCaracteristicaUsuario.peso_kg === ''
                                ? 'form-control'
                                : 'form-control is-invalid'
                        "
                        id="peso_kg"
                        placeholder="Ingrese el peso en kg"
                        v-model="dataInformacionCaracteristicaUsuario.peso_kg"
                    />
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.peso_kg !== ''
                        "
                        id="bstatura_metrosHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario.peso_kg[0]
                        }}</small
                    >
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="talla_camisa">Talla Camisa/Blusa</label>
                    <v-select
                        v-model="
                            dataInformacionCaracteristicaUsuario.tallaCamisaNombre
                        "
                        :value="
                            dataInformacionCaracteristicaUsuario.talla_camisa
                        "
                        :options="tallasCamisa"
                        label="TALLACAMISA_NOM"
                        @input="setSelectedTallaCamisa"
                    >
                        <template slot="no-options">seleccione</template>
                    </v-select>
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.talla_camisa !==
                                ''
                        "
                        id="talla_camisaHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario
                                .talla_camisa[0]
                        }}</small
                    >
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="talla_pantalon">Talla Pantalón</label>
                    <v-select
                        v-model="
                            dataInformacionCaracteristicaUsuario.tallaPantalonNombre
                        "
                        :value="
                            dataInformacionCaracteristicaUsuario.talla_pantalon
                        "
                        :options="tallasPantalon"
                        label="TALLAPANTALON_NOM"
                        @input="setSelectedTallaPantalon"
                    >
                        <template slot="no-options">seleccione</template>
                    </v-select>
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.talla_pantalon !==
                                ''
                        "
                        id="talla_pantalonHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario
                                .talla_pantalon[0]
                        }}</small
                    >
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="talla_zapato">Talla Zapato</label>
                    <v-select
                        v-model="
                            dataInformacionCaracteristicaUsuario.tallaZapatoNombre
                        "
                        :value="
                            dataInformacionCaracteristicaUsuario.talla_zapato
                        "
                        :options="tallasZapato"
                        label="TALLAZAPATO_NOM"
                        @input="setSelectedTallaZapato"
                    >
                        <template slot="no-options">seleccione</template>
                    </v-select>
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.talla_zapato !==
                                ''
                        "
                        id="talla_zapatoHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario
                                .talla_zapato[0]
                        }}</small
                    >
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="movilizacion">Movilización</label>
                    <v-select
                        v-model="
                            dataInformacionCaracteristicaUsuario.movilizacionNombre
                        "
                        :value="
                            dataInformacionCaracteristicaUsuario.movilizacion
                        "
                        :options="movilizaciones"
                        label="display"
                        @input="setSelectedMovilizacion"
                    >
                        <template slot="no-options">seleccione</template>
                    </v-select>
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.movilizacion !==
                                ''
                        "
                        id="movilizacionHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario
                                .movilizacionNombre[0]
                        }}</small
                    >
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="observacion">Observaciones</label>
                    <textarea
                        name="observacion"
                        id="observacion"
                        rows="4"
                        :class="
                            errorInformacionCaracteristicaUsuario.observacion ===
                            ''
                                ? 'form-control'
                                : 'form-control is-invalid'
                        "
                        placeholder="Ingrese su observación"
                        v-model="
                            dataInformacionCaracteristicaUsuario.observacion
                        "
                    ></textarea>
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.observacion !==
                                ''
                        "
                        id="direccionHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario.observacion[0]
                        }}</small
                    >
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="observacion">
                        <strong>Posee una discapacidad?</strong>
                    </label>
                    <br />
                    <input
                        type="radio"
                        id="si"
                        value="S"
                        v-model="
                            dataInformacionCaracteristicaUsuario.discapacidad
                        "
                    />
                    <label for="si">Si</label>
                    <br />
                    <input
                        type="radio"
                        id="no"
                        value="N"
                        v-model="
                            dataInformacionCaracteristicaUsuario.discapacidad
                        "
                    />
                    <label for="no">No</label>
                    <br />

                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.discapacidad !==
                                ''
                        "
                        id="direccionHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario
                                .discapacidad[0]
                        }}</small
                    >
                </div>
            </div>
        </div>
        <div
            v-if="dataInformacionCaracteristicaUsuario.discapacidad == 'S'"
            class="row"
        >
            <!-- Tipo de Discapacidad -->
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="form-group">
                    <label for="movilizacion">Tipo de Discapacidad</label>
                    <v-select
                        v-model=" dataInformacionCaracteristicaUsuario.discapacidadesNombre"
                        :value="dataInformacionCaracteristicaUsuario.discapacidades"
                        :options="discapacidades"
                        label="display"
                        @input="setSelectedDiscapacidad"
                    >
                        <template slot="no-options">seleccione</template>
                    </v-select>
                    <small
                        v-if="errorInformacionCaracteristicaUsuario.discapacidad !=='' "
                        id="discapacidadHelp"
                        class="text-danger"
                    >
                        {{errorInformacionCaracteristicaUsuario.discapacidadNombre[0]}}
                    </small>
                </div>
            </div>
            <!-- Discapacidad (%) -->
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="form-group">
                    <label for="porcentage">Discapacidad (%)</label>
                    <input
                        type="number"
                        class="form-control"
                        id="porcentage"
                        placeholder="Porcentaje"
                        v-model="
                            dataInformacionCaracteristicaUsuario.porcentageDiscapacidad
                        "
                    />
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.porcentageDiscapacidad !==
                                ''
                        "
                        id="bstatura_metrosHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario
                                .porcentageDiscapacidad[0]
                        }}</small
                    >
                </div>
            </div>
            <!-- Conadis % -->
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="form-group">
                    <label for="conadis">Conadis %</label>
                    <input
                        type="number"
                        class="form-control"
                        id="conadis"
                        placeholder="Conadis"
                        v-model="dataInformacionCaracteristicaUsuario.conadis"
                    />
                    <small
                        v-if="
                            errorInformacionCaracteristicaUsuario.conadis !== ''
                        "
                        id="bstatura_metrosHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario.conadis[0]
                        }}</small
                    >
                </div>
            </div>
            <!-- MSP % -->
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="form-group">
                    <label for="msp">MSP %</label>
                    <input
                        type="number"
                        class="form-control"
                        id="msp"
                        placeholder="msp"
                        v-model="dataInformacionCaracteristicaUsuario.msp"
                    />
                    <small
                        v-if="errorInformacionCaracteristicaUsuario.msp !== ''"
                        id="bstatura_metrosHelp"
                        class="text-danger"
                        >{{
                            errorInformacionCaracteristicaUsuario.msp[0]
                        }}</small
                    >
                </div>
            </div>
            <!-- PDF Conadis -->
            <div class="col-lg-6">
                <input
                    type="file"
                    ref="file1"
                    @change="onFileSelectedConadis"
                    style="display: none"
                />
                <pdf-preview
                    :blobType="blobConadisType"
                    :esTabla="false"
                    :url="
                        this.$refs.file1 != undefined &&
                        this.$props.dataInformacionCaracteristicaUsuario
                            .pdfConadis == this.$refs.file1.files[0]
                            ? URLpreviewConadis
                            : this.$props.dataInformacionCaracteristicaUsuario
                                  .pdfConadis
                    "
                    :size="['100%']"
                ></pdf-preview>
                <button
                    class="btn btn-block btn-info btn-sm mb-3"
                    @click="$refs.file1.click()"
                >
                    Cargar Archivo Conadis
                </button>
            </div>
            <!-- PDF MSP -->
            <div class="col-lg-6">
                <input
                    type="file"
                    ref="file2"
                    @change="onFileSelectedMSP"
                    style="display: none"
                />
                <pdf-preview
                    :blobType="blobMSPType"
                    :esTabla="false"
                    :url="
                        this.$refs.file2 != undefined &&
                        this.$props.dataInformacionCaracteristicaUsuario
                            .pdfMsp == this.$refs.file2.files[0]
                            ? URLpreviewMSP
                            : this.$props.dataInformacionCaracteristicaUsuario
                                  .pdfMsp
                    "
                    :size="['100%']"
                ></pdf-preview>
                <button
                    class="btn btn-block btn-info btn-sm mb-3"
                    @click="$refs.file2.click()"
                >
                    Cargar Archivo MSP
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        dataInformacionCaracteristicaUsuario: {
            type: Object
        },
        errorInformacionCaracteristicaUsuario: {
            type: Object
        }
    },
    data: function() {
        return {
            URLpreviewConadis: "",
            blobConadisType: "",
            URLpreviewMSP: "",
            blobMSPType: "",
            tallasCamisa: [],
            tallasPantalon: [],
            tallasZapato: [],
            movilizaciones: [],
            discapacidades: [],
            tieneDiscapacidad: "",
            pdfConadis: "",
            pdfMsp: ""
        };
    },
    watch: {
        "dataInformacionCaracteristicaUsuario.estatura_metros"(value) {
            this.$emit("actualizarData", "estatura_metros", value);
        },
        "dataInformacionCaracteristicaUsuario.peso_kg"(value) {
            this.$emit("actualizarData", "peso_kg", value);
        },
        "dataInformacionCaracteristicaUsuario.observacion"(value) {
            this.$emit("actualizarData", "observacion", value);
        },
        "dataInformacionCaracteristicaUsuario.discapacidad"(value) {
            this.$emit("actualizarData", "discapacidad", value);
        },
        "dataInformacionCaracteristicaUsuario.porcentageDiscapacidad"(value) {
            this.$emit("actualizarData", "porcentageDiscapacidad", value);
        },
        "dataInformacionCaracteristicaUsuario.conadis"(value) {
            this.$emit("actualizarData", "conadis", value);
        },
        "dataInformacionCaracteristicaUsuario.msp"(value) {
            this.$emit("actualizarData", "msp", value);
        }
    },
    mounted: function() {
        this.cargarTallasCamisa();
        this.cargarTallasPantalon();
        this.cargarTallasZapato();
        this.cargarMovilizaciones();
        this.cargarDiscapacidades();
    },

    methods: {
        onFileSelectedConadis(event) {
            if (
                event.target.files[0]["type"] === "application/pdf" ||
                event.target.files[0]["type"] === "image/jpg" ||
                event.target.files[0]["type"] === "image/png" ||
                event.target.files[0]["type"] === "image/jpeg"
            ) {
                this.pdfConadis = event.target.files[0];
                this.URLpreviewConadis = window.URL.createObjectURL(
                    this.pdfConadis
                );
                if (this.pdfConadis["type"] === "application/pdf") {
                    this.blobConadisType = "pdf";
                } else {
                    this.blobConadisType = "image";
                }

                this.$emit("actualizarData", "pdfConadis", this.pdfConadis);
            } else {
                this.$swal({
                    icon: "error",
                    title: "Error de Archivo",
                    text: "Solo archivos de formato: .pdf o de imagen!"
                });
            }
        },
        onFileSelectedMSP(event) {
            if (
                event.target.files[0]["type"] === "application/pdf" ||
                event.target.files[0]["type"] === "image/jpg" ||
                event.target.files[0]["type"] === "image/png" ||
                event.target.files[0]["type"] === "image/jpeg"
            ) {
                this.pdfMsp = event.target.files[0];
                this.URLpreviewMSP = window.URL.createObjectURL(this.pdfMsp);
                if (this.pdfMsp["type"] === "application/pdf") {
                    this.blobMSPType = "pdf";
                } else {
                    this.blobMSPType = "image";
                }

                this.$emit("actualizarData", "pdfMsp", this.pdfMsp);
            } else {
                this.$swal({
                    icon: "error",
                    title: "Error de Archivo",
                    text: "Solo archivos de formato: .pdf o de imagen!"
                });
            }
        },
        setSelectedTallaCamisa(value) {
            this.$emit("actualizarData", "talla_camisa", value.TALLACAMISA_COD);
            this.$emit(
                "actualizarData",
                "tallaCamisaNombre",
                value.TALLACAMISA_NOM
            );
        },
        setSelectedTallaPantalon(value) {
            this.$emit(
                "actualizarData",
                "talla_pantalon",
                value.TALLAPANTALON_COD
            );
            this.$emit(
                "actualizarData",
                "tallaPantalonNombre",
                value.TALLAPANTALON_NOM
            );
        },
        setSelectedTallaZapato(value) {
            this.$emit("actualizarData", "talla_zapato", value.TALLAZAPATO_COD);
            this.$emit(
                "actualizarData",
                "tallaZapatoNombre",
                value.TALLAZAPATO_NOM
            );
        },
        setSelectedMovilizacion(value) {
            this.$emit("actualizarData","movilizacion",value.value);
            this.$emit("actualizarData","movilizacionNombre",value.display);
        },
        setSelectedDiscapacidad(value) {
            this.$emit("actualizarData","discapacidades",value.value);
            this.$emit("actualizarData","discapacidadesdNombre",value.display);
        },
        cargarTallasCamisa() {
            let that = this;
            let url = "/datos_generales/usuarios/tallas_camisa";
            axios
                .get(url)
                .then(function(response) {
                    let tallasCamisa = [];
                    tallasCamisa = response.data.tallasCamisa;

                    that.tallasCamisa = tallasCamisa;
                })
                .catch(error => {
                    //Errores
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                });
        },
        cargarTallasZapato() {
            let that = this;
            let url = "/datos_generales/usuarios/tallas_zapato";
            axios
                .get(url)
                .then(function(response) {
                    let tallasZapato = [];
                    tallasZapato = response.data.tallasZapato;

                    that.tallasZapato = tallasZapato;
                })
                .catch(error => {
                    //Errores
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                });
        },
        cargarTallasPantalon() {
            let that = this;
            let url = "/datos_generales/usuarios/tallas_pantalon";
            axios
                .get(url)
                .then(function(response) {
                    let tallasPantalon = [];
                    tallasPantalon = response.data.tallasPantalon;

                    that.tallasPantalon = tallasPantalon;
                })
                .catch(error => {
                    //Errores
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                });
        },
        cargarMovilizaciones() {
            let that = this;
            let url = "/datos_generales/usuarios/movilizaciones";
            axios
                .get(url)
                .then(function(response) {
                    let movilizaciones = [];
                    for (let i = 0; i < response.data.movilizaciones.length; i++) {
                        let objeto = {};
                        objeto.value = response.data.movilizaciones[i].MOVILIZACION_COD;
                        objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(response.data.movilizaciones[i].MOVILIZACION_NOM);
                        movilizaciones.push(objeto);
                    }
                    that.movilizaciones = movilizaciones;
                })
                .catch(error => {
                    //Errores
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                });
        },
        cargarDiscapacidades() {
            let that = this;
            let url = "/datos_generales/usuarios/discapacidades";
            axios
                .get(url)
                .then(function(response) {
                    let discapacidades = [];
                    for (let i = 0; i < response.data.discapacidades.length; i++) {
                        let objeto = {};
                        objeto.value = response.data.discapacidades[i].DISCAPACIDAD_COD;
                        objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(response.data.discapacidades[i].DISCAPACIDAD_NOM);
                        discapacidades.push(objeto);
                    }
                    that.discapacidades = discapacidades;

                    
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
