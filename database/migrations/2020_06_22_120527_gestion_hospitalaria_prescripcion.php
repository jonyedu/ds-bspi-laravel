<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaPrescripcion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('prescripcion')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('prescripcion', function (Blueprint $table) {
                
                $table->BigIncrements('PRESCRIPCION_COD');
                $table->unsignedBigInteger('DOCTOR_COD');
                $table->unsignedBigInteger('HOSPITAL_COD');
                $table->unsignedBigInteger('PACIENTE_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->date('PRESCRIPCION_FCHA_CTUAL');
                $table->char('PRESCRIPCION_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('prescripcion');
    }
}
