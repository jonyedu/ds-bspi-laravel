<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaPacientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('pacientes')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('pacientes', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->String('PACIENTE_COD')->primary();
                $table->unsignedBigInteger('USER_ID');
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->timestamps();
                $table->index('USER_ID');
                
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('pacientes');
    }
}
