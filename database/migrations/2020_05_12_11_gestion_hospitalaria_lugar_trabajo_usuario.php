<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaLugarTrabajoUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('lugar_trabajo_usuario')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('lugar_trabajo_usuario', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('LUGARTRABAJOUSUARIO_COD');
                $table->unsignedBigInteger('LUGARESDETRABAJO_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->string('LUGARTRABAJOUSUARIO_OBS')->nullable();
                $table->char('LUGARTRABAJOUSUARIO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->foreign('LUGARESDETRABAJO_COD')->references('LUGARESDETRABAJO_COD')->on('lugares_de_trabajo');
                $table->index(['LUGARESDETRABAJO_COD', 'USER_ID']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('lugar_trabajo_usuario');
    }
}
