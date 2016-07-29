<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReAddColumnsToSquads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('squads', function (Blueprint $table) {
            $table->integer('wins')->unsigned();
            $table->integer('draws')->unsigned();
            $table->integer('losses')->unsigned();
            $table->integer('uplinks_captured')->unsigned();
            $table->integer('uplinks_saved')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('squads', function (Blueprint $table) {
            $table->dropColumn('wins');
            $table->dropColumn('draws');
            $table->dropColumn('losses');
            $table->dropColumn('uplinks_captured');
            $table->dropColumn('uplinks_saved');
        });
    }
}
