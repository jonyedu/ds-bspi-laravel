<template>
    <div id="layoutSidenav_nav" style="height: 100%;">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseLayouts"
                        aria-expanded="false"
                        aria-controls="collapseLayouts"
                    >
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-columns"></i>
                        </div>
                        Módulos
                        <div class="sb-sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div
                        class="collapse"
                        id="collapseLayouts"
                        aria-labelledby="headingOne"
                        data-parent="#sidenavAccordion"
                    >
                        <nav class="sb-sidenav-menu-nested nav">
                            <a
                                href="#"
                                v-for="(gestion, index) in gestiones"
                                :key="index"
                                class="nav-link"
                                v-on:click="cambiarMenu"
                                >{{
                                    $funcionesGlobales.toCapitalFirstAllWords(
                                        gestion.GESTION_NOM
                                    )
                                }}</a
                            >
                        </nav>
                    </div>
                    <a
                        v-if="id_menu === 'DatosGenerales'"
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapsePages"
                        aria-expanded="false"
                        aria-controls="collapsePages"
                    >
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        Datos Generales
                        <div class="sb-sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div
                        v-if="id_menu == 'DatosGenerales'"
                        class="collapse"
                        id="collapsePages"
                        aria-labelledby="headingTwo"
                        data-parent="#sidenavAccordion"
                    >
                        <menu-datos-generales
                            :prefijo="prefijo"
                            :id-rol="id_rol"
                        ></menu-datos-generales>
                    </div>
                    <a
                        v-if="id_menu === 'Admisiones'"
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapsePages"
                        aria-expanded="false"
                        aria-controls="collapsePages"
                    >
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        Admisiones
                        <div class="sb-sidenav-collapse-arrow">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div
                        v-if="id_menu == 'Admisiones'"
                        class="collapse"
                        id="collapsePages"
                        aria-labelledby="headingTwo"
                        data-parent="#sidenavAccordion"
                    >
                        <menu-gestion-hospitalaria
                            :prefijo="prefijo"
                            :id-rol="id_rol"
                        ></menu-gestion-hospitalaria>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
import { prefix } from "../../variables";
export default {
    props: {
        columnsData: {
            type: Object
        },
        user: {
            type: Object
        },
        gestiones: {
            type: Array
        }
    },
    data: function() {
        return {
            id_rol: "",
            id_menu: "",
            prefijo: "",
            modulos: [],
            llamarConfiguracion: 0
        };
    },
    mounted: function() {
        this.llamarConfiguracion = this.$route.query.mostrar;

        if(! this.llamarConfiguracion){
            this.cargarConfiguraciones();
        }
        this.cargarModulos();

        this.prefijo = prefix;
    },
    methods: {
        cambiarMenu: function(event) {
            let nombreMenu = event.target.text;
            this.id_menu = nombreMenu.replace(/ /g, ""); //esto quita espacios
            let id_rol = this.gestiones.find(
                gestion =>
                    gestion.GESTION_NOM.replace(/ /g, "") ==
                    this.$funcionesGlobales.toCapitalAllWords(this.id_menu)
            );
            this.id_rol = id_rol.USROL_COD;
        },
        cargarModulos() {
            let that = this;
            let url = "/datos_generales/gestiones/cargar_gestiones_combo_box";
            axios
                .get(url)
                .then(function(response) {
                    let modulos = [];
                    modulos = response.data.modulos;
                    that.modulos = modulos;
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
        cargarConfiguraciones: function() {
            let that = this;
            let url = "/datos_generales/generalidades/cargar_configuracion";
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    if(response.data.configuracion.TIEMPO_ACTUALIZACION_CLAVE > 0){
                        that.$funcionesGlobales.validarCambioClavePorFecha(that.$props.user.USUARIO, that.$props.user.FULL_IDENTIFICATION, that.$props.user.id, that.$props.user.US_FECHA_CAMBIO_CLAVE,response.data.configuracion.TIEMPO_ACTUALIZACION_CLAVE);
                    }
                    loader.hide();
                })
                .catch(error => {
                    //Errores
                    loader.hide();
                });
        }
    }
};
</script>
