<template>
    <div class="row mt-2">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="primer_apellido"
                    ><span class="text-danger">(*)</span> Primer Apellido</label
                >
                <input
                    type="text"
                    :class="
                        errorInformacionPersonal.primer_apellido === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="primer_apellido"
                    placeholder="Ingrese apellido"
                    v-model="dataInformacionPersonal.primer_apellido"
                />
                <small
                    v-if="errorInformacionPersonal.primer_apellido !== ''"
                    id="primer_apellidoelp"
                    class="text-danger"
                    >{{ errorInformacionPersonal.primer_apellido[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="segundo_apellido">Segundo Apellido</label>
                <input
                    type="text"
                    :class="
                        errorInformacionPersonal.segundo_apellido === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="segundo_apellido"
                    placeholder="Ingrese apellido"
                    v-model="dataInformacionPersonal.segundo_apellido"
                />
                <small
                    v-if="errorInformacionPersonal.segundo_apellido !== ''"
                    id="segundo_apellidoHelp"
                    class="text-danger"
                    >{{ errorInformacionPersonal.segundo_apellido[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="primer_nombre"
                    ><span class="text-danger">(*)</span> Primer Nombre</label
                >
                <input
                    type="text"
                    :class="
                        errorInformacionPersonal.primer_nombre === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="primer_nombre"
                    placeholder="Ingrese nombre"
                    v-model="dataInformacionPersonal.primer_nombre"
                />
                <small
                    v-if="errorInformacionPersonal.primer_nombre !== ''"
                    id="primer_nombreHelp"
                    class="text-danger"
                    >{{ errorInformacionPersonal.primer_nombre[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="segundo_nombre">Segundo Nombre</label>
                <input
                    type="text"
                    :class="
                        errorInformacionPersonal.segundo_nombre === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="segundo_nombre"
                    placeholder="Ingrese nombre"
                    v-model="dataInformacionPersonal.segundo_nombre"
                />
                <small
                    v-if="errorInformacionPersonal.segundo_nombre !== ''"
                    id="primer_nombreHelp"
                    class="text-danger"
                    >{{ errorInformacionPersonal.segundo_nombre[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="email_institucional"
                    ><span class="text-danger">(*)</span> Correo
                    Electrónico</label
                >
                <input
                    type="email"
                    :class="
                        errorInformacionPersonal.email_institucional === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="email_institucional"
                    placeholder="Ingrese correo electrónico"
                    v-model="dataInformacionPersonal.email_institucional"
                />
                <small
                    v-if="errorInformacionPersonal.email_institucional !== ''"
                    id="email_institucionalHelp"
                    class="text-danger"
                >
                    {{ errorInformacionPersonal.email_institucional[0] }}
                </small>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="email_alternativo">Correo Alternativo</label>
                <input
                    type="email"
                    :class="
                        errorInformacionPersonal.email_alternativo === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="email_alternativo"
                    placeholder="Ingrese correo alternativo"
                    v-model="dataInformacionPersonal.email_alternativo"
                />
                <small
                    v-if="errorInformacionPersonal.email_alternativo !== ''"
                    id="email_alternativoHelp"
                    class="text-danger"
                    >{{ errorInformacionPersonal.email_alternativo[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input
                    type="email"
                    :class="
                        errorInformacionPersonal.telefono === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="telefono"
                    placeholder="Ingrese teléfono"
                    v-model="dataInformacionPersonal.telefono"
                />
                <small
                    v-if="errorInformacionPersonal.telefono !== ''"
                    id="telefonoHelp"
                    class="text-danger"
                    >{{ errorInformacionPersonal.telefono[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="celular">Celular</label>
                <input
                    type="text"
                    :class="
                        errorInformacionPersonal.celular === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="celular"
                    placeholder="Ingrese celular"
                    v-model="dataInformacionPersonal.celular"
                />
                <small
                    v-if="errorInformacionPersonal.celular !== ''"
                    id="celularHelp"
                    class="text-danger"
                    >{{ errorInformacionPersonal.celular[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="rol"><span class="text-danger">(*)</span> Sexo</label>
                <v-select
                    v-model="dataInformacionPersonal.sexoNombre"
                    :value="dataInformacionPersonal.sexo"
                    :options="sexos"
                    label="display"
                    @input="setSelectedSexo"
                    :class="
                        errorInformacionPersonal.sexo === ''
                            ? ''
                            : 'form-control is-invalid'
                    "
                >
                    <template slot="no-options"
                        >No se ha encontrado ningun dato</template
                    >
                </v-select>
                <small
                    v-if="errorInformacionPersonal.sexo !== ''"
                    id="primer_nombreHelp"
                    class="text-danger"
                    >{{ errorInformacionPersonal.sexo[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="rol">Estado civil</label>
                <v-select
                    v-model="dataInformacionPersonal.estadoCivilNombre"
                    :value="dataInformacionPersonal.estado_civil"
                    :options="estadosCivil"
                    label="display"
                    @input="setSelectedEstadoCivil"
                >
                    <template slot="no-options"
                        >No se ha encontrado ningun dato</template
                    >
                </v-select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="rol">Tipos de sangre</label>
                <v-select
                    v-model="dataInformacionPersonal.tipoSangreNombre"
                    :value="dataInformacionPersonal.tipo_sangre"
                    :options="tiposDeSangre"
                    label="display"
                    @input="setSelectedTipoDeSangre"
                >
                    <template slot="no-options"
                        >No se ha encontrado ningun dato</template
                    >
                </v-select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="rol">Religión</label>
                <v-select
                    v-model="dataInformacionPersonal.religionNombre"
                    :value="dataInformacionPersonal.religion"
                    :options="religiones"
                    label="display"
                    @input="setSelectedReligion"
                >
                    <template slot="no-options"
                        >No se ha encontrado ningun dato</template
                    >
                </v-select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="rol">Grupos Culturales</label>
                <v-select
                    v-model="dataInformacionPersonal.grupoCulturalNombre"
                    :value="dataInformacionPersonal.grupo_cultural"
                    :options="gruposCulturales"
                    label="display"
                    @input="setSelectedGrupoCultural"
                >
                    <template slot="no-options"
                        >No se ha encontrado ningun dato</template
                    >
                </v-select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="nombre_contacto_emergencia"
                    >Nombre Contacto Emergencia</label
                >
                <input
                    type="text"
                    :class="
                        errorInformacionPersonal.nombre_contacto_emergencia ===
                        ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="nombre_contacto_emergencia"
                    placeholder="Ingrese nombre contacto emergencia"
                    v-model="dataInformacionPersonal.nombre_contacto_emergencia"
                />
                <small
                    v-if="
                        errorInformacionPersonal.nombre_contacto_emergencia !==
                            ''
                    "
                    id="nombre_contacto_emergenciaHelp"
                    class="text-danger"
                >
                    {{ errorInformacionPersonal.nombre_contacto_emergencia[0] }}
                </small>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="telefono_contacto_emergencia"
                    >Teléfono Contacto Emergencia</label
                >
                <input
                    type="text"
                    :class="
                        errorInformacionPersonal.telefono_contacto_emergencia ===
                        ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="teléfono_contacto_emergencia"
                    placeholder="Ingrese telefono contacto emergencia"
                    v-model="
                        dataInformacionPersonal.telefono_contacto_emergencia
                    "
                />
                <small
                    v-if="
                        errorInformacionPersonal.telefono_contacto_emergencia !==
                            ''
                    "
                    id="telefono_contacto_emergenciaHelp"
                    class="text-danger"
                >
                    {{
                        errorInformacionPersonal.telefono_contacto_emergencia[0]
                    }}
                </small>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row" style="width: 100%;justify-content:center">
                <input
                    type="file"
                    ref="file"
                    @change="onFileSelected"
                    style="display: none"
                />
                <pdf-preview
                    :blobType="blobType"
                    :esTabla="false"
                    :url="
                        this.$refs.file != undefined &&
                        this.$props.dataInformacionPersonal.pdf_cedula ==
                            this.$refs.file.files[0]
                            ? URLpreviewCedula
                            : this.$props.dataInformacionPersonal.pdf_cedula
                    "
                    :size="['100%']"
                ></pdf-preview>
            </div>
            <div class="row" style="width: 100%;justify-content:center">
                <button
                    class="btn btn-info btn-sm mb-3"
                    @click="$refs.file.click()"
                >
                    Cargar Cédula de Identidad
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        dataInformacionPersonal: {
            type: Object
        },
        errorInformacionPersonal: {
            type: Object
        },
        tiposDeSangre: {
            type: Array
        },
        religiones: {
            type: Array
        },
        gruposCulturales: {
            type: Array
        }
    },
    created: function() {
        // `this` hace referencia a la instancia vm
    },
    data: function() {
        return {
            URLpreviewCedula: "",
            blobType: "",
            pdfCedula: "",
            sexos: [
                {
                    display: "Maculino",
                    value: "M"
                },
                {
                    display: "Femenino",
                    value: "F"
                },
                {
                    display: "Otros",
                    value: "O"
                }
            ],
            estadosCivil: [
                {
                    display: "Soltero(a)",
                    value: "S"
                },
                {
                    display: "Casado(a)",
                    value: "C"
                },
                {
                    display: "Divorciado(a)",
                    value: "D"
                },
                {
                    display: "Viudo(a)",
                    value: "V"
                },
                {
                    display: "Union Libre",
                    value: "U"
                }
            ]
        };
    },
    watch: {
        "dataInformacionPersonal.primer_apellido"(value) {
            this.$emit("actualizarData", "primer_apellido", value);
        },
        "dataInformacionPersonal.segundo_apellido"(value) {
            this.$emit("actualizarData", "segundo_apellido", value);
        },
        "dataInformacionPersonal.primer_nombre"(value) {
            this.$emit("actualizarData", "primer_nombre", value);
        },
        "dataInformacionPersonal.segundo_nombre"(value) {
            this.$emit("actualizarData", "segundo_nombre", value);
        },
        "dataInformacionPersonal.email_institucional"(value) {
            this.$emit("actualizarData", "email_institucional", value);
        },
        "dataInformacionPersonal.email_alternativo"(value) {
            this.$emit("actualizarData", "email_alternativo", value);
        },
        "dataInformacionPersonal.telefono"(value) {
            this.$emit("actualizarData", "telefono", value);
        },
        "dataInformacionPersonal.celular"(value) {
            this.$emit("actualizarData", "celular", value);
        },
        "dataInformacionPersonal.nombre_contacto_emergencia"(value) {
            this.$emit("actualizarData", "nombre_contacto_emergencia", value);
        },
        "dataInformacionPersonal.telefono_contacto_emergencia"(value) {
            this.$emit("actualizarData", "telefono_contacto_emergencia", value);
        }
    },
    mounted: function() {
        if (this.dataInformacionPersonal != null) {
        }
    },
    methods: {
        onFileSelected(event) {
            if (
                event.target.files[0]["type"] === "application/pdf" ||
                event.target.files[0]["type"] === "image/jpg" ||
                event.target.files[0]["type"] === "image/png" ||
                event.target.files[0]["type"] === "image/jpeg"
            ) {
                this.pdfCedula = event.target.files[0];
                this.URLpreviewCedula = window.URL.createObjectURL(
                    this.pdfCedula
                );
                if (this.pdfCedula["type"] === "application/pdf") {
                    this.blobType = "pdf";
                } else {
                    this.blobType = "image";
                }

                this.$emit("actualizarData", "pdf_cedula", this.pdfCedula);
            } else {
                this.$swal({
                    icon: "error",
                    title: "Error de Archivo",
                    text: "Solo archivos de formato: .pdf o de imagen!"
                });
            }
        },
        setSelectedSexo(value) {
            this.$emit("actualizarData", "sexo", value.value);
            this.$emit("actualizarData", "sexoNombre", value.display);
        },
        setSelectedEstadoCivil(value) {
            this.$emit("actualizarData", "estado_civil", value.value);
            this.$emit("actualizarData", "estadoCivilNombre", value.display);
        },
        setSelectedTipoDeSangre(value) {
            this.$emit("actualizarData", "tipo_sangre", value.value);
            this.$emit("actualizarData", "tipoSangreNombre", value.display);
        },
        setSelectedReligion(value) {
            this.$emit("actualizarData", "religion", value.value);
            this.$emit("actualizarData", "religionNombre", value.display);
        },
        setSelectedGrupoCultural(value) {
            this.$emit("actualizarData", "grupo_cultural", value.value);
            this.$emit("actualizarData", "grupoCulturalNombre", value.display);
        }
    }
};
</script>
