<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaDocumentosCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('documentos_cita')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('documentos_cita', function (Blueprint $table) {
                $table->BigIncrements('DOCUMENTOSCITA_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->string('DOCUMENTOSCITA_NOM', 70);
                $table->string('DOCUMENTOSCITA_OBS')->nullable();
                $table->string('DOCUMENTOSCITA_RUTA');
                $table->char('DOCUMENTOSCITA_TIPO', 10); //EXCEL PDF WORD IMAGEN
                $table->char('DOCUMENTOSCITA_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('documentos_cita');
    }
}
