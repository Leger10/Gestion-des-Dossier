<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        // Désactiver temporairement les contraintes pour éviter les erreurs de suppression
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('roles');
        Schema::enableForeignKeyConstraints();
    }
};
