<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->enum('sexe', ['M', 'F']);
            $table->string('situation_matrimoniale');
            $table->string('matricule')->unique();
            $table->string('nationalite');
            $table->date('date_recrutement');
            $table->string('diplome_recrutement');
            $table->string('statut');
            $table->string('position');
            $table->string('grade');
            $table->enum('categorie', ['I', 'II', 'III', 'Néant']);
            $table->unsignedTinyInteger('echelon');
            $table->integer('indice');
            $table->date('date_prise_de_service');

            // Liens de rattachement
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();

            $table->timestamps();

            $table->foreign('direction_id')->references('id')->on('directions')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
        // Table: actes_administratifs
        Schema::create('acte_administratifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->string('type');
            $table->string('reference')->unique();
            $table->date('date_acte');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });

        // Table: evaluations
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->year('annee');
            $table->string('note');
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });

        // Table: sanctions
        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->string('type_sanction');
            $table->text('motif')->nullable();
            $table->date('date_sanction');
            $table->string('statut')->default('en cours');
            $table->string('document')->nullable(); // 📎 Ajout du champ pour document
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });

        // Table: recompenses
        Schema::create('recompenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->string('type_recompense'); // corrigé depuis 'type'
            $table->text('motif')->nullable();
            $table->date('date_recompense');
            $table->string('statut')->default('en cours'); // statut par défaut
            $table->string('document')->nullable(); // champ pour joindre un PDF
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });

        // Table: conges_absences
        Schema::create('conge_absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->enum('type', ['congé', 'absence']);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('motif')->nullable();
            $table->string('document')->nullable(); // <-- Ajout du champ document
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });


        // Table: formations
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->string('intitule');
            $table->string('organisme');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('description')->nullable();
            $table->string('attestation')->nullable(); // <-- Champ ajouté
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });
        // Table: affectations
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->date('date_affectation');
            $table->text('motif')->nullable();
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->foreign('direction_id')->references('id')->on('directions')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('affectations');
        Schema::dropIfExists('formations');
        Schema::dropIfExists('conges_absences');
        Schema::dropIfExists('recompenses');
        Schema::dropIfExists('sanctions');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('actes_administratifs');
        Schema::dropIfExists('agents');
    }
};
