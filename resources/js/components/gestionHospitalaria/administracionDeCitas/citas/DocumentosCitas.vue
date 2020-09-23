<template>
  <div class="row" >
      <div class="col-md-9">
        <h1 class="float-left" style="margin-top:25px">Documentos de {{tituloDocs}} </h1>
      </div>
      <div class="col-md-3 mt-2">
        <h4 class="float-left" style="margin-top:25px">Cita Nro. {{ultimo_codigo_cita}} </h4>
      </div>

      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
          <div class="card-body">
            
            <div class="row">
              <lista-cita-emergencia-consulta-externa-hospitalizacion @handleSeleccionarClick="handleSeleccionarClick"></lista-cita-emergencia-consulta-externa-hospitalizacion>
                <div class="col-lg-12 col-md-12 col-sm-12 text-center" style="display:flex;flex-direction:row" v-if="ultimo_codigo_cita!=null">
                  <div >
                    <div >
                      <div class="mt-3" >
                        <div>
                          <button type="button" class="btn btn-dark" style="font-size:small;width:100%;margin-bottom:5px"
                                  @click="cambiarTitulo()">
                            - <b>CLICK AQUÍ</b> - Para Mostrar Documentos de {{(tituloDocs==this.titulos[0])?this.titulos[1]:this.titulos[0]}} 
                            <span>
                              <i class="fas fa-exchange-alt"></i>
                            </span> 
                          </button>
                          <vuetable-component
                            :anular-button="true"
                            :modificar-button="false"
                            :columns-data="columns"
                            :rows-data="registroDocs"
                            @handleRowClick="previsualizarArchivo"
                            @handleAnularClick="anularDocConfirmacion"
                          ></vuetable-component>
                        </div>
                      </div>
                      <div class="mt-3" v-if="estadoComponente.btnsIniciales">
                        <button type="button" class="btn btn-primary m-1" 
                                @click="mostrarBotonesDeCarga()">
                            Cargar Archivo
                        </button>
                      </div>
                      <div class="mt-3" v-if="estadoComponente.btnsCargaArchivo">
                        <div></div>
                        <button type="button" class="btn btn-info m-1"
                                @click="abrirModalIngreso(true,false)">
                          Cargar Archivo a Paciente
                        </button>
                        <button type="button" class="btn btn-info m-1"
                                @click="abrirModalIngreso(false,true)">
                            Cargar Archivo a Cita
                        </button>
                        <button type="button" class="btn btn-info m-1"
                                @click="abrirModalIngreso(true,true)">
                            Cargar Archivo a Ambos
                        </button><br>
                        <button class="btn btn-danger m-1"
                                @click="mostrarBotonesIniciales()">
                          Cancelar
                        </button>
                      </div>
                    </div>
                  </div>
                  <div>
                    <pdf-preview :url="urlArchivo" :size="['350px']" class="ml-3"></pdf-preview>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearDocumento">
          <crear-documento
            :cargaUsuario="carga_a_usuario"
            :cargaCita="carga_a_cita"
            :codigo-usuario="codigo_usuario"
            :codigo-cita="ultimo_codigo_cita"
            @recargarTabla="cargarDocs"
            @cerrarModalIngreso="cerrarModalIngreso"
            ref="crearDocumento"
          ></crear-documento>
        </modal>
      </div>
    </div>
</template>
<style>
  span{
    cursor: pointer;
  }
  tr:hover{
    background-color:#dbdbdb;
  }
