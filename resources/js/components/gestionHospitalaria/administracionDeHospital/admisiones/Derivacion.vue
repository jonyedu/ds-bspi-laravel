<template>
  <div class="row p-3">
     <div class="col-md-12">
      <h1 class="float-left">Derivación - {{titulo_seleccionado }}</h1>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
              <div class="btn-group" role="group"  v-if="esConsultaExterna">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="mostrarComponenteConsultaExterna()"
                > <i class="fas fa-user-nurse"></i>Consulta Externa</button>
                <button
                  v-if="esEmergencia"
                  type="button"
                  class="btn btn-danger"
                  @click="mostrarComponenteEmergencia()"
                > <i class="fas fa-first-aid"></i>Emergencia</button>
            </div>
            <div class="btn-group" role="group" v-else-if="esEmergencia">
                <button
                  v-if="esEmergencia"
                  type="button"
                  class="btn btn-danger"
                  @click="mostrarComponenteEmergencia()"
                > <i class="fas fa-first-aid"></i>Emergencia</button>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <label><b>Paciente: </b>{{paciente.nombre_paciente}} </label>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
            <derivacion-emergencia :objeto-mod="objetoEmergencia" @recargarDatosEmergencia="recargarDatosEmergencia" :codigo-cita="codigoCita"  :especialidades="especialidades" v-if="componente_seleccionado=='Emergencia'"></derivacion-emergencia >
            <derivacion-consulta-externa :objeto-mod="objetoConsultaExterna" @recargarDatosConsultaExterna="recargarDatosConsultaExterna" :codigo-cita="codigoCita"  :especialidades="especialidades" v-else></derivacion-consulta-externa>
          </div>
        </div>
      </div>
    </div>
  </div>
 
</div>
</template>
<script>
export default {
  props: {
    objetoConsultaExterna:{
      type:Object,
      default:null
    },
    objetoEmergencia:{
      type:Object,
      default:null
    },
    codigoCita:{
      type:Number
    },
    paciente:{
      type:Object,
      default:null
    },
    esModal: {
      type: Boolean,
      default: false
    },
    especialidades:{
      type: Array,
      default: false
    },
    esConsultaExterna:{
      type:Boolean,
      default:false
    },
    esEmergencia:{
      type:Boolean,
      default:false
    }
  },
  data: function() {
    return {
      titulo_seleccionado: "",
      componente_seleccionado: "ListaAdmisiones",
      tiposDeSangre: [],
      religiones: [],
    };
  },
  mounted: function() {
    if(this.$props.objetoConsultaExterna==null && this.$props.objetoEmergencia==null)
    {
      this.titulo_seleccionado = "Consulta Externa";
      this.componente_seleccionado="ConsultaExterna";
    }else{
      if(this.$props.objetoConsultaExterna!=null)
      {
        this.titulo_seleccionado = "Consulta Externa";
        this.componente_seleccionado="ConsultaExterna";
      }else{
        if(this.$props.objetoEmergencia!=null){
          this.titulo_seleccionado = "Emergencia";
          this.componente_seleccionado="Emergencia";
        }
      }
    }
    
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.admisiones.derivacion.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.admisiones.derivacion.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    limpiar(){
      this.usuarioData=null;
    },
    recargarDatosEmergencia(){
      this.$emit("recargarDatosEmergencia");
    },
    recargarDatosConsultaExterna(){
      this.$emit("recargarDatosConsultaExterna");
    },
    modificarAdmision(admision){
      this.dataCrearAdmision = admision;
      this.mostrarComponenteAsignacionSeguro();
    },
    modificarUsuarioAdmision(usuario){
      this.usuarioData = usuario;
      this.mostrarComponenteCrearAdmision();
    },
    cargarUltimoCodigoCita() {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_cita/cargar_ultimo_codigo_cita";
      axios
        .get(url)
        .then(function(response) {
          let codigo= response.data.datos.codigo;
          that.ultimo_codigo_cita =  that.$funcionesGlobales.addCeroToLeft(codigo,8);
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
    mostrarComponenteEmergencia(){
      this.titulo_seleccionado = "Emergencia";
      this.componente_seleccionado = "Emergencia";
    },
     mostrarComponenteConsultaExterna() {
      this.titulo_seleccionado = "Consulta Externa";
      this.componente_seleccionado =  "CosultaExterna"; 
    },
    
    
    cargarTiposDeSangre: function() {
      return new Promise(resolve => {
        let that = this;
        let url = "/datos_generales/usuarios/tipos_sangre";
        axios
          .get(url)
          .then(function(response) {
            let tiposDeSangre = [];
            for (let i = 0; i < response.data.tiposDeSangre.length; i++) {
              let objeto = {};
              objeto.value = response.data.tiposDeSangre[i].TSANGRE_COD;
              objeto.display = response.data.tiposDeSangre[i].TSANGRE_NOM;
              tiposDeSangre.push(objeto);
            }
            that.tiposDeSangre = tiposDeSangre;
            resolve();
          })
          .catch(error => {
            //Errores
            that.$swal({
              icon: "error",
              title: "Existe un error",
              text: error
            });
          });
      });
    },
  }
};
</script>
