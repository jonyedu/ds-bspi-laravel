<template>
  <div class="row">
    <h1 class="mt-4">Jornadas</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="cargo">Personal Médico</label>
                <v-select
                  v-model="personalMod"
                  :value="form.TRABAJADORESPERSONALSALUD_COD"
                  :options="personalMedico"
                  label="display"
                  @input="setSelectedPersonalMedico"
                >
                  <template slot="no-options">
                    No se ha encontrado ningun
                    dato
                  </template>
                </v-select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="float-right">
                <button
                  v-if="jornadas.length!=0"
                  class="btn btn-primary"
                  @click="nuevaJornada()"
                >Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                v-if="jornadas.length!=0"
                :anular-button="true"
                :modificar-button="false"
                :columns-data="columns"
                :rows-data="jornadas"
                @handleModificarClick="modificarJornada"
                @handleAnularClick="anularJornadaConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearJornada">
      <crear-Jornada
        :personal-mod="personalMod"
        :jornada-mod="jornadaMod"
        :personalMedico="personalMedico"
        @recargarJornadas="cargarJornadas"
        @cerrarModalCrearJornada="cerrarModalCrearJornada"
        ref="crearJornada"
      ></crear-Jornada>
    </modal>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      personalMod: null,
      jornadaMod: null,
      errores: {},
      form: {
        jornada_cod: "",
      },
      personal_cod: "",
      personalMedico: [],
      jornadas: [],

      columns: [
        {
          label: "Inicio de Jornada",
          field: "JORNADATRABAJADOR_INICIO",
          type: "String",
        },
        {
          label: "Fin de Jornada",
          field: "JORNADATRABAJADOR_FIN",
          type: "String",
        },
        {
          label: "Dias Aplicados",
          field: "JORNADATRABAJADOR_DIAS",
          type: "String",
        },
        {
          label: "Observaciones",
          field: "JORNADATRABAJADOR_OBS",
          type: "String",
        },
      ],
    };
  },
  mounted: function () {
    this.cargarTrabajadoresSalud();
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.jornadas.jornadas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function () {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.jornadas.jornadas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    setSelectedPersonalMedico(value) {
      if (value !== null) {
        this.form.personal_cod = value.TRABAJADORESPERSONALSALUD_COD;
        this.cargarJornadas();
      } else {
        this.form.personal_cod = "";
      }
    },
    modificarJornada(value) {
      this.jornadaMod = value;
      this.abrirModalCrearJornada();
    },
    anularJornadaConfirmacion(value) {
      this.form.jornada_cod = value.JORNADATRABAJADOR_COD;

      let that = this;
      this.$swal({
        title: "¿Desea anular el elemento seleccionado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          that.anularJornada();
        }
      });
    },
    anularJornada() {
      let that = this;
      let url = "/gestion_hospitalaria/jornadas/eliminar_jornadas";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function (response) {
          loader.hide();
          that.cargarJornadas();
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Dato anulado correctamente.",
          });
        })
        .catch((error) => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
        });
    },
    cerrarModalCrearJornada: function () {
      this.$modal.hide("crearJornada");
    },
    nuevaJornada: function () {
      this.jornadaMod = null;
      this.abrirModalCrearJornada();
    },
    abrirModalCrearJornada: function () {
      this.$modal.show("crearJornada");
    },
    cargarTrabajadoresSalud: function () {
      let that = this;
      var loader = that.$loading.show();
      let url =
        "/gestion_hospitalaria/personalMedico/cargar_personal_medico_dropdown";
      axios      
        .get(url)
        .then(function (response) {
          let personalMedico=[];
            response.data.medicos.forEach(medico => {
                let objeto= {};
                objeto.TRABAJADORESPERSONALSALUD_COD = medico.TRABAJADORESPERSONALSALUD_COD;
                objeto.display= that.$funcionesGlobales.toCapitalFirstAllWords(medico.USER_NOM);
                personalMedico.push(objeto);
            });
          that.personalMedico =personalMedico;
          loader.hide();
        })
        .catch((error) => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
        });
    },
    cargarJornadas: function () {
      let that = this;
      let url =
        "/gestion_hospitalaria/jornadas/cargar_jornadas/" +
        this.form.personal_cod;
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function (response) {
          that.jornadas = response.data.jornadas;

          loader.hide();
        })
        .catch((error) => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
        });
    },
  },
};
</script>
