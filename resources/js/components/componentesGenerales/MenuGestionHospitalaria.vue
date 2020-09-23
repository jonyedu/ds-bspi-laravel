<template>
  <div>
    <nav
      class="sb-sidenav-menu-nested nav accordion"
      id="sidenavAccordionPages"
      v-if="
                                    idRol == 'ADMIN' ||
                                    idRol == 'ADMIN-ADMISIONES'
                            "
    >
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapsePacientes"
        aria-expanded="false"
        aria-controls="pagesCollapsePacientes"
      >
        <i class="fas fa-user-edit"></i>
        Pacientes
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapsePacientes"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_tipos_parentesco'
                                        "
            class="nav-link"
          >Tipo Parentesco</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_parentescos'
                                        "
            class="nav-link"
          >Parentesco</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_usuarios_patentesco'
                                        "
            class="nav-link"
          >Usuario Parentesco</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_lugares_de_trabajo'
                                        "
            class="nav-link"
          >Lugares De Trabajo</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_ocupaciones'
                                        "
          >Ocupaciones</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_lugares_de_trabajo_usuario'
                                        "
            class="nav-link"
          >Lugares De Trabajo Usuario</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseSeguros"
        aria-expanded="false"
        aria-controls="pagesCollapseSeguros"
      >
        <i class="fas fa-user-edit"></i>
        Seguros
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseSeguros"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/seguros/disponibilidad'
                                        "
            class="nav-link"
          >Disponibiidad Seguros</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_aseguradoras'
                                        "
            class="nav-link"
          >Aseguradora</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_polizas'
                                        "
          >Póliza</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_beneficiarios'
                                        "
            class="nav-link"
          >Beneficiario</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapsePersonalMedico"
        aria-expanded="false"
        aria-controls="pagesCollapsePersonalMedico"
      >
        <i class="fa fa-user-md"></i>
        Personal Medico
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapsePersonalMedico"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/agenda'
                                        "
            class="nav-link"
          >Agenda Cita</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/jornadas'
                                        "
            class="nav-link"
          >Jornadas</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/personal_medico'
                                        "
            class="nav-link"
          >Personal Medico</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/tipo_trabajadores'
                                        "
            class="nav-link"
          >Tipos de Personal Medico</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/funciones_personal_medico'
                                        "
            class="nav-link"
          >Funciones de Personal Medico</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseAdministracionHospital"
        aria-expanded="false"
        aria-controls="pagesCollapseAdministracionHospital"
      >
        <i class="fas fa-hospital"></i>
        Administración de Hospital
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseAdministracionHospital"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/hopistales'
                                        "
            class="nav-link"
          >Hospitales</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/especialidades'
                                        "
            class="nav-link"
          >Especialidades</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/areas'
                                        "
            class="nav-link"
          >Areas</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/tipo_habitaciones'
                                        "
            class="nav-link"
          >Tipo de Habitaciones</router-link>
          <router-link
            :to="
                    prefijo +
                        '/gestion_hospitalaria/administracion_de_hospital/consultorios'
                "
            class="nav-link"
          >Consultorios</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/habitaciones'
                                        "
            class="nav-link"
          >Habitaciones</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/tipo_camas'
                                        "
          >Tipo De Camas</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/camas'
                                        "
          >Camas</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseAdministracionCitas"
        aria-expanded="false"
        aria-controls="pagesCollapseAdministracionCitas"
      >
        <i class="fas fa-calendar"></i>
        Gestión de admisiones
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseAdministracionCitas"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_citas/mostrar_admisiones'
                                        "
            class="nav-link"
          >Admisiones</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_citas/mostrar_documentos_citas'
                                        "
            class="nav-link"
          >Documentos Cita</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_citas/mostrar_documentos_usuarios'
                                        "
            class="nav-link"
          >Documentos Usuario</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseConsultaExterna"
        aria-expanded="false"
        aria-controls="pagesCollapseConsultaExterna"
      >
        <i class="fas fa-user-nurse"></i>
        Consulta Externa
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseConsultaExterna"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_asignacion_consulta_externa'
            "
            class="nav-link"
          >Asignación de consulta externa a pacientes</router-link>
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_visualizacion_consulta_externa'
            "
            class="nav-link"
          >Visualización de consultas externas</router-link>
          <router-link
            :to="
                                           prefijo +
                                                '/gestion_hospitalaria/consulta_externa/jornadas'
                                        "
            class="nav-link"
          >Horarios de medicos</router-link>
          <router-link
            :to="
                                            prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_preparacion_del_paciente'
            "
            class="nav-link"
          >Preparación del paciente</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseEmergencia"
        aria-expanded="false"
        aria-controls="pagesCollapseEmergencia"
      >
        <i class="fas fa-first-aid"></i>
        Emergencia
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseEmergencia"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/emergencia/mostrar_asignacion_emergencia'
            "
            class="nav-link"
          >Asignación de emergencia a pacientes</router-link>
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/emergencia/mostrar_visualizacion_emergencia'
            "
            class="nav-link"
          >Visualización de emergencias</router-link>
        </nav>
      </div>
      <!-- Menu Farmacia -->
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseFarmacia"
        aria-expanded="false"
        aria-controls="pagesCollapseFarmacia"
      >
        <i class="fas fa-folder-plus"></i>
        Administración de Farmacia
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseFarmacia"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/farmacia/mostrar_farmacia'
                    "
            class="nav-link"
          >Farmacia</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/asociacion_de_farmacia/mostrar_asociacion_farmacia'
                    "
            class="nav-link"
          >Asociación de Farmacia</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/categoria/mostrar_categoria'
                    "
            class="nav-link"
          >Categoria</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/productos/mostrar_productos'
                    "
            class="nav-link"
          >Productos</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/presentaciones/mostrar_presentaciones'
                    "
            class="nav-link"
          >Presentaciones</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/presentaciones/mostrar_presentacion_productos'
                    "
            class="nav-link"
          >Asociar Productos y Presentaciones</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/tipo_movimiento/mostrar_tipo_movimiento'
                    "
            class="nav-link"
          >Tipo de Movimiento</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/movimiento_producto/mostrar_movimiento_productos'
                    "
            class="nav-link"
          >Movimiento de Productos</router-link>
        </nav>
      </div>
      <!-- Fin Menu Farmacia -->
      <!-- Menu Generar Formulario MSP -->
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseFormularioMSP"
        aria-expanded="false"
        aria-controls="pagesCollapseFormularioMSP"
      >
        <i class="far fa-file-alt"></i>
        Formulario MSP
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseFormularioMSP"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/formulario_msp/mostrar_formulario_msp'
                    "
            class="nav-link"
          >Generar Formulario MSP</router-link>
        </nav>
      </div>
      <!-- Fin Menu Generar Formulario MSP -->
      
    </nav>
    <!-- Rol ADMINISTRATIVO -->
    <nav
      class="sb-sidenav-menu-nested nav accordion"
      id="sidenavAccordionPages"
      v-else-if="
                                    idRol == 'ADMINISTRATIVO' 
                            "
    >
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapsePacientes"
        aria-expanded="false"
        aria-controls="pagesCollapsePacientes"
      >
        <i class="fas fa-user-edit"></i>
        Pacientes
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapsePacientes"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_tipos_parentesco'
                                        "
            class="nav-link"
          >Tipo Parentesco</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_parentescos'
                                        "
            class="nav-link"
          >Parentesco</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_usuarios_patentesco'
                                        "
            class="nav-link"
          >Usuario Parentesco</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_lugares_de_trabajo'
                                        "
            class="nav-link"
          >Lugares De Trabajo</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_ocupaciones'
                                        "
          >Ocupaciones</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_lugares_de_trabajo_usuario'
                                        "
            class="nav-link"
          >Lugares De Trabajo Usuario</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseSeguros"
        aria-expanded="false"
        aria-controls="pagesCollapseSeguros"
      >
        <i class="fas fa-user-edit"></i>
        Seguros
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseSeguros"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/seguros/disponibilidad'
                                        "
            class="nav-link"
          >Disponibiidad Seguros</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_aseguradoras'
                                        "
            class="nav-link"
          >Aseguradora</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_polizas'
                                        "
          >Póliza</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_beneficiarios'
                                        "
            class="nav-link"
          >Beneficiario</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapsePersonalMedico"
        aria-expanded="false"
        aria-controls="pagesCollapsePersonalMedico"
      >
        <i class="fa fa-user-md"></i>
        Personal Medico
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapsePersonalMedico"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/agenda'
                                        "
            class="nav-link"
          >Agenda Cita</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/jornadas'
                                        "
            class="nav-link"
          >Jornadas</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/personal_medico'
                                        "
            class="nav-link"
          >Personal Medico</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/tipo_trabajadores'
                                        "
            class="nav-link"
          >Tipos de Personal Medico</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/funciones_personal_medico'
                                        "
            class="nav-link"
          >Funciones de Personal Medico</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseAdministracionHospital"
        aria-expanded="false"
        aria-controls="pagesCollapseAdministracionHospital"
      >
        <i class="fas fa-hospital"></i>
        Administración de Hospital
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseAdministracionHospital"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/hopistales'
                                        "
            class="nav-link"
          >Hospitales</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/especialidades'
                                        "
            class="nav-link"
          >Especialidades</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/areas'
                                        "
            class="nav-link"
          >Areas</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/tipo_habitaciones'
                                        "
            class="nav-link"
          >Tipo de Habitaciones</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/habitaciones'
                                        "
            class="nav-link"
          >Habitaciones</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/tipo_camas'
                                        "
          >Tipo De Camas</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/camas'
                                        "
          >Camas</router-link>
        </nav>
      </div>
    </nav>
    <!-- Rol ADMISIONISTA -->
    <nav
      class="sb-sidenav-menu-nested nav accordion"
      id="sidenavAccordionPages"
      v-else-if="
                                    idRol == 'ADMISIONISTA'
                            "
    >
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapsePacientes"
        aria-expanded="false"
        aria-controls="pagesCollapsePacientes"
      >
        <i class="fas fa-user-edit"></i>
        Pacientes
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapsePacientes"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_tipos_parentesco'
                                        "
            class="nav-link"
          >Tipo Parentesco</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_parentescos'
                                        "
            class="nav-link"
          >Parentesco</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_usuarios_patentesco'
                                        "
            class="nav-link"
          >Usuario Parentesco</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_lugares_de_trabajo'
                                        "
            class="nav-link"
          >Lugares De Trabajo</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_ocupaciones'
                                        "
          >Ocupaciones</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_lugares_de_trabajo_usuario'
                                        "
            class="nav-link"
          >Lugares De Trabajo Usuario</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseSeguros"
        aria-expanded="false"
        aria-controls="pagesCollapseSeguros"
      >
        <i class="fas fa-user-edit"></i>
        Seguros
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseSeguros"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/seguros/disponibilidad'
                                        "
            class="nav-link"
          >Disponibiidad Seguros</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/generalidades/mostrar_aseguradoras'
                                        "
            class="nav-link"
          >Aseguradora</router-link>
          <router-link
            class="nav-link"
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_polizas'
                                        "
          >Póliza</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/pacientes/mostrar_beneficiarios'
                                        "
            class="nav-link"
          >Beneficiario</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseAdministracionCitas"
        aria-expanded="false"
        aria-controls="pagesCollapseAdministracionCitas"
      >
        <i class="fas fa-calendar"></i>
        Gestión de admisiones
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseAdministracionCitas"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_citas/mostrar_admisiones'
                                        "
            class="nav-link"
          >Admisiones</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_citas/mostrar_documentos_citas'
                                        "
            class="nav-link"
          >Documentos Cita</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_citas/mostrar_documentos_usuarios'
                                        "
            class="nav-link"
          >Documentos Usuario</router-link>
    
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseConsultaExterna"
        aria-expanded="false"
        aria-controls="pagesCollapseConsultaExterna"
      >
        <i class="fas fa-user-nurse"></i>
        Consulta Externa
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseConsultaExterna"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_asignacion_consulta_externa'
            "
            class="nav-link"
          >Asignación de consulta externa a pacientes</router-link>
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_visualizacion_consulta_externa'
            "
            class="nav-link"
          >Visualización de consultas externas</router-link>
          <router-link
            :to="
                                           prefijo +
                                                '/gestion_hospitalaria/consulta_externa/jornadas'
                                        "
            class="nav-link"
          >Horarios de medicos</router-link>
          <router-link
            :to="
                                            prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_preparacion_del_paciente'
            "
            class="nav-link"
          >Preparación del paciente</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseEmergencia"
        aria-expanded="false"
        aria-controls="pagesCollapseEmergencia"
      >
        <i class="fas fa-first-aid"></i>
        Emergencia
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseEmergencia"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/emergencia/mostrar_asignacion_emergencia'
            "
            class="nav-link"
          >Asignación de emergencia a pacientes</router-link>
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/emergencia/mostrar_visualizacion_emergencia'
            "
            class="nav-link"
          >Visualización de emergencias</router-link>
        </nav>
      </div>

    </nav>
    <nav
      class="sb-sidenav-menu-nested nav accordion"
      id="sidenavAccordionPages"
      v-else-if="
                                    idRol == 'FARMACIA' 
                            "
    >
      <!-- Menu Farmacia -->
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseFarmacia"
        aria-expanded="false"
        aria-controls="pagesCollapseFarmacia"
      >
        <i class="fas fa-folder-plus"></i>
        Administración de Farmacia
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseFarmacia"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/farmacia/mostrar_farmacia'
                    "
            class="nav-link"
          >Farmacia</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/asociacion_de_farmacia/mostrar_asociacion_farmacia'
                    "
            class="nav-link"
          >Asociación de Farmacia</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/categoria/mostrar_categoria'
                    "
            class="nav-link"
          >Categoria</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/productos/mostrar_productos'
                    "
            class="nav-link"
          >Productos</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/tipo_movimiento/mostrar_tipo_movimiento'
                    "
            class="nav-link"
          >Tipo de Movimiento</router-link>
          <router-link
            :to="
                        prefijo +
                            '/gestion_hospitalaria/administracion_de_farmacia/movimiento_producto/mostrar_movimiento_productos'
                    "
            class="nav-link"
          >Movimiento de Productos</router-link>
        </nav>
      </div>
      <!-- Fin Menu Farmacia -->
    </nav>
    <nav
      class="sb-sidenav-menu-nested nav accordion"
      id="sidenavAccordionPages"
      v-else-if="
                                    idRol == 'MEDICO'"
    >
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapsePersonalMedico"
        aria-expanded="false"
        aria-controls="pagesCollapsePersonalMedico"
      >
        <i class="fa fa-user-md"></i>
        Personal Medico
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapsePersonalMedico"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/agenda'
                                        "
            class="nav-link"
          >Agenda Cita</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/jornadas'
                                        "
            class="nav-link"
          >Jornadas</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/personal_medico'
                                        "
            class="nav-link"
          >Personal Medico</router-link>

          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/tipo_trabajadores'
                                        "
            class="nav-link"
          >Tipos de Personal Medico</router-link>
          <router-link
            :to="
                                            prefijo +
                                                '/gestion_hospitalaria/administracion_de_hospital/funciones_personal_medico'
                                        "
            class="nav-link"
          >Funciones de Personal Medico</router-link>
        </nav>
      </div>

      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseConsultaExterna"
        aria-expanded="false"
        aria-controls="pagesCollapseConsultaExterna"
      >
        <i class="fas fa-user-nurse"></i>
        Consulta Externa
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseConsultaExterna"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_asignacion_consulta_externa'
            "
            class="nav-link"
          >Asignación de consulta externa a pacientes</router-link>
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_visualizacion_consulta_externa'
            "
            class="nav-link"
          >Visualización de consultas externas</router-link>
          <router-link
            :to="
                                           prefijo +
                                                '/gestion_hospitalaria/consulta_externa/jornadas'
                                        "
            class="nav-link"
          >Horarios de medicos</router-link>
          <router-link
            :to="
                                            prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_preparacion_del_paciente'
            "
            class="nav-link"
          >Preparación del paciente</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseEmergencia"
        aria-expanded="false"
        aria-controls="pagesCollapseEmergencia"
      >
        <i class="fas fa-first-aid"></i>
        Emergencia
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseEmergencia"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/emergencia/mostrar_asignacion_emergencia'
            "
            class="nav-link"
          >Asignación de emergencia a pacientes</router-link>
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/emergencia/mostrar_visualizacion_emergencia'
            "
            class="nav-link"
          >Visualización de emergencias</router-link>
        </nav>
      </div>
    </nav>
    <nav
      class="sb-sidenav-menu-nested nav accordion"
      id="sidenavAccordionPages"
      v-else-if="
                                    idRol == 'ENFERMERA'"
    >
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseConsultaExterna"
        aria-expanded="false"
        aria-controls="pagesCollapseConsultaExterna"
      >
        <i class="fas fa-user-nurse"></i>
        Consulta Externa
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseConsultaExterna"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_visualizacion_consulta_externa'
            "
            class="nav-link"
          >Visualización de consultas externas</router-link>
          <router-link
            :to="
                                           prefijo +
                                                '/gestion_hospitalaria/consulta_externa/jornadas'
                                        "
            class="nav-link"
          >Horarios de medicos</router-link>
          <router-link
            :to="
                                            prefijo +
                    '/gestion_hospitalaria/consulta_externa/mostrar_preparacion_del_paciente'
            "
            class="nav-link"
          >Preparación del paciente</router-link>
        </nav>
      </div>
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#pagesCollapseEmergencia"
        aria-expanded="false"
        aria-controls="pagesCollapseEmergencia"
      >
        <i class="fas fa-first-aid"></i>
        Emergencia
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>
      <div
        class="collapse"
        id="pagesCollapseEmergencia"
        aria-labelledby="headingOne"
        data-parent="#sidenavAccordionPages"
      >
        <nav class="sb-sidenav-menu-nested nav">
          <router-link
            :to="
                prefijo +
                    '/gestion_hospitalaria/emergencia/mostrar_visualizacion_emergencia'
            "
            class="nav-link"
          >Visualización de emergencias</router-link>
        </nav>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  props: {
    idRol: {
      type: String,
    },
    prefijo: {
      type: String,
    },
  },
};
</script>