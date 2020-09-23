<template>
    <div class="row mt-2">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="barrio">Barrio</label>
                <input
                    type="text"
                    :class="
                        errorInformacionVivienda.barrio === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    id="barrio"
                    placeholder="Ingrese su barrio"
                    v-model="dataInformacionVivienda.barrio"
                />
                <small
                    v-if="errorInformacionVivienda.barrio !== ''"
                    id="barrioHelp"
                    class="text-danger"
                    >{{ errorInformacionVivienda.barrio[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="urbano_rural">Urbano/Rural</label>
                <v-select
                    v-model="dataInformacionVivienda.urbanoRuralNombre"
                    :value="dataInformacionVivienda.urbano_rural"
                    :options="urbanosRural"
                    label="display"
                    @input="setSelectedUrbano"
                >
                    <template slot="no-options">seleccione</template>
                </v-select>
                <small
                    v-if="errorInformacionVivienda.urbano_rural !== ''"
                    id="urbano_ruralHelp"
                    class="text-danger"
                    >{{ errorInformacionVivienda.urbano_rural[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="tipo_de_casa">Tipo De Casa</label>
                <v-select
                    v-model="dataInformacionVivienda.tipoDeCasaNombre"
                    :value="dataInformacionVivienda.tipo_casa"
                    :options="tiposCasa"
                    label="display"
                    @input="setSelectedTipoCasa"
                >
                    <template slot="no-options">seleccione</template>
                </v-select>
                <small
                    v-if="errorInformacionVivienda.tipo_de_casa !== ''"
                    id="tipo_de_casaHelp"
                    class="text-danger"
                    >{{ errorInformacionVivienda.tipo_de_casa[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <textarea
                    name="direccion"
                    id="direccion"
                    rows="4"
                    :class="
                        errorInformacionVivienda.direccion === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    placeholder="Ingrese su dirección"
                    v-model="dataInformacionVivienda.direccion"
                ></textarea>
                <small
                    v-if="errorInformacionVivienda.direccion !== ''"
                    id="direccionHelp"
                    class="text-danger"
                    >{{ errorInformacionVivienda.direccion[0] }}</small
                >
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="form-group">
                <label for="referencia_domicilio">Referencia Domicilio</label>
                <textarea
                    name="referencia_domicilio"
                    id="referencia_domicilio"
                    rows="4"
                    :class="
                        errorInformacionVivienda.referencia_domicilio === ''
                            ? 'form-control'
                            : 'form-control is-invalid'
                    "
                    placeholder="Ingrese su referencia de domicilio"
                    v-model="dataInformacionVivienda.referencia_domicilio"
                ></textarea>
                <small
                    v-if="errorInformacionVivienda.referencia_domicilio !== ''"
                    id="referencia_domicilioHelp"
                    class="text-danger"
                >
                    {{ errorInformacionVivienda.referencia_domicilio[0] }}
                </small>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div style="height: 300px; width: 100%;" id="map" name="map"></div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        dataInformacionVivienda: {
            type: Object
        },
        latitud: {
            type: Number
        },
        longitud: {
            type: Number
        },
        errorInformacionVivienda: {
            type: Object
        },
        tiposCasa: {
            type: Array
        }
    },

    data: function() {
        return {
            urbanosRural: [
                {
                    display: "Urbano",
                    value: "U"
                },
                {
                    display: "Rural",
                    value: "R"
                }
            ]
        };
    },
    watch: {
        "dataInformacionVivienda.direccion"(value) {
            this.$emit("actualizarData", "direccion", value);
        },
        "dataInformacionVivienda.barrio"(value) {
            this.$emit("actualizarData", "barrio", value);
        },
        "dataInformacionVivienda.referencia_domicilio"(value) {
            this.$emit("actualizarData", "referencia_domicilio", value);
        },
        latitud(value) {
            this.initMap();
        },
        longitud(value) {
            this.initMap();
        }
    },
    mounted: function() {
        this.initMap();
    },
    methods: {
        initMap() {
            let that = this;
            var lat = that.latitud;
            var lng = that.longitud;
            var myLatlng = {
                lat: +lat,
                lng: +lng
            };
            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 16,
                center: myLatlng
            });

            // Create the initial InfoWindow.

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: "Ubicación"
            });

            // Configure the click listener.
            map.addListener("click", function(mapsMouseEvent) {
                // Close the current InfoWindow.
                marker.setMap(null);
                marker = new google.maps.Marker({
                    position: mapsMouseEvent.latLng,
                    map: map,
                    title: "Ubicación"
                });

                that.$emit(
                    "actualizarData",
                    "latitud",
                    marker.getPosition().lat()
                );
                that.$emit(
                    "actualizarData",
                    "longitud",
                    marker.getPosition().lng()
                );
                that.$emit("actualizarLatitud", marker.getPosition().lat());
                that.$emit("actualizarLongitud", marker.getPosition().lng());
                // Create a new InfoWindow.
                //infoWindow = new google.maps.InfoWindow({
                //position: mapsMouseEvent.latLng
                //});
                //infoWindow.setContent(mapsMouseEvent.latLng.toString());
                //infoWindow.open(map);
            });
        },
        setSelectedUrbano(value) {
            this.$emit("actualizarData", "urbano_rural", value.value);
            this.$emit("actualizarData", "urbanoRuralNombre", value.display);
        },
        setSelectedTipoCasa(value) {
            this.$emit("actualizarData", "tipo_casa", value.value);
            this.$emit("actualizarData","tipoDeCasaNombre",value.display
            );
        }
    }
};
</script>
