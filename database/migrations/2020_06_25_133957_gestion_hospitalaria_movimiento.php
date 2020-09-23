<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaMovimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('movimiento')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('movimiento', function (Blueprint $table) {
                
                $table->BigIncrements('MOVIMIENTO_COD');
                $table->unsignedBigInteger('TIPOMOVIMIENTO_COD');
                $table->date('MOVIMIENTO_FECHA');
                $table->unsignedBigInteger('MOVIMIENTO_FARMACIA_ORIGEN_COD')->nullable();
                $table->unsignedBigInteger('MOVIMIENTO_FARMACIA_DESTINO_COD')->nullable();
                $table->string('MOVIMIENTO_DESCRIPCION', 255)->nullable();
                $table->char('MOVIMIENTO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('TIPOMOVIMIENTO_COD')->references('TIPOMOVIMIENTO_COD')->on('tipo_movimiento');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('movimiento');
    }
}
