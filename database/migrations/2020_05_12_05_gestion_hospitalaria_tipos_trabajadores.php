<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTiposTrabajadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('tipos_trabajadores')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('tipos_trabajadores', function (Blueprint $table) {
                $table->BigIncrements('TIPOTRABAJADOR_COD');
                $table->string('TIPOTRABAJADOR_NOM',100)->unique();
                $table->string('TIPOTRABAJADOR_OBS')->nullable();
                $table->char('TIPOTRABAJADOR_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('tipos_trabajadores');
    }
}
