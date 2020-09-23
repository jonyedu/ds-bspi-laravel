<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaPrescripciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('prescripciones')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('prescripciones', function (Blueprint $table) {
              
                $table->BigIncrements('PRESCRIPCION_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->string('PRESCRIPCION_DESCRIPCION');
                $table->string('PRESCRIPCION_LINEA')->nullable();
                $table->string('PRESCRIPCION_OBS')->nullable();
                $table->decimal('PRESCRIPCION_UNIDAD', 8, 2);
                $table->string('PRESCRIPCION_EVOLUCION')->nullable();
                $table->string('PRESCRIPCION_MEDICAMENTOS_ADMINISTRADOR')->nullable();
                $table->char('PRESCRIPCION_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('prescripciones');
    }
}
