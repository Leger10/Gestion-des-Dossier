<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToAgentsTable extends Migration
{
   public function up()
{
    // Cette migration n'est plus nécessaire si vous avez déjà
    // défini les clés étrangères dans CreateAgentsTable
    // Vous pouvez la supprimer ou la laisser vide
}

public function down()
{
    // Laisser vide
}
}