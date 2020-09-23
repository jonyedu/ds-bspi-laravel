<template>
    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="card card-warning">
            <div
                class="card-header"
                style="background-color:#C2C2C2;color:#000000;"
            >
                <h5 class="card-title">Prescripcion</h5>
            </div>
            <div class="card-body">
                <form role="form">
                    <!-- Seccion de Prescripcion -->
                    <div class="row" v-if="!esModalHistoriaClinica">
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                            <!-- Fecha -->
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2 mt-2">
                                    <label for>Fecha Transacción:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 mt-2">
                                    <div class="form-inline">
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
                                <!-- Farmacia -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tipo"
                                            ><label class="text-danger"
                                                >(*)</label
                                            >
                                            Farmacia</label
                                        >
                                        <v-select
                                            v-model="selectedFarmacia"
                                            :value="form.frm_farmacia_cod"
                                            :options="farmacia"
                                            label="display"
                                            @input="setSelectedFarmacia"
                                        >
                                            <template slot="no-options">
                                                No se ha encontrado ningun dato
                                            </template>
                                        </v-select>
                                    </div>
                                </div>
                                <!-- Productos -->
                                <div class="col-sm-5">
                                    <label for="tipo"
                                        ><label class="text-danger">(*)</label>
                                        Productos</label
                                    >
                                    <div class="form-inline">
                                        <div class="btn-group" role="group">
                                            <button
                                                type="button"
                                                class="btn btn-primary"
                                                @click="abrirModalProducto()"
                                            >
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                        <v-select
                                            style="width:87%"
                                            v-model="selectedProductos"
                                            :value="form.frm_productos_cod"
                                            :options="productos"
                                            label="display"
                                            @input="setSelectedProductos"
                                        >
                                            <template slot="no-options">
                                                No se ha encontrado ningun dato
                                            </template>
                                        </v-select>
                                    </div>
                                </div>
                                <!-- Cantidad -->
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="tipo"
                                            ><label class="text-danger"
                                                >(*)</label
                                            >
                                            Cantidad</label
                                        >
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
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="form.frm_stockActual"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>
                            <!-- Observacion -->
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2 mt-2">
                                    <label for>Observacion:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 mt-2">
                                    <div class="form-inline">
                                        <textarea
                                            type="text"
                                            class="form-control"
                                            placeholder="Observacion para el medicamento"
                                            rows="3"
                                            cols="100"
                                            v-model="form.frm_observacion"
                                        ></textarea>
                                    </div>
                                </div>
                                <!-- Boton Añadir -->
                                <div class="col-lg-1 col-md-1 col-sm-1 mt-2">
                                    <div>
                                        <button
                                            type="button"
                                            class="btn btn-success"
                                            @click="añadirProductos()"
                                        >
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    &nbsp;
                    <!-- Seccion de la Tabla donde muestra la Prescripciones -->
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <vuetable-component
                            :anular-button="true"
                            :modificar-button="false"
                            :columns-data="columns"
                            :rows-data="productosData"
                            @handleAnularClick="anularProductosClick"
                            @handleInputEdit="actualizarCantidad"
                            :input-edit="true"
                        ></vuetable-component>
                    </div>
                </form>
            </div>
        </div>
        <modal :width="'75%'" height="auto" :scrollable="true" name="producto">
            <lista-producto-por-farmacia
                :id-farmacia="form.frm_farmacia_cod"
                :opc="opc"
                ref="producto"
                @handleSeleccionarClick="handleSeleccionarClick"
            ></lista-producto-por-farmacia>
        </modal>
    </div>
