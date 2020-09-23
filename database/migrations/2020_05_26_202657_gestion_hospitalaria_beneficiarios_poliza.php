<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaBeneficiariosPoliza extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('beneficiarios')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('beneficiarios', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('BENEFICIARIO_COD');
                $table->unsignedBigInteger('POLIZA_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->string('BENEFICIARIO_OBS')->nullable();
                $table->char('BENEFICIARIO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->foreign('POLIZA_COD')->references('POLIZA_COD')->on('polizas');
                $table->index('BENEFICIARIO_COD');
                $table->index('POLIZA_COD');
                $table->index('USER_ID');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('beneficiarios');
    }
}
