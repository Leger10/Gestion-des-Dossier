<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToAgentsTable extends Migration
{
    public function up()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->foreign('direction_id')
                  ->references('id')
                  ->on('directions')
                  ->onDelete('restrict');
                  
            $table->foreign('service_id')
                  ->references('id')
                  ->on('services')
                  ->onDelete('restrict');
                  
            // Cette clé sera ajoutée seulement si rattachement_types existe
            if (Schema::hasTable('rattachement_types')) {
                $table->foreign('rattachement_type_id')
                      ->references('id')
                      ->on('rattachement_types')
                      ->onDelete('restrict');
            }
        });
    }

    public function down()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropForeign(['direction_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['rattachement_type_id']);
        });
    }
}