<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAlterColumnsToCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('citas', function (Blueprint $table) {
            $table->bigInteger('AREA_COD')->unsigned()->nullable()->change();
            $table->bigInteger('ESPECIALIDAD_COD')->unsigned()->nullable()->change(); 
            $table->integer('CITA_DOCTOR_COD')->nullable()->change();
            $table->integer('CITA_ACOMPAÑANTE_COD')->nullable()->change();
            $table->date('CITA_FECHA')->nullable()->change();
            $table->time('CITA_HORA_INICIAL')->nullable()->change();
            $table->time('CITA_HORA_FINAL')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('citas', function (Blueprint $table) {
            //
        });
    }
}
