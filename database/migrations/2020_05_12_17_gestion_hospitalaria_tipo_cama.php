<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTipoCama extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipos_camas')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipos_camas', function (Blueprint $table) {
                $table->BigIncrements('TIPOCAMA_COD');
                $table->string('TIPOCAMA_NOM', 100);
                $table->string('TIPOCAMA_OBS')->nullable();
                $table->char('TIPOCAMA_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('areas');
    }
}
