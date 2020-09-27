<?php

namespace App\Http\Controllers\GestionHospitalaria\ConsultaExtena;

use App\GestionHospitalaria\AdministracionDeCitas\Cita;
use App\GestionHospitalaria\ConsultaExtena\Prescripcion;
use App\GestionHospitalaria\ConsultaExtena\PrescripcionDetalle;
use App\GestionHospitalaria\AdministracionDeFarmacia\ProductosDetalle;
use App\Http\Controllers\Controller;
use App\Mail\EnvioPrescripcion;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

class PrescripcionApiController extends Controller
{
    //***************PRESCRIPCION *****************//
    /* Funcion para cargar las firmas del doctor y del paciente*/
    public function cargarFirmaDoctorPaciente($idCita)
    {

        if ($idCita !== '' && isset($idCita)) {
            try {
                $firmaDoctor = Auth::user();
                $firmaPaciente = Cita::where('CITA_LOGIC_ESTADO', 'A')
                    ->where('CITA_COD', $idCita)
                    ->with('paciente')
                    ->first();
                return  response()->json(['firmaPaciente' => $firmaPaciente, 'firmaDoctor' => $firmaDoctor], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "No Existe Citas"], 500);
        }
    }
    /*Funcion para mostrar de la tabla Prescripcion*/
    public function cargarPrescripcion($idCita)
    {
        if ($idCita !== '' && isset($idCita)) {
            try {
                $prescripcion = Prescripcion::where('PRESCRIPCION_LOGIC_ESTADO', 'A')
                    ->where('CITA_COD', $idCita)
                    ->with('prescripcionDetalle.productoDetalle.presentacionProducto.presentaciones', 'prescripcionDetalle.productoDetalle.presentacionProducto.productos.categoria', 'prescripcionDetalle.productoDetalle.farmacia',  'doctor', 'cita.paciente', 'hospital')
                    ->first();
                return  response()->json(['prescripcion' => $prescripcion], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "No Existe Citas"], 500);
        }
    }
    /*Funcion para mostrar datos al pdf MSP 0002 */
    public function cargarPdfPrescripcion($idCita)
    {
        if ($idCita !== '' && isset($idCita)) {
            try {
                //Variables para retornar
                $cantidadArray = 0;
                $prescripcion = null;
                $edadPaciente = 0;
                $totalSuma = 0;
                Auth::user();
                $fechaImpresion = null;
                $nombreArchivo = 'No hay datos.pdf';

                $prescripcion = Prescripcion::where('PRESCRIPCION_LOGIC_ESTADO', 'A')
                    ->where('CITA_COD', $idCita)
                    ->with('prescripcionDetalle.productoDetalle.presentacionProducto.presentaciones', 'prescripcionDetalle.productoDetalle.presentacionProducto.productos.categoria', 'prescripcionDetalle.productoDetalle.farmacia',   'medico.funcionTrabajador.especialidad', 'cita.paciente.identificaciones', 'hospital')
                    ->first();
                //return $prescripcion;                  

                if ($prescripcion != null) {

                    //Para obtener la suma del valos a pagar    
                    $totalSuma = 0.00;
                    $array = [];
                    $cantidadArray = 0;
                    foreach ($prescripcion->prescripcionDetalle as $pres) {
                        array_push($array, $pres->PRESC_DETA_TOTAL);
                        $totalSum = array_sum($array);
                        $totalSuma = '$ ' . number_format((float)$totalSum, 2, '.', '');
                    }
                    //Para concatenar el nombre del archivo
                    $nombrePaciente = $prescripcion->cita->paciente->FULL_NAME;
                    $cedulaPaciente = str_replace(':', '_', $prescripcion->cita->paciente->FULL_IDENTIFICATION);
                    $dateImpresion = date("Y-m-d");
                    $timeImpresion = date("H:i:s");
                    $nombreArchivo = $nombrePaciente . '-' . $cedulaPaciente . '-' . $dateImpresion . ' ' . str_replace(':', '_', $timeImpresion) . '.pdf';

                    //Para saber la edad del paciente
                    $prescripcionApi = new PrescripcionApiController();
                    $edadPaciente = $prescripcionApi->calculaEdad($prescripcion->cita->paciente->US_FNAC);

                    $pdf = PDF::loadView('reportes.pdf.prescripcion-pdf', [
                        'cantidadArray' => $cantidadArray,
                        'prescripcion' => $prescripcion,
                        'edadPaciente' => $edadPaciente,
                        'totalSuma' => $totalSuma,
                        'user' => Auth::user(),
                        'fecha' => $dateImpresion . ' ' . $timeImpresion
                    ]);

                    //Codigo para enviar la prescripcion al paciente por correo electrónico

                    /* //Ruta para guardar en el servidor 
                    $destinationPath = public_path('reports/prescripciones/');
                    //Concatenar la ruta y el nombre del archivo
                    $rutaSave = $destinationPath . $nombreArchivo;
                    //Guardalo en una variable
                    $output = $pdf->output();
                    //Aqui es donde guarda en el servidor
                    file_put_contents($rutaSave, $output);

                    //Obtenemos el mail del paciente, para enviar la prescripcion
                    $datosPaciente = Cita::where('CITA_LOGIC_ESTADO', 'A')
                        ->where('CITA_COD', $idCita)
                        ->with('paciente')
                        ->first();

                    if ($datosPaciente != null) {
                        if ($datosPaciente->paciente != null) {
                            //Enviar la prescripcion vía Email al paciente
                            Mail::to($datosPaciente->paciente->email)->send(new EnvioPrescripcion($rutaSave, $datosPaciente->paciente));
                        }
                    } */

                    return $pdf->stream($nombreArchivo);
                } else {
                    $pdf = PDF::loadView('reportes.pdf.prescripcion-pdf', [
                        'cantidadArray' => $cantidadArray,
                        'prescripcion' => $prescripcion,
                        'edadPaciente' => $edadPaciente,
                        'totalSuma' => $totalSuma,
                        'user' => Auth::user(),
                        'fecha' => $fechaImpresion
                    ]);

                    return $pdf->stream($nombreArchivo);
                }
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "No Existe Citas"], 500);
        }
    }
    /* Funcion para cargar la edad del paciente*/
    function calculaEdad($fechanacimiento)
    {
        list($ano, $mes, $dia) = explode("-", $fechanacimiento);
        $ano_diferencia  = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }
    /*Funcion para guardar o modificar a la tabla Prescripcion*/
    public function guardarModificarPrescripcion(Request $request, $idCita)
    {
        try {
            $user = Auth::user();

            $doctor = User::with('trabajadorPersonalSalud')->where('id', $user->id)->first();

            $productoSinStockArray = [];
            $respuestaValidacion = false;
            foreach ($request->input('productosData') as  $productos) {
                $prescripcion = new PrescripcionApiController();
                $stockActualOrigenFinal = $prescripcion->validarStockProducto($productos['col_farmacia_cod'], $productos['col_productos_cod'], $productos);
                //llamo al metodo validarStockProducto1 para saber si hay stock o no
                //Saco el stock actual del producto
                $stockAnteriorOrigen = ProductosDetalle::where('FARMACIA_COD', $productos['col_farmacia_cod'])->where('PRESENTACIONPRODUCTO_COD', $productos['col_productos_cod'])->first();


                //-1 Indica que no hay registro, entonces no hay stock
                if ($stockActualOrigenFinal == -1) {
                    //Añado los productos sin stock al arreglo
                    if ($stockAnteriorOrigen != null) {
                        array_push($productoSinStockArray, $productos['col_producto'] . "-" . $stockAnteriorOrigen->PRODUCTO_DETALLE_STOCK);
                    } else {
                        array_push($productoSinStockArray, $productos['col_producto'] . "-" . "0");
                    }
                } else {
                    $respuestaValidacion = true;
                }
            }
            if (sizeof($productoSinStockArray) > 0) {
                return response()->json(['msg' => $productoSinStockArray], 421);
            }
            if ($respuestaValidacion) {

                foreach ($request->input('productosDataAnterior') as  $productoAnterior) {
                    $reservaActual = ProductosDetalle::where('PRESENTACIONPRODUCTO_COD', $productoAnterior['col_productos_cod'])
                        ->where('FARMACIA_COD', $productoAnterior['col_farmacia_cod'])
                        ->first();
                    ProductosDetalle::where('FARMACIA_COD', $productoAnterior['col_farmacia_cod'])
                        ->where('PRESENTACIONPRODUCTO_COD', $productoAnterior['col_productos_cod'])->update([
                            'PRODUCTO_DETALLE_RESERVA_STOCK' => $reservaActual->PRODUCTO_DETALLE_RESERVA_STOCK - $productoAnterior['col_cantidad']
                        ]);
                    PrescripcionDetalle::where('PRESC_DETA_COD', $productoAnterior['col_prescripcion_detalle_cod'])->update([
                        'PRESC_DETA_LOGIC_ESTADO' => 'I',
                    ]);
                }
                foreach ($request->input('productosData') as  $productos) {
                    if ($productos['col_prescripcion_detalle_cod'] == 0) {
                        $prescripcion = Prescripcion::updateOrCreate(
                            [
                                'CITA_COD' => $idCita, 'PRESCRIPCION_LOGIC_ESTADO' => 'A'
                            ],
                            [
                                'PRESCRIPCION_TOTAL_ITEMS' => $request->input('frm_cantidadArray'),
                                'HOSPITAL_COD' => $request->input('frm_idHospital'),
                                'CITA_COD' => $idCita,
                                'DOCTOR_COD' => $doctor->trabajadorPersonalSalud->TRABAJADORESPERSONALSALUD_COD,
                                'PRESCRIPCION_FECHA' => $request->input('frm_fecha_transaccion'),
                                'PRESCRIPCION_HORA' => $request->input('frm_hora_transaccion'),
                                'PRESCRIPCION_DOCTOR_FIRMA' => $request->input('frm_doctor_firma'),
                                'PRESCRIPCION_PACIENTE_FIRMA' => $request->input('frm_paciente_firma'),
                                'PRESCRIPCION_LOGIC_ESTADO' => 'A',
                                'US_COD_CREATED_UPDATED' => $user->US_COD,
                            ]
                        );
                        //Para saber cuanto hay de reservados
                        $reservaNuevo = 0;
                        $reservaActual = ProductosDetalle::where('PRESENTACIONPRODUCTO_COD', $productos['col_productos_cod'])
                            ->where('FARMACIA_COD', $productos['col_farmacia_cod'])
                            ->first();
                        if ($reservaActual->PRODUCTO_DETALLE_RESERVA_STOCK == 0) {
                            $reservaNuevo = $productos['col_cantidad'];
                        } else {
                            $reservaNuevo = $productos['col_cantidad'] + $reservaActual->PRODUCTO_DETALLE_RESERVA_STOCK;
                        }
                        $productoDetalle = ProductosDetalle::updateOrCreate(
                            [
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_productos_cod'], 'FARMACIA_COD' => $productos['col_farmacia_cod']
                            ],
                            [
                                'FARMACIA_COD' => $productos['col_farmacia_cod'],
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_productos_cod'],
                                'PRODUCTO_DETALLE_RESERVA_STOCK' => $reservaNuevo,
                                'PRODUCTO_DETALLE_LOGIC_ESTADO' => 'A',
                                'US_COD_CREATED_UPDATED' => $user->US_COD,
                            ]
                        );
                        PrescripcionDetalle::updateOrCreate(
                            [
                                'PRESCRIPCION_COD' => $prescripcion->PRESCRIPCION_COD, 'PRODUCTO_DETALLE_COD' => $productoDetalle->PRODUCTO_DETALLE_COD
                            ],
                            [
                                'PRESCRIPCION_COD' => $prescripcion->PRESCRIPCION_COD,
                                'PRODUCTO_DETALLE_COD' => $productoDetalle->PRODUCTO_DETALLE_COD,
                                'PRESC_DETA_STOCK' => $stockActualOrigenFinal,
                                'PRESC_DETA_CANT' => $productos['col_cantidad'],
                                'PRESC_DETA_PVP' => $productos['col_pvp'],
                                'PRESC_DETA_TOTAL' => $productos['col_cantidad'] * $productos['col_pvp'],
                                'PRESC_DETA_OBS' => $productos['col_observacion'],
                                'PRESC_DETA_LOGIC_ESTADO' => 'A',
                                'US_COD_CREATED_UPDATED' => $user->US_COD,
                            ]
                        );
                    } else {
                        $prescripcion = Prescripcion::updateOrCreate(
                            [
                                'CITA_COD' => $idCita, 'PRESCRIPCION_LOGIC_ESTADO' => 'A'
                            ],
                            [
                                'PRESCRIPCION_TOTAL_ITEMS' => $request->input('frm_cantidadArray'),
                                'HOSPITAL_COD' => $request->input('frm_idHospital'),
                                'CITA_COD' => $idCita,
                                'DOCTOR_COD' => $doctor->trabajadorPersonalSalud->TRABAJADORESPERSONALSALUD_COD,
                                'PRESCRIPCION_FECHA' => $request->input('frm_fecha_transaccion'),
                                'PRESCRIPCION_HORA' => $request->input('frm_hora_transaccion'),
                                'PRESCRIPCION_DOCTOR_FIRMA' => $request->input('frm_doctor_firma'),
                                'PRESCRIPCION_PACIENTE_FIRMA' => $request->input('frm_paciente_firma'),
                                'PRESCRIPCION_LOGIC_ESTADO' => 'A',
                                'US_COD_CREATED_UPDATED' => $user->US_COD,
                            ]
                        );
                        $prescriDetalle = PrescripcionDetalle::where('PRESC_DETA_COD', $productos['col_prescripcion_detalle_cod'])->first();

                        $producDetalle = ProductosDetalle::where('PRODUCTO_DETALLE_COD', $prescriDetalle->PRODUCTO_DETALLE_COD)->first();

                        if ($productos['col_cantidad'] != $prescriDetalle->PRESC_DETA_CANT) {
                            //Primero restar la cantidad en reserva, para dejar la reserva normal
                            ProductosDetalle::where('PRODUCTO_DETALLE_COD', $prescriDetalle->PRODUCTO_DETALLE_COD)->update([
                                'PRODUCTO_DETALLE_RESERVA_STOCK' => $producDetalle->PRODUCTO_DETALLE_RESERVA_STOCK - $prescriDetalle->PRESC_DETA_CANT
                            ]);
                            //Actualizar con la nueva cantidad que fue cambiada
                            PrescripcionDetalle::where('PRESC_DETA_COD', $productos['col_prescripcion_detalle_cod'])->update([
                                'PRESC_DETA_CANT' => $productos['col_cantidad'],
                                'PRESC_DETA_PVP' => $productos['col_pvp'],
                                'PRESC_DETA_TOTAL' => $productos['col_cantidad'] * $productos['col_pvp'],
                            ]);

                            //Para saber cuanto hay de reservados
                            $reservaNuevo = 0;
                            $reservaActual = ProductosDetalle::where('PRESENTACIONPRODUCTO_COD', $productos['col_productos_cod'])
                                ->where('FARMACIA_COD', $productos['col_farmacia_cod'])
                                ->first();
                            if ($reservaActual->PRODUCTO_DETALLE_RESERVA_STOCK == 0) {
                                $reservaNuevo = $productos['col_cantidad'];
                            } else {
                                $reservaNuevo = $productos['col_cantidad'] + $reservaActual->PRODUCTO_DETALLE_RESERVA_STOCK;
                            }
                            //Actualizar con la nueva cantidad que fue cambiada
                            ProductosDetalle::where('PRODUCTO_DETALLE_COD', $prescriDetalle->PRODUCTO_DETALLE_COD)->update([
                                'PRODUCTO_DETALLE_RESERVA_STOCK' => $reservaNuevo
                            ]);
                        }
                    }
                }
            }
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function validarStockProducto($idFarmacia, $idProducto, $productos)
    {
        $stockActualOrigenFinal = -1;
        $stockActualOrigen = 0;

        //Hago una consulta a la tabla producto_detalle, para saber si hay registro
        $stockAnteriorOrigen = ProductosDetalle::where('FARMACIA_COD', $idFarmacia)->where('PRESENTACIONPRODUCTO_COD', $idProducto)->first();
        //Si no es NULL, entonces hay registro en la tabla producto_detalle, caso contrario devuelve -1 que significa que no hay registro
        if ($stockAnteriorOrigen != null) {
            //Si el stock es <= 0, devolver un mensaje diciendo que no hay stock
            if ($stockAnteriorOrigen->PRODUCTO_DETALLE_STOCK <= 0) {
                $stockActualOrigenFinal = -1;
            }
            //Si hay registro y es mayor a 0, entonces hay stock
            else {
                //Obtengo el resulta del stock Actual, despues de haber restado con la cantidad que sale
                $stockActualOrigen = $stockAnteriorOrigen->PRODUCTO_DETALLE_STOCK - $productos['col_cantidad'];
                //Ahora obtengo el resultado, restado con la reserva
                $stockActualSinRerserva = $stockActualOrigen - $stockAnteriorOrigen->PRODUCTO_DETALLE_RESERVA_STOCK;

                //Si el resultado es menor a 0, entonces no hay stock suficiente para salir
                if ($stockActualSinRerserva < 0) {
                    $stockActualOrigenFinal = -1;
                }
                //Hay estoy suficiente, para trasladar o el egreso
                else {
                    $stockActualOrigenFinal = $stockActualOrigen;
                }
            }
        }

        return $stockActualOrigenFinal;
    }

    //***************Evolucion*****************//
    /*Funcion para mostrar el dato de la tabla prescripcion, solo el campo PRESCRIPCION_EVOLUCION*/
    public function cargarEvolucion($idCita)
    {
        if ($idCita !== '' && isset($idCita)) {
            try {

                $evolucion = Prescripcion::select('PRESCRIPCION_EVOLUCION')
                    ->where('PRESCRIPCION_LOGIC_ESTADO', 'A')
                    ->where('CITA_COD', $idCita)
                    ->first();

                return  response()->json(['evolucion' => $evolucion], 200);
            } catch (Exception $e) {
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['mensaje' => "No Existe Citas"], 500);
        }
    }
    /*Funcion para guardar o moficiar de la tabla prescripcion, solo el campo PRESCRIPCION_EVOLUCION*/
    public function guardarModificarEvolucion(Request $request, $idCita)
    {
        $request->validate([
            'frm_evolucion' => 'required|string'
        ]);
        try {
            $user = Auth::user();
            $antecedente = new AntecedenteApiController();
            Prescripcion::updateOrCreate(
                [
                    'CITA_COD' => $idCita,
                    'PRESCRIPCION_LOGIC_ESTADO' => 'A',
                ],
                [
                    'CITA_COD' => $idCita,
                    'PRESCRIPCION_FECHA' => $request->input('frm_fecha_transaccion'),
                    'PRESCRIPCION_HORA' => $request->input('frm_hora_transaccion'),
                    'PRESCRIPCION_TOTAL_ITEMS' => 0,
                    'PRESCRIPCION_EVOLUCION' => $request->input('frm_evolucion'),
                    'PRESCRIPCION_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
