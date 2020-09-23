<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaUsuariosParentezco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('usuario_parentezco')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('usuario_parentezco', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('USUARIOPARENTEZCO_COD');
                $table->unsignedBigInteger('TIPOPARENTEZCO_COD');
                $table->unsignedBigInteger('PARENTEZCO_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->string('PARENTEZCO_OBS')->nullable();
                $table->char('PARENTEZCO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->foreign('PARENTEZCO_COD')->references('PARENTEZCO_COD')->on('parentezcos');
                $table->foreign('TIPOPARENTEZCO_COD')->references('TIPOPARENTEZCO_COD')->on('tipo_parentezco');
                $table->index(['PARENTEZCO_COD', 'USER_ID']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('usuario_parentezco');
    }
}
