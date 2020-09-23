<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaCategoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('categoria')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('categoria', function (Blueprint $table) {
                
                $table->BigIncrements('CATEGORIA_COD');
                $table->string('CATEGORIA_NOM', 255);
                $table->string('CATEGORIA_OBS', 255)->nullable();;
                $table->char('CATEGORIA_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('categoria');
    }
}
