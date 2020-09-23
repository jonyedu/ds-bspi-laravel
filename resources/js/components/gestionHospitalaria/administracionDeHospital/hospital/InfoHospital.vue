<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">HOSPITALES</h5>
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
                    v-model="hospital.HOSPITAL_NOM"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="contacto">Contacto</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="contacto"
                    placeholder="Ingrese el contacto"
                    v-model="hospital.HOSPITAL_EMAIL_CONTACTO"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="telefono">Telefono De Contacto</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="telefono"
                    placeholder="Ingrese El Telefono Del Contacto"
                    v-model="hospital.HOSPITAL_TELF_CONTACTO"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="correo">Correo Del Contacto</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="observacion"
                    placeholder="Ingrese El Correo Del Contacto"
                    v-model="hospital.HOSPITAL_EMAIL_CONTACTO"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="webpage">Pagina Web</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="webpage"
                    placeholder="Ingrese Pagina Web Del Hospital"
                    v-model="hospital.HOSPITAL_WEB_PAGE"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    :readonly="true"
                    type="text"
                    class="form-control"
                    id="observacion"
                    placeholder="Ingrese su observación"
                    v-model="hospital.HOSPITAL_OBS"
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
