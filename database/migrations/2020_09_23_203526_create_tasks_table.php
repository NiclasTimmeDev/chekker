<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // The title of the task.
            $table->string('title');

            // The process the task belongs to.
            $table->unsignedBigInteger('process_id')->nullable();

            // Is task comleted
            $table->boolean('is_done')->default(false);

            // Default timestamps.
            $table->timestamps();

            // The rank that the task will be listed at.
            $table->integer('rank');

            // Has the task watchers that must be notified?
            $table->boolean('has_watchers')->default(false);

            // The id of the user the task is assigned to, if applicable.
            $table->unsignedBigInteger('assignee_id')->nullable();

            // Does the task have a due date?
            $table->boolean('has_due_date')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}