<template>
    <div class="row m-1">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <center>
                <h5 class="mt-2">DATOS</h5>
            </center>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="col-lg-12 col-md-12 col-sm-12 p-3">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                id="sistema-tab"
                                data-toggle="tab"
                                href="#sistema"
                                role="tab"
                                aria-controls="sistema"
                                aria-selected="true"
                                >Información del sistema</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="personal-tab"
                                data-toggle="tab"
                                href="#personal"
                                role="tab"
                                aria-controls="personal"
                                aria-selected="false"
                                >Información personal</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="nacimiento-tab"
                                data-toggle="tab"
                                href="#nacimiento"
                                role="tab"
                                aria-controls="nacimiento"
                                aria-selected="false"
                                >Información de nacimiento</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="vivienda-tab"
                                data-toggle="tab"
                                href="#vivienda"
                                role="tab"
                                aria-controls="vivienda"
                                aria-selected="false"
                                >Información de vivienda</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                id="usuario-tab"
                                data-toggle="tab"
                                href="#usuario"
                                role="tab"
                                aria-controls="usuario"
                                aria-selected="false"
                                >Información de usuario</a
                            >
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div
                            class="tab-pane fade show active"
                            id="sistema"
                            role="tabpanel"
                            aria-labelledby="sistema"
                        >
                            <informacion-sistema
                                :es-admisiones="esAdmisiones"
                                :data-informacion-sistema="
                                    dataInformacionSistema
                                "
                                :error-informacion-sistema="
                                    errorInformacionSistema
                                "
                                @actualizarData="
                                    actualizarDataInformacionSistema
                                "
                            ></informacion-sistema>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="personal"
                            role="tabpanel"
                            aria-labelledby="personal"
                        >
                            <informacion-personal
                                :tipos-de-sangre="tiposDeSangre"
                                :religiones="religiones"
                                :grupos-culturales="gruposCulturales"
                                :data-informacion-personal="
                                    dataInformacionPersonal
                                "
                                :error-informacion-personal="
                                    errorInformacionPersonal
                                "
                                @actualizarData="
                                    actualizarDataInformacionPersonal
                                "
                            ></informacion-personal>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="nacimiento"
                            role="tabpanel"
                            aria-labelledby="nacimiento"
                        >
                            <informacion-nacimiento
                                :data-informacion-nacimiento="
                                    dataInformacionNacimiento
                                "
                                :error-informacion-nacimiento="
                                    errorInformacionNacimiento
                                "
                                @actualizarData="
                                    actualizarDataInformacionNacimiento
                                "
                            ></informacion-nacimiento>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="vivienda"
                            role="tabpanel"
                            aria-labelledby="vivienda"
                        >
                            <informacion-vivienda
                                :data-informacion-vivienda="
                                    dataInformacionVivienda
                                "
                                :error-informacion-vivienda="
                                    errorInformacionVivienda
                                "
                                :latitud="this.latitud"
                                :longitud="this.longitud"
                                :tipos-casa="tiposCasa"
                                @actualizarData="
                                    actualizarDataInformacionVivienda
                                "
                                @actualizarLatitud="actualizarLatitud"
                                @actualizarLongitud="actualizarLongitud"
                            ></informacion-vivienda>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="usuario"
                            role="tabpanel"
                            aria-labelledby="usuario"
                        >
                            <informacion-caracteristica-usuario
                                :data-informacion-caracteristica-usuario="
                                    dataInformacionCaracteristicaUsuario
                                "
                                :error-informacion-caracteristica-usuario="
                                    errorInformacionCaracteristicaUsuario
                                "
                                @actualizarData="
                                    actualizarDataInformacionCaracteristicaUsuario
                                "
                            ></informacion-caracteristica-usuario>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-4 pt-1">
                        <div class="form-inline">
                            <button
                                type="button"
                                class="btn btn-success btn-block"
                                @click="guardar()"
                            >
                                {{
                                    dataUsuario === null
                                        ? "Guardar"
                                        : "Modificar"
                                }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        esAdmisiones: {
            type: Boolean,
            default: false
        },
        dataUsuario: {
            type: Object
        },
        tiposDeSangre: {
            type: Array
        },
        religiones: {
            type: Array
        },
        gruposCulturales: {
            type: Array
        },
        tiposCasa: {
            type: Array
        }
    },
    limpiarErrores() {
        this.errorInformacionSistema = {
            fotoUsuario: "", //yess
            tipoIdentificacion: "", //yess
            identificacionCedula: "", //yess
            identificacionPasaporte: "", //yess
            identificacion17Digitos: "", //yess
            codigoRegistroNuevo: "",
            password: "",
            activo: "", //yes
            trabajadorBSPI: "", //yes
            alias: "" //yes
        };
        this.errorInformacionPersonal = {
            primer_apellido: "",
            segundo_apellido: "",
            primer_nombre: "",
            segundo_nombre: "",
            email_institucional: "",
            email_alternativo: "",
            telefono: "",
            celular: "",
            sexo: "",
            estado_civil: "",
            tipo_sangre: "",
            religion: "",
            grupo_cultural: "",
            nombre_contacto_emergencia: "",
            telefono_contacto_emergencia: "",
            pdf_cedula: ""
        };
        this.errorInformacionNacimiento = {
            fecha_nacimiento: "",
            lugar_nacimiento: "",
            pais: "",
            parroquia: ""
        };
        this.errorInformacionVivienda = {
            direccion: "",
            urbano_rural: "",
            barrio: "",
            tipo_de_casa: "",
            tipo_casa: "",
            referencia_domicilio: "",
            latitud: "",
            longitud: ""
        };
        this.errorInformacionCaracteristicaUsuario = {
            estatura_metros: "",
            peso_kg: "",
            observacion: "",
            talla_camisa: "",
            talla_pantalon: "",
            talla_zapato: "",
            movilizacionNombre: "",
            discapacidad: "",
            porcentageDiscapacidad: "",
            conadis: "",
            msp: "",
            pdfConadis: "",
            pdfMsp: ""
        };
    },
    data: function() {
        return {
            US_COD: "",
            form: new FormData(),
            validCedula: false,
            //Informacion Sistema
            errorInformacionSistema: {
                fotoUsuario: "", //yess
                tipoIdentificacion: "", //yess
                identificacionCedula: "", //yess
                identificacionPasaporte: "", //yess
                identificacion17Digitos: "", //yess
                codigoRegistroNuevo: "",
                password: "",
                password_confirmation: "",
                activo: "", //yes
                trabajadorBSPI: "", //yes
                alias: ""
            },
            dataInformacionSistema: {
                fotoUsuario: "", //yess
                tipoIdentificacion: "", //yess //combo
                identificacionCedula: "", //yess
                identificacionPasaporte: "", //yess
                identificacion17Digitos: "", //yess
                codigoRegistroNuevo: "",
                password: "", //yess
                password_confirmation: "",
                activo: "", //yess //combo
                trabajadorBSPI: "", //yes //combo
                alias: "",
                fotoURL: ""
            },
            //InformacionPersonal
            latitud: -2.213499,
            longitud: -79.887541,
            errorInformacionPersonal: {
                primer_apellido: "",
                segundo_apellido: "",
                primer_nombre: "",
                segundo_nombre: "",
                email_institucional: "",
                email_alternativo: "",
                telefono: "",
                celular: "",
                sexo: "",
                estado_civil: "",
                tipo_sangre: "",
                religion: "",
                grupo_cultural: "",
                nombre_contacto_emergencia: "",
                telefono_contacto_emergencia: "",
                pdf_cedula: ""
            },
            dataInformacionPersonal: {
                primer_apellido: "",
                segundo_apellido: "",
                primer_nombre: "",
                segundo_nombre: "",
                email_institucional: "",
                email_alternativo: "",
                telefono: "",
                celular: "",
                sexo: "",
                sexoNombre: "",
                estado_civil: "",
                estadoCivilNombre: "",
                tipo_de_sangre: "",
                tipoSangreNombre: "",
                religion: "",
                religionNombre: "",
                grupo_cultural: "",
                grupoCulturalNombre: "",
                nombre_contacto_emergencia: "",
                telefono_contacto_emergencia: "",
                pdf_cedula: ""
            },
            errorInformacionNacimiento: {
                fecha_nacimiento: "",
                lugar_nacimiento: "",
                pais: "",
                parroquia: ""
            },
            dataInformacionNacimiento: {
                fecha_nacimiento: "",
                lugar_nacimiento: "",
                pais: "",
                paisNombre: "",
                parroquia: ""
            },
            errorInformacionVivienda: {
                direccion: "",
                urbano_rural: "",
                barrio: "",
                tipo_de_casa: "",
                tipo_casa: "",
                referencia_domicilio: "",
                latitud: "",
                longitud: ""
            },
            dataInformacionVivienda: {
                direccion: "",
                urbano_rural: "",
                urbanoRuralNombre: "",
                barrio: "",
                tipo_de_casa: "",
                tipo_casa: "",
                tipoDeCasaNombre: "",
                referencia_domicilio: "",
                latitud: "",
                longitud: ""
            },
            errorInformacionCaracteristicaUsuario: {
                estatura_metros: "",
                peso_kg: "",
                observacion: "",
                talla_camisa: "",
                talla_pantalon: "",
                talla_zapato: "",
                movilizacion: "",
                movilizacionNombre: "",
                discapacidad: "",
                porcentageDiscapacidad: "",
                conadis: "",
                msp: "",
                pdfConadis: "",
                pdfMsp: ""
            },
            dataInformacionCaracteristicaUsuario: {
                estatura_metros: "",
                peso_kg: "",
                observacion: "",
                talla_camisa: "",
                tallaCamisaNombre: "",
                talla_pantalon: "",
                tallaPantalonNombre: "",
                talla_zapato: "",
                tallaZapatoNombre: "",
                movilizacion: "",
                movilizacionNombre: "",
                discapacidades: "",
                discapacidadesNombre: "",
                discapacidad: "N",
                porcentageDiscapacidad: "",
                conadis: "",
                msp: "",
                pdfConadis: "",
                pdfMsp: ""
            }
        };
    },
    mounted: function() {
        if (this.dataUsuario != null) {
            this.US_COD = this.dataUsuario.US_COD;
            //sistema
            let indexCedula = this.dataUsuario.identificaciones.findIndex(
                x => x.ID_COD === "CEDULA"
            );
            let indexPasaporte = this.dataUsuario.identificaciones.findIndex(
                x => x.ID_COD === "PASAPORTE"
            );
            let index17Digitos = this.dataUsuario.identificaciones.findIndex(
                x => x.ID_COD === "17-DIGITOS"
            );
            indexCedula != -1
                ? (this.dataInformacionSistema.identificacionCedula = this.dataUsuario.identificaciones[
                      indexCedula
                  ].USID_CODIGO)
                : (this.dataInformacionSistema.identificacionCedula = "");
            indexPasaporte != -1
                ? (this.dataInformacionSistema.identificacionPasaporte = this.dataUsuario.identificaciones[
                      indexPasaporte
                  ].USID_CODIGO)
                : (this.dataInformacionSistema.identificacionPasaporte = "");
            index17Digitos != -1
                ? (this.dataInformacionSistema.identificacion17Digitos = this.dataUsuario.identificaciones[
                      index17Digitos
                  ].USID_CODIGO)
                : (this.dataInformacionSistema.identificacion17Digitos = "");

            this.dataInformacionSistema.activo = this.dataUsuario.US_ACTIVO;
            this.dataInformacionSistema.trabajadorBSPI = this.dataUsuario.US_TRABAJADOR_BSPI;
            this.dataInformacionSistema.tipoIdentificacion = this.dataUsuario.identificaciones[0].ID_COD;
            this.dataInformacionSistema.fotoUsuario = this.dataUsuario.US_FOTO;
            //this.dataInformacionSistema.password=this.dataUsuario
            this.dataInformacionSistema.alias = this.dataUsuario.US_ALIAS;
            this.dataInformacionSistema.fotoURL = this.dataUsuario.IMAGEN_PERFIL_URL;

            this.dataInformacionPersonal.primer_apellido = this.dataUsuario.US_APELL1;
            this.dataInformacionPersonal.segundo_apellido = this.dataUsuario.US_APELL2;
            this.dataInformacionPersonal.primer_nombre = this.dataUsuario.US_NOM1;
            this.dataInformacionPersonal.segundo_nombre = this.dataUsuario.US_NOM2;
            this.dataInformacionPersonal.email_institucional = this.dataUsuario.US_EMAIL;
            this.dataInformacionPersonal.email_alternativo = this.dataUsuario.US_EMAIL2;
            this.dataInformacionPersonal.telefono = this.dataUsuario.US_TELF;
            this.dataInformacionPersonal.celular = this.dataUsuario.US_CEL;
            this.dataInformacionPersonal.sexo = this.dataUsuario.US_SEXO;
            this.dataInformacionPersonal.sexoNombre =
                this.dataUsuario.US_SEXO == "M"
                    ? "Masculino"
                    : this.dataUsuario.US_SEXO == "F"
                    ? "Femenino"
                    : this.dataUsuario.US_SEXO == "O"
                    ? "Otros"
                    : "";
            this.dataInformacionPersonal.estado_civil = this.dataUsuario.US_ECIVIL;
            this.dataInformacionPersonal.estadoCivilNombre =
                this.dataUsuario.US_ECIVIL == "S"
                    ? "Soltero"
                    : this.dataUsuario.US_ECIVIL == "C"
                    ? "Casado"
                    : this.dataUsuario.US_ECIVIL == "D"
                    ? "Divorciado"
                    : this.dataUsuario.US_ECIVIL == "V"
                    ? "Viudo"
                    : this.dataUsuario.US_ECIVIL == "U"
                    ? "Unión Libre"
                    : "";
            this.dataInformacionPersonal.tipo_de_sangre = this.dataUsuario.TSANGRE_COD;
            this.dataInformacionPersonal.tipoSangreNombre =
                this.dataUsuario.tipo_sangre != null
                    ? this.dataUsuario.tipo_sangre.TSANGRE_NOM
                    : "";
            this.dataInformacionPersonal.religion = this.dataUsuario.RELIGION_COD;
            this.dataInformacionPersonal.religionNombre =
                this.dataUsuario.religion != null
                    ? this.dataUsuario.religion.RELIGION_NOM
                    : "";
            this.dataInformacionPersonal.grupo_cultural = this.dataUsuario.GCULTURAL_COD;
            this.dataInformacionPersonal.grupoCulturalNombre =
                this.dataUsuario.grupo_cultural != null
                    ? this.dataUsuario.grupo_cultural.GCULTURAL_NOM
                    : "";
            this.dataInformacionPersonal.nombre_contacto_emergencia = this.dataUsuario.US_CONTACTO_EMERG;
            this.dataInformacionPersonal.telefono_contacto_emergencia = this.dataUsuario.US_TELF_EMERG;
            this.dataInformacionPersonal.pdf_cedula = this.dataUsuario.US_CEDULA_PDF;
            //INFORMACIÓN VIVIENDA
            this.dataInformacionVivienda.direccion = this.dataUsuario.US_DIR;
            this.dataInformacionVivienda.urbano_rural = this.dataUsuario.US_URB_O_RURAL;
            this.dataInformacionVivienda.urbanoRuralNombre =
                this.dataUsuario.US_URB_O_RURAL == "U" ? "Urbano" : "Rural";
            this.dataInformacionVivienda.barrio = this.dataUsuario.US_BARRIO;
            this.dataInformacionVivienda.tipo_de_casa = this.dataUsuario.TIPOCASA_COD;
            this.dataInformacionVivienda.tipoDeCasaNombre =
                this.dataUsuario.tipo_casa != null
                    ? this.dataUsuario.tipo_casa.TIPOCASA_NOM
                    : "";
            this.dataInformacionVivienda.referencia_domicilio = this.dataUsuario.US_REFERENCIA_DOMICILIO;
            this.dataInformacionVivienda.latitud = parseFloat(
                this.dataUsuario.US_LATITUD
            );
            this.dataInformacionVivienda.longitud = parseFloat(
                this.dataUsuario.US_LONGITUD
            );
            this.latitud = parseFloat(this.dataUsuario.US_LATITUD);
            this.longitud = parseFloat(this.dataUsuario.US_LONGITUD);
            //INFORMACIÓN NACIMIENTO
            this.dataInformacionNacimiento.fecha_nacimiento = this.dataUsuario.US_FNAC;
            this.dataInformacionNacimiento.lugar_nacimiento = this.dataUsuario.US_LNACIMIENTO;
            this.dataInformacionNacimiento.pais = this.dataUsuario.PAIS_COD;
            this.dataInformacionNacimiento.paisNombre =
                this.dataUsuario.pais != null
                    ? this.dataUsuario.pais.PAIS_NOM
                    : "";
            this.dataInformacionNacimiento.parroquia = this.dataUsuario.PARR_COD;
            //INFORMACIÓN USUARIO
            this.dataInformacionCaracteristicaUsuario.estatura_metros = this.dataUsuario.US_ESTATURA_METROS;
            this.dataInformacionCaracteristicaUsuario.peso_kg = this.dataUsuario.US_PESO_KG;
            this.dataInformacionCaracteristicaUsuario.observacion = this.dataUsuario.US_OBS;
            this.dataInformacionCaracteristicaUsuario.talla_camisa = this.dataUsuario.TALLACAMISA_COD;
            this.dataInformacionCaracteristicaUsuario.porcentageDiscapacidad = this.dataUsuario.US_PORC_DISCAPACIDAD;
            if (this.dataUsuario.US_PORC_DISCAPACIDAD != "") {
                this.dataInformacionCaracteristicaUsuario.discapacidad = "S";
            }
            this.dataInformacionCaracteristicaUsuario.conadis = this.dataUsuario.US_CONADIS_DISCAPACIDAD;
            this.dataInformacionCaracteristicaUsuario.msp = this.dataUsuario.US_MSP_DISCAPACIDAD;
            this.dataInformacionCaracteristicaUsuario.tallaCamisaNombre =
                this.dataUsuario.talla_camisa !== null
                    ? this.dataUsuario.talla_camisa.TALLACAMISA_NOM
                    : "";
            this.dataInformacionCaracteristicaUsuario.talla_pantalon = this.dataUsuario.TALLAPANTALON_COD;
            this.dataInformacionCaracteristicaUsuario.tallaPantalonNombre =
                this.dataUsuario.talla_pantalon != null
                    ? this.dataUsuario.talla_pantalon.TALLAPANTALON_NOM
                    : "";
            this.dataInformacionCaracteristicaUsuario.talla_zapato = this.dataUsuario.TALLAZAPATO_COD;
            this.dataInformacionCaracteristicaUsuario.tallaZapatoNombre =
                this.dataUsuario.talla_zapato != null
                    ? this.dataUsuario.talla_zapato.TALLAZAPATO_NOM
                    : "";
            this.dataInformacionCaracteristicaUsuario.movilizacion = this.dataUsuario.MOVILIZACION_COD;
            this.dataInformacionCaracteristicaUsuario.movilizacionNombre =
                this.dataUsuario.movilizacion != null
                    ? this.dataUsuario.movilizacion.MOVILIZACION_NOM
                    : "";
            /* Discapacidades */    
            this.dataInformacionCaracteristicaUsuario.discapacidades = this.dataUsuario.DISCAPACIDAD_COD;
            this.dataInformacionCaracteristicaUsuario.discapacidadesNombre =
                this.dataUsuario.discapacidad != null
                    ? this.dataUsuario.discapacidad.DISCAPACIDAD_NOM
                    : "";    
            /* Fin Discapacidades */    
            this.dataInformacionCaracteristicaUsuario.pdfMsp = this.dataUsuario.US_MSP_PDF;
            this.dataInformacionCaracteristicaUsuario.pdfConadis = this.dataUsuario.US_CONADIS_PDF;            
        }
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales.usuarios
            .datos.crear_usuario.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Ingreso"
        );
    },
    beforeDestroy: function() {
        let nombreModulo = this.$nombresModulo.datos_generales;
        let nombreFormulario = this.$nombresFormulario.datos_generales.usuarios
            .datos.crear_usuario.nombre_formulario;
        this.$funcionesGlobales.registrarLogForm(
            nombreModulo,
            nombreFormulario,
            "Salida"
        );
    },
    methods: {
        limpiarErrores() {
            this.errorInformacionSistema = {
                fotoUsuario: "", //yess
                tipoIdentificacion: "", //yess
                identificacionCedula: "", //yess
                identificacionPasaporte: "", //yess
                identificacion17Digitos: "", //yess
                codigoRegistroNuevo: "",
                password: "",
                password_confirmation: "",
                activo: "", //yes
                trabajadorBSPI: "", //yes
                alias: ""
            };

            this.errorInformacionPersonal = {
                primer_apellido: "",
                segundo_apellido: "",
                primer_nombre: "",
                segundo_nombre: "",
                email_institucional: "",
                email_alternativo: "",
                telefono: "",
                celular: "",
                sexo: "",
                estado_civil: "",
                tipo_sangre: "",
                religion: "",
                grupo_cultural: "",
                nombre_contacto_emergencia: "",
                telefono_contacto_emergencia: "",
                pdf_cedula: ""
            };

            this.errorInformacionNacimiento = {
                fecha_nacimiento: "",
                lugar_nacimiento: "",
                pais: "",
                parroquia: ""
            };

            this.errorInformacionVivienda = {
                direccion: "",
                urbano_rural: "",
                barrio: "",
                tipo_de_casa: "",
                tipo_casa: "",
                referencia_domicilio: "",
                latitud: "",
                longitud: ""
            };

            this.errorInformacionCaracteristicaUsuario = {
                estatura_metros: "",
                peso_kg: "",
                observacion: "",
                talla_camisa: "",
                talla_pantalon: "",
                talla_zapato: "",
                movilizacion: "",
                movilizacionNombre: "",
                discapacidad: "",
                porcentageDiscapacidad: "",
                conadis: "",
                msp: "",
                pdfConadis: "",
                pdfMsp: ""
            };
        },
        validarCedula(cedula) {
            //var cedula = '0931811087';

            //Preguntamos si la cedula consta de 10 digitos
            if (cedula.length == 10) {
                //Obtenemos el digito de la region que sonlos dos primeros digitos
                var digito_region = cedula.substring(0, 2);

                //Pregunto si la region existe ecuador se divide en 24 regiones
                if (digito_region >= 1 && digito_region <= 24) {
                    // Extraigo el ultimo digito
                    var ultimo_digito = cedula.substring(9, 10);

                    //Agrupo todos los pares y los sumo
                    var pares =
                        parseInt(cedula.substring(1, 2)) +
                        parseInt(cedula.substring(3, 4)) +
                        parseInt(cedula.substring(5, 6)) +
                        parseInt(cedula.substring(7, 8));

                    //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
                    var numero1 = cedula.substring(0, 1);
                    var numero1 = numero1 * 2;
                    if (numero1 > 9) {
                        var numero1 = numero1 - 9;
                    }

                    var numero3 = cedula.substring(2, 3);
                    var numero3 = numero3 * 2;
                    if (numero3 > 9) {
                        var numero3 = numero3 - 9;
                    }

                    var numero5 = cedula.substring(4, 5);
                    var numero5 = numero5 * 2;
                    if (numero5 > 9) {
                        var numero5 = numero5 - 9;
                    }

                    var numero7 = cedula.substring(6, 7);
                    var numero7 = numero7 * 2;
                    if (numero7 > 9) {
                        var numero7 = numero7 - 9;
                    }

                    var numero9 = cedula.substring(8, 9);
                    var numero9 = numero9 * 2;
                    if (numero9 > 9) {
                        var numero9 = numero9 - 9;
                    }

                    var impares =
                        numero1 + numero3 + numero5 + numero7 + numero9;

                    //Suma total
                    var suma_total = pares + impares;

                    //extraemos el primero digito
                    var primer_digito_suma = String(suma_total).substring(0, 1);

                    //Obtenemos la decena inmediata
                    var decena = (parseInt(primer_digito_suma) + 1) * 10;

                    //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
                    var digito_validador = decena - suma_total;

                    //Si el digito validador es = a 10 toma el valor de 0
                    if (digito_validador == 10) var digito_validador = 0;

                    //Validamos que el digito validador sea igual al de la cedula
                    if (digito_validador == ultimo_digito) {
                        this.validCedula = true;
                    } else {
                        this.validCedula = false;
                    }
                } else {
                    // imprimimos en consola si la region no pertenece
                    this.validCedula = false;
                }
            } else {
                //imprimimos en consola si la cedula tiene mas o menos de 10 digitos
                this.validCedula = false;
            }
        },
        guardar() {
            if (
                this.validCedula == false &&
                this.dataInformacionSistema.tipoIdentificacion == "CEDULA"
            ) {
                this.$swal({
                    icon: "error",
                    title: "Existen errores",
                    text:
                        "Cedula ingresada es invalida, por favor vuelva a revisar!"
                });
            } else {
                let that = this;
                that.form = new FormData();
                that.form.append(
                    "fotoUsuario",
                    that.dataInformacionSistema.fotoUsuario
                );
                that.form.append(
                    "pdfCedula",
                    that.dataInformacionPersonal.pdf_cedula
                );
                that.form.append(
                    "pdfConadis",
                    that.dataInformacionCaracteristicaUsuario.pdfConadis
                );
                that.form.append(
                    "pdfMsp",
                    that.dataInformacionCaracteristicaUsuario.pdfMsp
                );

                const config = {
                    headers: { "content-type": "multipart/form-data" }
                };
                that.limpiarErrores();
                var loader = that.$loading.show();
                axios
                    .post(
                        "/datos_generales/usuarios/guardarArchivos",
                        that.form,
                        config
                    )
                    .then(function(response) {
                        loader.hide();
                        that.guardarActualizar(
                            response.data.pathFoto,
                            response.data.pathCedula,
                            response.data.pathMSP,
                            response.data.pathConadis
                        );
                    })
                    .catch(error => {
                        if (!error.response) {
                            // network error
                            this.errorStatus = "Error: Network Error";
                        } else {
                            this.errorStatus = error.response.data.message;
                        }
                        loader.hide();
                    });
            }
        },
        actualizarLatitud(value) {
            this.latitud = value;
        },
        actualizarLongitud(value) {
            this.longitud = value;
        },
        actualizarDataInformacionSistema(field, value) {
            this.dataInformacionSistema[field] = value;
            if (field == "identificacionCedula") {
                this.validarCedula(value);
            }
        },
        actualizarDataInformacionPersonal(field, value) {
            this.dataInformacionPersonal[field] = value;
        },
        actualizarDataInformacionNacimiento(field, value) {
            this.dataInformacionNacimiento[field] = value;
        },
        actualizarDataInformacionVivienda(field, value) {
            this.dataInformacionVivienda[field] = value;
        },
        actualizarDataInformacionCaracteristicaUsuario(field, value) {
            this.dataInformacionCaracteristicaUsuario[field] = value;
        },
        cargarInfo() {
            //this.organismosS = this.$props.organismos;
            //this.cargosA = this.$props.cargos;
            //this.usuariosA = this.$props.usuarios;
        },
        limpiarForm() {
            this.US_COD = "";
            this.form = new FormData();
            //Informacion Sistema

            this.dataInformacionSistema = {
                fotoUsuario: "", //yess
                tipoIdentificacion: "", //yess //combo
                identificacionCedula: "", //yess
                identificacionPasaporte: "", //yess
                identificacion17Digitos: "", //yess
                codigoRegistroNuevo: "",
                password: "", //yess
                password_confirmation: "",
                activo: "", //yess //combo
                trabajadorBSPI: "", //yes //combo
                alias: "",
                fotoURL: ""
            };
            //InformacionPersonal
            this.latitud = -2.213499;
            this.longitud = -79.887541;

            this.dataInformacionPersonal = {
                primer_apellido: "",
                segundo_apellido: "",
                primer_nombre: "",
                segundo_nombre: "",
                email_institucional: "",
                email_alternativo: "",
                telefono: "",
                celular: "",
                sexo: "",
                sexoNombre: "",
                estado_civil: "",
                estadoCivilNombre: "",
                tipo_de_sangre: "",
                tipoSangreNombre: "",
                religion: "",
                religionNombre: "",
                grupo_cultural: "",
                grupoCulturalNombre: "",
                nombre_contacto_emergencia: "",
                telefono_contacto_emergencia: "",
                pdf_cedula: ""
            };

            this.dataInformacionNacimiento = {
                fecha_nacimiento: "",
                lugar_nacimiento: "",
                pais: "",
                paisNombre: "",
                parroquia: ""
            };

            this.dataInformacionVivienda = {
                direccion: "",
                urbano_rural: "",
                urbanoRuralNombre: "",
                barrio: "",
                tipo_de_casa: "",
                tipo_casa: "",
                tipoDeCasaNombre: "",
                referencia_domicilio: "",
                latitud: "",
                longitud: ""
            };

            this.dataInformacionCaracteristicaUsuario = {
                estatura_metros: "",
                peso_kg: "",
                observacion: "",
                talla_camisa: "",
                tallaCamisaNombre: "",
                talla_pantalon: "",
                tallaPantalonNombre: "",
                talla_zapato: "",
                tallaZapatoNombre: "",
                movilizacion: "",
                movilizacionNombre: "",
                discapacidad: "N",
                porcentageDiscapacidad: "",
                conadis: "",
                msp: "",
                pdfConadis: "",
                pdfMsp: ""
            };
        },
        guardarActualizar(pathFoto, pathCedula, pathMSP, pathConadis) {
            let that = this;
            let url = "";
            let mensaje = "";
            if (this.$props.esAdmisiones) {
                let pswd = this.dataInformacionPersonal.email_institucional.trim();
                this.dataInformacionSistema.password = pswd.substring(0, 12); //yess
                this.dataInformacionSistema.password_confirmation = pswd.substring(
                    0,
                    12
                );
                this.dataInformacionSistema.activo = "S";
            }
            let sendForm = {
                sistemas: that.dataInformacionSistema,
                personal: that.dataInformacionPersonal,
                nacimiento: that.dataInformacionNacimiento,
                caracteristicas: that.dataInformacionCaracteristicaUsuario,
                vivienda: that.dataInformacionVivienda,
                foto: pathFoto,
                cedula_pdf: pathCedula,
                conadis_pdf: pathConadis,
                msp_pdf: pathMSP,
                US_COD: that.US_COD
            };
            if (this.dataUsuario === null) {
                url = "/datos_generales/usuarios/guardar_usuario";
                mensaje = "Datos guardados correctamente.";
            } else {
                url = "/datos_generales/usuarios/modificar_usuario";
                mensaje = "Datos guardados modificados.";
            }
            var loader = that.$loading.show();
            axios
                .post(url, sendForm)
                .then(function(response) {
                    //Llamar metodo de parent para que actualice el grid.
                    loader.hide();

                    that.$emit("recargarUsuarios");
                    that.$emit("cerrarModalCrearUsuario");
                    that.$swal({
                        icon: "success",
                        title: "Proceso realizado exitosamente",
                        text: "Datos actualizados correctamente."
                    });
                    that.limpiarForm();
                })
                .catch(error => {
                    //Errores de validación

                    if (error.response.status === 422) {
                        that.errorInformacionPersonal.email_institucional =
                            error.response.data.errors[
                                "personal.email_institucional"
                            ] != undefined
                                ? error.response.data.errors[
                                      "personal.email_institucional"
                                  ]
                                : "";

                        that.errorInformacionPersonal.email_alternativo =
                            error.response.data.errors[
                                "personal.email_alternativo"
                            ] != undefined
                                ? error.response.data.errors[
                                      "personal.email_alternativo"
                                  ]
                                : "";
                        that.errorInformacionPersonal.primer_nombre =
                            error.response.data.errors[
                                "personal.primer_nombre"
                            ] != undefined
                                ? error.response.data.errors[
                                      "personal.primer_nombre"
                                  ]
                                : "";
                        that.errorInformacionPersonal.primer_apellido =
                            error.response.data.errors[
                                "personal.primer_apellido"
                            ] != undefined
                                ? error.response.data.errors[
                                      "personal.primer_apellido"
                                  ]
                                : "";
                        that.errorInformacionPersonal.sexo =
                            error.response.data.errors[
                                "personal.sexo"
                            ] != undefined
                                ? error.response.data.errors[
                                      "personal.sexo"
                                  ]
                                : "";        
                        that.errorInformacionSistema.password =
                            error.response.data.errors["sistemas.password"] !=
                            undefined
                                ? error.response.data.errors[
                                      "sistemas.password"
                                  ]
                                : "";
                        that.errorInformacionNacimiento.fecha_nacimiento =
                            error.response.data.errors["nacimiento.fecha_nacimiento"] !=
                            undefined
                                ? error.response.data.errors[
                                      "nacimiento.fecha_nacimiento"
                                  ]
                                : "";        
                        loader.hide();
                        that.$swal({
                            icon: "error",
                            title: "Existen errores",
                            text:
                                "Compruebe los errores en el formulario, se presentan errores de validación"
                        });
                    } else {
                        loader.hide();
                        if (error.response.status === 403) {
                            that.$swal({
                                icon: "error",
                                title: "Existen errores",
                                text: error.response.data.mensaje
                            });
                        } else {
                            that.$swal({
                                icon: "error",
                                title: "Existen errores",
                                text: error
                            });
                        }
                    }
                });
        }
    }
};
</script>
