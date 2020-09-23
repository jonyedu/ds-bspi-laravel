<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaTrabajadoresPersonalSalud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('trabajadores_personal_salud')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('trabajadores_personal_salud', function (Blueprint $table) {
                $db =DB::connection('mysql')->getDatabaseName();
                $table->BigIncrements('TRABAJADORESPERSONALSALUD_COD');
                $table->unsignedBigInteger('TIPOTRABAJADOR_COD');
                $table->unsignedBigInteger('USER_ID');
                $table->date('TRABAJADORESPERSONALSALUD_FECHA_CONTRATO')->nullable();
                $table->string('TRABAJADORESPERSONALSALUD_OBS')->nullable();
                $table->string('TRABAJADORESPERSONALSALUD_CONTRATO_PDF')->nullable();
                $table->char('TRABAJADORESPERSONALSALUD_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();
                $table->foreign('USER_ID')->references('id')->on(new Expression ($db . '.users'));
                $table->foreign('TIPOTRABAJADOR_COD')->references('TIPOTRABAJADOR_COD')->on('tipos_trabajadores');
                $table->index(['TIPOTRABAJADOR_COD', 'USER_ID']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('trabajadores_personal_salud');
    }
}
