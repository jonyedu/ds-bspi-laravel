<template>
    <div class="row m-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-4">ORGANISMOS Y CONTACTOS</h5>
            </center>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-md-12 col-sm-12 p-5">
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="organismo">Organismo</label>
                                    <v-select
                                        v-model="selectedOrganismo"
                                        :value="form.organismo_cod"
                                        :options="organismos"
                                        label="ORG_NOM"
                                        @input="setSelectedOrganismo"
                                    >
                                        <template slot="no-options"
                                            >No se ha encontrado ningun
                                            dato</template
                                        >
                                    </v-select>
                                    <small
                                        v-if="errores.organismo !== ''"
                                        id="organismoHelp"
                                        class="text-danger"
                                        >{{ errores.organismo[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="usuario"
                                        >Usuario (Contacto)</label
                                    >
                                    <v-select
                                        v-model="selectedUsuario"
                                        :value="form.usuario_cod"
                                        :options="usuarios"
                                        label="FULL_NAME_IDENTIFICATION"
                                        @input="setSelectedUsuario"
                                    >
                                        <template slot="no-options"
                                            >No se ha encontrado ningun
                                            dato</template
                                        >
                                    </v-select>
                                    <small
                                        v-if="errores.usuario !== ''"
                                        id="usuarioHelp"
                                        class="text-danger"
                                        >{{ errores.usuario[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="cargo"
                                        >Cargo En Organismo</label
                                    >
                                    <v-select
                                        v-model="selectedCargo"
                                        :value="form.cargo_cod"
                                        :options="cargos"
                                        label="CARGOORG_NOM"
                                        @input="setSelectedCargo"
                                    >
                                        <template slot="no-options"
                                            >No se ha encontrado ningun
                                            dato</template
                                        >
                                    </v-select>
                                    <small
                                        v-if="errores.cargo !== ''"
                                        id="cargoHelp"
                                        class="text-danger"
                                        >{{ errores.cargo[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="rol">Activo</label>
                                    <v-select
                                        v-model="selectedActivo"
                                        :value="form.activo"
                                        :options="activos"
                                        label="id_tipo"
                                        @input="setSelected"
                                    >
                                        <template slot="no-options"
                                            >No se ha encontrado ningun
                                            dato</template
                                        >
                                    </v-select>
                                    <small
                                        v-if="errores.activo !== ''"
                                        id="activoHelp"
                                        class="text-danger"
                                        >{{ errores.activo[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <input
                                        type="text"
                                        :class="
                                            errores.observacion === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="observacion"
                                        placeholder="Ingrese su observación"
                                        v-model="form.observacion"
                                    />
                                    <small
                                        v-if="errores.observacion !== ''"
                                        id="observacionHelp"
                                        class="text-danger"
                                        >{{ errores.observacion[0] }}</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1"
                            >
                                <div class="form-inline">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block"
                                        @click="guardarActualizar()"
                                    >
                                        {{
                                            organismoYContactoMod === null
                                                ? "Guardar"
                                                : "Modificar"
                                        }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        organismoYContactoMod: {
            type: Object
        },
        organismos: {
            type: Array
        },
        usuarios: {
            type: Array
        },
        cargos: {
            type: Array
        }
    },
    data: function() {
        return {
            errores: {
                organismo: "",
                cargo: "",
                usuario: "",
                activo: "",
                observacion: ""
            },
            form: {
                organismo_cod: "",
                cargo_cod: "",
                usuario_cod: "",
                activo: "",
                observacion: ""
            },
            activos: [
                {
                    id_tipo: "S"
                },
                {
                    id_tipo: "N"
                }
            ],
            selectedOrganismo: "",
            selectedActivo: "S",
            selectedUsuario: "",
            selectedCargo: ""
            //organismosA: [],
            //cargosA: [],
            //usuariosA: []
        };
    },
    mounted: function() {
        this.form.activo = "S";

        if (this.$props.organismoYContactoMod !== null) {
            var organismoYContactoMod = this.$props.organismoYContactoMod;

            this.form.organismo_cod = organismoYContactoMod.ORG_COD;
            this.selectedOrganismo = organismoYContactoMod.ORG_NOM;

            this.form.cargo_cod = organismoYContactoMod.CARGOORG_COD;
            this.selectedCargo = organismoYContactoMod.CARGOORG_NOM;

            this.form.usuario_cod = organismoYContactoMod.US_COD;
            this.selectedUsuario = organismoYContactoMod.name;

            this.form.activo = organismoYContactoMod.ORGCONT_ACTIVO;

            this.form.observacion = organismoYContactoMod.ORGCONT_OBS;

            this.selectedActivo = organismoYContactoMod.ORGCONT_ACTIVO;
        }
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organismo_y_contactos_bspi
            .crear_organismos_y_contactos_bspi.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales
            .generalidades.organismo_y_contactos_bspi
            .crear_organismos_y_contactos_bspi.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        limpiarForm() {
            this.errores = {
                organismo: "",
                cargo: "",
                usuario: "",
                activo: "",
                observacion: ""
            };
            this.form = {
                organismo_cod: "",
                nombre: "",
                pais: "",
                tipo_organismo: "",
                email: "",
                celular: "",
                telefono: "",
                activo: "",
                observacion: "",
                direccion: ""
            };

            this.selectedActivo = "S";
            this.form.activo = "S";
            this.selectedCargo = "";
            this.selectedOrganismo = "";
            this.selectedUsuario = "";
        },
        setSelectedOrganismo(value) {
            if (value !== null) {
                this.form.organismo_cod = value.ORG_COD;
            } else {
                this.form.organismo_cod = "";
            }
        },
        setSelectedUsuario(value) {
            if (value !== null) {
                this.form.usuario_cod = value.US_COD;
            } else {
                this.form.usuario_cod = "";
            }
        },
        setSelectedCargo(value) {
            if (value !== null) {
                this.form.cargo_cod = value.CARGOORG_COD;
            } else {
                this.form.cargo_cod = "";
            }
        },
        setSelected(value) {
            if (value !== null) {
                this.form.activo = value.id_tipo;
            } else {
                this.form.activo = "";
            }
        },
        guardarActualizar: function() {
            let that = this;
            that.errores = {
                organismo_cod: "",
                nombre: "",
                pais: "",
                tipo_organismo: "",

                activo: "",
                observacion: ""
            };
            let url = "";
            let mensaje = "";

            if (this.$props.organismoYContactoMod !== null) {
                url =
                    "/datos_generales/generalidades/modificar_organismosYContactos";
                mensaje = "Datos actualizados correctamente.";
            } else {
                url =
                    "/datos_generales/generalidades/guardar_organismosYContactos";
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarOrganismoYContacto");
                    that.$emit("cerrarModalCrearOrganismoYContacto");
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente",
                        text: "Datos actualizados correctamente."
                    });
                    that.limpiarForm();
                })
                .catch(error => {
                    //Errores de validación
                    if (error.response.status === 422) {
                        that.errores.usuario =
                            error.response.data.errors.usuario != undefined
                                ? error.response.data.errors.activo
                                : "";

                        that.errores.cargo =
                            error.response.data.errors.cargo != undefined
                                ? error.response.data.errors.usuario
                                : "";
                        that.errores.organismo =
                            error.response.data.errors.organismo != undefined
                                ? error.response.data.errors.organismo
                                : "";
                    }
                    loader.hide();
                    that.$swal({
                        icon: "error",
                        title: "Existen errores",
                        text: error
                    });
                });
        }
    }
};
</script>
