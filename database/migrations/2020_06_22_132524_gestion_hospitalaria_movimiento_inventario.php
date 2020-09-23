<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaMovimientoInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('movimiento_inventario')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('movimiento_inventario', function (Blueprint $table) {
                
                $table->BigIncrements('MOVIM_INV_COD');
                $table->unsignedBigInteger('PROD_DETA_COD');
                $table->unsignedBigInteger('MOVIM_INV_FARM_COD_ORGI')->nullable();
                $table->unsignedBigInteger('MOVIM_INV_FARM_COD_DEST')->nullable();
                $table->unsignedBigInteger('MOVIM_INV_INGR')->nullable();
                $table->unsignedBigInteger('MOVIM_INV_EGR')->nullable();
                $table->unsignedBigInteger('MOVIM_INV_STOCK');
                $table->char('MOVIM_INV_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('PROD_DETA_COD')->references('PROD_DETA_COD')->on('productos_detalle');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('movimiento_inventario');
    }
}
