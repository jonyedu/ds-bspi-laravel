<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaDocumentosUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('documentos_usuario')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('documentos_usuario', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('DOCUMENTOSUSUARIO_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->string('DOCUMENTOSUSUARIO_NOM', 70);
                $table->string('DOCUMENTOSUSUARIO_OBS')->nullable();
                $table->string('DOCUMENTOSUSUARIO_RUTA');
                $table->char('DOCUMENTOSUSUARIO_TIPO', 10); //EXCEL PDF WORD IMAGEN
                $table->char('DOCUMENTOSUSUARIO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->index(['USER_ID']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('documentos_usuario');
    }
}
