<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('collectivites') && !Schema::hasTable('agents')) {
            DB::statement('RENAME TABLE collectivites TO agents');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasTable('agents') && !Schema::hasTable('collectivites')) {
            DB::statement('RENAME TABLE agents TO collectivites');
        }
    }
};