</template>
<script>
export default {
    props: {
        idCita: {
            type: Number
        },
        idHospital: {
            type: Number
        },
        esModalHistoriaClinica: {
            type: Boolean
        }
    },
    data: function() {
        return {
            //Variables para los ComboBox
            selectedFarmacia: "",
            selectedProductos: "",

            //Variables de arreglo para lo ComboBox
            farmacia: [],
            productos: [],

            //Variables para la Tabla
            columns: [
                {
                    label: "Farmacia",
                    field: "col_farmacia",
                    type: "String"
                },
                {
                    label: "Descripción",
                    field: "col_descripcion",
                    type: "String"
                },
                {
                    label: "Categoria",
                    field: "col_categoria",
                    type: "String"
                },
                {
                    label: "Observación",
                    field: "col_observacion",
                    type: "String"
                }
            ],
            productosData: [],
            productosDataAnterior: [],

            validarGuardarModificar: 0,
            validarImprimir: 0,
            opc: 0,
            form: {
                frm_cantidadArray: 0,
                frm_idHospital: "",
                frm_fecha_transaccion: "",
                frm_hora_transaccion: "",
                frm_movimiento_producto_cod: "",
                frm_farmacia_cod: 0,
                frm_productos_cod: "",
                frm_productos_pvp: "",
                frm_cantidad: "",
                frm_observacion: "",
                frm_categoria: "",
                frm_stockActual: 0,
                frm_doctor_firma: 0,
                frm_paciente_firma: 0
                //frm_doctor_cod: ""
            }
        };
    },
    mounted: function() {
        this.setSelectedFarmacia();
        this.obtenerFechaHoraActual();
        this.cargarFirmaDoctorPaciente();
        this.cargarPrescripcion();
        this.dimensionArray();
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.examen_fisico.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .admistracion_de_citas.citas.examen_fisico.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        //Metodo para actualizar la cantidad cada vez que se cambie en la tabla
        actualizarCantidad: function(value) {
            for (let i = 0; i < this.productosData.length; i++) {
                if (
                    this.productosData[i].col_productos_cod ==
                        value.col_productos_cod &&
                    this.productosData[i].col_farmacia_cod ==
                        value.col_farmacia_cod
                ) {
                    this.productosData[i].col_cantidad = value.col_cantidad;
                }
            }
        },
        //Metodo para saber la dimension del arreglo productosData
        dimensionArray: function() {
            this.form.frm_cantidadArray = this.productosData.length + 1;
        },
        //Metodo para obtener la fecha y hora actual y añadir al input de fecha
        obtenerFechaHoraActual: function() {
            var date = new Date();
            //Año
            var y = date.getFullYear();
            //Mes
            var m = date.getMonth() + 1;
            //Día
            var d = date.getDate();

            //Hora
            var h = date.getHours();
            //Minuto
            var mi = date.getMinutes();
            //Segundo
            var s = date.getSeconds();
            //Lo ordenas a gusto.
            var fechaActual = y + "/" + m + "/" + d;
            var horaActual = h + ":" + mi + ":" + s;
            this.form.frm_fecha_transaccion = fechaActual;
            this.form.frm_hora_transaccion = horaActual;
        },
        //Metodo para guardar datos a la tabla
        guardarModificarPrescripcion: function(opc) {
            let that = this;
            let idCita = this.$props.idCita;
            //this.form.frm_idHospital = this.$props.idHospital;
            this.form.frm_idHospital = 1;
            let url =
                "/gestion_hospitalaria/consulta_externa/guardar_modificar_prescripcion/" +
                idCita;
            let mensaje = "";
            //Se comprueba que haya productos en la tabla
            if (that.productosData.length == 0) {
                that.$swal({
                    icon: "error",
                    title: "Información validación",
                    text: "Debe agregar una o varios productos para continuar."
                });
                return;
            }
            if (opc == 1) {
                //Modificar
                mensaje = "Datos modificados correctamente.";
            } else {
                //Guardar
                mensaje = "Datos guardados correctamente.";
            }
            var loader = that.$loading.show();
            this.form.productosData = this.productosData;
            this.form.productosDataAnterior = this.productosDataAnterior;
            axios
                .post(url, this.form)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    that.validarGuardarModificar = 1;
                    that.$emit(
                        "validarGuardarModificar",
                        that.validarGuardarModificar
                    );
                    that.limpiarForm();
                    that.cargarPrescripcion();
                    loader.hide();
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente",
                        text: mensaje
                    });
                })
                .catch(error => {
                    that.$swal({
                        icon: "error",
                        title: "Error al Procesar",
                        text: error
                    });
                    //Errores de validación
                    if (error.response.status === 421) {
                        alert(
                            "Productos sin Stock: " + error.response.data.msg
                        );
                    }
                    loader.hide();
                });
        },
        //Metodo para obtener las firmas del doctor y del paciente
        cargarFirmaDoctorPaciente: function() {
            let that = this;
            let url =
                "/gestion_hospitalaria/consulta_externa/cargar_firma_doctor_paciente/" +
                that.$props.idCita;
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    //Obtiene los datos de las firmas
                    if (
                        response.data.firmaPaciente == null ||
                        (response.data.firmaPaciente == "" &&
                            response.data.firmaDoctor == null) ||
                        response.data.firmaDoctor == ""
                    ) {
                        loader.hide();
                        that.$swal({
                            icon: "error",
                            title: "Existe un error",
                            text: "No hay Firmas Registradas"
                        });
                    } else {
                        that.form.frm_paciente_firma =
                            response.data.firmaPaciente.paciente.FULL_NAME;
                        that.form.frm_doctor_firma =
                            response.data.firmaDoctor.FULL_NAME;
                        loader.hide();
                    }
                })
                .catch(error => {
                    //Errores
                    loader.hide();
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                });
        },
        //Metodo para cargar las Prescripcion del paciente mediante el cod cita
        cargarPrescripcion: function() {
            let that = this;
            let url =
                "/gestion_hospitalaria/consulta_externa/cargar_prescripcion/" +
                that.$props.idCita;
            that.productosData = [];
            var loader = that.$loading.show();
            axios
                .get(url)
                .then(function(response) {
                    //Obtiene los datos de prescripcion
                    if (
                        response.data.prescripcion == null  || response.data.prescripcion == ""  || response.data.prescripcion.prescripcion_detalle.length == 0
                    ) {
                        that.validarGuardarModificar = 0;
                        that.validarImprimir = 0;
                        loader.hide();
                    } else {
                        that.validarGuardarModificar = 1;
                        that.validarImprimir = 1;
                        //nueva forma
                        for (
                            let i = 0;
                            i <
                            response.data.prescripcion.prescripcion_detalle
                                .length;
                            i++
                        ) {
                            that.dimensionArray();
                            that.form.frm_fecha_transaccion = response.data.prescripcion.PRESCRIPCION_FECHA.replace(/-/g, "/");
                                
                            that.form.frm_hora_transaccion =
                                response.data.prescripcion.PRESCRIPCION_HORA;
                            that.productosData.push({
                                col_producto_detalle_cod:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i]
                                        .producto_detalle.PRODUCTO_DETALLE_COD,
                                col_prescripcion_detalle_cod:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i].PRESC_DETA_COD,
                                col_farmacia_cod:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i]
                                        .producto_detalle.farmacia.FARMACIA_COD,
                                col_productos_cod:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i]
                                        .producto_detalle.presentacion_producto
                                        .PRESENTACIONPRODUCTO_COD,
                                col_cantidadArray: that.form.frm_cantidadArray,
                                col_producto:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i]
                                        .producto_detalle.presentacion_producto
                                        .productos.PRODUCTO_NOM,
                                col_pvp:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i].PRESC_DETA_PVP,
                                col_farmacia:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i]
                                        .producto_detalle.farmacia.FARMACIA_NOM,
                                col_descripcion:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i]
                                        .producto_detalle.presentacion_producto
                                        .presentaciones.PRESENTACIONFULLPRECIO,
                                col_categoria:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i]
                                        .producto_detalle.presentacion_producto
                                        .productos.categoria.CATEGORIA_NOM,
                                col_observacion:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i].PRESC_DETA_OBS,
                                col_cantidad:
                                    response.data.prescripcion
                                        .prescripcion_detalle[i].PRESC_DETA_CANT
                            });
                        }
                        loader.hide();
                    }
                    that.$emit(
                        "validarGuardarModificar",
                        that.validarGuardarModificar
                    );
                    that.$emit("validarImprimir", that.validarImprimir);
                })
                .catch(error => {
                    //Errores
                    loader.hide();
                    that.$swal({
                        icon: "error",
                        title: "Existe un error",
                        text: error
                    });
                });
        },
        //Metodos para cargar los datos de farmacia y agregar al comboBox de farmacia
        setSelectedFarmacia(value) {
            let that = this;
            if (this.$props.idCita > 0) {
                //this.form.frm_idHospital = this.$props.idHospital;
                this.form.frm_idHospital = 1;
                var loader = that.$loading.show();
                let url =
                    "/gestion_hospitalaria/administracion_farmacia/cargar_asociacion_farmacia_por_id/" +
                    this.form.frm_idHospital;
                if (this.selectedFarmacia == null) {
                    this.form.frm_farmacia_cod = 0;
                    this.form.frm_cantidad = "";
                    this.form.frm_categoria = "";
                    this.selectedProductos = "";
                }
                if (value != null) {
                    if (value.farmacia_cod != null) {
                        this.form.frm_farmacia_cod = value.farmacia_cod;
                        this.selectedProductos = "";
                    }
                }
                axios
                    .get(url)
                    .then(function(response) {
                        let farmacia = [];
                        response.data.asociacionFarmaciaPorId.forEach(
                            farmacias => {
                                let objeto = {};
                                objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(farmacias.farmacia.FARMACIA_NOM);
                                objeto.farmacia_cod =
                                    farmacias.farmacia.FARMACIA_COD;
                                farmacia.push(objeto);
                            }
                        );
                        that.farmacia = farmacia;
                        loader.hide();
                        that.setSelectedProductos();
                    })
                    .catch(error => {
                        //Errores
                        that.$swal({
                            icon: "error",
                            title: "Existe un error",
                            text: error
                        });
                        loader.hide();
                    });
            }
        },
        //Metodos para los datos de producto por farmacia y agregar al comboBox de producto
        setSelectedProductos(value) {
            if (this.selectedProductos == null) {
                this.form.frm_productos_cod = "";
                this.form.frm_productos_pvp = "";
                this.form.frm_categoria = "";
                this.form.frm_cantidad = "";
                this.form.frm_stockActual = "";
            }
            if (value != null) {
                this.form.frm_productos_cod = value.productos_cod;
                this.form.frm_productos_pvp = value.productos_pvp;
                this.form.frm_categoria = value.nombre_categoria;
            }
            if (this.form.frm_farmacia_cod != 0) {
                let that = this;
                //var loader = that.$loading.show();
                let url =
                    "/gestion_hospitalaria/administracion_farmacia/cargar_producto_por_farmacia/" +
                    this.form.frm_farmacia_cod;
                axios
                    .get(url)
                    .then(function(response) {
                        let productos = [];
                        response.data.productoPorFarmacia.forEach(producto => {
                            let objeto = {};
                            objeto.display = that.$funcionesGlobales.toCapitalFirstAllWords(producto.PRODUCTO_NOM);
                            objeto.productos_cod =
                                producto.PRESENTACIONPRODUCTO_COD;
                            objeto.productos_pvp = producto.PRODUCTO_PVP;
                            objeto.nombre_categoria = that.$funcionesGlobales.toCapitalFirstAllWords(producto.CATEGORIA_NOM);
                            productos.push(objeto);
                        });
                        that.productos = productos;
                        that.cargarStockActual();
                        that.cargarObservacionPorProducto(that.form.frm_productos_cod);
                        //loader.hide();
                    })
                    .catch(error => {
                        alert("entra?");
                        //Errores
                        this.$swal({
                            icon: "error",
                            title: "Existe un error",
                            text: error
                        });
                        //loader.hide();
                    });
            }
        },
        //Metodo para cargar el Stock Actual del producto seleccionado
        cargarStockActual: function() {
            if (this.form.frm_productos_cod != "") {
                let that = this;
                let url =
                    "/gestion_hospitalaria/consulta_externa/cargar_stock_producto/" +
                    this.form.frm_productos_cod +
                    "/" +
                    this.form.frm_farmacia_cod;
                //var loader = that.$loading.show();
                axios
                    .get(url)
                    .then(function(response) {
                        if (response.data.stockActual != null) {
                            that.form.frm_stockActual =
                                response.data.stockActual
                                    .PRODUCTO_DETALLE_STOCK -
                                response.data.stockActual
                                    .PRODUCTO_DETALLE_RESERVA_STOCK;
                        } else {
                            that.form.frm_stockActual = 0;
                        }
                        //loader.hide();
                    })
                    .catch(error => {
                        //Errores
                        //loader.hide();
                    });
            }
        },
        //Metodo para cargar La observación del producto cuando se haya insertado en la tabla
        cargarObservacionPorProducto: function(id_producto) {
            if (this.productosData.length > 0) {
                for (let i = 0; i < this.productosData.length; i++) {
                    let producto = this.productosData[i];
                    if (producto.col_productos_cod == id_producto) {
                        if (producto.col_observacion != null) {
                            this.form.frm_observacion =
                                this.$funcionesGlobales.toCapitalFirstAllWords(producto.col_observacion);
                            break;
                        }
                    }
                }
            }
        },
        //Metodo para abril el modal de lista de productos por farmacia
        abrirModalProducto: function() {
            this.$modal.show("producto");
        },
        //Metodo para cerrar el modal de lista de productos por farmacia
        cerrarModalProducto: function() {
            this.$modal.hide("producto");
        },
        //Metodo para obtener el data seleccionado cuando el modal se haya cerrado
        handleSeleccionarClick(value) {
            this.$modal.hide("producto");
            this.selectedProductos = value;
            this.form.frm_productos_cod = value.id_producto;
            this.selectedProductos.display = value.nombre_producto;
            this.form.frm_categoria = value.nombre_categoria;
            this.form.frm_productos_pvp = value.pvp_producto;
            this.cargarStockActual();
        },
        //Metodo para añadir los datos a la tabla
        añadirProductos: function() {
            //Se valida para que elija la fecha de transacción, antes de añadir productos a la tabla
            if (this.form.frm_fecha_transaccion == "") {
                this.$swal({
                    icon: "error",
                    title: "Existe un error",
                    text:
                        "Por favor elija una fecha realizar el movimiento de productos"
                });
                return;
            }
            //Se valida cuando no haya seleccionado la farmacia
            if (this.form.frm_farmacia_cod == "") {
                this.$swal({
                    icon: "error",
                    title: "Existe un error",
                    text: "Se necesita la Farmacia"
                });
                return;
            }
            //Se valida cuando no haya seleccionado el producto
            if (this.form.frm_productos_cod == "") {
                this.$swal({
                    icon: "error",
                    title: "Existe un error",
                    text: "Se necesita el Producto"
                });
                return;
            }
            //Se valida cuando la cantidad no está ingresada
            if (this.form.frm_cantidad == "") {
                this.$swal({
                    icon: "error",
                    title: "Existe un error",
                    text: "Se necesita la Cantidad"
                });
                return;
            }
            //Se valida cuando la cantidad es negativo
            if (this.form.frm_cantidad <= 0) {
                this.$swal({
                    icon: "error",
                    title: "Existe un error",
                    text: "Se necesita que la Cantidad sea mayor a 0"
                });
                return;
            }
            //Se valida cuando el Stock es 0
            if (this.form.frm_stockActual <= 0) {
                this.$swal({
                    icon: "error",
                    title: "Existe un error",
                    text: "El Producto, no tiene Stock"
                });
                return;
            }
            //Se valida que los productos no exista previamente.
            let encontrado = false;
            if (this.productosData.length > 0) {
                for (let i = 0; i < this.productosData.length; i++) {
                    let producto = this.productosData[i];
                    if (
                        producto.col_productos_cod ==
                            this.form.frm_productos_cod &&
                        producto.col_farmacia_cod == this.form.frm_farmacia_cod
                    ) {
                        encontrado = true;
                        break;
                    }
                }
            }
            //Si no existe en la tabla, se agrega los productos.
            if (!encontrado) {
                this.dimensionArray();
                if (this.form.frm_stockActual == "") {
                    this.form.frm_stockActual = 0;
                }
                this.productosData.push({
                    col_prescripcion_detalle_cod: 0,
                    col_farmacia_cod: this.form.frm_farmacia_cod,
                    col_productos_cod: this.form.frm_productos_cod,
                    col_cantidadArray: this.form.frm_cantidadArray,
                    col_producto: this.selectedProductos.display,
                    col_pvp: this.form.frm_productos_pvp,
                    col_farmacia: this.selectedFarmacia.display,
                    col_descripcion: this.selectedProductos.display,
                    col_categoria: this.form.frm_categoria,
                    col_observacion: this.$funcionesGlobales.toCapitalFirstAllWords(this.form.frm_observacion),
                    col_cantidad: this.form.frm_cantidad
                });
                this.form.frm_cantidad = "";
                this.selectedProductos.display = null;
                this.form.frm_stockActual = "";
                this.form.frm_observacion = "";
            } else {
                this.$swal({
                    icon: "error",
                    title: "Existe un error",
                    text:
                        "El producto que intenta añadir, ya se encuentra en la tabla"
                });
            }
        },
        //Metodo para quitar los datos a la tabla
        anularProductosClick(data) {
            //Se valida que los productos no exista previamente en el arreglo donde va a tener los productos antes de que se eliminen.
            let encontrado = false;
            if (this.productosDataAnterior.length > 0) {
                for (let i = 0; i < this.productosDataAnterior.length; i++) {
                    let producto = this.productosDataAnterior[i];
                    if (
                        producto.col_productos_cod == data.col_productos_cod &&
                        producto.col_farmacia_cod == data.col_farmacia_cod
                    ) {
                        encontrado = true;
                        break;
                    }
                }
            }
            //Si no existe en el arreglo, se agrega los datos al nuevo arreglo.
            if (!encontrado) {
                this.productosDataAnterior.push({
                    col_cantidadArray: this.form.frm_cantidadArray,
                    col_productos_cod: data.col_productos_cod,
                    col_farmacia_cod: data.col_farmacia_cod,
                    col_cantidad: data.col_cantidad,
                    col_prescripcion_detalle_cod:
                        data.col_prescripcion_detalle_cod
                });
            } else {
                this.$swal({
                    icon: "error",
                    title: "Existe un error",
                    text:
                        "El producto que intenta añadir, ya se encuentra en la tabla"
                });
            }
            let index = null;
            for (let i = 0; i < this.productosData.length; i++) {
                if (
                    this.productosData[i].col_productos_cod ==
                        data.col_productos_cod &&
                    this.productosData[i].col_farmacia_cod ==
                        data.col_farmacia_cod
                ) {
                    index = i;
                    break;
                }
            }
            this.productosData.splice(index, 1);
            this.form.frm_cantidadArray = this.productosData.length;
            for (let i = 0; i < this.productosData.length; i++) {
                this.productosData[
                    i
                ].col_cantidadArray = this.productosData.length;
            }
        },
        //Metodo para limpiar los campos
        limpiarForm: function() {
            this.form = {
                frm_cantidadArray: 0,
                frm_idHospital: "",
                frm_fecha_transaccion: "",
                frm_movimiento_producto_cod: "",
                frm_farmacia_cod: 0,
                frm_productos_cod: "",
                frm_cantidad: "",
                frm_observacion: "",
                frm_categoria: "",
                frm_stockActual: 0
            };
            this.selectedFarmacia = "";
            this.selectedProductos = "";
            this.productosData = [];
            this.productosDataAnterior = [];
            this.obtenerFechaHoraActual();
        },
        imprimirPdfPrescripcion: function() {
            window.open(
                "/gestion_hospitalaria/consulta_externa/cargar_pdf_prescripcion/" +
                    this.$props.idCita
            );
        }
    }
};
</script>
