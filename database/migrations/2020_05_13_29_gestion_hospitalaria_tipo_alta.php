<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTipoAlta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipos_alta')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipos_alta', function (Blueprint $table) {
                $table->BigIncrements('TIPOALTA_COD');
                 $table->unsignedBigInteger('CITA_COD');
                $table->integer('TIPOALTA_DOMICILIO')->default(0);
                $table->integer('TIPOALTA_C_EXTERNA')->default(0);
                $table->integer('TIPOALTA_OBSERVACION')->default(0);
                $table->integer('TIPOALTA_INTERNACION')->default(0);
                $table->integer('TIPOALTA_REFERENCIA')->default(0);
                $table->integer('TIPOALTA_MUERTO_EMERGENCIA')->default(0);
                $table->string('TIPOALTA_MUERTO_EMERGENCIA_OBS')->nullable();
                 $table->string('TIPOALTA_SERVICIO_REFERENCIA')->nullable();
                 $table->string('TIPOALTA_ESTABLECIMIENTO')->nullable();
                $table->char('TIPOALTA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                $table->index(['CITA_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipos_alta');
    }
}
