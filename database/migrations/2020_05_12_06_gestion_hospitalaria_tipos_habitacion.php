<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTiposHabitacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipos_habitacion')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipos_habitacion', function (Blueprint $table) {
                $table->BigIncrements('TIPOHABITACION_COD');
                $table->integer('AREA_COD')->nullable();//EN CASO QUE SE LO REQUIERA
                $table->string('TIPOHABITACION_NOM',100);
                $table->string('TIPOHABITACION_OBS')->nullable();
                $table->char('TIPOHABITACION_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipos_habitacion');
    }
}
