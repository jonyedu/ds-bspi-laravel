<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('consultorios')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('consultorios', function (Blueprint $table) {
                
                $table->BigIncrements('CONSULTORIO_COD');
                $table->BigInteger('AREA_COD');
                $table->unsignedBigInteger('JORNADATRABAJADOR_COD');
                $table->string('CONSULTORIO_NOM');
                $table->string('CONSULTORIO_OBS')->nullable();
                $table->char('CONSULTORIO_LOGIC_ESTADO', 2);
                $table->BigInteger('US_COD_CREATED_UPDATED');
                $table->timestamps();

                //$table->foreign('AREA_COD')->references('AREA_COD')->on('areas');
                $table->foreign('JORNADATRABAJADOR_COD')->references('JORNADATRABAJADOR_COD')->on('jornada_trabajadores');
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
        Schema::dropIfExists('consultorios');
    }
}
