<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumnsCiePreDefToDiagnosticos extends Migration
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
                $table->string('DIAGNOSTICO_CIE')->nullable();
                $table->string('DIAGNOSTICO_PRE')->nullable();
                $table->char('DIAGNOSTICO_DEF')->nullable();
                
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
        //
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('diagnosticos');
    }
}
