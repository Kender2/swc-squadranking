<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSquadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('squads', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('name')->nullable();
            $table->double('mu')->default(25.0);
            $table->double('sigma')->default(25/3);
            $table->integer('wins')->unsigned();
            $table->integer('draws')->unsigned();
            $table->integer('losses')->unsigned();
            $table->integer('uplinks_captured')->unsigned();
            $table->integer('uplinks_saved')->unsigned();
            $table->string('faction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('squads');
    }
}