</style>
<script>
export default {
  data: function() {
    return {
      acompanantes: [],
      titulos:["Cita","Paciente"],
      tituloDocs: "Cita",
      ultimo_codigo_cita: null,
      codigo_usuario:null,
      urlArchivo: "",
      registroDocs: [],
      componente_seleccionado: "Documentos de Cita",
      estadoComponente: {
        btnsIniciales: true,
        btnsCargaArchivo: false,
      },
      carga_a_cita: true,
      carga_a_usuario: false,
      columns: [
        {
          label: "Nombre Del Archivo",
          field: "nombre_doc",
          type: "String"
        },
        {
          label: "Tipo",
          field: "tipo_doc",
          type: "String"
        },
        {
          label: "Observación",
          field: "obs_doc",
          type: "String"
        },
        {
          label: "Fecha",
          field: "fecha_doc",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .admistracion_de_citas.citas.documentos_citas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    //this.cargarDocs();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .admistracion_de_citas.citas.documentos_citas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    handleSeleccionarClick(value){
      this.ultimo_codigo_cita=value.codigo_cita;
      this.codigo_usuario = value.codigo_paciente;
      this.urlArchivo ="";
      this.cargarDocs();
    },
    calculaTipo(valor){
      switch (valor) {
        case 'CEDU':
          return 'Cedula'
        case 'CONT':
          return 'Contrato'
        case 'PASA':
          return 'Pasaporte'
        case 'LICE':
          return 'Licencia de Conducir'
        case 'EXAM':
          return 'Exámenes Médicos'
        case 'PREE':
          return 'Preescripciones'
        case 'POLI':
          return 'Póliza'
        default:
          return 'Otros'
      }
    },
    cargarDocs() {
      let that = this;
      let url;
      if(this.tituloDocs==this.titulos[1]){
        url = "/gestion_hospitalaria/administracion_cita/cargar_documentosUsuario/"+this.codigo_usuario;
      }
      else{
        url = "/gestion_hospitalaria/administracion_cita/cargar_documentosCita/"+this.ultimo_codigo_cita;
      }
      
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let registroDocs = [];
          
          for (let i = 0; i < response.data.datos.length; i++) {
            let objeto = {
              codigo_doc: response.data.datos[i].codigoDoc,
              codigo_usu_cita: response.data.datos[i].codigoUsuCita,
              nombre_doc: response.data.datos[i].nombreDoc,
              tipo_doc: that.calculaTipo(response.data.datos[i].tipoDoc),
              obs_doc: response.data.datos[i].obsDoc,
              ruta_doc: response.data.datos[i].rutaDoc,
              fecha_doc: response.data.datos[i].fechaCreacion
            };
            if (objeto.obs_doc==null) {
              objeto.obs_doc="Ninguna";
            }
            registroDocs.push(objeto);
            //that.cargarUltimoCodigoCita();
          }
          that.registroDocs = registroDocs;
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
    abrirModalIngreso: function(usuario,cita) {
      this.carga_a_usuario = usuario;
      this.carga_a_cita = cita;
      this.$modal.show("crearDocumento");
    },
    cerrarModalIngreso: function() {
      this.$modal.hide("crearDocumento");
    },
    previsualizarArchivo(value) {
      this.urlArchivo=value.ruta_doc;
    },
    mostrarBotonesDeCarga() {
      this.estadoComponente.btnsIniciales = false;
      this.estadoComponente.btnsCargaArchivo = true;
    },
    mostrarBotonesIniciales() {
      this.estadoComponente.btnsIniciales = true;
      this.estadoComponente.btnsCargaArchivo = false;
    },
    cambiarTitulo(){
      (this.tituloDocs==this.titulos[0])?this.tituloDocs=this.titulos[1]:this.tituloDocs=this.titulos[0];
      this.urlArchivo="";
      this.cargarDocs()
    },
    anularDocConfirmacion(value) {
      let that = this;
      this.$swal({
        title: "¿Desea anular el elemento seleccionado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          that.anularDoc(value.codigo_usu_cita,value.codigo_doc);
        }
      });
    },
    anularDoc(id,idDoc) {
      let that = this;
      let url;
      if(this.tituloDocs==this.titulos[1]){
        url = "/gestion_hospitalaria/administracion_cita/anular_documento_usuario";
      }
      else{
        url = "/gestion_hospitalaria/administracion_cita/anular_documento_cita";
      }
      
      var loader = that.$loading.show();
      axios
        .post(
          url,
          {'id':id,'idDoc':idDoc}
        )
        .then(function(response) {
          that.urlArchivo="";
          loader.hide();
          that.cargarDocs();
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Dato anulado correctamente."
          });
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
    anularAllDocsConfirmacion() {
      let that = this;
      let tipo;
      if(this.tituloDocs==this.titulos[1]){
        tipo = 'usuario';
      }
      else{
        tipo = 'cita';
      }
      this.$swal({
        title: "¿Desea eliminar todos los documentos de "+ tipo +"?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          that.anularAllDocs(tipo);
        }
      });
    },
    anularAllDocs(tipo) {
      let that = this;
      let url;
      url = "/gestion_hospitalaria/administracion_cita/anular_all_docs";
      
      var loader = that.$loading.show();
      axios
        .post(
          url,
          {'tipo':tipo}
        )
        .then(function(response) {
          that.urlArchivo="";
          loader.hide();
          that.cargarDocs();
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Dato anulado correctamente."
          });
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