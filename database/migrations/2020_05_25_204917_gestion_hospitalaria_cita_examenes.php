<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaCitaExamenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('cita_examenes')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('cita_examenes', function (Blueprint $table) {
                $table->BigIncrements('CITAEXAMEN_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->unsignedBigInteger('TIPOEXAMEN_COD');
                $table->unsignedBigInteger('EXAMEN_COD');
                $table->integer('DOCTOR_COD')->nullable();
                $table->string('CITAEXAMEN_OBS')->nullable();
                $table->char('CITAEXAMEN_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                $table->foreign('EXAMEN_COD')->references('EXAMEN_COD')->on('examenes');
                $table->foreign('TIPOEXAMEN_COD')->references('TIPOEXAMEN_COD')->on('tipos_examen');
                $table->index('CITA_COD');
                $table->index('EXAMEN_COD');
                $table->index('TIPOEXAMEN_COD');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('cita_examenes');
    }
}
