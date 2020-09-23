<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaCamas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('camas')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('camas', function (Blueprint $table) {
                $table->BigIncrements('CAMA_COD');
                $table->unsignedBigInteger('HABITACION_COD');
                $table->string('CAMA_NOM', 90);//EL NOMBRE NO SE DEBE REPETIR PARA EL MISMO CODIGO DE HABITACION
                $table->string('CAMA_OBS')->nullable();
                $table->char('CAMA_TIPO', 2)->nullable();
                $table->char('CAMA_DISPONIBILIDAD', 2)->nullable(); // S-DISPONIBLE, N-OCUPADA, D -DANIADA, M- EN MANTENIMIENTO
                $table->char('CAMA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('HABITACION_COD')->references('HABITACION_COD')->on('habitaciones');
                $table->index(['HABITACION_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('camas');
    }
}
