<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Consultorio</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input
                    type="text"
                    :readonly="true"
                    class="form-control"
                    id="cicloInicial"
                    placeholder="Ingrese un nombre"
                    v-model="consultorio.CONSULTORIO_NOM"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="contacto">Area</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="contacto"
                    placeholder="Ingrese el contacto"
                    v-model="consultorio.AREA_NOM"
                  />
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="telefono">Medico Asignado</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="telefono"
                    placeholder="Ingrese El Telefono Del Contacto"
                    v-model="consultorio.MEDICO_NOM"
                  />
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="correo">Dias Asignados</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="observacion"
                    placeholder="Ingrese El Correo Del Contacto"
                    v-model="consultorio.JORNADATRABAJADOR_DIAS"
                  />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="webpage">Horario</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="webpage"
                    placeholder="Ingrese Pagina Web Del Hospital"
                    v-model="consultorio.JORNADATRABAJADOR_HORARIO"
                  />
                </div>
              </div>
              
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    consultorio: {
      type: Object
    }
  },
  data: function() {
    return {};
  }
};
</script>
