<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaProducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('producto')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('producto', function (Blueprint $table) {
                
                $table->BigIncrements('PRODUCTO_COD');
                $table->unsignedBigInteger('CATEGORIA_COD');
                $table->string('PRODUCTO_NOM', 255);
                $table->string('PRODUCTO_CLAVE', 255)->nullable();
                $table->decimal('PRODUCTO_PVP', 18);
                $table->char('PRODUCTO_LOGIC_ESTADO', 2);
                $table->string('US_COD_CREATED_UPDATED', 10);
                $table->timestamps();

                $table->foreign('CATEGORIA_COD')->references('CATEGORIA_COD')->on('categoria');
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
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('producto');
    }
}
