<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaDetalleMovimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('detalle_inventario')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('detalle_inventario', function (Blueprint $table) {
                
                $table->BigIncrements('DETALLEMOVIMIENTO_COD');
                $table->unsignedBigInteger('MOVIMIENTO_COD');
                $table->unsignedBigInteger('PRODUCTO_DETALLE_COD');
                $table->unsignedBigInteger('DETALLEMOVIMIENTO_CANTIDAD');
                $table->unsignedBigInteger('DETALLEMOVIMIENTO_STOCK_FARMACIA_ORIGEN')->nullable();
                $table->unsignedBigInteger('DETALLEMOVIMIENTO_STOCK_FARMACIA_DESTINO')->nullable();
                $table->char('DETALLEMOVIMIENTO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('MOVIMIENTO_COD')->references('MOVIMIENTO_COD')->on('movimiento');
                $table->foreign('PRODUCTO_DETALLE_COD')->references('PRODUCTO_DETALLE_COD')->on('producto_detalle');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('detalle_inventario');
    }
}
