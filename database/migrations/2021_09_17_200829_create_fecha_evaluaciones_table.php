<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFechaEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fecha_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idperiodo');
            $table->date('inicio');
            $table->date('final');
            $table->integer('estado');
            $table->string('sysuser',30);
            $table->timestamps();

            $table->foreign('idperiodo')->references('id')->on('periodos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fecha_evaluaciones');
    }
}
