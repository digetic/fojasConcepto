<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Integer;

class CreateJuradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurados', function (Blueprint $table) {
            $table->id();
            $table->integer('per_cod');
            $table->string('graCom');
            $table->string('cargo');
            $table->integer('orden');
            $table->unsignedBigInteger('dest1');
            $table->unsignedBigInteger('dest2');
            $table->unsignedBigInteger('dest3');
            $table->unsignedBigInteger('dest4');
            $table->integer('evaluacion');
            $table->integer('externo')->default(0);
            $table->integer('estado');
            $table->string('sysuser',30);
            $table->timestamps();

            $table->foreign('dest1')->references('id')->on('nivel1_destinos');
            $table->foreign('dest2')->references('id')->on('nivel2_destinos');
            $table->foreign('dest3')->references('id')->on('nivel3_destinos');
            $table->foreign('dest4')->references('id')->on('nivel4_destinos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurados');
    }
}
