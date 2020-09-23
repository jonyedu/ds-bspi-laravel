<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaDetalleCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('detalle_cita')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('detalle_cita', function (Blueprint $table) {
                
                $table->BigIncrements('DETALLECITA_COD');
                
                $table->unsignedBigInteger('CITA_COD');
                
                $table->unsignedBigInteger('TIPODETALLE_COD');
                
                $table->integer('DETALLECITA_CANTIDAD_VENTA');
                $table->integer('DETALLECITA_CANTIDAD_PRESCRIPCION');

                $table->decimal('DETALLECITA_PRECIO',18,2);
                $table->decimal('DETALLECITA_SUBTOTAL',18,2);
                $table->decimal('DETALLECITA_TOTAL',18,2);//VALOR CON IVA SI IVA ES APLICABLE
                
                $table->string('DETALLECITA_OBS')->nullable();
                
                $table->char('DETALLECITA_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('TIPODETALLE_COD')->references('TIPODETALLE_COD')->on('tipo_detalle');
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                
                $table->index(['CITA_COD', 'TIPODETALLE_COD']);
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('detalle_cita');
    }
}
