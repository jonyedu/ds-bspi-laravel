<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTipoParentezco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipo_parentezco')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipo_parentezco', function (Blueprint $table) {
                $table->BigIncrements('TIPOPARENTEZCO_COD');
                $table->string('TIPOPARENTEZCO_NOM',100)->nullable();
                $table->string('TIPOPARENTEZCO_OBS')->nullable();
                $table->char('TIPOPARENTEZCO_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipo_parentezco');
    }
}
