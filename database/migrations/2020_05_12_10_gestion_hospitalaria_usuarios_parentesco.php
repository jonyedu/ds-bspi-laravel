<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaUsuariosParentesco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('usuario_parentesco')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('usuario_parentesco', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('USUARIOPARENTESCO_COD');
                $table->unsignedBigInteger('TIPOPARENTESCO_COD');
                $table->unsignedBigInteger('PARENTESCO_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->string('PARENTESCO_OBS')->nullable();
                $table->char('PARENTESCO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->foreign('PARENTESCO_COD')->references('PARENTESCO_COD')->on('parentescos');
                $table->foreign('TIPOPARENTESCO_COD')->references('TIPOPARENTESCO_COD')->on('tipo_parentesco');
                $table->index(['PARENTESCO_COD', 'USER_ID']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('usuario_parentesco');
    }
}
