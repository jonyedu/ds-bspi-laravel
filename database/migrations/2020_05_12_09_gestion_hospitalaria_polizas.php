<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaPolizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('polizas')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('polizas', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('POLIZA_COD');
                $table->BigInteger('POLIZA_TITULAR');
                $table->unsignedBigInteger('ASEGURADORA_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->string('POLIZA_NUMERO')->nullable();
                $table->string('POLIZA_OBS')->nullable();
                $table->string('POLIZA_DOCUMENTO')->nullable();
                $table->char('POLIZA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->foreign('ASEGURADORA_COD')->references('ASEGURADORA_COD')->on('aseguradoras');
                $table->index(['ASEGURADORA_COD', 'USER_ID']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('polizas');
    }
}
