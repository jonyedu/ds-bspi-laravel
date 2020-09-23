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
      urlCargar: "/gestion_hospitalaria/tipo_camas/cargar_tipo_camas",
      urlModificar: "/gestion_hospitalaria/tipo_camas/modificar_tipo_camas",
      urlGuardar: "/gestion_hospitalaria/tipo_camas/guardar_tipo_camas",
      urlEliminar: "/gestion_hospitalaria/tipo_camas/eliminar_tipo_camas/",
      titulo: "TIPOS DE CAMAS"
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.tipo_camas.tipo_camas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .administracion_de_hospital.tipo_camas.tipo_camas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  }
};
</script>