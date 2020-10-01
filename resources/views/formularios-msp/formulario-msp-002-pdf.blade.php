</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario MSP-002 {{$cita->paciente->US_NOM.' '.$cita->paciente->US_APELL}}</title>
    <style>
        #header,
        #logo {
            position: fixed;
            top: -50px;
            left: 0px;
            right: 0px;
        }

        .page:after {
            content: counter(page, arial);
        }

        .cabecera th {
            background-color: #D2F0CA;
            text-align: center;
            top: -50px;
        }

        .cabecera td {
            text-align: center;
        }

        .general th {
            text-align: center;
        }

        .piePagina {
            position: fixed;
            left: 0px;
            right: 0px;
            bottom: 30px;
            text-align: center;
        }

        td {
            text-align: left;
            border: 1px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #F8AEDC;
            text-align: left;
            height: 2.5%;
        }

        body {
            font-size: 12px;
            font-family: Helvetica, Futura, Arial, Verdana, sans-serif;
        }

        .derecha {
            float: right;
        }

        .izquierda {
            float: left;
        }

        /* Para los bordes de la tabla */
        .bordered-no {
            border: 0px;
            border-top: 0px;
            border-right: 0px;
            border-left: 0px;
        }

        .bordered-no-componet th,
        .bordered-no-componet td {
            background-color: white;
            border-right: 0px;
            border-left: 0px;
            border-top: 0px solid black;
        }

        .bordered {
            border: 1px solid black;
        }

        .bordered-top-right {
            border-top: 1px solid black;
            border-right: 1px solid black;
        }

        .bordered-top {
            border-top: 1px solid black;
        }

        .bordered-no-side {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .bordered-no-left {
            border-right: 1px solid black;
        }

        .bordered-no-right {
            border-left: 1px solid black;
        }
    </style>
</head>

<body>
    <!-- 0 Cabecera -->
    <table class="cabecera">
        <thead>
            <tr>
                <th class="bordered">ESTABLECIMIENTO</th>
                <th class="bordered">NOMBRE</th>
                <th class="bordered">APELLIDO</th>
                <th class="bordered">SEXO
                    <table>
                        <tbody>
                            <tr>
                                <th class="bordered-top-right">M</th>
                                <th class="bordered-top">F</th>
                            </tr>
                        </tbody>
                    </table>
                </th>
                <th class="bordered">NÚMERO DE HOJA</th>
                <th class="bordered">HISTORIA CLÍNICA</th>
            </tr>
        </thead>
        <tbody>
            @if ($cita != null)
            <tr>
                <td>{{$cita->ESTADO_INICIAL_CITA->especialidad->hospital->HOSPITAL_NOM}} </td>
                <td>{{$cita->paciente->US_NOM}}</td>
                <td>{{$cita->paciente->US_APELL}}</td>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                @if ($cita->paciente->US_SEXO === 'M')
                                <td style="border-right: 1px solid black;background-color: yellow;color: yellow;" class="bordered-no">M</td>
                                <td style="color: white;" class="bordered-no">F</td>
                                @elseif ($cita->paciente->US_SEXO === 'F')
                                <td style="border-right: 1px solid black; color: white;" class="bordered-no">M</td>
                                <td style="background-color: yellow;color: yellow;" class="bordered-no">F</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class="page"></td>
                <td>{{$cita->paciente->US_HISTORIACLINICACOD}}</td>
            </tr>
            @else
            <tr>
                <td style="height: 15px;"></td>
                <td></td>
                <td></td>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td class="bordered-no"></td>
                                <td class="bordered-no"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td></td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>
    <br>
    <!-- 1 MOTIVO DE CONSULTA -->
    <table>
        <thead>
            <tr>
                <th class="bordered">1 MOTIVO DE CONSULTA</th>
            </tr>
        </thead>
        <tbody>
            @if ($cita != null)
            @if ($cita->antecedente != null)
            <tr>
                <td> {{$cita->antecedente->ANTECEDENTE_MOTIVO_CONSULTA}} </td>
            </tr>
            @else
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            @endif
            @endif
        </tbody>
    </table>
    <br>
    <!-- 2 ANTECEDENTES PERSONALES -->
    <table>
        <thead>
            <tr>
                <th class="bordered">2 ANTECEDENTES PERSONALES</th>

            </tr>
        </thead>
        <tbody>
            @if ($cita != null)
            @if ($cita->antecedente != null)
            <tr>
                <td> {{$cita->antecedente->ANTECEDENTE_PERSONALES}} </td>
            </tr>
            @else
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            @endif
            @endif
        </tbody>
    </table>
    <br>
    <!-- 3 ANTECEDENTES FAMILIARES -->
    <table>
        <thead>
            <tr>
                <th class="bordered">3 ANTECEDENTES FAMILIARES</th>

            </tr>
        </thead>
        <tbody>
            @if ($cita != null)
            @if ($cita->antecedente != null)
            <tr>
                <td>{{$antecedenteFamiliar}}</td>
            </tr>
            @else
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            @endif
            @endif
        </tbody>
    </table>
    <br>
    <!-- 4 ENFERMEDAD O PROBLEMA ACTUAL -->
    <table>
        <thead>
            <tr>
                <th class="bordered">4 ENFERMEDAD O PROBLEMA ACTUAL</th>

            </tr>
        </thead>
        <tbody>
            @if ($cita != null)
            @if ($cita->antecedente != null)
            <tr>
                <td>{{$cita->antecedente->ANTECEDENTE_ENFERMEDAD_ACTUAL_PROBLEMA}}</td>
            </tr>
            @else
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            @endif
            @endif
        </tbody>
    </table>
    <br>
    <!-- 5 REVISION ACTUAL DE ORGANOS Y SISTEMAS -->
    <table>
        <thead>
            <tr>
                <th class="bordered">5 REVISIÓN ACTUAL DE ORGANOS Y SISTEMAS</th>

            </tr>
        </thead>
        <tbody>
            @if ($cita != null)
            @if ($cita->antecedente != null)
            <tr>
                <td>{{$cita->antecedente->ANTECEDENTE_REVISION_ACTUAL_ORGANO_SISTEMA}}</td>
            </tr>
            @else
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            @endif
            @endif
        </tbody>
    </table>
    <br>
    <!-- 6 SIGNOS VITALES -->
    <table>
        <thead>
            <tr>
                <th class="bordered">6 SIGNOS VITALES</th>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            @if ($citaArray != null)
            <tr>
                <th style="width: 10%; background-color: #D2F0CA;text-align: left;" class="bordered">FECHA</th>
                @forelse($citaArray as $signosVitales)
                @if ($signosVitales->informacionInicial != null)
                <td>{{$signosVitales->informacionInicial->INFORMACIONINICIAL_FECHA}} </td>
                @endif
                @empty
                <td colspan="8"><strong>Sin Datos.</strong></td>
                @endforelse
            </tr>
            <tr>
                <th style="background-color: #D2F0CA;text-align: left;" class="bordered">PRESIÓN ARTERIAL</th>
                @forelse($citaArray as $signosVitales)
                @if ($signosVitales->informacionInicial != null)
                <td>{{$signosVitales->informacionInicial->INFORMACIONINICIAL_PRESION_ARTERIAL}} </td>
                @endif
                @empty
                <td colspan="8"><strong>Sin Datos.</strong></td>
                @endforelse
            </tr>
            <tr>
                <th style="background-color: #D2F0CA;text-align: left;" class="bordered">PULSO X min</th>
                @forelse($citaArray as $signosVitales)
                @if ($signosVitales->informacionInicial != null)
                <td>{{$signosVitales->informacionInicial->INFORMACIONINICIAL_PULSO}} </td>
                @endif
                @empty
                <td colspan="8"><strong>Sin Datos.</strong></td>
                @endforelse
            </tr>
            <tr>
                <th style="background-color: #D2F0CA;text-align: left;" class="bordered">TEMPERATURA °C</th>
                @forelse($citaArray as $signosVitales)
                @if ($signosVitales->informacionInicial != null)
                <td>{{$signosVitales->informacionInicial->INFORMACIONINICIAL_TEMPERATURA}} </td>
                @endif
                @empty
                <td colspan="8"><strong>Sin Datos.</strong></td>
                @endforelse
            </tr>
            @else
            <tr>
                <th style="width: 10%; background-color: #D2F0CA;text-align: center;" class="bordered">FECHA</th>
                <td></td>
            </tr>
            <tr>
                <th style="background-color: #D2F0CA;text-align: center;" class="bordered">PESION ARTERIAL</th>
                <td></td>
            </tr>
            <tr>
                <th style="background-color: #D2F0CA;text-align: center;" class="bordered">PULSO X min</th>
                <td></td>
            </tr>
            <tr>
                <th style="background-color: #D2F0CA;text-align: center;" class="bordered">TEMPERATURA °C</th>
                <td></td>
            </tr>
            @endif
        </thead>
        <tbody>

        </tbody>
    </table>
    <br>
    <!-- 7 EXAMEN FISICO -->
    <table>
        <thead>
            <tr>
                <th class="bordered">7 EXAMEN FÍSICO</th>

            </tr>
        </thead>
        <tbody>
            @if ($cita != null)
            @if ($cita->examenFisico != null)
            <tr>
                <td> {{$examenFisico}} </td>
            </tr>
            @else
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            @endif
            @endif
        </tbody>
    </table>
    <br>
    <!-- 8 DIAGNOSTICOS -->
    <table>
        <thead>
            <tr>
                <th style="text-align: center; border-right: 0px solid black;width: 3%;" class="bordered">8</th>
                <th style="border-left: 0px solid black;" class="bordered">DIAGNÓSTICOS</th>
                <th style="text-align: center;border-right: 0px solid black;width:6%;" class="bordered">CIE</th>
                <th style="text-align: center;border-left: 0px solid black;border-right: 0px solid black;width:3%;" class="bordered">PRE</th>
                <th style="text-align: center;border-left: 0px solid black;width:3%;" class="bordered">DEF</th>
                <th style="color: #F8AEDC;border-right: 0px solid black;width: 3%;" class="bordered">8</th>
                <th style="border-left: 0px solid black;width: 32%;" class="bordered">PRE= PRESUNTIVO DEF= DEFINITIVO</th>
                <th style="text-align: center;border-right: 0px solid black;width:6%;" class="bordered">CIE</th>
                <th style="text-align: center;border-left: 0px solid black;border-right: 0px solid black;width:3%;" class="bordered">PRE</th>
                <th style="text-align: center;border-left: 0px solid black;width:3%;" class="bordered">DEF</th>
            </tr>
        </thead>
        <tbody>
            @if ($cita != null)
            <!-- Cuando el arreglo es de 1 -->
            @if (count($cita->diagnostico) == 1)
            <tr>
                <!-- Primera Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">1</td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[0]->cie->CIE_DESCRIPCION}} </td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[0]->cie->CIE_CLAVE}} </td>
                @if ($cita->diagnostico[0]->cie->DIAGNOSTICO_PRESUNTIVO === 1)
                <td style="background-color: yellow; text-align: center;width: 5%;" class="bordered"></td>
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                @else
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                @endif
                <!-- Segunda Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">3</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>               
            </tr>
            <tr>
                <!-- Primera Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">2</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <!-- Segunda Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">4</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
            </tr>
            @elseif(count($cita->diagnostico) == 2)
            <tr>
                <!-- Primera Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">1</td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[0]->cie->CIE_DESCRIPCION}} </td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[0]->cie->CIE_CLAVE}} </td>
                @if ($cita->diagnostico[0]->cie->DIAGNOSTICO_PRESUNTIVO === 1)
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                @else
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                @endif
                <!-- Segunda Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">3</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>               
            </tr>
            <tr>
                <!-- Primera Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">2</td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[1]->cie->CIE_DESCRIPCION}} </td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[1]->cie->CIE_CLAVE}} </td>
                @if ($cita->diagnostico[1]->cie->DIAGNOSTICO_PRESUNTIVO === 1)
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                @else
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                @endif
                <!-- Segunda Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">4</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
            </tr>
            @elseif(count($cita->diagnostico) == 3)
            <tr>
                <!-- Primera Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">1</td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[0]->cie->CIE_DESCRIPCION}} </td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[0]->cie->CIE_CLAVE}} </td>
                @if ($cita->diagnostico[0]->cie->DIAGNOSTICO_PRESUNTIVO === 1)
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                @else
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                @endif
                <!-- Segunda Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">3</td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[2]->cie->CIE_DESCRIPCION}} </td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[2]->cie->CIE_CLAVE}} </td>
                @if ($cita->diagnostico[2]->cie->DIAGNOSTICO_PRESUNTIVO === 1)
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                @else
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                @endif              
            </tr>
            <tr>
                <!-- Primera Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">2</td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[1]->cie->CIE_DESCRIPCION}} </td>
                <td style="text-align: center;" class="bordered"> {{$cita->diagnostico[1]->cie->CIE_CLAVE}} </td>
                @if ($cita->diagnostico[1]->cie->DIAGNOSTICO_PRESUNTIVO === 1)
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                <td style="text-align: center;width: 5%;" class="bordered"></td>
                @else
                <td style="text-align: center;width: 5%;" class="bordered-n"></td>
                <td style="background-color: yellow;text-align: center;width: 5%;" class="bordered"></td>
                @endif
                <!-- Segunda Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">4</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
            </tr>
            @endif
            @else
            <tr>
                <!-- Primera Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">1</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>  
                <!-- Segunda Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">3</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>               
            </tr>
            <tr>
                <!-- Primera Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">2</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <!-- Segunda Parte -->
                <td style="background-color: #D2F0CA; text-align: center;">4</td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
            </tr>
            @endif
        </tbody>
    </table>
    <br>
    <!-- 9 PLANES DE DIAGNOSTICO, TERAPEUTICOS Y EDUCACIONALES -->
    <table>
        <thead>
            <tr>
                <th class="bordered">9 PLANES DE DIAGNÓSTICO, TERAPÉUTICOS Y EDUCACIONALES </th>
            </tr>
        </thead>
        <tbody>
            @if ($cita != null )
                @if(sizeOf($cita->diagnostico)>0)
                    <tr>
                        <td>{{$cita->diagnostico[0]->DIAGNOSTICO_PLAN}}</td>
                    </tr>
                @else 
                    <tr>
                        <td style="height: 15px;"></td>
                    </tr>
                @endif
            @else
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            @endif
        </tbody>
    </table>
    <!-- 10 PIE DE PAGINA Seccion para la informacion del doctor-->
    <table style="position: absolute;bottom: 100px;">
        <thead>
            <tr class="bordered-no-componet">
                <th></th>
                <td></td>
                <th></th>
                <td></td>
                <th></th>
                <td></td>
                <td style="font-size: 9px;text-align: center;">código</td>
                <th></th>
                <td></td>
            </tr>
            @if($cita != null)
            <tr>
                <th style="width: 13%; background-color: #D2F0CA;text-align: center;" class="bordered">FECHA PARA CONTROL</th>
                <td style="width: 10%;text-align: center;"> {{$cita->ESTADO_FINAL_CITA->ESTADOCITA_FECHA}} </td>
                <th style="background-color: #D2F0CA;text-align: center;" class="bordered">HORA FIN</th>
                <td style="width: 5%;text-align: center;"> {{$cita->ESTADO_FINAL_CITA->ESTADOCITA_HORA_FINAL}} </td>
                <th style="width: 5%;background-color: #D2F0CA;text-align: center;" class="bordered">MÉDICO</th>
                <td style="text-align: center;width: 20%;">{{$cita->ESTADO_FINAL_CITA->doctor->user->FULL_NAME}}</td>
                <td style="text-align: center;width: 5%;">{{$cita->ESTADO_FINAL_CITA->doctor->user->US_COD}}</td>
                <th style="width: 5%;background-color: #D2F0CA;text-align: center;" class="bordered">FIRMA</th>
                <td style="text-align: center;">{{$cita->ESTADO_FINAL_CITA->doctor->user->FULL_NAME}}</td>
            </tr>
            @else
            <tr>
                <th style="width: 13%; background-color: #D2F0CA;" class="bordered">FECHA PARA CONTROL</th>
                <td></td>
                <th style="background-color: #D2F0CA;" class="bordered">HORA FIN</th>
                <td style="width: 8%;"></td>
                <th style="width: 5%;background-color: #D2F0CA;" class="bordered">MÉDICO</th>
                <td style="width: 20%;"></td>
                <td style="width: 5%;"></td>
                <th style="width: 5%;background-color: #D2F0CA;" class="bordered">FIRMA</th>
                <td></td>
            </tr>
            @endif
        </thead>
    </table>
    <table style="position: fixed;bottom: 0px;">
        <thead>
            <tr>
                <th style="background-color: white;">SNS-MSP / HCU-form.002 / 2020 <span class="derecha">CONSULTA EXTERNA - ANAMNESIS Y EF</span></th>
            </tr>
        </thead>
    </table>
    <!-- Salto de linea, para que me envie a la otra pagina -->
    <!-- 11 EVOLUCION Y PRESCIONES -->
    <div style="page-break-after:always;"></div>
    <table class="general">
        <thead>
            <tr>
                <th style="width:10%;" class="bordered">FECHA
                    <table>
                        <tbody>
                            <tr>
                                <th>(DÍA/MES/AÑO)</th>
                            </tr>
                        </tbody>
                    </table>
                </th>
                <th style="width:5%;" class="bordered">HORA</th>
                <th class="bordered">EVOLUCIÓN
                    <table>
                        <tbody>
                            <tr>
                                <th style="background-color: #D2F0CA;text-align: center;" class="bordered-top">FIRMAR AL PIE DE CADA NOTA DE EVOLUCIÓN</th>
                            </tr>
                        </tbody>
                    </table>
                </th>
                <th class="bordered">PRESCRIPCIONES
                    <table>
                        <tbody>
                            <tr>
                                <th style="background-color: #D2F0CA;text-align: center;" class="bordered-top">FIRMAR AL PIE DE CADA CONJUNTO DE PRESCRIPCIONES</th>
                            </tr>
                        </tbody>
                    </table>
                </th>
                <th style="width:5%;" class="bordered">MEDICAMENTOS
                    <table>
                        <tbody>
                            <tr>
                                <th style="background-color: #D2F0CA;text-align: center;" class="bordered-top">REGISTRAR ADMINISTR</th>
                            </tr>
                        </tbody>
                    </table>
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($citaArray != null)
            @forelse($citaArray as $prescripciones)
            @if ($prescripciones->prescripcion != null && sizeOf($prescripciones->prescripcion->prescripcionDetalle)>0 )
            <tr>
                <td style="text-align: center;">{{$prescripciones->prescripcion->PRESCRIPCION_FECHA}}</td>
                <td style="text-align: center;">{{$prescripciones->prescripcion->PRESCRIPCION_HORA}}</td>
                <td style="text-align: center;">{{$prescripciones->prescripcion->PRESCRIPCION_EVOLUCION}}</td>
                <td style="text-align: center;">Doctor: {{$prescripciones->prescripcion->medico[0]->user->FULL_NAME}}
                    <table>
                        <thead>
                            <tr>
                                <th class="bordered">Medicamento</th>
                                <th class="bordered">Observación</th>
                                <th class="bordered">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prescripciones->prescripcion->prescripcionDetalle as $pres)
                            <tr>
                                <td style="text-align: center;"> {{$pres->productoDetalle->presentacionProducto->productos->PRODUCTO_NOM.' -Presentacion: '.$pres->productoDetalle->presentacionProducto->presentaciones->PRESENTACIONFULLPRECIO}} </td>
                                <td style="text-align: center;">{{$pres->PRESC_DETA_OBS}}</td>
                                <td style="text-align: center;">{{$pres->PRESC_DETA_CANT}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <table>
                        <tbody>
                            <tr>
                                <td style="text-align: center;" class="bordered-no">{{$prescripciones->prescripcion->medico[0]->user->FULL_NAME}}</td>
                                <td style="text-align: center;" class="bordered-no">{{$cita->paciente->FULL_NAME}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;" class="bordered-no">{{$prescripciones->prescripcion->medico[0]->user->FULL_IDENTIFICATION}}</td>
                                <td style="text-align: center;" class="bordered-no">{{$cita->paciente->FULL_IDENTIFICATION}}</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th style="background-color: white;" class="bordered-no">Firma Doctor</th>
                                <th style="background-color: white;" class="bordered-no">Firma Paciente</th>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td style="text-align: center;">{{$prescripciones->prescripcion->PRESCRIPCION_TOTAL_ITEMS}}</td>
            </tr>
            @endif
            @empty
            <tr>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">Doctor:
                    <table>
                        <thead>
                            <tr>
                                <th class="bordered">Medicamento</th>
                                <th class="bordered">Observación</th>
                                <th class="bordered">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="height: 15px;text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>
                            <tr>
                                <td style="text-align: center;" class="bordered-no"></td>
                                <td style="text-align: center;" class="bordered-no"></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;" class="bordered-no"></td>
                                <td style="text-align: center;" class="bordered-no"></td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th style="background-color: white;" class="bordered-no">Firma Doctor</th>
                                <th style="background-color: white;" class="bordered-no">Firma Paciente</th>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            @endforelse
            @else
            <tr>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">Doctor:
                    <table>
                        <thead>
                            <tr>
                                <th class="bordered">Medicamento</th>
                                <th class="bordered">Observación</th>
                                <th class="bordered">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="height: 15px;text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>
                            <tr>
                                <td style="text-align: center;" class="bordered-no"></td>
                                <td style="text-align: center;" class="bordered-no"></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;" class="bordered-no"></td>
                                <td style="text-align: center;" class="bordered-no"></td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th style="background-color: white;" class="bordered-no">Firma Doctor</th>
                                <th style="background-color: white;" class="bordered-no">Firma Paciente</th>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td style="text-align: center;"></td>
            </tr>
            @endif
        </tbody>
    </table>
    <table style="position: fixed;bottom: 0px;">
        <thead>
            <tr>
                <th style="background-color: white;" class="text-center" colspan="4"><strong>SNS-MSP / HCU-form.002 / 2020 </strong></th>
                <th style="text-align: right;background-color: white;" colspan="4"><strong>CONSULTA EXTERNA - EVOLUCIÓN</strong></th>
            </tr>
        </thead>
    </table>
</body>

</html>