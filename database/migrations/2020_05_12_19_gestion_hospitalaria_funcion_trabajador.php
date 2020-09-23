<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaFuncionTrabajador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('funcion_trabajador')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('funcion_trabajador', function (Blueprint $table) {
                $table->BigIncrements('FUNCIONTRABAJADOR_COD');
                $table->unsignedBigInteger('TRABAJADORESPERSONALSALUD_COD');
                $table->unsignedBigInteger('AREA_COD');
                $table->unsignedBigInteger('ESPECIALIDAD_COD');
                
                $table->string('FUNCIONTRABAJADOR_OBS')->nullable();
                $table->char('FUNCIONTRABAJADOR_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('TRABAJADORESPERSONALSALUD_COD')->references('TRABAJADORESPERSONALSALUD_COD')->on('trabajadores_personal_salud');
                $table->foreign('AREA_COD')->references('AREA_COD')->on('areas');
                $table->foreign('ESPECIALIDAD_COD')->references('ESPECIALIDAD_COD')->on('especialidades');
                $table->index(['ESPECIALIDAD_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('funcion_trabajador');
    }
}
