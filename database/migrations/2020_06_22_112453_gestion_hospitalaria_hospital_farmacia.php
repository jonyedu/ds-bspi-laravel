<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaHospitalFarmacia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('hospital_farmacia')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('hospital_farmacia', function (Blueprint $table) {
                
                $table->BigIncrements('HOSP_FARM_COD');
                $table->unsignedBigInteger('HOSPITAL_COD');
                $table->unsignedBigInteger('FARMACIA_COD');
                $table->char('HOSP_FARM_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('HOSPITAL_COD')->references('HOSPITAL_COD')->on('hospital');
                $table->foreign('FARMACIA_COD')->references('FARMACIA_COD')->on('farmacia');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('hospital_farmacia');
    }
}
