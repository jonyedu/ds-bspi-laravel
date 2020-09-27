<template>
  <div class="row">
    <!-- Seccion del Titulo -->
    <div class="col-md-12">
      <h1 class="float-left">Movimiento de Productos</h1>
    </div>
    <!-- Inicio Información del Movimiento -->
    <div class="col-md-12">
      <!-- general form elements disabled -->
      <div class="card">
        <div class="card-header" style="background-color:#C2C2C2;color:#000000;">
          <h5 class="card-title">Información del Movimiento</h5>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form role="form">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="fecha_cita">Fecha de la Transacción</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Seleccione la fecha de cita"
                    v-model="form.frm_fecha_transaccion"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="tipo"><label class="text-danger">(*)</label> Tipo de Movimiento</label>
                  <v-select
                    v-model="selectedTipoMovimiento"
                    :value="form.frm_tipo_movimiento_cod"
                    :options="tipoMovimiento"
                    label="display"
                    @input="setSelectedTipoMovimiento"
                    v-bind:class="{
                                            disabled:
                                                disabledTipoMovimiento != false
                                        }"
                  >
                    <template slot="no-options">No se ha encontrado ningun dato</template>
                  </v-select>
                </div>
              </div>
              <div
                class="col-sm-4"
                v-if="
                                    form.frm_tipo_movimiento_abrev == 'EGR' ||
                                        form.frm_tipo_movimiento_abrev == 'TRA'
                                "
              >
                <div class="form-group">
                  <label for="tipo"><label class="text-danger">(*)</label> Farmacia Orígen</label>
                  <v-select
                    v-model="selectedFarmaciaOrigen"
                    :value="form.frm_farmacia_cod_origen"
                    :options="farmaciaOrigen"
                    label="display"
                    @input="setSelectedFarmacia"
                    v-bind:class="{
                                            disabled:
                                                disabledFarmaciaOrigen != false
                                        }"
                  >
                    <template slot="no-options">No se ha encontrado ningun dato</template>
                  </v-select>
                </div>
              </div>
              <div
                class="col-sm-4"
                v-if="
                                    form.frm_tipo_movimiento_abrev == 'ING' ||
                                        form.frm_tipo_movimiento_abrev == 'TRA'
                                "
              >
                <div class="form-group">
                  <label for="tipo"><label class="text-danger">(*)</label> Farmacia Destino</label>
                  <v-select
                    v-model="selectedFarmaciaDestino"
                    :value="form.frm_farmacia_cod_destino"
                    :options="farmaciaDestino"
                    label="display"
                    @input="setSelectedFarmacia"
                    v-bind:class="{
                                            disabled:
                                                disabledFarmaciaDestino != false
                                        }"
                  >
                    <template slot="no-options">No se ha encontrado ningun dato</template>
                  </v-select>
                </div>
              </div>
            </div>
            <div class="row"></div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="tipo">Descripción</label>
                  <textarea
                    type="text"
                    class="form-control"
                    placeholder="Descripción del Movimiento...."
                    rows="2"
                    v-model="form.frm_descripcion"
                  />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Fin Información del Movimiento -->
    &nbsp;
    <!-- Inicio Productos -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" style="background-color:#C2C2C2;color:#000000;">
          <h5 class="card-title">Productos</h5>
        </div>
        <div class="card-body">
          <form role="form">
            <div class="row">
              <!-- Categoria -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="tipo"><label class="text-danger">(*)</label> Categoría</label>
                  <v-select
                    v-model="selectedCategoria"
                    :value="form.frm_categoria_cod"
                    :options="categoria"
                    label="display"
                    v-bind:class="{
                                            disabled: disabledProducto != false
                                        }"
                    @input="setSelectedCategoria"
                  >
                    <template slot="no-options">No se ha encontrado ningun dato</template>
                  </v-select>
                </div>
              </div>
              <!-- Productos -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="tipo"><label class="text-danger">(*)</label> Productos</label>
                  <v-select
                    v-model="selectedProductos"
                    :value="form.frm_productos_cod"
                    :options="productos"
                    label="display"
                    v-bind:class="{
                                            disabled: disabledProducto != false
                                        }"
                    @input="setSelectedProductos"
                  >
                    <template slot="no-options">No se ha encontrado ningun dato</template>
                  </v-select>
                </div>
              </div>
              <!-- PresentacionProductos -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="tipo"><label class="text-danger">(*)</label> Presentación de Producto</label>
                  <v-select
                    v-model="selectedPresentacionProducto"
                    :options="presentacionproductos"
                    label="PRESENTACION_FULL"
                    v-bind:class="{
                                            disabled: disabledProducto != false
                                        }"
                    @input="setSelectedPresentacionProducto"
                  >
                    <template slot="no-options">No se ha encontrado ningun dato</template>
                  </v-select>
                </div>
              </div>
              <!-- Cantidad -->
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="tipo"><label class="text-danger">(*)</label> Cantidad</label>
                  <input
                    type="number"
                    class="form-control"
                    v-model="form.frm_cantidad"
                    placeholder="Cantidad"
                  />
                </div>
              </div>
              <!-- Stock Actual -->
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="tipo">Stock</label>
                  <input type="number" class="form-control" v-model="form.frm_stockActual" disabled />
                </div>
              </div>
              <!-- Boton Añadir -->
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <div>
                    <button type="button" class="btn btn-success" @click="añadirProductos()">
                      <i class="fas fa-plus-circle"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <vuetable-component
                  :anular-button="true"
                  :modificar-button="false"
                  :derivar-button="false"
                  :columns-data="productosColumn"
                  :rows-data="productosData"
                  @handleAnularClick="anularProductosClick"
                  @handleInputEdit="actualizarCantidad"
                  :input-edit="true"
                ></vuetable-component>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        <label></label>
        <div>
          <button type="button" class="btn btn-success btn-block" @click="guardarActualizar()">
            {{
            this.objetoMod != null
            ? "Modificar Movimiento"
            : "Guardar Movimiento"
            }}
          </button>
        </div>
      </div>
    </div>

    <!-- Fin Productos -->
  </div>
