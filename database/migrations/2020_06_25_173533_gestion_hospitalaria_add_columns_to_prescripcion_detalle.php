<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaAddColumnsToPrescripcionDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_gestion_hospitalaria')->table('prescripcion_detalle', function (Blueprint $table) {
            $table->dropForeign('presc_deta_farmacia_cod_foregin');
            $table->dropColumn('FARMACIA_COD');
            $table->dropIndex('presc_deta_farmacia_cod_foregin_idx');
            $table->renameColumn('PROD_DETA_COD','PRODUCTO_DETALLE_COD');
            
            $table->foreign('PRODUCTO_DETALLE_COD')->references('PRODUCTO_DETALLE_COD')->on('producto_detalle');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prescripcion_detalle', function (Blueprint $table) {
            //
        });
    }
}
