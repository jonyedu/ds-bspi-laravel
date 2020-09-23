<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaMotivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('motivos')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('motivos', function (Blueprint $table) {
                //CUANDO INGRESA POR EMERGENCIA SE LLENA ESTA TABLA .
               
                $table->BigIncrements('MOTIVO_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->string('TIPOSANGRE_COD');
                $table->integer('MOTIVO_TRAUMA')->default(0);
                $table->integer('MOTIVO_CAUSA_CLINICA')->default(0);
                $table->integer('MOTIVO_CAUSA_OBSTETRICIA')->default(0);
                $table->integer('MOTIVO_CAUSA_QUIRURGICA')->default(0);
                $table->integer('MOTIVO_NOTIFICACION_A_LA_POLICIA')->default(0);
                $table->integer('MOTIVO_OTRO_MOTIVO')->default(0);
                $table->string('MOTIVO_OBS')->nullable();
                $table->string('US_COD_CREATED_UPDATED', 10);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('motivos');
    }
}
