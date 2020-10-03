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

            // Default timestamps.
            $table->timestamps();

            // The recurrence pattern of the process.
            $table->string('recurrence_pattern')->nullable();

            // The category of the process
            $table->unsignedBigInteger('category_id')->nullable();

            $table->boolean('is_active')->default(false);
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
