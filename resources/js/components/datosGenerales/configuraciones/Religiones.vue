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
      urlCargar: "/datos_generales/configuraciones/cargar_religiones",
      urlModificar: "/datos_generales/configuraciones/modificar_religion",
      urlGuardar: "/datos_generales/configuraciones/guardar_religion",
      urlEliminar: "/datos_generales/configuraciones/eliminar_religion/",
      titulo: "RELIGIONES"
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.religiones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.religiones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  }
};
</script>