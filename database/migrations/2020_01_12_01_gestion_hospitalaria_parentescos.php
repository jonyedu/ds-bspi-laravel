<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaParentescos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('parentescos')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('parentescos', function (Blueprint $table) {
                $table->BigIncrements('PARENTESCO_COD');
                $table->string('PARENTESCO_NOM',100);
                $table->string('PARENTESCO_APELL',100);
                $table->string('PARENTESCO_IDENTIFICACION');
                $table->string('PARENTESCO_OBS')->nullable();
                $table->char('PARENTESCO_TIPO_IDENTIFICACION', 2);
                $table->char('PARENTESCO_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('parentescos');
    }
}
