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
            $table->integer('dest1');
            $table->integer('dest2');
            $table->integer('dest3');
            $table->integer('dest4');
            $table->integer('evaluacion');
            $table->integer('externo')->default(0);
            $table->integer('estado');
            $table->string('sysuser',30);
            $table->timestamps();
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
