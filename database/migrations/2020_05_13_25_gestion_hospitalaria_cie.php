<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaCie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('cie')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('cie', function (Blueprint $table) {
                $table->BigIncrements('CIE_COD');
                $table->string('CIE_CLAVE',100);
                $table->string('CIE_DESCRIPCION')->nullable();
                $table->char('CIE_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->integer('CIE_NIVEL');
                $table->string('CIE_PADRE_COD',100)->nullable();
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('cie');
    }
}
