<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prescripción del Paciente</title>
    <style>
        html {
            margin: 70px 30px 60px;
        }

        .pagenum:before {
            content: counter(page);
        }

        #header,
        #logo {
            position: fixed;
            top: -50px;
            left: 0px;
            right: 0px;

        }

        #logo {
            text-align: right;
        }

        #footer {
            position: fixed;
            left: 0px;
            right: 0px;
            bottom: 30px;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        body {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-bottom {
            padding-bottom: 12px;
        }

        .bordered {
            border: 1px solid black;
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
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;
        }

        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        .table-bordered {
            border: 1px solid #c2cfd6;
        }

        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }

        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #c2cfd6;
        }

        th,
        td {
            display: table-cell;
            vertical-align: inherit;
        }

        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: center;
        }

        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }

        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .izquierda {
            float: left;
        }

        .derecha {
            float: right;
        }
    </style>

</head>

<body>
    <br>
    <!-- Seccion del logo y el N° de la Receta -->
    <header>
        <div id="logo">
            @if ($prescripcion != null)
            <img src="{{$prescripcion->hospital->HOSPITAL_LOGO}}" alt="logoHospital" id="imagen">
            @else
            <h5>No hay Logo</h5>
            @endif
        </div>
        <table>
            <tbody>
                @if ($prescripcion != null)
                <tr>
                    <td class="text-left" colspan="4"><strong>RECETA N°: {{ $prescripcion->PRESCRIPCION_COD }} </strong></td>
                </tr>
                @else
                <tr>
                    <td style="height: 15px;" class="text-left" colspan="4"><strong>RECETA N°:</strong></td>
                </tr>
                @endif
            </tbody>
        </table>
    </header>
    <br>
    <!-- Seccion de la informacion del hospital-->
    <table id="header">
        <tbody>
            @if ($prescripcion != null)
            <tr>
                <td class="text-center" colspan="4"><strong>HOSPITAL: {{$prescripcion->hospital->HOSPITAL_NOM}}</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>TELÉFONO: {{$prescripcion->hospital->HOSPITAL_TELF_CONTACTO}}</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>CORREO ELECTRONICO: {{$prescripcion->hospital->HOSPITAL_EMAIL_CONTACTO}}</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>PAGINA WEB: {{$prescripcion->hospital->HOSPITAL_WEB_PAGE}}</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>FECHA: {{ $fecha }} </strong></td>
            </tr>
            @else
            <tr>
                <td style="height: 15px;" class="text-center" colspan="4"><strong>HOSPITAL:</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>TELEFONO:</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>CORREO:</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>PAGINA WEB:</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>FECHA:</strong></td>
            </tr>
            @endif
        </tbody>
    </table>
    <br>
    <br>
    <!-- Seccion de la informacion del paciente y el doctor-->
    <table>
        <tbody>
            @if ($prescripcion != null)
            <tr>
                <td class="text-left" colspan="4"><strong>PACIENTE: {{$prescripcion->cita->paciente->FULL_NAME}}</strong></td>
                <td class="text-right" colspan="4"><strong>DOCTOR: {{$prescripcion->medico[0]->user->FULL_NAME}}</strong></td>
            </tr>
            <tr>
                <td class="text-left" colspan="4"><strong>DOCUMENTO IDENTIDAD: {{$prescripcion->cita->paciente->FULL_IDENTIFICATION}}</strong></td>

                <td class="text-right" colspan="4"><strong>ESPECIALIDAD: {{$prescripcion->medico[0]->funcionTrabajador->especialidad->ESPECIALIDAD_NOM}}</strong></td>
            </tr>
            <tr>
                <td class="text-left" colspan="4"><strong>FECHA NACIMIENTO: {{$prescripcion->cita->paciente->US_FNAC}}</strong></td>
                <td class="text-right" colspan="4"><strong>CORREO: {{$prescripcion->medico[0]->user->email}}</strong></td>
            </tr>
            <tr>
                <td class="text-left" colspan="4"><strong>EDAD: {{$edadPaciente}} </strong></td>
            </tr>
            @else
            <tr>
                <td class="text-left" colspan="4"><strong>PACIENTE:</strong></td>
                <td class="text-right" colspan="4"><strong>DOCTOR:</strong></td>
            </tr>
            <tr>
                <td class="text-left" colspan="4"><strong>DOCUMENTO IDENTIDAD:</strong></td>

                <td class="text-right" colspan="4"><strong>ESPECIALIDAD:</strong></td>
            </tr>
            <tr>
                <td class="text-left" colspan="4"><strong>FECHA NACIMIENTO:</strong></td>
                <td class="text-right" colspan="4"><strong>CORREO:</strong></td>
            </tr>
            <tr>
                <td class="text-left" colspan="4"><strong>EDAD:</strong></td>
            </tr>
            @endif
        </tbody>
    </table>
    <!-- Seccion donde lista los productos de la prescripcion-->
    <table class="table table-bordered table-striped table-sm">
        <tbody>
            <tr>
                <!-- <th class="bordered">#</th> -->
                <th class="bordered">Producto</th>
                <th class="bordered">Observacion</th>
                <th class="bordered">Precio</th>
                <th class="bordered">Cantidad</th>
                <th class="bordered">Subtotal</th>
            </tr>
            @if ($prescripcion != null)
            @forelse ($prescripcion->prescripcionDetalle as $pre)
            <tr>
                <!-- <td></td> -->
                <td align="center">{{ $pre->productoDetalle->presentacionProducto->productos->PRODUCTO_NOM.' -Presentacion: '.$pre->productoDetalle->presentacionProducto->presentaciones->PRESENTACIONFULLPRECIO }}</td>
                <td align="center">{{ $pre->PRESC_DETA_OBS }}</td>
                <td align="right">$ {{ $pre->PRESC_DETA_PVP }}</td>
                <td align="right">{{ $pre->PRESC_DETA_CANT }}</td>
                <td align="right">$ {{ $pre->PRESC_DETA_TOTAL }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8"><strong>Sin Datos.</strong></td>
            </tr>
            @endforelse
            <tr style="font-weight: bold">
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="right">Total {{$totalSuma}}</td>
            </tr>
            @else
            <tr style="font-weight: bold">
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="right">Total</td>
            </tr>
            @endif
        </tbody>
    </table>
    <br>
    <!-- Seccion de Nota.-->
    <div>
        <span style="font-weight: bold;font-size: 14px;">Nota: Para el retiro de los medicamentos ir la(s) farmacia(s).</span>
        <span>    
            <br>
            @if ($prescripcion != null)
            @forelse ($prescripcion->prescripcionDetalle as $pre)
            <span style="font-weight: bold;font-size: 14px;">*Medicamento: </span><span>{{ $pre->productoDetalle->presentacionProducto->productos->PRODUCTO_NOM.' -Presentacion: '.$pre->productoDetalle->presentacionProducto->presentaciones->PRESENTACIONFULLPRECIO }}</span> - <span style="font-weight: bold;font-size: 14px;">Farmacia:</span> <span>{{ $pre->productoDetalle->farmacia->FARMACIA_NOM }}</span>
            <br>
            @empty
            @endforelse
            @else
            <span>*Medicamento: - Farmacia: </span>
            @endif
        </span>
    </div>
    <br>
    <br>
    <!-- Seccion de Pie de Pagina.-->
    <table id="footer">
        <tbody>
            @if ($prescripcion != null)
            <tr>
                <td class="text-left" colspan="4"><strong>{{$prescripcion->PRESCRIPCION_DOCTOR_FIRMA}}</strong></td>
                <td class="text-right" colspan="4"><strong>{{$prescripcion->PRESCRIPCION_PACIENTE_FIRMA}}</strong></td>
            </tr>
            <tr>
                <td class="text-left" colspan="4"><strong>{{$prescripcion->medico[0]->user->FULL_IDENTIFICATION}}</strong></td>
                <td class="text-right" colspan="4"><strong>{{$prescripcion->cita->paciente->FULL_IDENTIFICATION}}</strong></td>
            </tr>
            <tr>
                <td style="font-size: 20px;" class="text-left" colspan="4"><strong>Firma del Doctor</strong></td>
                <td style="font-size: 20px;" class="text-right" colspan="4"><strong>Firma del Paciente</strong></td>
            </tr>
            @else
            <tr>
                <td style="font-size: 20px;" class="text-left" colspan="4"><strong>Firma del Doctor</strong></td>
                <td style="font-size: 20px;" class="text-right" colspan="4"><strong>Firma del Paciente</strong></td>
            </tr>
            @endif
        </tbody>
    </table>
    <br>
    <br>
</body>