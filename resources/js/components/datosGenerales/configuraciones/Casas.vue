<template>
  <div class="col-sm-12 col-md-12 col-lg-12">
    <maestra-general
      :titulo="titulo"
      :url-cargar="urlCargar"
      :url-guardar="urlGuardar"
      :url-modificar="urlModificar"
      :url-eliminar="urlEliminar"
    ></maestra-general>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      urlCargar: "/datos_generales/configuraciones/cargar_casas",
      urlModificar: "/datos_generales/configuraciones/modificar_casa",
      urlGuardar: "/datos_generales/configuraciones/guardar_casa",
      urlEliminar: "/datos_generales/configuraciones/eliminar_casa/",
      titulo: "CASAS"
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.casas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.casas.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  }
};
</script>