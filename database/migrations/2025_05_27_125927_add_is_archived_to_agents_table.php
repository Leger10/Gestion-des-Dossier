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
        if (!Schema::hasColumn('agents', 'deleted_at')) {
            $table->softDeletes(); // ajoute 'deleted_at'
        }

        $table->boolean('is_archived')->default(false)->after('deleted_at');
    });
}

};
