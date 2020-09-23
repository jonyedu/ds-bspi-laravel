<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">ORGANISMOS</h5>
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
                    :readonly="organismoMod !== null"
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
                  <label for="tipo_organismo">Tipo De Organismo</label>
                  <v-select
                    v-model="selectedTipoOrganismo"
                    :value="form.tipo_organismo"
                    :options="tiposOrganismo"
                    label="TIPOORG_NOM"
                    @input="setSelectedTipoOrganismo"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.tipo_organismo !== ''"
                    id="tipo_organismoHelp"
                    class="text-danger"
                  >{{ errores.tipo_organismo[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="pais">País</label>
                  <v-select
                    v-model="selectedPais"
                    :value="form.pais"
                    :options="paises"
                    label="PAIS_NOM"
                    @input="setSelectedPais"
                    @search="cargarPaises"
                  >
                    <template slot="no-options">
                      Escriba el nombre de un
                      país
                    </template>
                  </v-select>
                  <small
                    v-if="errores.pais !== ''"
                    id="paisHelp"
                    class="text-danger"
                  >{{ errores.pais[0] }}</small>
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
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato
                    </template>
                  </v-select>
                  <small
                    v-if="errores.activo !== ''"
                    id="activoHelp"
                    class="text-danger"
                  >{{ errores.activo[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="direccion">Dirección</label>
                  <input
                    type="text"
                    :class="
                                            errores.direccion === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="direccion"
                    placeholder="Ingrese su dirección"
                    v-model="form.direccion"
                  />
                  <small
                    v-if="errores.direccion !== ''"
                    id="direccionHelp"
                    class="text-danger"
                  >{{ errores.direccion[0] }}</small>
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
                  >{{ errores.observacion[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="telefono">Telefono</label>
                  <input
                    type="text"
                    :class="
                                            errores.telefono === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="telefono"
                    placeholder="Ingrese su telefono"
                    v-model="form.telefono"
                  />
                  <small
                    v-if="errores.telefono !== ''"
                    id="telefonoHelp"
                    class="text-danger"
                  >{{ errores.telefono[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="celular">Celular</label>
                  <input
                    type="text"
                    :class="
                                            errores.celular === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="celular"
                    placeholder="Ingrese su celular"
                    v-model="form.celular"
                  />
                  <small
                    v-if="errores.celular !== ''"
                    id="celularHelp"
                    class="text-danger"
                  >{{ errores.celular[0] }}</small>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input
                    type="text"
                    :class="
                                            errores.email === ''
                                                ? 'form-control'
                                                : 'form-control is-invalid'
                                        "
                    id="email"
                    placeholder="Ingrese su email"
                    v-model="form.email"
                  />
                  <small
                    v-if="errores.email !== ''"
                    id="observacionHelp"
                    class="text-danger"
                  >{{ errores.email[0] }}</small>
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
                  >
                    {{
                    organismoMod === null
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
    organismoMod: {
      type: Object
    }
  },
  data: function() {
    return {
      errores: {
        nombre: "",
        pais: "",
        tipo_organismo: "",
        email: "",
        celular: "",
        telefono: "",
        activo: "",
        observacion: "",
        direccion: ""
      },
      form: {
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
      },
      activos: [
        {
          id_tipo: "S"
        },
        {
          id_tipo: "N"
        }
      ],
      selectedActivo: "S",
      selectedPais: "",
      selectedTipoOrganismo: "",
      paises: [],
      tiposOrganismo: []
    };
  },
  mounted: function() {
    this.cargarTiposOrganismos();
    this.form.activo = "S";
    if (this.$props.organismoMod !== null) {
      var organismo = this.$props.organismoMod;

      this.form.organismo_cod = organismo.ORG_COD;
      this.form.nombre = organismo.ORG_NOM;
      this.form.pais = organismo.PAIS_COD;
      this.form.tipo_organismo = organismo.TIPOORG_COD;
      this.form.email = organismo.ORG_EMAIL;
      this.form.celular = organismo.ORG_CEL;
      this.form.telefono = organismo.ORG_TELF;
      this.form.activo = organismo.ORG_ACTIVO;
      this.form.observacion = organismo.ORG_OBS;
      this.form.direccion = organismo.ORG_DIR;
      this.selectedActivo = organismo.ORG_ACTIVO;
      this.selectedPais = organismo.PAIS_NOM;
      this.selectedTipoOrganismo = organismo.TIPOORG_NOM;
    }
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organismos_vinculantes_con_la_bspi.crear_organismo_vinculante_con_la_bspi
      .nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organismos_vinculantes_con_la_bspi.crear_organismo_vinculante_con_la_bspi
      .nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    cargarTiposOrganismos() {
      let that = this;
      var loader = that.$loading.show();
      let url =
        "/datos_generales/generalidades/cargar_tiposdeorganismos_combo_box";
      axios
        .get(url)
        .then(function(response) {
          let tiposOrganismo = [];
          tiposOrganismo = response.data.tipos;
          that.tiposOrganismo = tiposOrganismo;
          loader.hide();
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
    cargarPaises() {
      let that = this;
      let url = "/datos_generales/generalidades/cargar_paises";
      axios
        .get(url)
        .then(function(response) {
          let paises = [];
          paises = response.data.paises;

          that.paises = paises;
        })
        .catch(error => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    },
    limpiarForm() {
      this.errores = {
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
      this.selectedPais = "";
      this.selectedTipoOrganismo = "";
    },
    setSelectedTipoOrganismo(value) {
      if (value !== null) {
        this.form.tipo_organismo = value.TIPOORG_COD;
      } else {
        this.form.tipo_organismo = "";
      }
    },
    setSelectedPais(value) {
      if (value !== null) {
        this.form.pais = value.PAIS_COD;
      } else {
        this.form.pais = "";
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
        email: "",
        celular: "",
        telefono: "",
        activo: "",
        observacion: "",
        direccion: ""
      };
      let url = "";
      let mensaje = "";

      if (this.$props.organismoMod !== null) {
        url = "/datos_generales/generalidades/modificar_organismos";
        mensaje = "Datos actualizados correctamente.";
      } else {
        url = "/datos_generales/generalidades/guardar_organismos";
        mensaje = "Datos guardados correctamente.";
      }
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("recargarOrganismo");
          that.$emit("cerrarModalCrearOrganismo");
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

            that.errores.pais =
              error.response.data.errors.pais != undefined
                ? error.response.data.errors.pais
                : "";
            that.errores.tipo_organismo =
              error.response.data.errors.tipo_organismo != undefined
                ? error.response.data.errors.tipo_organismo
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
