<template>
    <div>
        <nav
            class="sb-sidenav-menu-nested nav accordion"
            id="sidenavAccordionPages"
            v-if="
                idRol == 'ADMIN' ||
                    idRol == 'ASIST-PRESIDENCIA' ||
                    idRol == 'ALTA-GERENCIA'
            "
        >
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#pagesCollapseGeneralidades"
                aria-expanded="false"
                aria-controls="pagesCollapseGeneralidades"
            >
                <div class="sb-nav-link-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                Generalidades
                <div class="sb-sidenav-collapse-arrow">
                    <i class="fas fa-angle-down"></i>
                </div>
            </a>
            <div
                class="collapse"
                id="pagesCollapseGeneralidades"
                aria-labelledby="headingOne"
                data-parent="#sidenavAccordionPages"
            >
                <nav class="sb-sidenav-menu-nested nav">
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_configuracion'
                        "
                        class="nav-link"
                        >Configuración</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_organizacion_bspi'
                        "
                        class="nav-link"
                        >Organizaciones BSPI</router-link
                    >

                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_organismos_vinculantes_con_la_bspi'
                        "
                        class="nav-link"
                    >
                        Organismos vinculantes con la BSPI
                    </router-link>
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_tipos_de_organismo'
                        "
                        class="nav-link"
                    >
                        Tipo de Organismos vinculantes con la BSPI
                    </router-link>
                    <router-link
                        class="nav-link"
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_cargos_en_organismos'
                        "
                    >
                        Cargos en Organismos vinculantes con la BSPI
                    </router-link>
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_organismos_contactos'
                        "
                        class="nav-link"
                    >
                        Organismos Vinculantes con la BSPI y Contactos
                    </router-link>
                </nav>
            </div>
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#pagesCollapseUsuario"
                aria-expanded="false"
                aria-controls="pagesCollapseUsuario"
            >
                <div class="sb-nav-link-icon">
                    <i class="fas fa-user-edit"></i>
                </div>                
                Usuario
                <div class="sb-sidenav-collapse-arrow">
                    <i class="fas fa-angle-down"></i>
                </div>
            </a>
            <div
                class="collapse"
                id="pagesCollapseUsuario"
                aria-labelledby="headingOne"
                data-parent="#sidenavAccordionPages"
            >
                <nav class="sb-sidenav-menu-nested nav">
                    <router-link
                        :to="
                            prefijo + '/datos_generales/usuarios/mostrar_roles'
                        "
                        class="nav-link"
                        >Roles</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/usuarios/mostrar_usuarios'
                        "
                        class="nav-link"
                        >Datos</router-link
                    >
                </nav>
            </div>
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#pagesCollapseGestiones"
                aria-expanded="false"
                aria-controls="pagesCollapseGestiones"
            >
                <div class="sb-nav-link-icon">
                    <i class="fas fa-tasks"></i>
                </div>                 
                Gestiones
                <div class="sb-sidenav-collapse-arrow">
                    <i class="fas fa-angle-down"></i>
                </div>
            </a>
            <div
                class="collapse"
                id="pagesCollapseGestiones"
                aria-labelledby="headingOne"
                data-parent="#sidenavAccordionPages"
            >
                <nav class="sb-sidenav-menu-nested nav">
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/gestiones/mostrar_gestiones'
                        "
                        class="nav-link"
                        >Datos</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/gestiones/mostrar_gestiones_y_usuarios'
                        "
                        class="nav-link"
                        >Gestiones y usuario</router-link
                    >
                </nav>
            </div>
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#pagesCollapseLogs"
                aria-expanded="false"
                aria-controls="pagesCollapseLogs"
            >
                <div class="sb-nav-link-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>                 
                Logs
                <div class="sb-sidenav-collapse-arrow">
                    <i class="fas fa-angle-down"></i>
                </div>
            </a>
            <div
                class="collapse"
                id="pagesCollapseLogs"
                aria-labelledby="headingOne"
                data-parent="#sidenavAccordionPages"
            >
                <nav class="sb-sidenav-menu-nested nav">
                    <router-link
                        :to="prefijo + '/datos_generales/logs/mostrar_logs'"
                        class="nav-link"
                        >Logs Usuario</router-link
                    >
                </nav>
            </div>
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#pagesCollapseConfiguraciones"
                aria-expanded="false"
                aria-controls="pagesCollapseConfiguraciones"
            >
                <div class="sb-nav-link-icon">
                    <i class="fas fa-cogs"></i>
                </div>                 
                Configuraciones
                <div class="sb-sidenav-collapse-arrow">
                    <i class="fas fa-angle-down"></i>
                </div>
            </a>
            <div
                class="collapse"
                id="pagesCollapseConfiguraciones"
                aria-labelledby="headingOne"
                data-parent="#sidenavAccordionPages"
            >
                <nav class="sb-sidenav-menu-nested nav">
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_paises'
                        "
                        class="nav-link"
                        >Paises</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_provincias'
                        "
                        class="nav-link"
                        >Provincias</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_cantones'
                        "
                        class="nav-link"
                        >Cantones</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_parroquias'
                        "
                        class="nav-link"
                        >Parroquias</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_tipos_de_sangre'
                        "
                        class="nav-link"
                        >Tipo de Sangre</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_religiones'
                        "
                        class="nav-link"
                        >Religiones</router-link
                    >

                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_casas'
                        "
                        class="nav-link"
                        >Casa</router-link
                    >

                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_tipos_de_casa'
                        "
                        class="nav-link"
                        >Tipo de Casa</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_movilizaciones'
                        "
                        class="nav-link"
                        >Movilizaciones</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_discapacidades'
                        "
                        class="nav-link"
                        >Discapacidades</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_tipos_de_organismo'
                        "
                        class="nav-link"
                        >Tipos de organismo</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_tipos_de_organizacion'
                        "
                        class="nav-link"
                        >Tipos de Organización</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_grupos_culturales'
                        "
                        class="nav-link"
                        >Grupos Culturales</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_tipo_unidad'
                        "
                        class="nav-link"
                        >Tipo de Unidad</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/configuraciones/mostrar_unidad'
                        "
                        class="nav-link"
                        >Unidad</router-link
                    >
                </nav>
            </div>
        </nav>

        <nav
            class="sb-sidenav-menu-nested nav accordion"
            id="sidenavAccordionPages"
            v-else-if="idRol == 'ADMIN-DONACIONES'"
        >
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#pagesCollapseGeneralidades"
                aria-expanded="false"
                aria-controls="pagesCollapseGeneralidades"
            >
                <div class="sb-nav-link-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                Generalidades
                <div class="sb-sidenav-collapse-arrow">
                    <i class="fas fa-angle-down"></i>
                </div>
            </a>
            <div
                class="collapse"
                id="pagesCollapseGeneralidades"
                aria-labelledby="headingOne"
                data-parent="#sidenavAccordionPages"
            >
                <nav class="sb-sidenav-menu-nested nav">
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_organismos_vinculantes_con_la_bspi'
                        "
                        class="nav-link"
                    >
                        Organismos vinculantes con la BSPI
                    </router-link>
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_tipos_de_organismo'
                        "
                        class="nav-link"
                    >
                        Tipo de Organismos vinculantes con la BSPI
                    </router-link>
                </nav>
            </div>
        </nav>
        <nav
            class="sb-sidenav-menu-nested nav accordion"
            id="sidenavAccordionPages"
            v-else-if="idRol == 'ADMIN-THUMANO'"
        >
            <a
                class="nav-link collapsed"
                href="#"
                data-toggle="collapse"
                data-target="#pagesCollapseGeneralidades"
                aria-expanded="false"
                aria-controls="pagesCollapseGeneralidades"
            >
                <div class="sb-nav-link-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                Generalidades
                <div class="sb-sidenav-collapse-arrow">
                    <i class="fas fa-angle-down"></i>
                </div>
            </a>
            <div
                class="collapse"
                id="pagesCollapseGeneralidades"
                aria-labelledby="headingOne"
                data-parent="#sidenavAccordionPages"
            >
                <nav class="sb-sidenav-menu-nested nav">
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_organizacion_bspi'
                        "
                        class="nav-link"
                        >Organizaciones BSPI</router-link
                    >
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_organismos_vinculantes_con_la_bspi'
                        "
                        class="nav-link"
                    >
                        Organismos vinculantes con la BSPI
                    </router-link>
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_tipos_de_organismo'
                        "
                        class="nav-link"
                    >
                        Tipo de Organismos vinculantes con la BSPI
                    </router-link>
                    <router-link
                        class="nav-link"
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_cargos_en_organismos'
                        "
                    >
                        Cargos en Organismos vinculantes con la BSPI
                    </router-link>
                    <router-link
                        :to="
                            prefijo +
                                '/datos_generales/generalidades/mostrar_organismos_contactos'
                        "
                        class="nav-link"
                    >
                        Organismos Vinculantes con la BSPI y Contactos
                    </router-link>
                </nav>
            </div>
        </nav>
    </div>
</template>
<script>
export default {
    props: {
        idRol: {
            type: String
        },
        prefijo: {
            type: String
        }
    }
};
</script>
