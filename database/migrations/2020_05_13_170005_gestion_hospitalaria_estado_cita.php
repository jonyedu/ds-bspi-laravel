<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaEstadoCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('estado_cita')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('estado_cita', function (Blueprint $table) {
                
                $table->BigIncrements('ESTADOCITA_COD');
                
                $table->unsignedBigInteger('CITA_COD');
                
                $table->char('ESTADOCITA_TIPO'); //H-HOSPITALIZACION E-EMERGENCIA C-CONSULTA EXTERNA T-TRASLADO A-ALTA
                $table->integer('CAMA_COD')->nullable();
                
                $table->datetime('ESTADOCITA_FECHA_EJECUTION')->nullable(); //para planificaciones a futuro ej: fecha de traslado
                $table->string('ESTADOCITA_OBS')->nullable();
                $table->integer('AUTORIZADOR_COD')->nullable();
                $table->char('ESTADOCITA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->integer('CITA_DOCTOR_COD')->nullable();
                $table->date('ESTADOCITA_FECHA')->nullable();
                $table->time('ESTADOCITA_HORA_INICIAL')->nullable();
                $table->time('ESTADOCITA_HORA_FINAL')->nullable();
                $table->integer('ESPECIALIDAD_COD');
                $table->timestamps();

                
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                
                $table->index(['CITA_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('estado_cita');
    }
}
