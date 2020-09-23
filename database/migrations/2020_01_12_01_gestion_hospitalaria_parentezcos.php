<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaParentezcos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('parentezcos')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('parentezcos', function (Blueprint $table) {
                $table->BigIncrements('PARENTEZCO_COD');
                $table->string('PARENTEZCO_NOM',100);
                $table->string('PARENTEZCO_APELL',100);
                $table->string('PARENTEZCO_IDENTIFICACION')->unique();
                $table->string('PARENTEZCO_OBS')->nullable();
                $table->char('PARENTEZCO_TIPO_IDENTIFICACION', 2);
                $table->char('PARENTEZCO_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('parentezcos');
    }
}
