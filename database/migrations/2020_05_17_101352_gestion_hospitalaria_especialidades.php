<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaEspecialidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('especialidades')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('especialidades', function (Blueprint $table) {
                $table->BigIncrements('ESPECIALIDAD_COD');
                $table->unsignedBigInteger('HOSPITAL_COD');
                $table->string('ESPECIALIDAD_NOM', 100);
                $table->string('ESPECIALIDAD_OBS')->nullable();
                $table->char('ESPECIALIDAD_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('especialidades');
    }
}
