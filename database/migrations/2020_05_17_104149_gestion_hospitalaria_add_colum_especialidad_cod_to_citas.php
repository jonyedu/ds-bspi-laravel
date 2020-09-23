<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumEspecialidadCodToCitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('citas', function (Blueprint $table) {
            $table->unsignedBigInteger('ESPECIALIDAD_COD');
            $table->foreign('ESPECIALIDAD_COD')->references('ESPECIALIDAD_COD')->on('especialidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('citas', function (Blueprint $table) {
            $table->dropColumn("ESPECIALIDAD_COD");
        });
    }
}
