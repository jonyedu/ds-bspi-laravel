<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToInformacionInicial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')
            ->table('informacion_inicial', function (Blueprint $table) {
                $table->char('INFORMACIONINICIAL_MENOR_DE_EDAD', 1)->default('N'); //si o no
                $table->char('INFORMACIONINICIAL_VIENE_SOLO', 1)->default('N'); //si o no
                $table->char('INFORMACIONINICIAL_CONSCIENTE', 1)->default('N'); //si o no
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informacion_inicial', function (Blueprint $table) {
            $table->dropColumn("INFORMACIONINICIAL_MENOR_DE_EDAD");
            $table->dropColumn("INFORMACIONINICIAL_VIENE_SOLO");
            $table->dropColumn("INFORMACIONINICIAL_CONSCIENTE");
        });
    }
}