</template>
<script>
export default {
  props: {
    objetoMod: {
      type: Object,
    },
    idHospital: {
      type: Number,
    },
  },
  data: function () {
    return {
      //Variables para habilitar/deshabilitar los componentes
      disabledTipoMovimiento: false,
      disabledFarmaciaOrigen: false,
      disabledFarmaciaDestino: false,
      disabledTipoMovimiento: false,
      disabledProducto: true,

      //Variables para los ComboBox
      selectedTipoMovimiento: "",
      selectedFarmaciaOrigen: "",
      selectedFarmaciaDestino: "",
      selectedCategoria: "",
      selectedProductos: "",
      selectedPresentacionProducto: "",

      //Variables de arreglo para lo ComboBox
      tipoMovimiento: [],
      farmaciaOrigen: [],
      farmaciaDestino: [],
      categoria: [],
      productos: [],
      presentacionproductos: [],

      //Variables para la Tabla
      cantidadArray: 0,
      productosColumn: [
        {
          label: "Descripción",
          field: "col_producto",
          type: "String",
          width: "45%",
        },
        {
          label: "Stock Actual",
          field: "col_stockActual",
          type: "String",
        },
      ],
      productosData: [],

      //Variables para el formulario
      form: {
        frm_fecha_transaccion: "",
        frm_movimiento_producto_cod: "",
        frm_farmacia_cod_destino: "",
        frm_farmacia_cod_origen: "",
        frm_categoria_cod: "",
        frm_productos_cod: "",
        frm_stockActual: "",
        frm_tipo_movimiento_cod: "",
        frm_tipo_movimiento_abrev: "",
        frm_cantidad: "",
        frm_descripcion: "",
        frm_detalle_movimiento_cod: "",
        frm_producto_detalle_cod: "",
        frm_producto_cod: "",
        frm_presentacionproducto_cod: "",
        frm_reserva_stock: "",
      },
    };
  },
  mounted: function () {
    this.setSelectedTipoMovimiento();
    this.setSelectedFarmacia();
    this.setSelectedCategoria();
    this.obtenerFechaActual();
    if (this.$props.objetoMod !== null) {
      let objeto = this.$props.objetoMod;
    }
    //this.form.tipo = "PU";
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.aseguradoras.crear_aseguradoras.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function () {
    let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
    let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
      .generalidades.aseguradoras.crear_aseguradoras.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    //Metodo para actualizar la cantidad cada vez que se cambie en la tabla
    actualizarCantidad: function (value) {
      for (let i = 0; i < this.productosData.length; i++) {
        if (
          this.productosData[i].col_productos_cod == value.col_productos_cod
        ) {
          this.productosData[i].col_cantidad = value.col_cantidad;
        }
      }
    },
    //Metodo para obtener la fecha actual y añadir al input de fecha
    obtenerFechaActual: function () {
      var date = new Date();
      //Año
      var y = date.getFullYear();
      //Mes
      var m = date.getMonth() + 1;
      //Día
      var d = date.getDate();

      //Lo ordenas a gusto.
      var fechaActual = y + "-" + m + "-" + d;
      this.form.frm_fecha_transaccion = fechaActual;
    },
    //Metodos para obtener y agregar datos a los comboBox
    setSelectedTipoMovimiento(value) {
      let that = this;
      var loader = that.$loading.show();
      let url =
        "/gestion_hospitalaria/administracion_farmacia/cargar_tipo_movimiento";
      this.selectedFarmaciaOrigen = "";
      this.selectedFarmaciaDestino = "";
      this.form.frm_farmacia_cod_origen = "";
      this.form.frm_farmacia_cod_destino = "";
      this.form.frm_stockActual = "";
      if (this.selectedTipoMovimiento == null) {
        this.form.frm_tipo_movimiento_cod = "";
        this.form.frm_tipo_movimiento_abrev = "";
        this.disabledProducto = true;
        this.selectedCategoria = "";
        this.selectedProductos = "";
        this.form.frm_stockActual = "";
      }
      if (value != null) {
        if (value.tipo_movimiento_cod != null) {
          this.form.frm_tipo_movimiento_cod = value.tipo_movimiento_cod;
          this.form.frm_tipo_movimiento_abrev = value.tipo_movimiento_abrev;
          this.selectedCategoria = "";
          this.form.frm_categoria_cod = "";
          this.selectedProductos = "";
          this.form.frm_productos_cod = "";
          this.form.frm_stockActual = "";
        }
      }
      axios
        .get(url)
        .then(function (response) {
          let tipoMovimiento = [];
          response.data.tipoMovimiento.forEach((tipoMovimientos) => {
            let objeto = {};
            objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(tipoMovimientos.TIPOMOVIMIENTO_NOMBRE);
            objeto.tipo_movimiento_cod = tipoMovimientos.TIPOMOVIMIENTO_COD;
            objeto.tipo_movimiento_abrev = tipoMovimientos.TIPOMOVIMIENTO_ABREVIATURA;

            tipoMovimiento.push(objeto);
          });
          that.tipoMovimiento = tipoMovimiento;
          loader.hide();
        })
        .catch((error) => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
          loader.hide();
        });
    },
    setSelectedFarmacia(value) {
      let that = this;
      //this.form.frm_idHospital = this.$props.idHospital;
      this.form.frm_idHospital = 1;
      var loader = that.$loading.show();
      let url =
        "/gestion_hospitalaria/administracion_farmacia/cargar_asociacion_farmacia_por_id/" +
        this.form.frm_idHospital;
      if (this.selectedFarmaciaOrigen == null) {
        this.form.frm_farmacia_cod_origen = "";
        this.disabledProducto = true;
        this.selectedCategoria = "";
        this.selectedProductos = "";
        this.form.frm_stockActual = "";
      }
      if (this.selectedFarmaciaDestino == null) {
        this.form.frm_farmacia_cod_destino = "";
        this.disabledProducto = true;
        this.selectedCategoria = "";
        this.selectedProductos = "";
        this.form.frm_stockActual = "";
      }
      if (value != null) {
        if (value.farmacia_cod_destino != null) {
          this.form.frm_farmacia_cod_destino = value.farmacia_cod_destino;
          this.disabledProducto = false;
          this.selectedCategoria = "";
          this.selectedProductos = "";
          this.form.frm_stockActual = "";
        }
        if (value.farmacia_cod_origen != null) {
          this.form.frm_farmacia_cod_origen = value.farmacia_cod_origen;
          this.disabledProducto = false;
          this.selectedCategoria = "";
          this.selectedProductos = "";
          this.form.frm_stockActual = "";
        }
      }
      axios
        .get(url)
        .then(function (response) {
          let farmaciaOrigen = [];
          response.data.asociacionFarmaciaPorId.forEach((farmaciasOrigen) => {
            let objeto = {};
            objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(farmaciasOrigen.farmacia.FARMACIA_NOM);
            objeto.farmacia_cod_origen = farmaciasOrigen.farmacia.FARMACIA_COD;
            farmaciaOrigen.push(objeto);
          });
          that.farmaciaOrigen = farmaciaOrigen;

          let farmaciaDestino = [];
          response.data.asociacionFarmaciaPorId.forEach((farmaciasDestino) => {
            let objeto = {};
            objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(farmaciasDestino.farmacia.FARMACIA_NOM);
            objeto.farmacia_cod_destino =
              farmaciasDestino.farmacia.FARMACIA_COD;
            farmaciaDestino.push(objeto);
          });
          that.farmaciaDestino = farmaciaDestino;
          loader.hide();
        })
        .catch((error) => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
          loader.hide();
        });
    },
    setSelectedCategoria(value) {
      if (this.selectedCategoria == null) {
        this.form.frm_categoria_cod = "";
        this.selectedProductos = "";
        this.form.frm_productos_cod = "";
        this.form.frm_stockActual = "";
      }
      let that = this;
      var loader = that.$loading.show();
      let url =
        "/gestion_hospitalaria/administracion_farmacia/cargar_categoria";
      if (value != null) {
        this.form.frm_categoria_cod = value.categoria_cod;
        this.selectedProductos = "";
        this.form.frm_productos_cod = "";
        this.form.frm_stockActual = "";
      }
      axios
        .get(url)
        .then(function (response) {
          let categoria = [];
          response.data.categoria.forEach((categorias) => {
            let objeto = {};
            objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(categorias.CATEGORIA_NOM);
            objeto.categoria_cod = categorias.CATEGORIA_COD;
            categoria.push(objeto);
          });
          that.categoria = categoria;
          that.setSelectedProductos();
          loader.hide();
        })
        .catch((error) => {
          //Errores
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
          loader.hide();
        });
    },
    setSelectedProductos(value) {
      if (this.selectedProductos == null) {
        this.form.frm_productos_cod = "";
        this.form.frm_stockActual = "";
      }
      if (value != null) {
        this.form.frm_productos_cod = value.productos_cod;
        this.form.frm_stockActual = "";
      }
      if (this.form.frm_categoria_cod != "") {
        let that = this;
        //var loader = that.$loading.show();
        let url =
          "/gestion_hospitalaria/administracion_farmacia/cargar_producto_por_id/" +
          this.form.frm_categoria_cod;

        axios
          .get(url)
          .then(function (response) {
            let productos = [];
            response.data.productos.forEach((producto) => {
              let objeto = {};
              objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(producto.PRODUCTO_NOM);
              objeto.productos_cod = producto.PRODUCTO_COD;
              productos.push(objeto);
            });
            that.productos = productos;
            that.presentacionproductos = response.data.presentacionproductos;
            //loader.hide();
          })
          .catch((error) => {
            //Errores
            that.$swal({
              icon: "error",
              title: "Existe un error",
              text: error,
            });
            //loader.hide();
          });
      }
    },
    setSelectedPresentacionProducto(value) {
      if (value !== null) {
        this.form.frm_presentacionproducto_cod = this.selectedPresentacionProducto.PRESENTACIONPRODUCTO_COD;
        if (this.form.frm_tipo_movimiento_abrev != "ING") {
          this.cargarStockActual();
        }
      } else {
        this.form.frm_presentacionproducto_cod = "";
      }
    },
    //Metodo para cargar el Stock Actual del producto seleccionado
    cargarStockActual: function () {
      if (this.form.frm_productos_cod != "") {
        let that = this;
        let url =
          "/gestion_hospitalaria/administracion_farmacia/cargar_stock_producto/" +
          this.form.frm_presentacionproducto_cod +
          "/" +
          this.form.frm_farmacia_cod_origen;
        //var loader = that.$loading.show();
        axios
          .get(url)
          .then(function (response) {
            if (response.data.stockActual != null) {
              that.form.frm_stockActual =
                response.data.stockActual.PRODUCTO_DETALLE_STOCK;
            } else {
              that.form.frm_stockActual = 0;
            }
            //loader.hide();
          })
          .catch((error) => {
            //Errores
            //loader.hide();
          });
      }
    },
    //Metodo para saber el Total de Item
    dimensionArray: function () {
      this.cantidadArray = this.productosData.length + 1;
    },
    //Metodo para añadir los datos a la tabla
    añadirProductos: function () {
      //Se valida para que elija el tipo de movimiento, antes de añadir productos a la tabla
      if (this.form.frm_fecha_transaccion == "") {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text: "Por favor elija una fecha realizar el movimiento de productos",
        });
        return;
      }
      //Se valida para que elija el tipo de movimiento, antes de añadir productos a la tabla
      if (this.form.frm_tipo_movimiento_abrev == "") {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text:
            "Por favor elija el 'Tipo de Movimiento' antes de añadir productos a la tabla",
        });
        return;
      }
      //Se valida cuando no haya seleccionado la farmacia de origen
      if (
        this.form.frm_tipo_movimiento_abrev != "" &&
        this.form.frm_tipo_movimiento_abrev == "EGR" &&
        this.form.frm_farmacia_cod_origen == ""
      ) {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text: "Se necesita la Farmacia de Origen",
        });
        return;
      }
      //Se valida cuando no haya seleccionado la farmacia de destino
      if (
        this.form.frm_tipo_movimiento_abrev != "" &&
        this.form.frm_tipo_movimiento_abrev == "ING" &&
        this.form.frm_farmacia_cod_destino == ""
      ) {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text: "Se necesita la Farmacia de Destino",
        });
        return;
      }
      //Se valida cuando no haya seleccionado la farmacia de origen y destino
      if (
        this.form.frm_tipo_movimiento_abrev != "" &&
        this.form.frm_tipo_movimiento_abrev == "TRA"
      ) {
        if (this.form.frm_farmacia_cod_origen == "") {
          this.$swal({
            icon: "error",
            title: "Existe un error",
            text: "Se necesita la Farmacia de Origen",
          });
          return;
        }
        if (this.form.frm_farmacia_cod_destino == "") {
          this.$swal({
            icon: "error",
            title: "Existe un error",
            text: "Se necesita la Farmacia de Destino",
          });
          return;
        }
      }
      //Se valida cuando la farmacia de origen y destino son las mismas
      if (
        this.form.frm_farmacia_cod_origen == this.form.frm_farmacia_cod_destino
      ) {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text: "La Farmacia de Origen, no puede ser a la Farmacia de Destino",
        });
        return;
      }
      if (this.form.frm_cantidad == "") {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text: "Se necesita la Cantidad para el Producto",
        });
        return;
      }
      if (this.form.frm_cantidad <= 0) {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text: "Se necesita que la Cantidad sea mayor a 0",
        });
        return;
      }
      if (this.form.frm_categoria_cod == "") {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text: "Se necesita una categoria para añadir a la tabla",
        });
        return;
      }
      if (this.form.frm_productos_cod == "") {
        this.$swal({
          icon: "error",
          title: "Existe un error",
          text: "Se necesita un producto para añadir a la tabla",
        });
        return;
      }
      //Otra forma de validar el stock sidponible
      let that = this;
      //var loader = that.$loading.show();
      if (this.form.frm_tipo_movimiento_abrev != "ING") {
        let url =
          "/gestion_hospitalaria/administracion_farmacia/validar_stock_producto/" +
          this.form.frm_presentacionproducto_cod +
          "/" +
          this.form.frm_farmacia_cod_origen +
          "/" +
          this.form.frm_cantidad;
        axios
          .get(url)
          .then(function (response) {
            that.dimensionArray();
            let encontrado = false;

            if (that.productosData.length > 0) {
              for (let i = 0; i < that.productosData.length; i++) {
                let producto = that.productosData[i];
                if (
                  producto.col_presentacionproducto_cod ==
                  that.form.frm_presentacionproducto_cod
                ) {
                  encontrado = true;
                  break;
                }
              }
            }
            //Si no existe en la tabla, se agrega los productos.

            if (!encontrado) {
              that.disabledTipoMovimiento = true;
              that.disabledFarmaciaOrigen = true;
              that.disabledFarmaciaDestino = true;
              that.productosData.push({
                col_presentacionproducto_cod:
                  that.form.frm_presentacionproducto_cod,
                col_cantidadArray: that.cantidadArray,
                col_productos_cod: that.form.frm_productos_cod,
                col_cantidad: that.form.frm_cantidad,
                col_producto:
                  that.selectedProductos.display +
                  " " +
                  that.selectedPresentacionProducto.PRESENTACION_FULL,
                col_stockActual: that.form.frm_stockActual,
                col_farmacia: that.selectedFarmaciaOrigen.display,
              });
              that.form.frm_cantidad = "";
              that.selectedCategoria.display = null;
              that.selectedProductos.display = null;
              that.form.frm_stockActual = "";
              that.selectedPresentacionProducto = null;
              that.form.frm_presentacionproducto_cod = "";
            }
          })
          .catch((error) => {
            //Errores
            if (error.response.status == 421) {
              that.$swal({
                icon: "error",
                title: "existe un error",
                text: error.response.data.msg,
              });
            }
          });
      } else {
        //Se valida que los productos no exista previamente.
        that.dimensionArray();
        let encontrado = false;
        if (this.productosData.length > 0) {
          for (let i = 0; i < this.productosData.length; i++) {
            let producto = this.productosData[i];
            if (
              producto.col_presentacionproducto_cod ==
              this.form.frm_presentacionproducto_cod
            ) {
              encontrado = true;
              break;
            }
          }
        }
        //Si no existe en la tabla, se agrega los productos.
        if (!encontrado) {
          this.disabledTipoMovimiento = true;
          this.disabledFarmaciaOrigen = true;
          this.disabledFarmaciaDestino = true;
          if (this.form.frm_stockActual == "") {
            this.form.frm_stockActual = 0;
          }
          this.productosData.push({
            col_cantidadArray: this.cantidadArray,
            col_productos_cod: this.form.frm_productos_cod,
            col_presentacionproducto_cod: this.form
              .frm_presentacionproducto_cod,
            col_cantidad: this.form.frm_cantidad,
            col_producto:
              this.selectedProductos.display +
              " " +
              that.selectedPresentacionProducto.PRESENTACION_FULL,
            col_stockActual: this.form.frm_stockActual,
            col_farmacia: this.selectedFarmaciaOrigen.display,
          });
          this.form.frm_cantidad = "";
          this.selectedCategoria.display = null;
          this.selectedProductos.display = null;
          this.form.frm_stockActual = "";
          this.selectedPresentacionProducto = null;
          this.form.frm_presentacionproducto_cod = "";
        } else {
          this.$swal({
            icon: "error",
            title: "Existe un error",
            text: "El producto que intenta añadir, ya se encuentra en la tabla",
          });
        }
      }
    },
    //Metodo para quitar los datos a la tabla
    anularProductosClick(id_producto) {
      let index = null;
      for (let i = 0; i < this.productosData.length; i++) {
        if (this.productosData[i].col_productos_cod == id_producto) {
          index = i;
          break;
        }
      }
      this.productosData.splice(index, 1);
      this.disabledTipoMovimiento = false;
      this.disabledFarmaciaOrigen = false;
      this.disabledFarmaciaDestino = false;
    },
    //Metodo para guardar datos a la tabla
    guardarActualizar: function () {
      let that = this;
      let url = "";
      let mensaje = "";
      //Se comprueba que haya productos en la tabla
      if (that.productosData.length == 0) {
        that.$swal({
          icon: "error",
          title: "Información validación",
          text: "Debe agregar una o varios productos para continuar.",
        });
        return;
      }
      if (this.$props.objetoMod != null) {
        url =
          "/gestion_hospitalaria/administracion_farmacia/modificar_movimiento_productos";
        mensaje = "Datos guardados correctamente.";
      } else {
        url =
          "/gestion_hospitalaria/administracion_farmacia/guardar_movimiento_productos";
        mensaje = "Datos actualizados correctamente.";
      }
      var loader = that.$loading.show();
      this.form.productosData = this.productosData;
      axios
        .post(url, this.form)
        .then(function (response) {
          //Llamar metodo de parent para que actualice el grid.
          loader.hide();
          that.$emit("cambioListaAdmisiones");
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: that.mensaje,
          });
          that.limpiarForm();
        })
        .catch((error) => {
          //Errores de validación
          if (error.response.status === 421) {
            alert("Productos sin Stock: " + error.response.data.msg);
            /* that.$swal({
              icon: "error",
              title: "No hay Stock",
              text: error.response.data.msg
            }); */
          }
          //this.productosData = null;
          loader.hide();
        });
    },
    //Metodo para limpiar los campos
    limpiarForm: function () {
      this.form = {
        frm_fecha_transaccion: "",
        frm_movimiento_producto_cod: "",
        frm_farmacia_cod_destino: "",
        frm_farmacia_cod_origen: "",
        frm_categoria_cod: "",
        frm_productos_cod: "",
        frm_stockActual: "",
        frm_tipo_movimiento_cod: "",
        frm_tipo_movimiento_abrev: "",
        frm_cantidad: "",
        frm_descripcion: "",
        frm_detalle_movimiento_cod: "",
        frm_producto_detalle_cod: "",
        frm_reserva_stock: "",
      };
      (this.disabledTipoMovimiento = false),
        (this.disabledFarmaciaOrigen = false),
        (this.disabledFarmaciaDestino = false),
        (this.disabledTipoMovimiento = false),
        (this.disabledProducto = true),
        (this.selectedTipoMovimiento = "");
      this.selectedCategoria = "";
      this.selectedProductos = "";
      this.productosData = [];
      this.obtenerFechaActual();
      this.selectedPresentacionProducto = null;
      this.form.frm_presentacionproducto_cod = "";
    },
  },
};
</script>
