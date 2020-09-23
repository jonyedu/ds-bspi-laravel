<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">PARENTESCO</h5>
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
                  >{{ errores.nombre[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="apellido">Apellido</label>
                  <input
                    type="text"
                    :class="
                                            errores.apellido === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="apellido"
                    placeholder="Ingrese un apellido"
                    v-model="form.apellido"
                  />
                  <small
                    v-if="errores.apellido !== ''"
                    id="apellidoHelp"
                    class="text-danger"
                  >{{ errores.apellido[0] }}</small>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="identificacion">Identificación</label>
                  <input
                    type="text"
                    :class="
                                            errores.identificacion === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="identificacion"
                    placeholder="Ingrese la identificación"
                    :readonly="objetoMod !== null"
                    v-model="form.identificacion"
                  />
                  <small
                    v-if="errores.identificacion !== ''"
                    id="identificacionHelp"
                    class="text-danger"
                  >{{ errores.identificacion[0] }}</small>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="tipo">Tipo Identificación</label>
                  <v-select
                    v-model="selectedTipo"
                    :value="form.tipo_identificacion"
                    :options="tipos"
                    label="display"
                    @input="setSelected"
                    v-bind:class="{ disabled: objetoMod!=null }"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.tipo_identificacion !== ''"
                    id="tipoHelp"
                    class="text-danger"
                  >{{ errores.tipo_identificacion[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    type="text"
                    :class="'form-control'"
                    id="observacion"
                    placeholder="Ingrese su observación"
                    v-model="form.observacion"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizar()"
                  >{{objetoMod!==null?'Modificar':'Guardar'}}</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.disabled {
  pointer-events: none;
  color: #bfcbd9;
  cursor: not-allowed;
  background-image: none;
  background-color: #eef1f6;
  border-color: #d1dbe5;
}
</style>
<script>
export default {
  props: {
    objetoMod: {
      type: Object
    },
  },
  data: function() {
    return {
      errores: {
        nombre: "",
        apellido: "",
        identificacion: "",
        tipo_identificacion: "",
        observacion: ""
      },
      form: {
        codigo: "",
        nombre: "",
        apellido: "",
        identificacion: "",
        tipo_identificacion: "",
        observacion: ""
      },

      tipos: [
        {
          display: "CEDULA",
          value: "CE"
        },
        {
          display: "PASAPORTE",
          value: "PA"
        }
      ],
      selectedTipo: "CEDULA"
    };
  },
  mounted: function() {
    if (this.$props.objetoMod !== null) {
      let objeto = this.$props.objetoMod;
      this.form = objeto;
      this.form.codigo = objeto.codigo;
      this.form.nombre = objeto.nombre;
      this.form.apellido = objeto.apellido;
      this.form.identificacion = objeto.identificacion;
      this.form.tipo_identificacion = objeto.tipo_identificacion;
      this.form.observacion = objeto.observacion;
    }
    this.form.tipo_identificacion = "CE";
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.parentescos.crear_parentesco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.parentescos.crear_parentesco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    setSelected(value) {
      if (value !== null) {
        this.form.tipo_identificacion = value.value;
      } else {
        this.form.tipo_identificacion = "";
      }
    },
    guardarActualizar: function() {
      let that = this;
      that.errores = {
        nombre: "",
        apellido: "",
        identificacion: "",
        tipo_identificacion: "",
        observacion: ""
      };

      let url = "";
      let mensaje = "";

      if (this.$props.objetoMod !== null) {
        url = "/gestion_hospitalaria/pacientes/modificar_parentesco";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/pacientes/guardar_parentesco";
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
          let mensaje = error;
          if (error.response.status === 421) {
            mensaje = error.response.data.msg;
          }

          if (error.response.status === 422) {
            that.errores.nombre =
              error.response.data.errors.nombre != undefined
                ? error.response.data.errors.nombre
                : "";

            that.errores.apellido =
              error.response.data.errors.apellido != undefined
                ? error.response.data.errors.apellido
                : "";
            that.errores.identificacion =
              error.response.data.errors.identificacion != undefined
                ? error.response.data.errors.identificacion
                : "";
            that.errores.tipo_identificacion =
              error.response.data.errors.tipo_identificacion != undefined
                ? error.response.data.errors.tipo_identificacion
                : "";
          }
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existen errores",
            text: mensaje
          });
        });
    }
  }
};
</script>
