<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivaCalificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetiva_calificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iddetalleObjetiva');
            $table->unsignedBigInteger('idjuradoPersonal');
            $table->decimal('nota',5,2);
            $table->timestamps();

            $table->foreign('iddetalleObjetiva')->references('id')->on('pregunta_objetivas');
            $table->foreign('idjuradoPersonal')->references('id')->on('jurado_personals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objetiva_calificaciones');
    }
}
