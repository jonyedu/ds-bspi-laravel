<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaOcupaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('ocupaciones')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('ocupaciones', function (Blueprint $table) {
                $table->BigIncrements('OCUPACIONES_COD');
                $table->string('OCUPACIONES_COD_DOC');//en caso que se importe desde la pagina del mt
                $table->string('OCUPACIONES_NOM',100)->unique();
                $table->string('OCUPACIONES_OBS')->nullable();
                $table->char('OCUPACIONES_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('ocupaciones');
    }
}
