<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumExamenFisicoToAntecedentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('antecedentes')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('antecedentes', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->string('ANTECEDENTE_EXAMEN_FISICO')->nullable();
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('antecedentes');
    }
}
