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

            // The title of the process.
            $table->text('description')->nullable();

            // The creator of the process.
            $table->unsignedBigInteger('user_id')->nullable();

            // The team the process belongs to.
            $table->unsignedBigInteger('team_id')->nullable();

            // The permission that the team of the user has for the process.
            $table->string('permission')->nullable();

            // The recurrence pattern of the process.
            $table->string('recurrence_pattern')->nullable();

            // The category (folder) of the process
            $table->unsignedBigInteger('category_id')->nullable();

            $table->boolean('is_active')->default(false);

            // The last kind of activity.
            $table->string('last_activity')->nullable();

            // The number of tasks in the process.
            $table->integer('task_count')->default(0);

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