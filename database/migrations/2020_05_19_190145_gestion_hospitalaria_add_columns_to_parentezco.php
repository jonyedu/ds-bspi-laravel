<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumnsToParentezco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('parentezcos', function (Blueprint $table) {
            $db = DB::connection('mysql')->getDatabaseName();
            $table->unsignedBigInteger('USER_ID');
            $table->unsignedBigInteger('TIPOPARENTEZCO_COD');
            $table->foreign('USER_ID')->references('id')->on(new Expression($db . '.users'));
            $table->foreign('TIPOPARENTEZCO_COD')->references('TIPOPARENTEZCO_COD')->on('tipo_parentezco');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('parentezcos', function (Blueprint $table) {
            $table->dropColumn("USER_ID");
        });
    }
}
