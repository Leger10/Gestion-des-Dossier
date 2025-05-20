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
    $table->foreignId('agent_id')->constrained()->onDelete('cascade');
    $table->string('titre')->nullable();
    $table->text('description')->nullable();
    $table->text('date_depart_affectation')->nullable();
    $table->string('autorisation_absence')->nullable(); // ✅ Une seule fois
    $table->string('mise_en_disposition')->nullable();
    $table->string('demande_conge')->nullable();
    $table->string('demande_explication')->nullable();
    $table->string('felicitation_reconnaissance')->nullable();
    $table->string('formation_acquise')->nullable();
    $table->string('sanctions')->nullable();
    $table->string('autre_situation')->nullable();
    $table->timestamps();
});
}

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
}
