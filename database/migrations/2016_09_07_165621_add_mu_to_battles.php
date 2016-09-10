<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMuToBattles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('battles', function (Blueprint $table) {
            $table->double('mu_before')->nullable();
            $table->double('mu_after')->nullable();
            $table->double('opponent_mu_before')->nullable();
            $table->double('opponent_mu_after')->nullable();
            $table->double('sigma_before')->nullable();
            $table->double('sigma_after')->nullable();
            $table->double('opponent_sigma_before')->nullable();
            $table->double('opponent_sigma_after')->nullable();
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
            $table->dropColumn('mu_before');
            $table->dropColumn('mu_after');
            $table->dropColumn('opponent_mu_before');
            $table->dropColumn('opponent_mu_after');
            $table->dropColumn('sigma_before');
            $table->dropColumn('sigma_after');
            $table->dropColumn('opponent_sigma_before');
            $table->dropColumn('opponent_sigma_after');
        });
    }
}
