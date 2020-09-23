<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumEvolucionToPrescripciones extends Migration
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
                $table->string('PRESCRIPCION_EVOLUCION')->nullable();
                $table->string('PRESCRIPCION_MEDICAMENTOS_ADMINISTRADOR')->nullable();
                
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
