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
        "/gestion_hospitalaria/personalMedico/cargar_tipo_personal_medico",
      urlModificar:
        "/gestion_hospitalaria/personalMedico/modificar_tipo_personal_medico",
      urlGuardar:
        "/gestion_hospitalaria/personalMedico/guardar_tipo_personal_medico",
      urlEliminar:
        "/gestion_hospitalaria/personalMedico/eliminar_tipo_personal_medico/",
      titulo: "TIPOS DE PERSONAL MEDICO"
    };
  },
  mounted: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.tiposDePersonalMedico.tipo_de_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .personalMedico.tiposDePersonalMedico.tipo_de_personal_medico.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  }
};
</script>