<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idperiodo');
            $table->unsignedBigInteger('idfechaEvaluacion');
            $table->integer('estado');
            $table->string('sysuser',30);
            $table->timestamps();

            $table->foreign('idperiodo')->references('id')->on('periodos');
            $table->foreign('idfechaEvaluacion')->references('id')->on('fecha_evaluaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluaciones');
    }
}
