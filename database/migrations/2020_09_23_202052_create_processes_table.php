<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();

            // The title of the process.
            $table->string('title');

            // The creator of the process.
            $table->unsignedBigInteger('user_id')->nullable();

            // The team the process belongs to.
            $table->unsignedBigInteger('team_id')->nullable();

            // The permission that the team of the user has for the process.
            $table->string('permission')->nullable();

            // The recurrence pattern of the process.
            $table->string('recurrence_pattern')->nullable();

            // The category of the process
            $table->unsignedBigInteger('category_id')->nullable();

            $table->boolean('is_active')->default(false);

            // Default timestamps.
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
        Schema::dropIfExists('processes');
    }
}