<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDossiersTable extends Migration
{
    public function up()
{
    Schema::create('dossiers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('agent_id');
        $table->string('titre')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();

        $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
}
