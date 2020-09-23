<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('areas')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('areas', function (Blueprint $table) {
                $table->BigIncrements('AREA_COD');
                $table->unsignedBigInteger('HOSPITAL_COD');
                $table->string('AREA_NOM', 100)->unique();
                $table->string('AREA_OBS')->nullable();
                $table->integer('AREA_PISO');
                $table->string('AREA_SUPERVISOR', 10)->nullable();
                $table->char('AREA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('HOSPITAL_COD')->references('HOSPITAL_COD')->on('hospital');
                $table->index(['HOSPITAL_COD']);
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
