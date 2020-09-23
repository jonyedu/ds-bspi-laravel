<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
          <form>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <v-select
                    v-model="selectedUsuario"
                    :value="form.codigo_usuario"
                    :options="usuarios"
                    label="display"
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
              <div class="col-md-12" v-if="coberturasRspi.length>0">
                  <div class="float-right">
                        <button @click="generarPdfCobertura()" type="button" class="btn btn-danger">PDF Cobertura Seguros Paciente</button>  
                  </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 mt-3" v-if="coberturasRspi.length>0">     
                  <vuetable-component
                  :anular-button="false"
                  :modificar-button="false"
                  :derivar-button="false"
                  :columns-data="coberturaPolizaRspiColumn"
                  :rows-data="coberturasRspi"
                 
                  ></vuetable-component>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="usuario">Pólizas del usuario seleccionado</label>
                  <v-select
                    v-model="selectedPoliza"
                    :value="form.codigo_poliza"
                    :options="polizas"
                    label="display"
                    @input="setSelectedPoliza"
                  >
                    <template slot="no-options">
                      No se ha encontrado ningun
                      dato, seleccione un usuario para cargar sus pólizas.
                    </template>
                  </v-select>
                  <small
                    v-if="errores.codigo_poliza !== ''"
                    id="usuarioHelp"
                    class="text-danger"
                  >{{ errores.codigo_poliza[0] }}</small>
                </div>
              </div>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <div class="form-group">
                    <label for="usuario">Beneficiarios de la póliza</label>
                    <v-select
                      v-model="selectedBeneficiario"
                      :value="form.codigo_usuario_beneficiario"
                      :options="beneficiarios"
                      label="display"
                      @input="setSelectedBeneficiario"
                    >
                      <template slot="no-options">
                        No se ha encontrado ningun
                        dato, seleccione una póliza para cargar sus beneficiarios
                      </template>
                    </v-select>
                    <small
                      v-if="errores.codigo_poliza !== ''"
                      id="usuarioHelp"
                      class="text-danger"
                    >{{ errores.codigo_poliza[0] }}</small>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                  <div class="form-group">
                    <label for="usuario">% de cobertura</label>
                    <input
                      type="number"
                      :class="'form-control'"
                      id="porcentaje"
                      placeholder="0"
                      v-model="form.porcentaje"
                    />
                  </div>
                </div>
              <div class="col-lg-12 col-md-12 col-sm-12 float-left">
                  <button type="button" class="btn btn-success" @click="addPoliza()">
                        <i class="fas fa-plus-circle"></i>Añadir cobertura seguro del paciente
                    </button>
                </div>
              <div class="col-lg-12 col-md-12 col-sm-12 mt-3">     
                  <vuetable-component
                  :anular-button="true"
                  :modificar-button="false"
                  :derivar-button="false"
                  :columns-data="coberturaPolizasColumn"
                  :rows-data="coberturaPolizas"
                  @handleAnularClick="anularCoberturaClick"
                  ></vuetable-component>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input
                      type="radio"
                      class="form-check-input"
                      value="S"
                      name="optradio"
                      v-model="form.acompanante"
                    />Viene Solo
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input
                      type="radio"
                      class="form-check-input"
                      value="A"
                      name="optradio"
                      v-model="form.acompanante"
                    />Viene Acompañado
                  </label>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 mt-2" v-if="form.acompanante=='A'">
                <div class="form-inline">
                    <input
                      style="display:flex;flex-grow:1 "
                      type="text"
                      :class="'form-control'"
                      :readonly="true"
                      id="acompanante"
                      placeholder="Seleccione el acompañante"
                      v-model="form.acompanante_nombre"
                    />
                  <div class="btn-group" role="group">
                    <button
                      type="button"
                      class="btn btn-primary"
                      @click="abrirModalParentescos()"
                    ><i class="fas fa-male"></i>Ingresar Familiar</button>
                    <button
                      type="button"
                      class="btn btn-warning"
                      @click="abrirModalUsuariosParentescos()"
                    ><i class="fas fa-user-friends"></i>Asociar Familiar al paciente</button>
                  </div>
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
                  {{this.objetoMod!=null?'Modificar Admisión':'Crear Admisión'}}   
                  </button>
                </div>
              </div>
            </div>
          </form>
    </div>
    <modal :width="'75%'" height="auto" :scrollable="true" name="parentescos">
      <lista-parentescos
        ref="parentescos"
      ></lista-parentescos>
    </modal>
    <modal :width="'75%'" height="auto" :scrollable="true" name="usuarios-parentescos">
      <lista-usuarios-parentescos
        :seleccionar-button="true"
        ref="usuarios-parentescos"
        @seleccionarUsuarioParentesco="seleccionarUsuarioParentesco"
      ></lista-usuarios-parentescos>
    </modal>
  </div>
