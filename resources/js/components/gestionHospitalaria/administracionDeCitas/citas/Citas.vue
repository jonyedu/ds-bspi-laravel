<template>
  <div class="row">
    <div class="col-md-9">
      <h1 class="float-left">Ingresos - {{titulo_seleccionado }}</h1>
    </div>
    <div class="col-md-3 mt-2">
      <h4 class="float-left">Cita Nro. {{ ultimo_codigo_cita }}</h4>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
              <div class="btn-group" role="group">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="mostrarComponenteCitasAgendadas()"
                >Ver Citas Agendadas</button>
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="mostrarComponenteIngresoEmergencia()"
                >Ingreso Por Emergencias</button>
                <button
                  type="button"
                  class="btn btn-info"
                  @click="mostrarComponenteIngresoConsulta()"
                >Ingreso Por Consulta Externa</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12" v-if="componente_seleccionado=='Citas'">
              <vuetable-component
                :anular-button="false"
                :modificar-button="false"
                :columns-data="columns"
                :rows-data="citas"
              ></vuetable-component>
            </div>
            <div
              class="col-lg-12 col-md-12 col-sm-12"
              v-else-if="componente_seleccionado=='Emergencia'"
            >
              <ingreso-emergencia
                :objeto-mod="null"
                :acompanantes="acompanantes"
                :especialidades="especialidades"
                @recargarDatos="cargarCitas"
              ></ingreso-emergencia>
            </div>
            <div
              class="col-lg-12 col-md-12 col-sm-12"
              v-else-if="componente_seleccionado=='Consulta'"
            >
              <ingreso-consulta-externa
                :objeto-mod="null"
                :acompanantes="acompanantes"
                :especialidades="especialidades"
                @recargarDatos="cargarCitas"
              ></ingreso-consulta-externa>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    data: function() {
      return {
        acompanantes: [],
        ultimo_codigo_cita: "",
        citas: [],
        titulo_seleccionado: "",
        componente_seleccionado: "Citas",
        especialidades: [],
        form: {
          cita_id: ""
        },
        objetoMod: null,
        columns: [
          {
            label: "Nombre Del Paciente",
            field: "nombre_mostrar_paciente",
            type: "String"
          },
          {
            label: "Nombre Del Doctor",
            field: "nombre_mostrar_doctor",
            type: "String"
          },
          {
            label: "Fecha",
            field: "fecha_cita",
            type: "String"
          },
          {
            label: "Hora Inicio",
            field: "hora_inicio",
            type: "String"
          },
          {
            label: "Hora Final",
            field: "hora_final",
            type: "String"
          }
        ]
      };
    },
  mounted: function() {
    this.titulo_seleccionado = "Citas Agendadas";
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.aseguradoras.aseguradoras.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarCitas();
    this.cargarEspecialidades();
    // this.cargarUltimoCodigoCita();
    this.cargarUsuarios();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.aseguradoras.aseguradoras.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    cargarCitas() {
      let that = this;
      let url = "/gestion_hospitalaria/administracion_cita/cargar_citas";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let citas = [];
          for (let i = 0; i < response.data.datos.length; i++) {
            let objeto = {
              codigo_cita: response.data.datos[i].codigo,
              codigo_doctor: response.data.datos[i].CITA_DOCTOR_COD,
              codigo_paciente: response.data.datos[i].USER_ID,
              nombre_paciente: response.data.datos[i].paciente.US_NOM,
              nombre_doctor: response.data.datos[i].doctor.US_NOM,
              apellido_paciente: response.data.datos[i].paciente.US_APELL,
              apellido_doctor: response.data.datos[i].doctor.US_APELL,
              hora_inicio: response.data.datos[i].CITA_HORA_INICIAL,
              hora_final: response.data.datos[i].CITA_HORA_FINAL,
              fecha_cita: response.data.datos[i].CITA_FECHA,
              nombre_mostrar_paciente:
                response.data.datos[i].paciente.US_NOM +
                " " +
                response.data.datos[i].paciente.US_APELL,
              nombre_mostrar_doctor:
                response.data.datos[i].doctor.US_NOM +
                " " +
                response.data.datos[i].doctor.US_APELL
            };
            citas.push(objeto);

            that.cargarUltimoCodigoCita();
          }
          that.citas = citas;
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
    cargarUsuarios() {
      let that = this;
      let url = "/datos_generales/usuarios/cargar_usuarios_campos";

      axios
        .get(url)
        .then(function(response) {
          let usuarios = [];

          for (let i = 0; i < response.data.usuarios.length; i++) {
            let objeto = {};
            objeto.value = response.data.usuarios[i].id;
            objeto.display = response.data.usuarios[i].FULL_NAME_IDENTIFICATION;
            usuarios.push(objeto);
          }
          that.acompanantes = usuarios;
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
    cargarUltimoCodigoCita() {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_cita/cargar_ultimo_codigo_cita";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.ultimo_codigo_cita = response.data.datos.codigo;
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
    cargarEspecialidades() {
      let that = this;
      let url =
        "/gestion_hospitalaria/personal_medico/cargar_especialidades_lista";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let especialidades = [];

          for (let i = 0; i < response.data.datos.length; i++) {
            let objeto = {
              display: response.data.datos[i].nombre,
              value: response.data.datos[i].codigo
            };
            especialidades.push(objeto);
          }
          that.especialidades = especialidades;
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
    mostrarComponenteCitasAgendadas() {
      this.titulo_seleccionado = "Citas Agendadas";
      this.componente_seleccionado = "Citas";
    },
    mostrarComponenteIngresoEmergencia() {
      this.titulo_seleccionado = "Emergencia";
      this.componente_seleccionado = "Emergencia";
    },
    mostrarComponenteIngresoConsulta() {
      this.titulo_seleccionado = "Consulta Externa";
      this.componente_seleccionado = "Consulta";
    }
  }
};
</script>
