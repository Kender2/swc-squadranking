<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameBattleColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('battles', function (Blueprint $table) {
            $table->renameColumn('rebel_id', 'squad_id');
            $table->renameColumn('rebel_score', 'score');
            $table->renameColumn('empire_id', 'opponent_id');
            $table->renameColumn('empire_score', 'opponent_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('battles', function (Blueprint $table) {
            $table->renameColumn('squad_id', 'rebel_id');
            $table->renameColumn('score', 'rebel_score');
            $table->renameColumn('opponent_id', 'empire_id');
            $table->renameColumn('opponent_score', 'empire_score');
        });
    }
}
