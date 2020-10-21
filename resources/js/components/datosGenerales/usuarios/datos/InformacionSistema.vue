<template>
    <div class="row m-3">
        <div class="col-lg-4 col-md-4 col-sm-12" v-if="!esAdmisiones">
            <div class="row" style="height: 300px; width: 300px;">
                <div v-if="this.$props.dataInformacionSistema !== null">
                    <img
                        class="w-50"
                        v-if="fotoUsuario == ''"
                        :src="this.$props.dataInformacionSistema.fotoURL"
                        alt
                        srcset
                    />
                    <img
                        class="w-50"
                        v-if="fotoUsuario != ''"
                        :src="dataInformacionSistema.fotoURL"
                        alt
                        srcset
                    />
                </div>
                <div v-if="this.$props.dataInformacionSistema === null">
                    <img
                        class="w-50"
                        v-if="fotoUsuario == '' || fotoUsuario == null"
                        src
                        alt
                        srcset
                    />
                    <img
                        class="w-50"
                        v-if="fotoUsuario != '' || fotoUsuario != null"
                        :src="dataInformacionSistema.fotoURL"
                        alt
                        srcset
                    />
                </div>
            </div>
            <div class="row">
                <input
                    type="file"
                    ref="file"
                    @change="onFileSelected"
                    style="display: none"
                />
                <button
                    type="button"
                    class="btn btn-primary"
                    @click="$refs.file.click()"
                >
                    <i class="fas fa-image"></i>Cargar Foto del Usuario
                </button>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="rol"
                    ><label class="text-danger">(*)</label> Identificación en
                    Sistema</label
                >
                <v-select
                    v-model="
                        this.$props.dataInformacionSistema.tipoIdentificacion
                    "
                    :options="opcionesIdentificacion"
                    :value="
                        this.$props.dataInformacionSistema.tipoIdentificacion
                    "
                    @input="selectIdentificacion"
                    label="display"
                >
                    <template slot="no-options"
                        >No se ha encontrado ningun dato</template
                    >
                </v-select>
            </div>
            <input
                class="form-control"
                v-if="
                    this.$props.dataInformacionSistema.tipoIdentificacion ==
                        'CEDULA'
                "
                max="10"
                min="10"
                v-model="dataInformacionSistema.identificacionCedula"
                type="number"
                placeholder="Cédula del usuario..."
            />
            <small
                v-if="
                    this.$props.errorInformacionSistema.identificacionCedula !==
                        ''
                "
                id="bstatura_metrosHelp"
                class="text-danger"
                >{{
                    this.$props.errorInformacionSistema.identificacionCedula[0]
                }}</small
            >
            <input
                type="number"
                class="form-control"
                v-if="
                    this.$props.dataInformacionSistema.tipoIdentificacion ==
                        'PASAPORTE'
                "
                v-model="dataInformacionSistema.identificacionPasaporte"
                placeholder="Pasaporte del usuario..."
            />
            <small
                v-if="
                    this.$props.errorInformacionSistema
                        .identificacionPasaporte !== ''
                "
                id="bstatura_metrosHelp"
                class="text-danger"
                >{{
                    this.$props.errorInformacionSistema
                        .identificacionPasaporte[0]
                }}</small
            >
            <input
                class="form-control"
                v-if="
                    this.$props.dataInformacionSistema.tipoIdentificacion ==
                        '17-DIGITOS'
                "
                v-model="dataInformacionSistema.identificacion17Digitos"
                placeholder="El sistema dará este valor."
                disabled
            />
            <small
                v-if="
                    this.$props.errorInformacionSistema
                        .identificacion17Digitos !== ''
                "
                id="bstatura_metrosHelp"
                class="text-danger"
                >{{
                    this.$props.errorInformacionSistema
                        .identificacion17Digitos[0]
                }}</small
            >
            <label for>Código para Registro Nuevo:</label>
            <input
                class="form-control"
                v-model="identificacion17Digitos"
                placeholder="CODIGO"
                disabled
            />
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12" v-if="!esAdmisiones">
            <div class="form-group">
                <label for>
                    (*) Contraseña
                </label>
                <input
                    type="password"
                    :class="
                        errorInformacionSistema.password === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    v-model="dataInformacionSistema.password"
                    placeholder="Ingresar contrasena de usuario..."
                />
                <small
                    v-if="errorInformacionSistema.password !== ''"
                    id="passwordHelp"
                    class="text-danger"
                    >{{ errorInformacionSistema.password[0] }}</small
                >
            </div>
            <div class="form-group">
                <label for>(*) Confirmar Contraseña</label>
                <input
                    type="password"
                    :class="
                        errorInformacionSistema.password_confirmation === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    v-model="dataInformacionSistema.password_confirmation"
                    placeholder="Ingresar la confirmación de contraseña"
                />
                <small
                    v-if="errorInformacionSistema.password_confirmation !== ''"
                    id="passwordConfirmationHelp"
                    class="text-danger"
                    >{{
                        errorInformacionSistema.password_confirmation[0]
                    }}</small
                >
            </div>
            <div class="form-group">
                <label for="rol">Activo</label>
                <v-select
                    v-model="this.$props.dataInformacionSistema.activo"
                    :value="this.$props.dataInformacionSistema.activo"
                    :options="activos"
                    label="id_tipo"
                    @input="setSelected"
                >
                    <template slot="no-options"
                        >No se ha encontrado ningun dato</template
                    >
                </v-select>
            </div>
            <div class="form-group">
                <label for="rol">Trabajador BSPI</label>
                <v-select
                    v-model="this.$props.dataInformacionSistema.trabajadorBSPI"
                    :value="this.$props.dataInformacionSistema.trabajadorBSPI"
                    :options="activos"
                    @input="setSelectedTrabajador"
                    label="id_tipo"
                >
                    <template slot="no-options"
                        >No se ha encontrado ningun dato</template
                    >
                </v-select>
            </div>
            <div class="form-group">
                <label for="alias">Alias</label>
                <input
                    class="form-control"
                    v-model="dataInformacionSistema.alias"
                    :placeholder="alias"
                />
            </div>
        </div>
        <modal
            :clickToClose="false"
            :width="'80%'"
            height="auto"
            :scrollable="true"
            name="listaPolizas"
        >
        </modal>
    </div>
