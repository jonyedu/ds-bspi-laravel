<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaHabitaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('habitaciones')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('habitaciones', function (Blueprint $table) {
                $table->BigIncrements('HABITACION_COD');
                $table->integer('AREA_COD')->nullable(); //ES OPCIONAL.
                $table->unsignedBigInteger('HOSPITAL_COD');
                $table->unsignedBigInteger('TIPOHABITACION_COD');
                $table->string('HABITACION_NOM');
                $table->double('HABITACION_PRECIO')->default(0);
                $table->string('HABITACION_OBS')->nullable();
                $table->char('HABITACION_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('HOSPITAL_COD')->references('HOSPITAL_COD')->on('hospital');
                $table->foreign('TIPOHABITACION_COD')->references('TIPOHABITACION_COD')->on('tipos_habitacion');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('habitaciones');
    }
}
