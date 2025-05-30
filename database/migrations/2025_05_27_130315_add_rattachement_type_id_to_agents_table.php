<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('agents', function (Blueprint $table) {
        $table->unsignedTinyInteger('rattachement_type_id')->nullable()->after('service_id');
    });
}

public function down()
{
    Schema::table('agents', function (Blueprint $table) {
        $table->dropColumn('rattachement_type_id');
    });
}

};
