<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Usuario Parentesco</h5>
      </center>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
               <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Usuario ingresado en parentesco</label>
                  <v-select
                    v-model="selectedUsuario"
                    :value="form.codigo_usuario"
                    :options="usuariosParentesco"
                    label="FULL_NAME_IDENTIFICACION"
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
                  <label for="usuario">Tipo Parentesco</label>
                  <v-select
                    v-model="selectedTipoParentesco"
                    :value="form.tipo_parentesco"
                    :options="tiposParentescos"
                    label="display"
                    @input="setSelectedTipoParentesco"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.tipo_parentesco !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.tipo_parentesco[0] }}</small>
                </div>
              </div>
              <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="form-group">
                  <label for="tipo">Usuario con el que tiene parentesco</label>
                  <v-select
                    v-model="selectedUsuarioParentesco"
                    :value="form.codigo_usuario_con_parentesco"
                    :options="usuarios"
                    label="FULL_NAME_IDENTIFICATION"
                    @input="setSelectedUsuarioParentesco"
                    v-bind:class="{ disabled: objetoMod!=null }"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.codigo_usuario_con_parentesco !== ''"
                    id="tipoHelp"
                    class="text-danger"
                  >{{ errores.codigo_usuario_con_parentesco[0] }}</small>
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
            <div class="row" >
              <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                <div class="form-inline">
                  <button
                    type="button"
                    class="btn btn-success btn-block"
                    @click="guardarActualizar()"
                  >{{objetoMod!=null?'Modificar':'Guardar'}}</button>
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
    usuariosParentesco:{
      type: Array
    },
    tiposParentescos: {
      type: Array
    }
  },
  data: function() {
    return {
      errores: {
        codigo: "",
        codigo_usuario: "",
        codigo_usuario_con_parentesco: "",
        observacion: "",
        tipo_parentesco: ""
      },
      form: {
        codigo: "",
        codigo_usuario: "",
        codigo_usuario_con_parentesco: "",
        observacion: "",
        tipo_parentesco: ""
      }, 
      selectedUsuario: "",
      selectedUsuarioParentesco:"",
      selectedTipoParentesco: ""
    };
  },
  mounted: function() {
    if (this.$props.objetoMod !== null) {
      let objeto = this.$props.objetoMod;
      this.form = objeto;
      this.form.codigo = objeto.codigo;
      this.form.codigo_usuario = objeto.codigo_usuario;
      this.form.codigo_usuario_con_parentesco = objeto.codigo_usuario_con_parentesco;
      this.form.tipo_identificacion = objeto.tipo_identificacion;
      this.form.observacion = objeto.observacion;
      this.form.tipo_parentesco = objeto.tipo_parentesco;
      this.selectedUsuario = objeto.full_name_identification_usuario;
      this.selectedUsuarioParentesco= objeto.full_name_identification_usuario_con_parentesco;
      this.selectedTipoParentesco = objeto.tipo_parentesco_name;
    }
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.usuarios_parentesco.crear_usuario_parentesco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .pacientes.usuarios_parentesco.crear_usuario_parentesco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    setSelectedTipoParentesco(value) {
      if (value !== null) {
        this.form.tipo_parentesco = value.value;
      } else {
        this.form.tipo_parentesco = "";
      }
    },
    setSelectedUsuario(value) {
    
      if (value !== null) {
        this.form.codigo_usuario = value.codigo;
      } else {
        this.form.codigo_usuario = "";
      }
    },
    setSelectedUsuarioParentesco(value) {
    
      if (value !== null) {
        this.form.codigo_usuario_con_parentesco = value.id;
      } else {
        this.form.codigo_usuario_con_parentesco = "";
      }
    },
    
    guardarActualizar: function() {
      let that = this;
      that.errores = {
        codigo: "",
        codigo_usuario: "",
        codigo_usuario_con_parentesco: "",
        observacion: "",
        tipo_parentesco: ""
      };

      let url = "";
      let mensaje = "";
      if (this.$props.objetoMod !== null) {
        url = "/gestion_hospitalaria/pacientes/modificar_usuario_parentesco";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/gestion_hospitalaria/pacientes/guardar_usuario_parentesco";
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

            that.errores.tipo_parentesco =
              error.response.data.errors.tipo_parentesco != undefined
                ? error.response.data.errors.tipo_parentesco
                : "";
            that.errores.codigo_usuario =
              error.response.data.errors.codigo_usuario != undefined
                ? error.response.data.errors.codigo_usuario
                : "";
            that.errores.codigo_usuario_con_parentesco =
              error.response.data.errors.codigo_usuario_con_parentesco != undefined
                ? error.response.data.errors.codigo_usuario_con_parentesco
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
