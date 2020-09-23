<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">LUGAR DE TRABAJO USUARIO</h5>
      </center>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              
              <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <v-select
                    v-model="selectedUsuario"
                    :value="form.codigo_usuario"
                    :options="usuarios"
                    label="FULL_NAME_IDENTIFICATION"
                    @input="setSelectedUsuario"
                    v-bind:class="{ disabled: objetoMod!=null }"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.codigo_usuario !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.codigo_usuario[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Lugares De Trabajo</label>
                  <v-select
                    v-model="selectedLugarDeTrabajo"
                    :value="form.codigo_aseguradora"
                    :options="lugaresDeTrabajo"
                    label="nombre"
                    @input="setSelectedLugarDeTrabajo"
                    v-bind:class="{ disabled: objetoMod!=null }"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.codigo_aseguradora !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.codigo_aseguradora[0] }}</small>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
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
            <div class="row" >
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizar()"
                  >{{this.objetoMod!=null?'Actualizar':'Guardar'}}</button>
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
    usuarios: {
      type: Array
    },
    aseguradoras: {
      type: Array
    },
    lugaresDeTrabajo:{
        type:Array
    }
  },
  data: function() {
    return {
      errores: {
        codigo: "",
        codigo_aseguradora: "",
        codigo_usuario: "",
        observacion: ""
      },
      form: {
        codigo: "",
        codigo_lugar_de_trabajo: "",
        codigo_usuario: "",
        observacion: ""
      },

      selectedTipo: "CEDULA",
      selectedUsuario: "",
      selectedLugarDeTrabajo: ""
    };
  },
  mounted: function() {
    if (this.$props.objetoMod !== null) {
      let objeto = this.$props.objetoMod;
      this.form = objeto;
      this.form.codigo = objeto.codigo;
      this.form.codigo_lugar_de_trabajo = objeto.codigo_lugar_de_trabajo;
      this.form.codigo_usuario = objeto.codigo_usuario;
      this.selectedUsuario = objeto.nombre_usuario;
      this.selectedLugarDeTrabajo = objeto.nombre_lugar_de_trabajo;
    }
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.lugares_de_trabajo_usuario.crear_lugar_de_trabajo_usuario.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
     let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.lugares_de_trabajo_usuario.crear_lugar_de_trabajo_usuario.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    setSelectedLugarDeTrabajo(value) {
      if (value !== null) {
        this.form.codigo_lugar_de_trabajo = value.codigo;
      } else {
        this.form.codigo_lugar_de_trabajo = "";
      }
    },
    setSelectedUsuario(value) {
    
      if (value !== null) {
        this.form.codigo_usuario = value.id;
      } else {
        this.form.codigo_usuario = "";
      }
    },
    
    guardarActualizar: function() {
      let that = this;
      that.errores = {
        codigo: "",
        codigo_lugar_de_trabajo: "",
        codigo_usuario: "",
        observacion: ""
      };

      let url = "";
      let mensaje = "";

      if (this.$props.objetoMod !== null) {
        url = "/gestion_hospitalaria/pacientes/modificar_lugar_de_trabajo_usuario";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/pacientes/guardar_lugar_de_trabajo_usuario";
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
         
            that.errores.codigo_lugar_de_trabajo =
              error.response.data.errors.codigo_lugar_de_trabajo != undefined
                ? error.response.data.errors.codigo_lugar_de_trabajo
                : "";
            that.errores.codigo_usuario =
              error.response.data.errors.codigo_usuario != undefined
                ? error.response.data.errors.codigo_usuario
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
