<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumnsToDiagnostico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('diagnostico', function (Blueprint $table) {
            $table->unsignedBigInteger('CITA_COD');
            $table->unsignedBigInteger('CIE_COD');
            $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
            $table->foreign('CIE_COD')->references('CIE_COD')->on('cie');

            $table->renameColumn('DIAGNOSTICO_NOM', 'DIAGNOSTICO_PLAN');
            $table->renameColumn('DIAGNOSTICO_OBS', 'DIAGNOSTICO_SIGNOS_SINTOMAS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diagnostico', function (Blueprint $table) {
            //
        });
    }
}
