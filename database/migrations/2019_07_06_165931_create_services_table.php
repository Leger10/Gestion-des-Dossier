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
            $table->text('description')->nullable();
            $table->foreignId('direction_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Index pour améliorer les performances des jointures
            $table->index('direction_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}