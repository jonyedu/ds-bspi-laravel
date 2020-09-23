<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaCitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('citas')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('citas', function (Blueprint $table) {
                $db = DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('CITA_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->unsignedBigInteger('AREA_COD');
                
                $table->integer('CITA_ANTERIOR')->nullable(); //adjuntar citas, para ejemplo cambio de doctor
                $table->integer('CITA_PRIORIDAD')->nullable();
                
                $table->integer('CITA_ACOMPAÑANTE_COD')->nullable(); //id de tabla parentezco
                $table->string('CITA_OBS')->nullable();
                $table->char('CITA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression($db . '.users'));
                $table->foreign('AREA_COD')->references('AREA_COD')->on('areas');
                $table->index(['USER_ID', 'AREA_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('citas');
    }
}
