<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaCitaDiagnosticos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('cita_diagnosticos')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('cita_diagnosticos', function (Blueprint $table) {
                $table->BigIncrements('CITADIAGNOSTICO_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->unsignedBigInteger('DIAGNOSTICO_COD');
                $table->unsignedBigInteger('TIPODIAGNOSTICO_COD');
                $table->integer('DOCTOR_COD');
                $table->integer('CITADIAGNOSTICO_REFERENCIA_DERIVACION')->default(0);
                $table->string('CITADIAGNOSTICO_SINTOMAS_ACTUALES',250)->nullable();
                $table->string('CITADIAGNOSTICO_PLAN',250)->nullable();
                $table->string('CITADIAGNOSTICO_OBS')->nullable();
                $table->char('CITADIAGNOSTICO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                $table->foreign('DIAGNOSTICO_COD')->references('DIAGNOSTICO_COD')->on('diagnosticos');
                $table->foreign('TIPODIAGNOSTICO_COD')->references('TIPODIAGNOSTICO_COD')->on('tipos_diagnostico');
                $table->index('CITA_COD');
                $table->index('DIAGNOSTICO_COD');
                $table->index('TIPODIAGNOSTICO_COD');
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
        //
    }
}
