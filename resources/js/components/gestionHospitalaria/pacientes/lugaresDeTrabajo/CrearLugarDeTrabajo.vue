<template>
    <div class="row m-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-4">LUGAR DE TRABAJO</h5>
            </center>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-md-12 col-sm-12 p-5">
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input
                                        type="text"
                                        :readonly="objetoMod !== null"
                                        :class="
                                            errores.nombre === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="cicloInicial"
                                        placeholder="Ingrese un nombre"
                                        v-model="form.nombre"
                                    />
                                    <small
                                        v-if="errores.nombre !== ''"
                                        id="nombreHelp"
                                        class="text-danger"
                                        >{{ errores.nombre[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                 <div class="form-group">
                                    <label for="nombre">Nombre Contacto</label>
                                    <input
                                        type="text"
                                        :class="
                                            errores.nombre_contacto === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="cicloInicial"
                                        placeholder="Ingrese un nombre de contacto"
                                        v-model="form.nombre_contacto"
                                    />
                                    <small
                                        v-if="errores.nombre_contacto !== ''"
                                        id="nombreHelp"
                                        class="text-danger"
                                        >{{ errores.nombre_contacto[0] }}</small
                                    >
                                </div>
                            </div>
                               
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="telefono_contacto">Telefono Contacto</label>
                                    <input
                                        type="text"
                                        :class="
                                            errores.telefono_contacto === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="telefono_contacto"
                                        placeholder="Ingrese un telefono de contacto"
                                        v-model="form.telefono_contacto"
                                    />
                                    <small
                                        v-if="errores.telefono_contacto !== ''"
                                        id="telefonoContactoHelp"
                                        class="text-danger"
                                        >{{ errores.telefono_contacto[0] }}</small
                                    >
                                </div>
                            </div>
                             <div class="col-lg-4 col-md-4 col-sm-12">
                                 <div class="form-group">
                                    <label for="email_contacto">Email Contacto</label>
                                    <input
                                        type="email"
                                        :class="
                                            errores.email_contacto === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="email_contacto"
                                        placeholder="Ingrese un email de contacto"
                                        v-model="form.email_contacto"
                                    />
                                    <small
                                        v-if="errores.email_contacto !== ''"
                                        id="emailContactoHelp"
                                        class="text-danger"
                                        >{{ errores.email_contacto[0] }}</small
                                    >
                                </div>
                             </div>
                            
                           
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="tipo">Tipo</label>
                                    <v-select
                                        v-model="selectedTipo"
                                        :value="form.tipo"
                                        :options="tipos"
                                        label="display"
                                        @input="setSelected"
                                    >
                                        <template slot="no-options"
                                            >No se ha encontrado ningun
                                            dato</template
                                        >
                                    </v-select>
                                    <small
                                        v-if="errores.tipo !== ''"
                                        id="tipoHelp"
                                        class="text-danger"
                                        >{{ errores.tipo[0] }}</small
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
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="web_page">Página Web</label>
                                    <input
                                        type="text"
                                        :class="
                                            errores.web_page === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="web_page"
                                        placeholder="Ingrese su observación"
                                        v-model="form.web_page"
                                    />
                                    <small
                                        v-if="errores.web_page !== ''"
                                        id="web_pageHelp"
                                        class="text-danger"
                                        >{{ errores.web_page[0] }}</small
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
                                            objetoMod === null
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
        objetoMod: {
            type: Object
        }
    },
    data: function() {
        return {
            errores: {
                nombre: "",
                nombre_contacto : "",
                telefono_contacto : "",
                email_contacto:"",
                web_page:"",
                tipo: "",
                observacion: ""
            },
            form: {
                codigo: "",
                nombre: "",
                nombre_contacto : "",
                telefono_contacto : "",
                email_contacto:"",
                web_page:"",
                tipo: "",
                observacion: ""
            },
            tipos: [
                {
                    display:"PUBLICO",
                    value: "PU"
                },
                {
                    display:"PRIVADO",
                    value: "PR"
                }
            ],
            selectedTipo: "Publico"
        };
    },
    mounted: function() {
        if (this.$props.objetoMod !== null) {
            let objeto = this.$props.objetoMod;
            this.form=objeto;
            this.selectedTipo=objeto.LUGARTRABAJO_TIPO_NOM;
            
        }
        this.form.tipo = "PU";
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .pacientes.lugares_de_trabajo.crear_lugar_de_trabajo
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
       let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
       let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .pacientes.lugares_de_trabajo.crear_lugar_de_trabajo
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        setSelected(value) {
            if (value !== null) {
                this.form.tipo = value.value;
            } else {
                this.form.tipo = "";
            }
        },
        guardarActualizar: function() {
            let that = this;
            that.errores = {
                nombre: "",
                nombre_contacto : "",
                telefono_contacto : "",
                email_contacto:"",
                web_page:"",
                tipo: "",
                observacion: ""
            };

            let url = "";
            let mensaje = "";
            if (this.$props.objetoMod !== null) {
                url = "/gestion_hospitalaria/pacientes/modificar_lugar_de_trabajo";
                mensaje = "Datos actualizados correctamente.";
            } else {
                url = "/gestion_hospitalaria/pacientes/guardar_lugar_de_trabajo";
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarDatos");
                    that.$emit("cerrarModalCrear");
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente",
                        text: "Datos actualizados correctamente."
                    });
                })
                .catch(error => {
                    //Errores de validación
                    if (error.response.status === 422) {
                        that.errores.nombre =
                            error.response.data.errors.nombre != undefined
                                ? error.response.data.errors.nombre
                                : "";

                        that.errores.nombre_contacto =
                            error.response.data.errors.nombre_contacto != undefined
                                ? error.response.data.errors.nombre_contacto
                                : "";
                        that.errores.telefono_contacto =
                            error.response.data.errors.telefono_contacto != undefined
                                ? error.response.data.errors.telefono_contacto
                                : "";
                        that.errores.email_contacto =
                            error.response.data.errors.email_contacto != undefined
                                ? error.response.data.errors.email_contacto
                                : "";
                        that.errores.web_page =
                            error.response.data.errors.web_page != undefined
                                ? error.response.data.errors.web_page
                                : "";    
                        that.errores.tipo =
                            error.response.data.errors.tipo != undefined
                                ? error.response.data.errors.tipo
                                : "";    
                        that.errores.observacion =
                            error.response.data.errors.observacion != undefined
                                ? error.response.data.errors.observacion
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
