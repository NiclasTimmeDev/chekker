<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_people', function (Blueprint $table) {
            $table->id();

            // The team the person is attached to.
            $table->unsignedBigInteger('team_id');

            // The name of the person.
            $table->string('name');

            // The email address.
            $table->string('name');

            // The organizaton the person belongs to.
            $table->string('organization')->nullable();

            // The timestamp of creation date.
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
        Schema::dropIfExists('external_people');
    }
}