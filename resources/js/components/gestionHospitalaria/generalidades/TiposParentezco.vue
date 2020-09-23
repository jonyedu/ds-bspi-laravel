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
      urlCargar: "/gestion_hospitalaria/generalidades/cargar_tipos_de_parentezco",
      urlModificar: "/gestion_hospitalaria/generalidades/modificar_tipo_de_parentezco",
      urlGuardar: "/gestion_hospitalaria/generalidades/guardar_tipo_de_parentezco",
      urlEliminar: "/gestion_hospitalaria/generalidades/eliminar_tipo_de_parentezco/",
      titulo: "TIPOS PARENTEZCO",
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
      .generalidades.tiposParentezco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.tiposParentezco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  }
};
</script>