<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAntecedentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('antecedentes')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('antecedentes', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('ANTECEDENTE_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->string('ANTECEDENTE_MOTIVO_CONSULTA')->nullable();
                $table->string('ANTECEDENTE_PERSONALES')->nullable();
                $table->string('ANTECEDENTE_FAMILIAR')->nullable();
                $table->integer('ANTECEDENTE_CARDIOPATIA')->nullable();
                $table->integer('ANTECEDENTE_TUBERCULOSIS')->nullable();
                $table->integer('ANTECEDENTE_DIABETES')->nullable();
                $table->integer('ANTECEDENTE_ENFC_VASCULAR')->nullable();
                $table->integer('ANTECEDENTE_HIPERTENSION')->nullable();
                $table->integer('ANTECEDENTE_CANCER')->nullable();
                $table->integer('ANTECEDENTE_ENFMENTAL')->nullable();
                $table->integer('ANTECEDENTE_ENFINFECCIOSA')->nullable();
                $table->integer('ANTECEDENTE_MALFORMACION')->nullable();
                $table->integer('ANTECEDENTE_OTRA')->nullable();
                $table->string('ANTECEDENTE_ENFERMEDAD_ACTUAL_PROBLEMA')->nullable();
                $table->string('ANTECEDENTE_EXAMEN_FISICO')->nullable();
                $table->string('ANTECEDENTE_REVISION_ACTUAL_ORGANOS_SISTEMAS')->nullable();
                $table->char('ANTECEDENTE_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->index(['USER_ID']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('antecedentes');
    }
}
