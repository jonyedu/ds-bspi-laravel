<template>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1 class="mt-4">PRODUCTOS POR FARMACIA</h1>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <button
                                    class="btn btn-primary"
                                    @click="nuevo()"
                                >
                                    Nuevo
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <vuetable-component
                                :seleccionar-button="seleccionarButton"
                                :anular-button="false"
                                :modificar-button="false"
                                :columns-data="columns"
                                :rows-data="producto"
                                @handleSeleccionarClick="handleSeleccionarClick"
                            ></vuetable-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal
            :width="'65%'"
            height="auto"
            :scrollable="true"
            name="crearModal"
        >
            <crear-producto
                :objeto-mod="objetoMod"
                @cerrarModalCrear="cerrarModalCrear"
                ref="crearModal"
            ></crear-producto>
        </modal>
    </div>
</template>
<script>
export default {
    props: {
        seleccionarButton: {
            type: Boolean,
            default: true
        },
        idFarmacia: {
            type: Number,
            default: 0
        }
    },
    data: function() {
        return {
            producto: [],
            objetoMod: null,
            columns: [
                {
                    label: "Nombre",
                    field: "PRODUCTO_NOM",
                    type: "String"
                },
                {
                    label: "Categoria",
                    field: "CATEGORIA_NOM",
                    type: "String"
                },
                {
                    label: "Clave",
                    field: "PRODUCTO_CLAVE",
                    type: "String"
                },
                {
                    label: "Stock",
                    field: "PRODUCTO_DETALLE_STOCK",
                    type: "String"
                } /* ,
                {
                    label: "Reserva",
                    field: "PRODUCTO_DETALLE_RESERVA_STOCK",
                    type: "String"
                } */
            ],
            form: {
                frm_farmacia_cod: ""
            }
        };
    },
    mounted: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .pacientes.usuarios_parentesco.usuarios_parentesco
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
        this.cargarProductoPorFarmacia();
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.gestion_hospitalaria;
        let nombreFormulario = this.$nombresFormulario.gestion_hospitalaria
            .pacientes.usuarios_parentesco.usuarios_parentesco
            .nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        handleSeleccionarClick(value) {
            this.$emit("handleSeleccionarClick", value);
        },
        modificar(value) {
            this.objetoMod = value;
            this.abrirModalCrear();
        },
        cerrarModalCrear: function() {
            this.$modal.hide("crearModal");
        },
        nuevo: function() {
            this.objetoMod = null;
            this.abrirModalCrear();
        },
        abrirModalCrear: function() {
            this.$modal.show("crearModal");
        },
        cargarProductoPorFarmacia() {
            let that = this;
            if (this.$props.idFarmacia > 0) {
                this.form.frm_farmacia_cod = this.$props.idFarmacia;
                let url =
                    "/gestion_hospitalaria/administracion_farmacia/cargar_producto_por_farmacia/" +
                    this.form.frm_farmacia_cod;
                var loader = that.$loading.show();
                axios
                    .get(url)
                    .then(function(response) {
                        let producto = [];
                        that.producto = response.data.productoPorFarmacia;
                        for (
                            let i = 0;
                            i < response.data.productoPorFarmacia.length;
                            i++
                        ) {
                            let objeto = {};
                            //Para la otra vista
                            objeto.id_producto =
                                response.data.productoPorFarmacia[
                                    i
                                ].producto.PRODUCTO_COD;
                            objeto.nombre_producto =
                                response.data.productoPorFarmacia[
                                    i
                                ].producto.PRODUCTO_NOM;
                            objeto.pvp_producto =
                                response.data.productoPorFarmacia[
                                    i
                                ].producto.PRODUCTO_PVP;
                            objeto.nombre_categoria =
                                response.data.productoPorFarmacia[
                                    i
                                ].producto.categoria.CATEGORIA_NOM;

                            //Para la tabla
                            objeto.PRODUCTO_NOM =
                                response.data.productoPorFarmacia[
                                    i
                                ].producto.PRODUCTO_NOM;
                            objeto.CATEGORIA_NOM =
                                response.data.productoPorFarmacia[
                                    i
                                ].producto.categoria.CATEGORIA_NOM;
                            objeto.PRODUCTO_CLAVE =
                                response.data.productoPorFarmacia[
                                    i
                                ].producto.PRODUCTO_CLAVE;
                            objeto.PRODUCTO_PVP =
                                response.data.productoPorFarmacia[
                                    i
                                ].producto.PRODUCTO_PVP;
                            objeto.PRODUCTO_DETALLE_STOCK =
                                response.data.productoPorFarmacia[i]
                                    .PRODUCTO_DETALLE_STOCK -
                                response.data.productoPorFarmacia[i]
                                    .PRODUCTO_DETALLE_RESERVA_STOCK;
                            //objeto.PRODUCTO_DETALLE_RESERVA_STOCK = response.data.productoPorFarmacia[i].PRODUCTO_DETALLE_RESERVA_STOCK;
                            producto.push(objeto);
                        }
                        that.producto = producto;
                        loader.hide();
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
            }
        }
    }
};
</script>
