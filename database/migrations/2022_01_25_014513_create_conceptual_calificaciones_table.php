<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptualCalificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptual_calificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idjuradoPersonal');
            $table->text('literal');
            $table->decimal('numerica',5,2);
            $table->timestamps();

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
        Schema::dropIfExists('conceptual_calificaciones');
    }
}
