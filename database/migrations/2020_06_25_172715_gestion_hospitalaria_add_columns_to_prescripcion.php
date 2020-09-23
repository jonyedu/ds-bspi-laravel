<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumnsToPrescripcion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('prescripcion', function (Blueprint $table) {
            $table->dropColumn('PACIENTE_COD');
            $table->unsignedBigInteger('PRESCRIPCION_TOTAL_ITEMS'); 
            $table->string('PRESCRIPCION_FIRMA', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prescripcion', function (Blueprint $table) {
            //
        });
    }
}
