<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaPrescripcionDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('prescripcion_detalle')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('prescripcion_detalle', function (Blueprint $table) {
                
                $table->BigIncrements('PRESC_DETA_COD');
                $table->unsignedBigInteger('PRESCRIPCION_COD');
                $table->unsignedBigInteger('FARMACIA_COD');
                $table->unsignedBigInteger('PROD_DETA_COD');
                $table->unsignedBigInteger('PRESC_DETA_STOCK');
                $table->unsignedBigInteger('PRESC_DETA_CANT');
                $table->decimal('PRESC_DETA_PVP' , 18);
                $table->decimal('PRESC_DETA_TOTAL', 18);
                $table->string('PRESC_DETA_OBS', 255);
                $table->char('PRESC_DETA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('PRESCRIPCION_COD')->references('PRESCRIPCION_COD')->on('prescripcion');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('prescripcion_detalle');
    }
}
