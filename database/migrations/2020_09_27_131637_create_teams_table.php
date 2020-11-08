<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // The creator of the team
            $table->unsignedBigInteger('user_id')->nullable();

            // The name of the team.
            $table->string('name')->nullable();

            // The code for joining the team.
            $table->string('access_code')->nullable();

            // If the team is a premium plan team
            $table->boolean("is_premium")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}