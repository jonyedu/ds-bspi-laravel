<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAseguradora extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('aseguradoras')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('aseguradoras', function (Blueprint $table) {
                $table->BigIncrements('ASEGURADORA_COD');
                $table->string('ASEGURADORA_NOM')->unique();
                $table->string('ASEGURADORA_NOM_CONTACTO')->nullable();
                $table->string('ASEGURADORA_TELF_CONTACTO')->nullable();
                $table->string('ASEGURADORA_EMAIL_CONTACTO')->nullable();
                $table->string('ASEGURADORA_OBS')->nullable();
                $table->string('ASEGURADORA_WEB_PAGE')->nullable();
                $table->char('ASEGURADORA_TIPO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->char('ASEGURADORA_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('aseguradoras');
    }
}
