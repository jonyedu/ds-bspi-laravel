<template>
  <div class="col-sm-12 col-md-12 col-lg-12">
    <maestra-general
      :titulo="titulo"
      :url-cargar="urlCargar"
      :url-guardar="urlGuardar"
      :url-modificar="urlModificar"
      :url-eliminar="urlEliminar"
      :activoField="false"
    ></maestra-general>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      urlCargar:
        "/gestion_hospitalaria/tipo_habitaciones/cargar_tipo_habitaciones",
      urlModificar:
        "/gestion_hospitalaria/tipo_habitaciones/modificar_tipo_habitaciones",
      urlGuardar:
        "/gestion_hospitalaria/tipo_habitaciones/guardar_tipo_habitaciones",
      urlEliminar:
        "/gestion_hospitalaria/tipo_habitaciones/eliminar_tipo_habitaciones/",
      titulo: "TIPOS DE HABITACIONES"
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.tipo_habitaciones.tipo_habitaciones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.tipo_habitaciones.tipo_habitaciones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  }
};
</script>