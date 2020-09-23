<template>
  <div class="col-sm-12 col-md-12 col-lg-12">
    <maestra-general
      :activo-field="false"
      :columnas="columnas"
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
      urlCargar: "/gestion_hospitalaria/generalidades/cargar_ocupaciones",
      urlModificar: "/gestion_hospitalaria/generalidades/modificar_ocupacion",
      urlGuardar: "/gestion_hospitalaria/generalidades/guardar_ocupacion",
      urlEliminar: "/gestion_hospitalaria/generalidades/eliminar_ocupacion/",
      titulo: "OCUPACIONES",
      columnas:[
        {
          label: "Nombre",
          field: "nombre",
          type: "String"
        },
        
        {
          label: "Observación",
          field: "observacion",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.ocupaciones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.ocupaciones.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  }
};
</script>