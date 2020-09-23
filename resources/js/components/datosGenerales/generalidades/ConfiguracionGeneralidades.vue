<template>
  <div class="row">
    <h1 class="mt-4">CONFIGURACIÓN GENERAL</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="cicloInicial">Ciclo Inicial</label>
                  <input
                    type="number"
                    :class="
                                            errores.ciclo_inicial === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="cicloInicial"
                    placeholder="Ingrese un ciclo inicial"
                    v-model="form.ciclo_inicial"
                  />
                  <small
                    v-if="errores.ciclo_inicial !== ''"
                    id="cicloInicialHelp"
                    class="text-danger"
                  >{{ errores.ciclo_inicial[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="cicloActivo">Ciclo Activo</label>
                  <input
                    type="number"
                    :class="
                                            errores.ciclo_activo === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="cicloActivo"
                    placeholder="Ingrese un ciclo activo"
                    v-model="form.ciclo_activo"
                  />
                  <small
                    v-if="errores.ciclo_activo !== ''"
                    id="cicloActivoHelp"
                    class="text-danger"
                  >{{ errores.ciclo_activo[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="cicloFinal">Ciclo Final</label>
                  <input
                    type="number"
                    :class="
                                            errores.ciclo_final === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="cicloFinal"
                    placeholder="Ingrese un ciclo final"
                    v-model="form.ciclo_final"
                  />
                  <small
                    v-if="errores.ciclo_final !== ''"
                    id="cicloFinalHelp"
                    class="text-danger"
                  >{{ errores.ciclo_final[0] }}</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="cedula">Administrador-Cédula</label>
                  <input
                    type="text"
                    :class="
                                            errores.cedula_administrador === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="cedula"
                    placeholder="Ingrese cédula de administrador"
                    v-model="form.cedula_administrador"
                  />
                  <small
                    v-if="
                                            errores.cedula_administrador !== ''
                                        "
                    id="cedulaHelp"
                    class="text-danger"
                  >
                    {{
                    errores.cedula_administrador[0]
                    }}
                  </small>
                </div>
              </div>
              <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="form-group">
                  <label for="email">Administrador-Email</label>
                  <input
                    type="email"
                    :class="
                                            errores.email_administrador === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="email"
                    placeholder="Ingrese email de administrador"
                    v-model="form.email_administrador"
                  />
                  <small
                    v-if="
                                            errores.email_administrador !== ''
                                        "
                    id="emailHelp"
                    class="text-danger"
                  >
                    {{
                    errores.email_administrador[0]
                    }}
                  </small>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="number"># Intentos Fallidos</label>
                  <input
                    type="number"
                    :class="
                                            errores.intento_fallido === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="number"
                    placeholder="# Intentos Fallidos"
                    v-model="form.intento_fallido"
                  />
                  <small
                    v-if="
                                            errores.intento_fallido !== ''
                                        "
                    id="emailHelp"
                    class="text-danger"
                  >
                    {{
                    errores.intento_fallido[0]
                    }}
                  </small>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="number"># Tiempo de Bloqueo(Min)</label>
                  <input
                    type="number"
                    :class="
                                            errores.tiempo_bloqueo === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="number"
                    placeholder="# Tiempo de Bloqueo"
                    v-model="form.tiempo_bloqueo"
                  />
                  <small
                    v-if="
                                            errores.tiempo_bloqueo !== ''
                                        "
                    id="emailHelp"
                    class="text-danger"
                  >
                    {{
                    errores.tiempo_bloqueo[0]
                    }}
                  </small>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                   <label for="number"># Meses Cambio de Contraseña</label>
                  <input
                    type="number"
                    :class="
                                            errores.meses_cambio_contrasena === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="number"
                    placeholder="# Meses Cambio de Contraseña"
                    v-model="form.meses_cambio_contrasena"
                  />
                  <small
                    v-if="
                                            errores.meses_cambio_contrasena !== ''
                                        "
                    id="emailHelp"
                    class="text-danger"
                  >
                    {{
                    errores.meses_cambio_contrasena[0]
                    }}
                  </small>
                </div>
              </div>
              <div style="width: 50%;margin: 0 auto;" class="col-lg-2 col-md-2 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizar()"
                  >Actualizar</button>
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
  data: function() {
    return {
      errores: {
        ciclo_inicial: "",
        ciclo_final: "",
        ciclo_activo: "",
        email_administrador: "",
        cedula_administrador: "",
        intento_fallido: "",
        tiempo_bloqueo: "",
        meses_cambio_contrasena: ""
      },
      form: {
        sistema: "",
        ciclo_inicial: "",
        ciclo_final: "",
        ciclo_activo: "",
        email_administrador: "",
        cedula_administrador: "",
        intento_fallido: "",
        tiempo_bloqueo: "",
        meses_cambio_contrasena: ""
      }
    };
  },
  mounted: function() {
    this.cargarConfiguraciones();
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .configuracion_generalidades.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .configuracion_generalidades.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },

  methods: {
    validarForm() {
      //validacion de ciclos
      let mensaje = "";
      let errores = false;
      if (this.form.ciclo_inicial > this.form.ciclo_final) {
        mensaje =
          mensaje + "El ciclo inicial debe ser menor que el ciclo final\n\n";
        errores = true;
      }
      if (
        this.form.ciclo_activo > this.form.ciclo_final ||
        this.form.ciclo_activo < this.form.ciclo_inicial
      ) {
        mensaje =
          mensaje +
          "El ciclo activo debe ser mayor que el ciclo inicial y menor que el ciclo final\n\n";
        errores = true;
      }
      if (this.form.intento_fallido < 0) {
        mensaje =
          mensaje +
          "El campo Intento Fallidos, no puede ser menor a 0\n\n";
        errores = true;
      }
      if (this.form.tiempo_bloqueo < 0) {
        mensaje =
          mensaje +
          "El campo Tiempo de Bloqueo, no puede ser menor a 0\n\n";
        errores = true;
      }
      if (this.form.intento_fallido > 0 && this.form.tiempo_bloqueo <= 0) {
        mensaje =
          mensaje +
          "El campo Tiempo de Bloqueo, debe tener un valor mayor a 0\n\n";
        errores = true;
      }
      if (this.form.tiempo_bloqueo > 0 && this.form.intento_fallido <= 0) {
        mensaje =
          mensaje +
          "El campo Intento Fallidos, debe tener un valor mayor a 0\n\n";
        errores = true;
      }
      if (this.form.tiempo_bloqueo > 0 && this.form.intento_fallido <= 0) {
        mensaje =
          mensaje +
          "El campo Intento Fallidos, debe tener un valor mayor a 0\n\n";
        errores = true;
      }
      if (this.form.meses_cambio_contrasena < 0) {
        mensaje =
          mensaje +
          "El campo Meses Cambio de Contraseña, debe tener un valor mayor a 0\n\n";
        errores = true;
      }
      if (this.form.meses_cambio_contrasena > 12) {
        mensaje =
          mensaje +
          "El campo Meses Cambio de Contraseña, debe tener un valor menor a 12\n\n";
        errores = true;
      }
      if (mensaje !== "")
        this.$swal({
          icon: "error",
          title: "Se poseen las siguientes validaciones",
          text: mensaje
        });

      return errores;
    },
    cargarConfiguraciones: function() {
      let that = this;
      let url = "/datos_generales/generalidades/cargar_configuracion";
      var loader = that.$loading.show();

      axios
        .get(url)
        .then(function(response) {
          that.form.sistema = response.data.configuracion.SISTEMA;
          that.form.ciclo_inicial = response.data.configuracion.CICLO_INICIAL;
          that.form.ciclo_final = response.data.configuracion.CICLO_FINAL;
          that.form.ciclo_activo = response.data.configuracion.CICLO_ACTIVO;
          that.form.email_administrador =
            response.data.configuracion.ADMIN_EMAIL;
          that.form.cedula_administrador =
            response.data.configuracion.ADMIN_NCED;
          that.form.intento_fallido = response.data.configuracion.INTENTO_FALLIDO;
          that.form.tiempo_bloqueo = response.data.configuracion.TIEMPO_BLOQUEO;  
          that.form.meses_cambio_contrasena = response.data.configuracion.TIEMPO_ACTUALIZACION_CLAVE; 
          loader.hide();
        })
        .catch(error => {
          //Errores
          loader.hide();
        });
    },
    guardarActualizar: function() {
      let that = this;
      that.errores = {
        ciclo_inicial: "",
        ciclo_final: "",
        ciclo_activo: "",
        email_administrador: "",
        cedula_administrador: "",
        intento_fallido: "",
        tiempo_bloqueo: "",
        meses_cambio_contrasena: ""
      };
      if (!this.validarForm()) {
        let url =
          "/datos_generales/generalidades/guardar_actualizar_configuracion";
        var loader = that.$loading.show();
        axios
          .post(url, this.form)
          .then(function(response) {
            loader.hide();
            that.$swal({
              icon: "success",
              title: "Proceso realizado exitosamente",
              text: "Datos actualizados correctamente."
            });
          })
          .catch(error => {
            //Errores de validación
            if (error.response.status === 422) {
              that.errores.ciclo_inicial =
                error.response.data.errors.ciclo_inicial != undefined
                  ? error.response.data.errors.ciclo_inicial
                  : "";
              that.errores.ciclo_final =
                error.response.data.errors.ciclo_final != undefined
                  ? error.response.data.errors.ciclo_final
                  : "";
              that.errores.ciclo_activo =
                error.response.data.errors.ciclo_activo != undefined
                  ? error.response.data.errors.ciclo_activo
                  : "";
              that.errores.email_administrador =
                error.response.data.errors.email_administrador != undefined
                  ? error.response.data.errors.email_administrador
                  : "";
              that.errores.cedula_administrador =
                error.response.data.errors.cedula_administrador != undefined
                  ? error.response.data.errors.cedula_administrador
                  : "";
              that.errores.intento_fallido =
                error.response.data.errors.intento_fallido != undefined
                  ? error.response.data.errors.intento_fallido
                  : "";  
              that.errores.tiempo_bloqueo =
                error.response.data.errors.tiempo_bloqueo != undefined
                  ? error.response.data.errors.tiempo_bloqueo
                  : "";     
              that.errores.meses_cambio_contrasena =
                error.response.data.errors.meses_cambio_contrasena != undefined
                  ? error.response.data.errors.meses_cambio_contrasena
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
  }
};
</script>
