<template>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <div class="text-left mt-3 col-md-5">
                    <div class="card card-warning">
                        <div
                            class="card-header"
                            style="background-color:#C2C2C2;color:#000000;"
                        >
                            <h5 class="card-title">
                                Actualización de Contraseña
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Usuario -->
                        <div class="form-group">
                            <label for>Usuario</label>
                            <div class="input-group mb-3">
                                <input
                                    class="form-control"
                                    v-model="form.identificacionInput"
                                    type="text"
                                    placeholder="Ingresar cedula del usuario..."
                                    :readonly="form.identificacionInput != ''"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user-circle"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contraseña -->
                        <div class="form-group">
                            <label
                                ><span class="text-danger">(*)</span>
                                Contraseña</label
                            >
                            <div class="input-group mb-3">
                                <input
                                    id="password"
                                    type="password"
                                    :class="
                                        error.password === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    v-model="form.password"
                                    placeholder="Contraseña"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <a @click="mostrarContrasena(1)"
                                            ><i id="fast" class="fas fa-eye"></i
                                        ></a>
                                    </div>
                                </div>
                            </div>
                            <small
                                v-if="error.password !== ''"
                                id="passwordHelp"
                                class="text-danger"
                                >{{ error.password[0] }}</small
                            >
                        </div>
                        <!-- Confirmar Contraseña -->
                        <div class="form-group">
                            <label
                                ><span class="text-danger">(*)</span> Confirmar
                                Contraseña</label
                            >
                            <div class="input-group mb-3">
                                <input
                                    id="password-confirm"
                                    type="password"
                                    :class="
                                        error.password_confirmation === ''
                                            ? 'form-control'
                                            : 'form-control is-invalid'
                                    "
                                    v-model="form.password_confirmation"
                                    placeholder="Confirmar Contraseña"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <a @click="mostrarContrasena(0)"
                                            ><i
                                                id="fastCon"
                                                style="color:#505050"
                                                class="fas fa-eye"
                                            ></i
                                        ></a>
                                    </div>
                                </div>
                            </div>
                            <small
                                v-if="error.password_confirmation !== ''"
                                id="passwordConfirmationHelp"
                                class="text-danger"
                                >{{ error.password_confirmation[0] }}</small
                            >
                        </div>
                        <!-- Boton actualizarContraseña -->
                        <div class="row">
                            <div
                                class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1"
                            >
                                <div class="form-inline">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block"
                                        @click="actualizarContraseña()"
                                    >
                                        Actualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
            <div
                style="position:absolute; top:0; left:69%;"
                class="text-left col-lg-4 col-md-4 col-sm-12"
            >
                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >
                    <strong
                        >La contraseña debe cumplir con los siguientes
                        puntos:</strong
                    >
                    <br />
                    <span>*Minimo 8 y Maximo 12 Caracteres</span>
                    <br />
                    <span>*Caracteres en mayúscula (A - Z)</span>
                    <br />
                    <span>*Caracteres en minúscula (a - z)</span>
                    <br />
                    <span>*Base 10 dígitos (0 - 9)</span>
                    <br />
                    <span>*Caracteres especiales (-@$!%*#?&)</span>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.form.id = this.$route.query.id;
        this.form.identificacionInput = this.$route.query.fullIdentificacion;
        this.form.usCod = this.$route.query.usCod;
    },
    data: function() {
        return {
            mostrar_contrasena: 0,
            form: {
                identificacionInput: "",
                password: "",
                password_confirmation: "",
                usCod: "",
                id: 0
            },
            error: {
                identificacionInput: "",
                password: "",
                password_confirmation: ""
            }
        };
    },
    methods: {
        actualizarContraseña() {
            let that = this;
            let url = "/datos_generales/usuarios/modificar_clave_usuario";
            var loader = that.$loading.show();
            this.error = {
                identificacionInput: "",
                password: "",
                password_confirmation: ""
            };
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    if (response.data.msg == "OK") {
                        that.$swal({
                            icon: "success",
                            title: "Proceso realizado exitosamente",
                            text: "Datos actualizados correctamente."
                        });
                    }
                    loader.hide();
                    that.cerrarSession();
                })
                .catch(error => {
                    //Errores de validación
                    if (error.response.status === 421) {
                        that.$swal({
                            icon: "error",
                            title: "Existe un error",
                            text: "error.response.data.msg"
                        });
                        loader.hide();
                    } else if (error.response.status === 422) {
                        loader.hide();
                        if (error.response.data.errors.password != null) {
                            that.error.password =
                                error.response.data.errors.password;
                        }
                        if (
                            error.response.data.errors.password_confirmation !=
                            null
                        ) {
                            that.error.password_confirmation =
                                error.response.data.errors.password_confirmation;
                        }
                        that.$swal({
                            icon: "error",
                            title: "Existen errores",
                            text: "Errores de Validación"
                        });
                    } else {
                        loader.hide();
                        that.$swal({
                            icon: "error",
                            title: "Existen errores",
                            text: error
                        });
                    }
                });
        },
        cerrarSession() {
            let that = this;
            var loader = that.$loading.show();
            let url = "/logout";
            axios
                .post(url)
                .then(function(response) {
                    loader.hide();
                    location.href = "/";
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
        mostrarContrasena(opc) {
            if (opc) {
                var tipo = document.getElementById("password");
                if (tipo.type == "password") {
                    tipo.type = "text";
                    this.mostrar_contrasena = 0;
                } else {
                    tipo.type = "password";
                    this.mostrar_contrasena = 1;
                }
            } else {
                var tipo1 = document.getElementById("password-confirm");
                var fastCon = document.getElementById("fastCon");
                if (tipo1.type == "password") {
                    tipo1.type = "text";
                    fastCon.class = "fa fa-eye-slash";
                } else {
                    tipo1.type = "password";
                    fastCon.class = "fas fa-eye";
                }
            }
        }
    }
};
</script>
