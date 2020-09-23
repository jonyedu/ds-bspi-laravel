<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaLugaresDeTrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('lugares_de_trabajo')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('lugares_de_trabajo', function (Blueprint $table) {
                $table->BigIncrements('LUGARESDETRABAJO_COD');
                $table->string('LUGARESDETRABAJO_NOM',100)->unique();
                $table->string('LUGARESDETRABAJO_NOM_CONTACTO',100)->nullable();
                $table->string('LUGARESDETRABAJO_TELF_CONTACTO',12)->nullable();
                $table->string('LUGARESDETRABAJO_EMAIL_CONTACTO',100)->nullable();
                $table->string('LUGARESDETRABAJO_OBS')->nullable();
                $table->string('LUGARESDETRABAJO_WEB_PAGE')->nullable();
                $table->char('LUGARESDETRABAJO_TIPO', 2);
                $table->char('LUGARESDETRABAJO_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('lugares_de_trabajo');
    }
}
