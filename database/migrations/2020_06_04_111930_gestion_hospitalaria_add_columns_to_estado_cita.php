<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumnsToEstadoCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('estado_cita', function (Blueprint $table) {
            $table->integer('CITA_DOCTOR_COD')->nullable(); //id de tabla trabajador_personal_salud
            $table->date('ESTADOCITA_FECHA')->nullable();
            $table->time('ESTADOCITA_HORA_INICIAL')->nullable();
            $table->time('ESTADOCITA_HORA_FINAL')->nullable();
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
