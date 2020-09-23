<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTipoMovimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipo_movimiento')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipo_movimiento', function (Blueprint $table) {
                $table->BigIncrements('TIPOMOVIMIENTO_COD');
                $table->string('TIPOMOVIMIENTO_NOMBRE', 255);
                $table->string('TIPOMOVIMIENTO_OBS', 255)->nullable();
                $table->char('TIPOMOVIMIENTO_ABREVIATURA', 3);
                $table->char('TIPOMOVIMIENTO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipo_movimiento');
    }
}
