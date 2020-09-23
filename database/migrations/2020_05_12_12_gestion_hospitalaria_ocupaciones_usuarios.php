<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaOcupacionesUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('ocupaciones_usuarios')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('ocupaciones_usuarios', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('OCUPACIONUSUARIO_COD');
                $table->unsignedBigInteger('OCUPACIONES_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->string('OCUPACIONUSUARIO_OBS')->nullable();
                $table->char('OCUPACIONUSUARIO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->foreign('OCUPACIONES_COD')->references('OCUPACIONES_COD')->on('ocupaciones');
                $table->index(['OCUPACIONES_COD', 'USER_ID']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('ocupaciones_usuarios');
    }
}
