<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTipoParentesco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipo_parentesco')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipo_parentesco', function (Blueprint $table) {
                $table->BigIncrements('TIPOPARENTESCO_COD');
                $table->string('TIPOPARENTESCO_NOM',100);
                $table->string('TIPOPARENTESCO_OBS')->nullable();
                $table->char('TIPOPARENTESCO_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipo_parentesco');
    }
}
