<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->unsignedBigInteger('direction_id'); // direction parente
    $table->timestamps();

    $table->foreign('direction_id')->references('id')->on('directions')->onDelete('cascade');
});

    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}