</template>

<script>
export default {
    props: {
        esAdmisiones: {
            type: Boolean,
            default: false
        },
        dataInformacionSistema: {
            type: Object
        },
        errorInformacionSistema: {
            type: Object
        }
    },
    mounted() {
        if (this.$props.dataInformacionSistema !== null) {
            //this.fotoUrl = this.$props.dataInformacionSistema.fotoURL;

            this.activo = "";
            this.trabajadorBSPI = "";
            this.alias = "";
            this.password = "";
            this.identificacionCedula = "";
            this.identificacion17Digitos = "";
        }
    },
    data: function() {
        return {
            fotoUsuario: "",
            fotoUrl: "",
            identificacionInput: "form-control text-danger",
            password: "",
            passwordValid: false,
            alias: "ALIAS",
            tipoIdentificacion: "Cédula",
            selectedIdentificacion: "",
            identificacionCedula: "",
            identificacionPasaporte: "",
            identificacion17Digitos: "",
            validIdentificacion: false,
            activo: "S",
            trabajadorBSPI: "S",
            activos: [
                {
                    id_tipo: "S"
                },
                {
                    id_tipo: "N"
                }
            ],
            activosTrabajador: [
                {
                    id_tipo: "S"
                },
                {
                    id_tipo: "N"
                }
            ],
            selectedActivo: "",
            selectedTrabajador: "",
            opcionesIdentificacion: [
                {
                    display: "Cédula",
                    value: "CEDULA"
                },
                {
                    display: "Pasaporte",
                    value: "PASAPORTE"
                },
                {
                    display: "17-Digitos",
                    value: "17-DIGITOS"
                }
            ]
        };
    },
    watch: {
        "dataInformacionSistema.identificacionCedula"(value) {
            this.$emit("actualizarData", "identificacionCedula", value);
        },
        "dataInformacionSistema.identificacionPasaporte"(value) {
            this.$emit("actualizarData", "identificacionPasaporte", value);
        },
        "dataInformacionSistema.password"(value) {
            this.$emit("actualizarData", "password", value);
        },
        "dataInformacionSistema.alias"(value) {
            this.$emit("actualizarData", "alias", value);
        },
        "dataInformacionSistema.fotoURL"(value) {
            this.$emit("actualizarData", "fotoURL", value);
        }
    },
    methods: {
        mostrarModalPoliza() {
            this.$modal.show("listaPolizas");
        },
        motrarModalBeneficiario() {
            this.$modal.show("listaBeneficiarios");
        },
        guardar() {
            this.$emit("guardarData");
        },
        //selects al padre
        setSelected(value) {
            if (value !== null) {
                this.activo = value.id_tipo;
                this.$emit("actualizarData", "activo", this.activo);
            } else {
                this.activo = "";
            }
        },
        setSelectedTrabajador(value) {
            if (value !== null) {
                this.trabajadorBSPI = value.id_tipo;
                this.$emit(
                    "actualizarData",
                    "trabajadorBSPI",
                    this.trabajadorBSPI
                );
            } else {
                this.trabajadorBSPI = "";
            }
        },
        onFileSelected(event) {
            if (
                event.target.files[0]["type"] === "image/jpeg" ||
                event.target.files[0]["type"] === "image/png" ||
                event.target.files[0]["type"] === "image/jpg"
            ) {
                this.fotoUsuario = event.target.files[0];
                this.dataInformacionSistema.fotoURL = URL.createObjectURL(
                    this.fotoUsuario
                );
                this.$emit("actualizarData", "fotoUsuario", this.fotoUsuario);
            } else {
                this.$swal({
                    icon: "error",
                    title: "Error de Archivo",
                    text:
                        "Solo imagenes de formato: .jpeg, .jpg, .png son permitidos!"
                });
            }
        },
        selectIdentificacion(value) {
            this.$emit("actualizarData", "tipoIdentificacion", value.value);
        }
    }
};
</script>
