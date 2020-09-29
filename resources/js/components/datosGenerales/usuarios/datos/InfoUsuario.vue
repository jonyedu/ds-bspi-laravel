<template>
  <div class="row m-3">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <center>
        <h5 class="mt-4">Datos Extra Usuario</h5>
      </center>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="col-lg-12 col-md-12 col-sm-12 p-5">
          <form>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="email">Correo Electrónico</label>
                  <input
                    :readonly="true"
                    type="text"
                    :class="'form-control'"
                    id="email"
                    v-model="usuario.US_EMAIL"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="email2">Correo Electrónico Alternativo</label>
                  <input
                    :readonly="true"
                    type="text"
                    :class="'form-control'"
                    id="email2"
                    v-model="usuario.US_EMAIL2"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="direccion">Dirección</label>
                  <input
                    :readonly="true"
                    type="text"
                    :class="'form-control'"
                    id="direccion"
                    v-model="usuario.US_DIR"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="telefono">Teléfono</label>
                  <input
                    :readonly="true"
                    type="text"
                    :class="'form-control'"
                    id="telefono"
                    v-model="usuario.US_TELF"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="celular">Celular</label>
                  <input
                    :readonly="true"
                    type="text"
                    :class="'form-control'"
                    id="celular"
                    v-model="usuario.US_CEL"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="activo">Activo</label>
                  <input
                    :readonly="true"
                    type="text"
                    :class="'form-control'"
                    id="activo"
                    v-model="usuario.US_ACTIVO"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="observacion">Observación</label>
                  <input
                    :readonly="true"
                    type="text"
                    :class="'form-control'"
                    id="observacion"
                    v-model="usuario.US_OBS"
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
    usuario: {
      type: Object
    }
  },
  data: function() {
    return {};
  }
};
</script>
