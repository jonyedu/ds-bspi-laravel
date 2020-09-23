<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaExamenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('examenes')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('examenes', function (Blueprint $table) {
                $table->BigIncrements('EXAMEN_COD');
                $table->string('EXAMEN_NOM',100)->unique();
                $table->string('EXAMEN_OBS')->nullable();
                $table->string('EXAMEN_LINEA')->nullable();
                $table->decimal('EXAMEN_PRECIO',10,2)->nullable();
                $table->char('EXAMEN_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('examenes');
    }
}
