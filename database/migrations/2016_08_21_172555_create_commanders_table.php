<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commanders', function (Blueprint $table) {
            $table->uuid('playerId')->unique();
            $table->uuid('squadId')->nullable;
            $table->string('name');
            $table->boolean('isOwner');
            $table->boolean('isOfficer');
            $table->dateTime('joinDate');
            $table->integer('troopsDonated')->unsigned();
            $table->integer('troopsReceived')->unsigned();
            $table->tinyInteger('hqLevel')->unsigned();
            $table->integer('reputationInvested')->unsigned();
            $table->integer('xp')->unsigned();
            $table->integer('score')->unsigned();
            $table->integer('attacksWon')->unsigned();
            $table->integer('defensesWon')->unsigned();
            $table->dateTime('lastLoginTime');
            $table->dateTime('lastUpdated');
            $table->string('faction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('commanders');
    }
}
