<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaChangeColumnToCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('citas', function (Blueprint $table) {
            $table->dropForeign('citas_especialidad_cod_foreign');
            $table->dropColumn('ESPECIALIDAD_COD');
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
            //
        });
    }
}
