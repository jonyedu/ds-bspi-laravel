<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaProductosDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('productos_detalle')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('productos_detalle', function (Blueprint $table) {
                
                $table->BigIncrements('PROD_DETA_COD');
                $table->unsignedBigInteger('FARMACIA_COD');
                $table->unsignedBigInteger('PRODUCTO_COD');
                $table->unsignedBigInteger('PROD_DETA_STOCK');
                $table->char('PROD_DETA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('FARMACIA_COD')->references('FARMACIA_COD')->on('farmacia');
                $table->foreign('PRODUCTO_COD')->references('PRODUCTO_COD')->on('producto');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('productos_detalle');
    }
}
