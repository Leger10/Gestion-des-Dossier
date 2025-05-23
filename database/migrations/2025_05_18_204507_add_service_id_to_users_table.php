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
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('service_id')->nullable()->after('id');
        $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['service_id']);
        $table->dropColumn('service_id');
    });
}

};
