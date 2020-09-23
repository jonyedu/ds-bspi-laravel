<template>
    <div class="row">
        <h1 class="mt-4">DISPONIBILIDAD DE SEGUROS RPIS</h1>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <v-select
                                    v-bind:style="{ width: ['100%'] }"
                                    v-model="selectedUsuario"
                                    :value="form.codigo_usuario"
                                    :options="usuarios"
                                    label="FULL_NAME_IDENTIFICATION"
                                    @input="setSelectedUsuario"
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
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="mr-2" for="fecha_desde">Disponible a la fecha:</label>
                                <input
                                    type="date"
                                    :class="
                                                                errores.fechaConsulta === ''
                                                                    ? 'form-control'
                                                                    : 'form-control is-invalid'
                                                            "
                                    id="fecha_desde"
                                    placeholder="Seleccione la fecha de cobertura"
                                    v-model="fechaConsulta"
                                />
                                <small
                                    v-if="errores.fechaConsulta !== ''"
                                    id="fecha_desdeHelp"
                                    class="text-danger"
                                    >{{ errores.fechaConsulta[0] }}
                                </small>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 mt-4">
                             <button type="button" class="btn btn-success ml-2" @click="cargarCoberturasPoliza()">
                                <i class="fa fa-search" aria-hidden="true"></i>Consultar
                            </button>
                        </div>
                         <div class="col-md-12" v-if="coberturasRspi.length>0">
                            <div class="float-right">
                                    <button @click="generarPdfCobertura()" type="button" class="btn btn-danger">Generar PDF RPIS</button>  
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
            fechaConsulta:"",
            codigo_usuario:[],
            coberturasRspi:[],
            usuarios:[],
            form: {
                codigo_usuario: "",
            },
            errores:{
                codigo_usuario:"",
                fechaConsulta:""
            },
            objetoMod: null,
            selectedUsuario:"",
            datos: [],
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
           
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .pacientes.disponibilidad_seguros.disponibilidad_seguros
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        this.cargarUsuarios();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .pacientes.disponibilidad_seguros.disponibilidad_seguros
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        generarPdfCobertura(){
            if(this.fechaConsulta==''|| this.fechaConsulta==null)
            {
                this.$swal({
                    icon: "info",
                    title: "Debe seleccionar una fecha",
                    text: error
                });
                return;
            }
             if(this.form.codigo_usuario==''|| this.form.codigo_usuario==null)
            {
                this.$swal({
                    icon: "info",
                    title: "Debe seleccionar un usuario",
                    text: error
                });
                return;
            }
            let that = this;
            let fecha= that.moment(this.fechaConsulta).format('DD-MM-YYYY')
            var loader = that.$loading.show();
            let url =
                "/rpis/obtener/seguros/"+that.form.codigo_usuario+"/"+fecha+"/pdf";
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
                        text: error
                    });
                });
        },
       
        setSelectedUsuario(value) {
            this.coberturasRspi=[];
            if (value !== null) {
                this.form.codigo_usuario=value.id;
                let that= this;
            } else {
                this.form.codigo_usuario="";
            }
        },
        cargarCoberturasPoliza(){
            if(this.fechaConsulta==''|| this.fechaConsulta==null)
            {
                this.$swal({
                    icon: "info",
                    title: "Validación no se puede continuar",
                    text: "Debe seleccionar una fecha"
                });
                return;
            }
             if(this.form.codigo_usuario==''|| this.form.codigo_usuario==null)
            {
                this.$swal({
                    icon: "info",
                    title: "Validación no se puede continuar",
                    text: "Debe seleccionar un usuario"
                });
                return;
            }
            let that = this;
            var loader = that.$loading.show();
            let fecha= that.moment(this.fechaConsulta).format('DD-MM-YYYY')
            let url = "/rpis/obtener/seguros/"+that.form.codigo_usuario+"/"+fecha;
            axios
            .get(url)
                .then(function(response) {
                that.coberturasRspi=response.data.datos;
                if(that.coberturasRspi.length==0){
                    that.$swal({
                        icon: "error",
                        title: "No se encontraron datos",
                        text:"Es posible que el servicio del RPIS no este disponible, o no existan datos para el usuario seleccionado."
                    });
                }
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
        cargarUsuarios(){
            let that = this;
            var loader = that.$loading.show();
            axios
            .get("/datos_generales/usuarios/cargar_usuarios_campos")
                .then(function(response) {
                    that.usuarios = response.data.usuarios;
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
        
    }
};
</script>
