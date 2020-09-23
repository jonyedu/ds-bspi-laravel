<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaEmergenciaObstetricia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('emergencia_obstetricia')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('emergencia_obstetricia', function (Blueprint $table) {
                $table->BigIncrements('EMERGENCIAOBSTETRICIA_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->integer('DOCTOR_COD')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_SEMANA_GESTACION')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_ALTURA_UTERINA')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_PLANO')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_MOVIMIENTO_FETAL')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_PRESENTACION')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_PELVIS_UTIL')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_FRECUENCIA_FETAL')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_DILATACION')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_SANGRADO_VAGINAL')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_MEMBRANAS_ROTAS')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_BORRAMIENTO')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_CONTRACCIONES')->nullable();
                $table->string('EMERGENCIAOBSTETRICIA_OBSERVACION')->nullable();
                $table->boolean('EMERGENCIAOBSTETRICIA_GESTAS')->nullable();
                $table->boolean('EMERGENCIAOBSTETRICIA_PARTOS')->nullable();
                $table->boolean('EMERGENCIAOBSTETRICIA_ABORTOS')->nullable();
                $table->boolean('EMERGENCIAOBSTETRICIA_CESAREAS')->nullable();
                $table->char('EMERGENCIAOBSTETRICIA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                $table->index('CITA_COD');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('emergencia_obstetricia');
    }
}
