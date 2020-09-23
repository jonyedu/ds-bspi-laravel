<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaExamenesFisicos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('examenes_fisicos')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('examenes_fisicos', function (Blueprint $table) {
                //CP-> CON EVIDENCIA PATOLOGICA
                //SP-> SIN EVIDENCIA PATOLOGICA
                //CUANDO SE SELECCIONA CP SE DEBE DESCRIBIR.
                $table->BigIncrements('EXAMENFISICO_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->integer('EXAMENFISICO_CABEZA_CP')->default(0);
                $table->integer('EXAMENFISICO_CABEZA_SP')->default(0);
                $table->string('EXAMENFISICO_CABEZA_CP_DESCRIPCION')->nullable();
                $table->integer('EXAMENFISICO_CUELLO_CP')->default(0);
                $table->integer('EXAMENFISICO_CUELLO_SP')->default(0);
                $table->string('EXAMENFISICO_CUELLO_CP_DESCRIPCION')->nullable();
                $table->integer('EXAMENFISICO_TORAX_CP')->default(0);
                $table->integer('EXAMENFISICO_TORAX_SP')->default(0);
                $table->string('EXAMENFISICO_TORAX_CP_DESCRIPCION')->nullable();
                $table->integer('EXAMENFISICO_ABDOMEN_CP')->default(0);
                $table->integer('EXAMENFISICO_ABDOMEN_SP')->default(0);
                $table->string('EXAMENFISICO_ABDOMEN_CP_DESCRIPCION')->nullable();
                $table->integer('EXAMENFISICO_PELVIS_CP')->default(0);
                $table->integer('EXAMENFISICO_PELVIS_SP')->default(0);
                $table->string('EXAMENFISICO_PELVIS_CP_DESCRIPCION')->nullable();
                $table->integer('EXAMENFISICO_EXTREMIDADES_CP')->default(0);
                $table->integer('EXAMENFISICO_EXTREMIDADES_SP')->default(0);
                $table->string('EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION')->nullable();
                $table->char('EXAMENFISICO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                $table->index(['CITA_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('examenes_fisicos');
    }
}
