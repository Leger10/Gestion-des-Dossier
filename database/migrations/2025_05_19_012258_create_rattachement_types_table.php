<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRattachementTypesTable extends Migration
{

public function up()
{
    Schema::create('rattachement_types', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // 'direction' ou 'service'
        $table->timestamps();
    });

    // Insérez les valeurs par défaut
    DB::table('rattachement_types')->insert([
        ['name' => 'direction'],
        ['name' => 'service']
    ]);
}
}