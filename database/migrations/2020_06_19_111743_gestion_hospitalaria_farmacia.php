<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaFarmacia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('farmacia')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('farmacia', function (Blueprint $table) {
                $table->BigIncrements('FARMACIA_COD');
                $table->string('FARMACIA_NOM', 255);
                $table->string('FARMACIA_TELF', 255)->nullable();
                $table->string('FARMACIA_DIREC', 255)->nullable();
                $table->string('FARMACIA_EMAIL', 255)->nullable();
                $table->string('FARMACIA_OBS', 255)->nullable();
                $table->string('FARMACIA_WEB_PAGE', 255)->nullable();
                $table->char('FARMACIA_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('farmacia');
    }
}
