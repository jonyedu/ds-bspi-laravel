<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTipoDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipo_detalle')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipo_detalle', function (Blueprint $table) {
                $table->bigIncrements('TIPODETALLE_COD');
                $table->string('TIPODETALLE_NOM');
                $table->decimal('TIPODETALLE_PRECIO', 18,2)->default(0);
                $table->integer('TIPODETALLE_IVA')->default(0);
                $table->string('TIPODETALLE_OBS')->nullable();
                $table->char('TIPODETALLE_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipo_detalle');
    }
}
