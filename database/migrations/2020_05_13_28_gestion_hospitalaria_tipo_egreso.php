<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTipoEgreso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipos_egresos')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipos_egresos', function (Blueprint $table) {
                $table->BigIncrements('TIPOEGRESO_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->integer('TIPOEGRESO_VIVO');
                $table->integer('TIPOEGRESO_COND_ESTABLE');
                $table->integer('TIPOEGRESO_DIAS_INCAPACIDAD');
                $table->string('TIPOEGRESO_OBS')->nullable();
                $table->char('TIPOEGRESO_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipos_egresos');
    }
}
