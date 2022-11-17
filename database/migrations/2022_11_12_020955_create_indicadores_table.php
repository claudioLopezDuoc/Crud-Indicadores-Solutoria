<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadores', function (Blueprint $table) {
            $table->id();
            $table->String('nombreIndicador');
            $table->String('codigoIndicador');
            $table->String('unidadMedidaIndicador');
            $table->decimal('valorIndicador');
            $table->date('fechaIndicador');
            $table->String('tiempoIndicador');
            $table->String('origenIndicador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicadores');
    }
};
