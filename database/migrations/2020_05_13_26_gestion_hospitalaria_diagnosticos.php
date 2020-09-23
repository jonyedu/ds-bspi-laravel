<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaDiagnosticos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('diagnosticos')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('diagnosticos', function (Blueprint $table) {
                $table->BigIncrements('DIAGNOSTICO_COD');
    
                $table->unsignedBigInteger('CITA_COD');
                $table->integer('DOCTOR_COD');
                $table->unsignedBigInteger('CIE_COD');
                $table->string('DIAGNOSTICO_CIE')->nullable();
                $table->string('DIAGNOSTICO_PRE')->nullable();
                $table->char('DIAGNOSTICO_DEF')->nullable();
                $table->integer('DIAGNOSTICO_REFERENCIA_DERIVACION')->default(0);
                $table->string('DIAGNOSTICO_SINTOMAS_ACTUALES',250)->nullable();
                $table->string('DIAGNOSTICO_SIGNOS_SINTOMAS',250)->nullable();
                $table->string('DIAGNOSTICO_PLAN',250)->nullable();
                $table->string('DIAGNOSTICO_OBS')->nullable();
                $table->char('DIAGNOSTICO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);

                $table->timestamps();
                
                $table->foreign('CIE_COD')->references('CIE_COD')->on('cie');
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                $table->index(['CITA_COD', 'CIE_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('diagnosticos');
    }
}
