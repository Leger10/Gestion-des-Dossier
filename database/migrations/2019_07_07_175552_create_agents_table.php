<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 
       public function up()
{
    if (!Schema::hasTable('agents')) {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rattachement_type_id');
            $table->unsignedBigInteger('rattachement_zone_id');
            $table->string('nom');
            $table->enum('sexe', ['Masculin', 'Feminin']);
            
            // Utilisez foreignId pour une meilleure syntaxe
            $table->foreignId('direction_id')->constrained('directions');
            $table->foreignId('service_id')->constrained('services');
            
            $table->string('prenom');
            $table->string('lieu_naiss');
            $table->date('date_naiss');
            $table->string('situation_matri');
            $table->string('matricule');
            $table->string('niveau_recrutement');
            $table->date('date_prise_de_service');
            $table->string('emploi');
            $table->string('fonction', 250);
            $table->string('statut');
            $table->string('categorie');
            $table->string('Grade');
            $table->string('classe');
            $table->string('echelon');
            $table->string('autorisation_absence')->nullable();
            $table->string('demande_conge')->nullable();
            $table->string('demande_explication')->nullable();
            $table->string('felicitation_reconnaissance')->nullable();
            $table->string('sanctions')->nullable();
            $table->string('autre_situation');
            $table->string('user_delete_name')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('rattachement_type_id')->references('id')->on('services');
            $table->foreign('rattachement_zone_id')->references('id')->on('directions');
            
            // Index
            $table->index('sexe');
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
}
