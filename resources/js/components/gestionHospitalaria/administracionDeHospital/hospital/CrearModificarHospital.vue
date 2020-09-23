<template>
    <div class="row m-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-4">HOSPITALES</h5>
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
                                        :readonly="hospitalMod !== null"
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
                                    <label for="contacto">Contacto</label>
                                    <input
                                        type="text"
                                        :class="
                                            errores.contacto === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="contacto"
                                        placeholder="Ingrese el contacto"
                                        v-model="form.contacto"
                                    />
                                    <small
                                        v-if="errores.contacto !== ''"
                                        id="contactoHelp"
                                        class="text-danger"
                                        >{{ errores.contacto[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="telefono"
                                        >Telefono De Contacto</label
                                    >
                                    <input
                                        type="text"
                                        :class="
                                            errores.telf_contacto === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="telefono"
                                        placeholder="Ingrese El Telefono Del Contacto"
                                        v-model="form.telf_contacto"
                                    />
                                    <small
                                        v-if="errores.telf_contacto !== ''"
                                        id="telefonoHelp"
                                        class="text-danger"
                                        >{{ errores.telf_contacto[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="correo"
                                        >Correo Del Contacto</label
                                    >
                                    <input
                                        type="text"
                                        :class="
                                            errores.email_contacto === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="observacion"
                                        placeholder="Ingrese El Correo Del Contacto"
                                        v-model="form.email_contacto"
                                    />
                                    <small
                                        v-if="errores.email_contacto !== ''"
                                        id="correoHelp"
                                        class="text-danger"
                                        >{{ errores.email_contacto[0] }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="webpage">Pagina Web</label>
                                    <input
                                        type="text"
                                        :class="
                                            errores.webpage === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                                        id="webpage"
                                        placeholder="Ingrese Pagina Web Del Hospital"
                                        v-model="form.webpage"
                                    />
                                    <small
                                        v-if="errores.webpage !== ''"
                                        id="webpageHelp"
                                        class="text-danger"
                                        >{{ errores.webpage[0] }}</small
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
                        <!-- Permitir la imagen -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div
                                class="row"
                                style="border: 1px solid black;display:block;margin:auto;height: 150px; width: 300px;"
                            >
                                <!-- Seccion para la imagen guardada en base -->
                                <div v-if="this.$props.hospitalMod !== null">
                                    <img
                                        style="display:block;margin:auto;height: 130px; width: 280px;"
                                        v-if="form.logo == ''"
                                        :src="
                                            this.$props.hospitalMod
                                                .HOSPITAL_LOGO
                                        "
                                        alt
                                        srcset
                                    />
                                    <img
                                        style="display:block;margin:auto;height: 130px; width: 280px;"
                                        class="w-50"
                                        v-if="form.logo != ''"
                                        :src="form.fotoURL"
                                        alt
                                        srcset
                                    />
                                </div>
                                <!-- Seccion para la imagen nueva que se vaya a guardar -->
                                <div v-if="this.$props.hospitalMod === null">
                                    <img
                                        style="display:block;margin:auto;height: 130px; width: 280px;"
                                        class="w-50"
                                        v-if="
                                            form.logo == '' || form.logo == null
                                        "
                                        src
                                        alt
                                        srcset
                                    />
                                    <img
                                        style="display:block;margin:auto;height: 130px; width: 280px;"
                                        class="w-50"
                                        v-if="
                                            form.logo != '' || form.logo != null
                                        "
                                        :src="form.fotoURL"
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
                                    <i class="fas fa-image"></i>Cargar Foto del
                                    Hospital
                                </button>
                            </div>
                        </div>
                        <!-- Fin la imagen -->
                        <div class="row">
                            <div
                                class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1"
                            >
                                <div class="form-inline">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block"
                                        @click="guardarModificarArchivo()"
                                    >
                                        {{
                                            hospitalMod === null
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
        hospitalMod: {
            type: Object
        }
    },
    data: function() {
        return {
            errores: {
                nombre: "",
                contacto: "",
                telf_contacto: "",
                email_contacto: "",
                webpage: "",
                activo: "",
                observacion: "",
                logo: "",
                fotoURL: ""
            },
            form: {
                hospital_cod: "",
                nombre: "",
                contacto: "",
                telf_contacto: "",
                email_contacto: "",
                webpage: "",
                activo: "",
                observacion: "",
                logo: "",
                fotoURL: "",
                nuevaURL: ""
            },
            activos: [
                {
                    id_tipo: "A"
                },
                {
                    id_tipo: "I"
                }
            ],
            selectedActivo: "A"
        };
    },
    mounted: function() {
        this.form.activo = "A";
        if (this.$props.hospitalMod !== null) {
            var hospital = this.$props.hospitalMod;
            this.form.hospital_cod = hospital.HOSPITAL_COD;
            this.form.nombre = hospital.HOSPITAL_NOM;
            this.form.contacto = hospital.HOSPITAL_NOM_CONTACTO;
            this.form.telf_contacto = hospital.HOSPITAL_TELF_CONTACTO;
            this.form.email_contacto = hospital.HOSPITAL_EMAIL_CONTACTO;
            this.form.webpage = hospital.HOSPITAL_WEB_PAGE;
            this.form.activo = hospital.HOSPITAL_LOGIC_ESTADO;
            this.form.observacion = hospital.HOSPITAL_OBS;
            //this.form.fotoUrl = hospital.HOSPITAL_LOGO;
            this.selectedActivo = hospital.HOSPITAL_LOGIC_ESTADO;
        }
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .administracion_de_hospital.hospital.crear_modificar_hospital
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
            .administracion_de_hospital.hospital.crear_modificar_hospital
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        limpiarForm() {
            this.errores = {
                nombre: "",
                contacto: "",
                telf_contacto: "",
                email_contacto: "",
                webpage: "",
                activo: "",
                observacion: "",
                logo: "",
                fotoURL: ""
            };
            this.form = {
                nombre: "",
                contacto: "",
                telf_contacto: "",
                email_contacto: "",
                webpage: "",
                activo: "",
                observacion: "",
                logo: "",
                fotoURL: "",
                nuevaURL: ""
            };
            this.selectedActivo = "A";
        },
        setSelected(value) {
            if (value !== null) {
                this.form.activo = value.id_tipo;
            } else {
                this.form.activo = "";
            }
        },
        guardarModificarArchivo() {
            if (this.form.fotoURL == null || this.form.fotoURL == "") {
                this.$swal({
                    icon: "error",
                    title: "Existen errores",
                    text: "Se necesita un logo para el hospital"
                });
            } else {
                let that = this;
                let file = that.form.logo;
                let formData = new FormData();
                formData.append("logo", file);
                const config = {
                    headers: { "content-type": "multipart/form-data" }
                };
                var loader = that.$loading.show();
                axios
                    .post(
                        "/gestion_hospitalaria/hospitales/guardarModificarArchivo",
                        formData,
                        config
                    )
                    .then(function(response) {
                        loader.hide();
                        that.guardarActualizar(response.data.pathFoto);
                    })
                    .catch(error => {
                        if (!error.response) {
                            this.errorStatus = "Error: Network Error";
                        } else {
                            this.errorStatus = error.response.data.message;
                        }
                        loader.hide();
                    });
            }
        },
        guardarActualizar: function(pathFoto) {
            //alert(pathFoto);
            let foto;
            let that = this;
            let formNew = {
                hospital_cod: that.form.hospital_cod,
                nombre: that.form.nombre,
                contacto: that.form.contacto,
                telf_contacto: that.form.telf_contacto,
                email_contacto: that.form.email_contacto,
                webpage: that.form.webpage,
                activo: that.form.activo,
                observacion: that.form.observacion,
                logo: that.form.logo,
                fotoURL: that.form.fotoURL,
                nuevaURL: pathFoto
            };
            //alert(formNew.nuevaURL);
            that.errores = {
                nombre: "",
                contacto: "",
                telf_contacto: "",
                email_contacto: "",
                webpage: "",
                activo: "",
                observacion: ""
            };
            let url = "";
            let mensaje = "";
            if (this.$props.hospitalMod !== null) {
                url = "/gestion_hospitalaria/hospitales/modificar_hospitales";
                mensaje = "Datos actualizados correctamente.";
            } else {
                url = "/gestion_hospitalaria/hospitales/guardar_hospitales";
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, formNew)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarHospitales");
                    that.$emit("cerrarModalCrearHospital");
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
                        that.errores.nombre =
                            error.response.data.errors.nombre != undefined
                                ? error.response.data.errors.nombre
                                : "";
                        that.errores.activo =
                            error.response.data.errors.activo != undefined
                                ? error.response.data.errors.activo
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
        },
        onFileSelected(event) {
            if (
                event.target.files[0]["type"] === "image/jpeg" ||
                event.target.files[0]["type"] === "image/png" ||
                event.target.files[0]["type"] === "image/jpg"
            ) {
                this.form.logo = event.target.files[0];
                this.form.fotoURL = URL.createObjectURL(this.form.logo);
            } else {
                this.$swal({
                    icon: "error",
                    title: "Error de Archivo",
                    text:
                        "Solo imagenes de formato: .jpeg, .jpg, .png son permitidos!"
                });
            }
        }
    }
};
</script>
