<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaCoberturaPolizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('cobertura_polizas')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('cobertura_polizas', function (Blueprint $table) {
                $table->BigIncrements('COBERTURAPOLIZA_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->bigInteger('POLIZA_COD');
                $table->bigInteger('BENEFICIARIO_COD');
                $table->decimal('COBERTURAPOLIZA_PORCENTAJE',10,2);
                $table->char('COBERTURAPOLIZA_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('cobertura_polizas');
    }
}
