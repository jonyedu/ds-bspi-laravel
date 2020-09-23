<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTiposDiagnostico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipos_diagnostico')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipos_diagnostico', function (Blueprint $table) {
                $table->BigIncrements('TIPODIAGNOSTICO_COD');
                $table->string('TIPODIAGNOSTICO_NOM',100)->unique();
                $table->string('TIPODIAGNOSTICO_OBS')->nullable();
                $table->char('TIPODIAGNOSTICO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipos_diagnostico');
    }
}
