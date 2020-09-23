<template>
    <div class="row m-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-4">CONSULTORIOS</h5>
            </center>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-md-12 col-sm-12 p-5">
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre/Numero</label>
                                    <input
                                        type="text"
                                        :readonly="consultorioMod !== null"
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
                                        >{{ errores.nombre[0] }}</small
                                    >
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="tipo">Area</label>
                                    <v-select
                                        v-model="selectedArea"
                                        :value="form.area_cod"
                                        :options="areas"
                                        label="AREA_NOM"
                                        @input="setSelectedArea"
                                    >
                                        <template slot="no-options">
                                            No se ha encontrado ningun dato
                                        </template>
                                    </v-select>
                                    <small
                                        v-if="errores.area_cod !== ''"
                                        id="tipoHelp"
                                        class="text-danger"
                                        >{{ errores.area_cod[0] }}</small
                                    >
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="cargo">Asignar a Jornada</label>
                                    <v-select
                                        v-model="selectedJornada"
                                        :value="form.JORNADATRABAJADOR_COD"
                                        :options="jornadas"
                                        label="JORNADATRABAJADOR_TRABAJADOR"
                                        @input="setSelectedJornada"
                                    >
                                        <template slot="no-options">
                                            No se ha encontrado ningun dato
                                        </template>
                                    </v-select>
                                    <small
                                        v-if="errores.jornada_cod !== ''"
                                        id="cargoHelp"
                                        class="text-danger"
                                        >{{ errores.jornada_cod[0] }}</small
                                    >
                                </div>
                            </div>
                            <div
                                v-if="form.jornada_cod != null"
                                class="col-lg-4 col-md-4 col-sm-12"
                            >
                                <div class="form-group">
                                    <label for="nombre">Horario</label>
                                    <input
                                        type="text"
                                        :class="form-control"
                                        id="cicloInicial"
                                        readonly
                                        v-model="selectedJornadaHorario"
                                    />
                                </div>
                            </div>
                            <div
                                v-if="form.jornada_cod != null"
                                class="col-lg-12 col-md-12 col-sm-12"
                            >
                                <div class="form-group">
                                    <label for="nombre">Dias</label>
                                    <input
                                        type="text"
                                        readonly
                                        :class="'form-control'"
                                        id="cicloInicial"
                                        v-model="
                                            selectedDias
                                        "
                                    />
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
                        <div class="row">
                            <div
                                class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1"
                            >
                                <div class="form-inline">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block"
                                        @click="guardarActualizar()"
                                    >
                                        {{
                                            consultorioMod === null
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
        consultorioMod: {
            type: Object
        },
        areas: {
            type: Array
        },
        jornadas: {
            type: Array
        }
    },
    data: function() {
        return {
            errores: {
                area_cod: "",
                nombre: "",
                jornada_cod: ""
            },
            form: {
                area_cod: "",
                nombre: "",
                consultorio_cod: "",
                jornada_cod: "",
                activo: "",
                observacion: ""
            },
            activos: [
                {
                    id_tipo: "A"
                },
                {
                    id_tipo: "I"
                }
            ],
            selectedArea: "",
            selectedActivo: "A",
            selectedJornada: "",
            selectedJornadaHorario: "",
            selectedDias:""
            //organismosA: [],
            //cargosA: [],
            //usuariosA: []
        };
    },
    mounted: function() {
        this.form.activo = "A";

        if (this.$props.consultorioMod !== null) {
            var consultorio = this.$props.consultorioMod;

            this.form.consultorio_cod=consultorio.CONSULTORIO_COD;
            this.form.area_cod = consultorio.AREA_COD;
            this.form.jornada_cod = consultorio.JORNADA_COD;
            this.form.nombre=consultorio.CONSULTORIO_NOM;
            this.selectedJornada=consultorio.MEDICO_NOM;
            this.selectedArea=consultorio.AREA_NOM;
            this.form.observacion=consultorio.CONSULTORIO_OBS;
            this.selectedJornadaHorario=consultorio.JORNADATRABAJADOR_HORARIO;
            this.selectedDias=consultorio.JORNADATRABAJADOR_DIAS;
            

           
        }
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .administracion_de_hospital.habitaciones.crear_modificar_habitacion
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .administracion_de_hospital.habitaciones.crear_modificar_habitacion
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        limpiarForm() {
            this.errores = {
                area_cod: "",
                nombre: "",
                jornada_cod: ""
            };
            this.form = {
                tipo_cod: "",
                hospital_cod: "",
                nombre: "",
                activo: "",
                observacion: ""
            };

            this.selectedActivo = "A";
            this.form.activo = "A";
            this.selectedHospital = "";
            this.selectedTipo = "";
        },
        setSelectedArea(value) {
            if (value !== null) {
                this.form.area_cod = value.AREA_COD;
            } else {
                this.form.area_cod = "";
            }
        },
        setSelected(value) {
            if (value !== null) {
                this.form.activo = value.id_tipo;
            } else {
                this.form.activo = "";
            }
        },

        setSelectedJornada(value) {
            if (value !== null) {
                this.form.jornada_cod = value.JORNADATRABAJADOR_COD;
                this.selectedJornadaHorario =
                    value.JORNADATRABAJADOR_INICIO +
                    "-" +
                    value.JORNADATRABAJADOR_FIN;
                    this.selectedDias=value.JORNADATRABAJADOR_DIAS;
            } else {
                this.form.jornada_cod = "";
            }
        },
        guardarActualizar: function() {
            let that = this;
            that.errores = {
               area_cod: "",
                nombre: "",
                jornada_cod: ""
            };
            let url = "";
            let mensaje = "";

            if (this.$props.consultorioMod !== null) {
                url =
                    "/gestion_hospitalaria/consultorios/modificar_consultorios";
                mensaje = "Datos actualizados correctamente.";
            } else {
                url = "/gestion_hospitalaria/consultorios/guardar_consultorios";
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();
                    that.$emit("recargarConsultorios");
                    that.$emit("cerrarModalCrearConsultorio");
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
                        that.errores.area_cod =
                            error.response.data.errors.area_cod != undefined
                                ? error.response.data.errors.area_cod
                                : "";

                        that.errores.jornada_cod =
                            error.response.data.errors.jornada_cod != undefined
                                ? error.response.data.errors.jornada_cod
                                : "";
                        that.errores.nombre =
                            error.response.data.errors.nombre != undefined
                                ? error.response.data.errors.nombre
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
