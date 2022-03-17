<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuradoPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurado_personals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idpersonal')->comment('percodigo de la persna evaluada');
            $table->unsignedBigInteger('idjurado');
            
            $table->string('graCom');
            $table->integer('division');
            $table->string('cargo');
            $table->unsignedBigInteger('dest4');
            $table->integer('evaluacion');

            $table->integer('estado');
            $table->string('sysuser',30);
            $table->timestamps();

            $table->foreign('idjurado')->references('id')->on('jurados');
            $table->foreign('idpersonal')->references('per_codigo')->on('personals');
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
        Schema::dropIfExists('jurado_personals');
    }
}
