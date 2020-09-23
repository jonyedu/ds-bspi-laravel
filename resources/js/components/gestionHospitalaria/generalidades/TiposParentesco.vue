<template>
  
    <maestra-general
      :activo-field="false"
      :columnas="columnas"
      :titulo="titulo"
      :url-cargar="urlCargar"
      :url-guardar="urlGuardar"
      :url-modificar="urlModificar"
      :url-eliminar="urlEliminar"
    ></maestra-general>
  
</template>
<script>
export default {
  data: function() {
    return {
      urlCargar: "/gestion_hospitalaria/generalidades/cargar_tipos_de_parentesco",
      urlModificar: "/gestion_hospitalaria/generalidades/modificar_tipo_de_parentesco",
      urlGuardar: "/gestion_hospitalaria/generalidades/guardar_tipo_de_parentesco",
      urlEliminar: "/gestion_hospitalaria/generalidades/eliminar_tipo_de_parentesco/",
      titulo: "TIPOS PARENTESCO",
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
      .generalidades.tiposParentesco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.tiposParentesco.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  }
};
</script>