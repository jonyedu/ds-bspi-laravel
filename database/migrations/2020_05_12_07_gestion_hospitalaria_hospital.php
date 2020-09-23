<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaHospital extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('hospital')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('hospital', function (Blueprint $table) {
                $table->BigIncrements('HOSPITAL_COD');
                $table->string('HOSPITAL_NOM');
                $table->string('HOSPITAL_NOM_CONTACTO')->nullable();
                $table->string('HOSPITAL_TELF_CONTACTO')->nullable();
                $table->string('HOSPITAL_EMAIL_CONTACTO')->nullable();
                $table->string('HOSPITAL_OBS')->nullable();
                $table->string('HOSPITAL_WEB_PAGE')->nullable();
                $table->char('HOSPITAL_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('hospital');
    }
}
