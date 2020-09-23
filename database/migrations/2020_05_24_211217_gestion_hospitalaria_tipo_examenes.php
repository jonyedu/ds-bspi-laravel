<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTipoExamenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipos_examen')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipos_examen', function (Blueprint $table) {
                $table->BigIncrements('TIPOEXAMEN_COD');
                $table->string('TIPOEXAMEN_NOM',100)->unique();
                $table->string('TIPOEXAMEN_OBS')->nullable();
                $table->char('TIPOEXAMEN_LOGIC_ESTADO', 2);
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
