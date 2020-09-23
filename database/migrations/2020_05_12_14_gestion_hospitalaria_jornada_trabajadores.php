<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaJornadaTrabajadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('jornada_trabajadores')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('jornada_trabajadores', function (Blueprint $table) {
              
                $table->BigIncrements('JORNADATRABAJADOR_COD');
                $table->unsignedBigInteger('TRABAJADORESPERSONALSALUD_COD');
                $table->time('JORNADATRABAJADOR_INICIO');
                $table->time('JORNADATRABAJADOR_FIN');
                $table->string('JORNADATRABAJADOR_OBS')->nullable();
                $table->char('JORNADATRABAJADOR_LUNES', 1)->nullable(); //A->ACTIVO I->INACTIVO
                $table->char('JORNADATRABAJADOR_MARTES', 1)->nullable(); //A->ACTIVO I->INACTIVO
                $table->char('JORNADATRABAJADOR_MIERCOLES', 1)->nullable(); //A->ACTIVO I->INACTIVO
                $table->char('JORNADATRABAJADOR_JUEVES', 1)->nullable(); //A->ACTIVO I->INACTIVO
                $table->char('JORNADATRABAJADOR_VIERNES', 1)->nullable(); //A->ACTIVO I->INACTIVO
                $table->char('JORNADATRABAJADOR_SABADO', 1)->nullable(); //A->ACTIVO I->INACTIVO
                $table->char('JORNADATRABAJADOR_DOMINGO', 1)->nullable(); //A->ACTIVO I->INACTIVO
                $table->char('JORNADATRABAJADOR_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps(); 
                $table->foreign('TRABAJADORESPERSONALSALUD_COD')->references('TRABAJADORESPERSONALSALUD_COD')->on('trabajadores_personal_salud');
                $table->index(['TRABAJADORESPERSONALSALUD_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('jornada_trabajadores');
    }
}
