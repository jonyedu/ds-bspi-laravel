
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket De {{$titulo}} </title>
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
        #footer {
            position: fixed;
            left: 0px;
            right: 0px;
            bottom: 0px;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        body {
            font-size: 12px;
        }
        p{
            font-size: 16px;
        }
        li{
            font-size: 16px;
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
</head>

<body>
    <br>
    <header>
        <div id="logo">
            <img src="images/hospital.png" alt="Dobaltoff" id="imagen">
        </div>
        <table>
            <tbody>
                <tr>
                <td class="text-left" colspan="4"><strong><h3>{{strtoupper($titulo)}} TICKET N°: {{ $dato->numero_ticket }} </h3> </strong></td>
                </tr>               
            </tbody>
        </table>
    </header>
    <table id="header">
        <tbody>
            <tr>
                <td class="text-center" colspan="4"><strong>HOSPITAL: {{'LEON BECERRA'}}</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>TELÉFONO: {{'0978658899'}}</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>CORREO ELECTRÓNICO: {{'PRUEBA@GMAIL.COM'}}</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>PÁGINA WEB: {{''}}</strong></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4"><strong>FECHA: {{ $dato->date }} </strong></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <p>Estimado Sr(a), {{$dato->cita->paciente->FULL_NAME}}.</p>
    <p>Se generó el ticket número <span style="font-weight: bolder;">{{$dato->numero_ticket}}</span>, para su ingreso por consulta externa con fecha {{$dato->date}} con el/la Dr(a). {{$dato->doctor->user->FULL_NAME}} para la especialidad {{$dato->especialidad->ESPECIALIDAD_NOM}}, por favor diríjase a la sala de espera para seguir con el proceso.</p>
    <p>Tenga en cuenta las siguientes recomendaciones.</p>
    <ol>
        <li>Portar sus documentos de identificación personal.</li>
        <li>Portar el ticket.</li>
        <li>Situarse en la sala de espera.</li>
        <li>En caso de faltarle algun documento requerido, entregarlo en admisiones.</li>
        <li>Estar atento al llamado de su nombre.</li>
        <li>Cualquier información adicional consultarla en admisiones.</li>
      </ol>
</body>

</html>
