<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaInformacionInicial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('informacion_inicial')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('informacion_inicial', function (Blueprint $table) {
                //van los signos vitales del paciente.
                $table->BigIncrements('INFORMACIONINICIAL_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->decimal('INFORMACIONINICIAL_TEMPERATURA',18,2)->default(0);
                $table->decimal('INFORMACIONINICIAL_RESPIRACION',18,2)->default(0);
                $table->decimal('INFORMACIONINICIAL_TALLA',18,2)->default(0);
                $table->decimal('INFORMACIONINICIAL_PULSO',18,2)->default(0);
                $table->decimal('INFORMACIONINICIAL_PESO',18,2)->default(0);
                $table->decimal('INFORMACIONINICIAL_PRESION_ARTERIAL',18,2)->default(0);
                $table->decimal('INFORMACIONINICIAL_ESTATURA',18,2)->default(0);
                $table->decimal('INFORMACIONINICIAL_SUPERFICIE_CORPORAL',18,2)->default(0);
                 $table->char('INFORMACIONINICIAL_MENOR_DE_EDAD', 1)->default('N'); //si o no
                $table->char('INFORMACIONINICIAL_VIENE_SOLO', 1)->default('N'); //si o no
                $table->char('INFORMACIONINICIAL_CONSCIENTE', 1)->default('N'); //si o no
                $table->string('INFORMACIONINICIAL_SUPERFICIE_OBS')->nullable();
                $table->char('INFORMACIONINICIAL_LOGIC_ESTADO', 2);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('informacion_inicial');
    }
}
