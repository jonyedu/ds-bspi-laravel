<template>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
       <h4 class="mt-4">Consultas Externas - Emergencias - Hospitalización</h4>
       <h5>(Seleccione un registro para visualizar sus datos.)</h5>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :seleccionar-button="seleccionarButton"
                :anular-button="false"
                :modificar-button="false"
                :columns-data="columns"
                :rows-data="citas"
                @handleSeleccionarClick="handleSeleccionarClick"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props:{
    seleccionarButton:{
      type:Boolean,
      default:true
    }
  },
  data: function() {
    return {
      citas: [],
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
          label:"Tipo",
          field:"tipo_estado_cita",
          type:"String"
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
      .admistracion_de_citas.citas.lista_citas_emergencia_hospitalizacion.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarCitas();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .admistracion_de_citas.citas.lista_citas_emergencia_hospitalizacion.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    handleSeleccionarClick(value){
      this.$emit("handleSeleccionarClick",value);
    },
    cargarCitas() {
      let that = this;
      let url = "/gestion_hospitalaria/administracion_cita/cargar_citas_emergencia_hospitalizacion";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let citas = [];
          for (let i = 0; i < response.data.datos.length; i++) {
            let objeto = {
              codigo_cita: response.data.datos[i].codigo,
              codigo_doctor: response.data.datos[i].estado_cita.CITA_DOCTOR_COD,
              codigo_paciente: response.data.datos[i].USER_ID,
              nombre_paciente: response.data.datos[i].paciente.US_NOM,
              nombre_doctor: response.data.datos[i].estado_cita.doctor.user.US_NOM,
              apellido_paciente: response.data.datos[i].paciente.US_APELL,
              apellido_doctor: response.data.datos[i].estado_cita.doctor.user.US_APELL,
              hora_inicio: response.data.datos[i].estado_cita.ESTADOCITA_HORA_INICIAL,
              hora_final: response.data.datos[i].estado_cita.ESTADOCITA_HORA_FINAL,
              fecha_cita: response.data.datos[i].estado_cita.ESTADOCITA_FECHA,
              nombre_mostrar_paciente:response.data.datos[i].paciente.FULL_NAME_IDENTIFICATION,
              nombre_mostrar_doctor:
                response.data.datos[i].estado_cita.doctor.user.US_NOM +
                " " +
                response.data.datos[i].estado_cita.doctor.user.US_APELL,
              tipo_estado_cita:response.data.datos[i].estado_cita.ESTADOCITA_TIPO=='C'?'Consulta Externa':
                response.data.datos[i].estado_cita.ESTADOCITA_TIPO=='E'?'Emergencia':'Hospitalización'
            };
            citas.push(objeto);
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
    }
  }
};
</script>