</template>
<script>
import UsuariosParentescoVue from '../../pacientes/usuariosParentesco/UsuariosParentesco.vue';
export default {
  props: {
    objetoMod: {
      type: Object
    }
  },
  data: function() {
    return {
      coberturaPolizas:[],
      coberturaPolizaRspiColumn:[
       {
          label: "Seguro",
          field: "nombre_seguro",
          type: "String"
        },
        {
          label: "Posee Cobertura",
          field: "posee_cobertura",
          type: "String"
        }, 
      ],
      coberturaPolizasColumn:[
        {
          label: "Póliza",
          field: "poliza_nombre_mostrar",
          type: "String"
        },
        {
          label: "Beneficiario",
          field: "beneficiario_nombre_mostrar",
          type: "String"
        },
        {
          label: "%Financiamiento",
          field: "porcentaje",
          type: "number"
        }
      ],
    
      usuarios:[],
      polizas: [],
      coberturasRspi:[],
      beneficiarios:[],
      selectedPoliza: "",
      selectedBeneficiario:"",
      errores: {
        codigo_poliza: "",
        codigo_usuario: "",
      },
      form: {
        codigo:"",
        acompanante: "S",
        acompanante_nombre:"",
        codigo_usuario_beneficiario:"",
        codigo_usuario: "",
        codigo_poliza: "",
        id_acompanante: "",
        porcentaje:0
      },
      datos_paciente_mostrar: "",
      selectedUsuario: "",
    };
  },
  mounted: function() {
    if (this.$props.objetoMod !== null) {
      let objeto = this.$props.objetoMod;
      this.form.codigo= objeto.codidoCita;
      this.form.acompanante=objeto.acompanante;
      this.form.acompanante_nombre = objeto.acompanante_nombre;
      this.form.codigo_usuario=objeto.codigo_usuario;
      this.form.id_acompanante=objeto.id_acompanante;
      this.selectedUsuario=objeto.nombre_paciente;
      this.coberturaPolizas= objeto.coberturaPolizas;
      this.setSelectedUsuario(objeto.userObject);
    }
    //this.form.tipo = "PU";
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.admisiones.crear_admision.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarUsuarios()
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.admisiones.crear_admision.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: { 
    generarPdfCobertura(){
      let that = this;
      var loader = that.$loading.show();
      let url =
        "/rpis/obtener/pdf/"+that.form.codigo_usuario+"/seguros";
      axios
        .get(url)
        .then(function(response) {
          loader.hide();
          let url= response.data.url;
          var win = window.open(url, '_blank');
          if (win) {
              //Browser has allowed it to be opened
              win.focus();
          } else {
              //Browser has blocked it
              alert('Please allow popups for this website');
          }
        })
        .catch(error => {
          loader.hide();
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: "El servicio del Rpis no se encuentra disponible"
          });
        });
    },
    anularCoberturaClick(data){
      let index=null;
      for(let i=0; i< this.coberturaPolizas.length; i++){
        if(this.coberturaPolizas[i].codigo_poliza==data.codigo_poliza)
        {
          index=i;
          break;
        }
      }
      this.coberturaPolizas.splice(index,1);
      
    },
    cargarCoberturasPoliza(value){
      
      let that = this;
      var loader = that.$loading.show();
      let url = "/rpis/obtener/seguros/"+this.form.codigo_usuario;
      axios
        .get(url)
        .then(function(response) {
          that.coberturasRspi=response.data.datos;
          //Se procede a cargar las polizas
          url="/gestion_hospitalaria/pacientes/cargar_polizas_por_usuario/"+value.id;
          axios
          .get(url)
            .then(function(response) {
              let polizas=[];
              response.data.datos.forEach(poliza => {
                  let objeto= {};
                  objeto.codigo= poliza.POLIZA_COD;
                  objeto.display= that.$funcionesGlobales.toCapitalFirstAllWords(poliza.FULL_NAME_POLIZA);
                  polizas.push(objeto);
              });
              that.polizas = polizas;
              loader.hide();
            })
            .catch(error => {
              loader.hide();
              //Errores
              that.$swal({
                icon: "error",
                title: "Existe un error",
                text: error
              });
            });
        })
        .catch(error => {
          //Se procede a cargar las polizas
          let url="/gestion_hospitalaria/pacientes/cargar_polizas_por_usuario/"+value.id;
          axios
          .get(url)
            .then(function(response) {
              let polizas=[];
              response.data.datos.forEach(poliza => {
                  let objeto= {};
                  objeto.codigo= poliza.POLIZA_COD;
                  objeto.display= that.$funcionesGlobales.toCapitalFirstAllWords(poliza.FULL_NAME_POLIZA);
                  polizas.push(objeto);
              });
              that.polizas = polizas;
              
              loader.hide();
            })
            .catch(error => {
              //Errores
              that.$swal({
                icon: "error",
                title: "Existe un error",
                text: error
              });
              loader.hide();
            });
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text:"El servicio del Rpis no esta disponible"
          });
        });
    },
    addPoliza(){
      //Se valida que la poliza este seleccionada
      if(this.form.codigo_poliza==''|| this.form.codigo_poliza==null){
        this.$swal({
              icon: "error",
              title: "Información de validación",
              text: "Debe seleccionar una póliza"
            });
            return;
      }
      if(this.form.codigo_usuario_beneficiario=='' || this.form.codigo_usuario_beneficiario==null){
        this.$swal({
              icon: "error",
              title: "Información de validación",
              text: "Debe seleccionar un beneficiario de la póliza"
            });
            return;
      }
      if(this.form.porcentaje=='' || this.form.porcentaje==0 || this.form.porcentaje==null || this.form.porcentaje<0){
         this.$swal({
              icon: "error",
              title:"Información de validación",
              text: "Debe ingresar un porcentaje mayor que 0"
            });
            return;
      }
      //Se valida que la poliza no exista previamente.
      let total_porcentaje=0;
      let encontrado=false;
      if(this.coberturaPolizas.length>0){  
         for(let i=0; i<this.coberturaPolizas.length;i++){
            let poliza= this.coberturaPolizas[i];
            total_porcentaje=total_porcentaje+poliza.porcentaje;
            if(poliza.codigo_poliza==this.form.codigo_poliza){
              encontrado=true;
              break;
            }
          }
      }
      let total_faltante= 100-total_porcentaje;
      
      if(parseFloat(parseFloat(this.form.porcentaje).toFixed(2)) > total_faltante ){
           this.$swal({
              icon: "error",
              title:"Información de validación",
              text: "La suma de los porcentajes de cobertura no puede superar el 100%"
            });
            return;
      }
      if(!encontrado){
        this.coberturaPolizas.push({
          codigo_poliza:this.form.codigo_poliza,
          codigo_usuario_beneficiario: this.form.codigo_usuario_beneficiario,
          poliza_nombre_mostrar:this.selectedPoliza.display,
          beneficiario_nombre_mostrar:this.selectedBeneficiario.display,
          porcentaje:parseFloat(parseFloat(this.form.porcentaje).toFixed(2))
        });
        this.form.codigo_usuario_beneficiario='';
        this.form.codigo_poliza='';
        this.selectedPoliza='';
        this.selectedBeneficiario='';
        this.form.porcentaje=0;
      }else{
         this.$swal({
              icon: "error",
              title:"Información de validación",
              text: "La póliza se encuentra ingresada, no se puede repetir."
            });
            return;
      }
      
    },
    seleccionarUsuarioParentesco(usuarioParentesco){
    
      this.form.acompanante_nombre=usuarioParentesco.full_name_identification_usuario;
      this.form.id_acompanante=usuarioParentesco.codigo_usuario;
      this.cerrarModalUsuariosParentescos();
    },
    abrirModalParentescos: function() {
      this.$modal.show("parentescos");
    },
    cerrarModalParentescos: function() {
      this.$modal.hide("parentescos");
    },
    abrirModalUsuariosParentescos: function() {
      this.$modal.show("usuarios-parentescos");
    },
    cerrarModalUsuariosParentescos: function() {
      this.$modal.hide("usuarios-parentescos");
    },
    setSelectedBeneficiario(value) {
      if (value !== null) {
        this.form.codigo_usuario_beneficiario=value.codigo;
      }else{
        this.form.codigo_usuario_beneficiario="";
      }
    },
    limpiarSeleccionados(){
      this.selectedPoliza="";
      this.selectedBeneficiario="";
      this.form.acompanante_nombre="";
      this.form.codigo_usuario_beneficiario="";
      this.form.codigo_poliza="";
      this.form.id_acompanante="";

    },
    setSelectedUsuario(value) {
      if(this.$props.objetoMod==null){
         this.limpiarSeleccionados();
      }
      if (value !== null) {
        this.form.codigo_usuario=value.id;
        this.cargarCoberturasPoliza(value);

      } else {
        this.form.codigo_usuario="";
       
      }
    },
    cargarUsuarios(){
      let that = this;
      var loader = that.$loading.show();
      axios
          .get("/datos_generales/usuarios/cargar_usuarios_campos")
            .then(function(response) {
              let usuarios = [];
              response.data.usuarios.forEach((usuario) => {
                let objeto = {};
                objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(usuario.FULL_NAME_IDENTIFICATION);
                objeto.id = usuario.id;
                usuarios.push(objeto);
              });
              that.usuarios = usuarios;
              loader.hide();
            })
            .catch(error => {
              //Errores
              that.$swal({
                icon: "error",
                title: "Existe un error",
                text: error
              });
              loader.hide();
            });
    },
    setSelectedPoliza(value) {
      if (value !== null) {
        this.form.codigo_usuario_beneficiario="";
        this.selectedBeneficiario="";
        this.form.codigo_poliza = value.codigo;
         //Se procede a cargar las polizas
        let that= this;
        var loader = that.$loading.show();
        let url="/gestion_hospitalaria/pacientes/cargar_beneficiarios_por_poliza/"+value.codigo;
        axios
        .get(url)
          .then(function(response) {
            let beneficiarios=[];
            response.data.datos.forEach(beneficiario => {
                let objeto= {};
                objeto.codigo= beneficiario.BENEFICIARIO_COD;
                objeto.display= that.$funcionesGlobales.toCapitalFirstAllWords(beneficiario.usuario_beneficiario.FULL_NAME_IDENTIFICATION);
                beneficiarios.push(objeto);
            });
            that.beneficiarios = beneficiarios;
            loader.hide();
          })
          .catch(error => {
            //Errores
            that.$swal({
              icon: "error",
              title: "Existe un error",
              text: error
            });
            loader.hide();
          });

      } else {
        this.form.codigo_poliza = "";
      }
    },
    setSelected(value) {
      if (value !== null) {
        this.form.tipo = value.value;
      } else {
        this.form.tipo = "";
      }
    },
    guardarActualizar: function() {
      let that = this;
      let url = "";
      let mensaje = "";
      //Se comprueba que las polizas esten ingresadas y que su total sea del 100.
      if(that.coberturaPolizas.length==0){
        that.$swal({
          icon: "error",
          title: "Información validación",
          text: "Debe seleccionar una o varias pólizas para continuar."
        });
        return;
      }else{
        let total_cobertura=0;
        that.coberturaPolizas.forEach(element => {
            total_cobertura=total_cobertura+element.porcentaje;
        }); 
        if(total_cobertura<100 || total_cobertura>100){
          that.$swal({
            icon: "error",
            title: "Información validación",
            text: "El total de porcentaje de cobertura no debe ser superior o inferior a 100."
          });
          return;
        }
      }

      if (this.$props.objetoMod !== null) {
        url = "/gestion_hospitalaria/administracion_cita/modificar_admision";
        mensaje = "Datos guardados correctamente.";
      }
      else {
        url = "/gestion_hospitalaria/administracion_cita/crear_admision";
        mensaje = "Datos actualizados correctamente.";
      }
      var loader = that.$loading.show();
      this.form.coberturaPolizas=this.coberturaPolizas;
      axios
        .post(url, this.form)
        .then(function(response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("cambioListaAdmisiones");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Datos actualizados correctamente."
          });
        })
        .catch(error => {
          //Errores de validación
          if (error.response.status === 403) {
               that.$swal({
                icon: "info",
                title: "Validaciones Del Formulario",
                text: error.response.data.mensaje
              });
          }else{
             that.$swal({
                icon: "error",
                title: "Existen errores",
                text: error
              });
          }
          loader.hide();
         
        });
    }
  }
};
</script>
