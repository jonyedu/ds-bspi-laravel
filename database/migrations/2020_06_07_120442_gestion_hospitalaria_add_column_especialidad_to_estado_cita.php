<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumnEspecialidadToEstadoCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('estado_cita', function (Blueprint $table) {
            $table->bigInteger('ESPECIALIDAD_COD')->unsigned()->nullable();
            $table->foreign('ESPECIALIDAD_COD')->references('ESPECIALIDAD_COD')->on('especialidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('estado_cita', function (Blueprint $table) {
            //
        });
    }
}
