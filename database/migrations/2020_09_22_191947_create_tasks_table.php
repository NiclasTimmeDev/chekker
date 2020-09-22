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
            // Creator.
            $table->unsignedBigInteger('user_id')->nullable();

            // The process the task belongs to.
            $table->unsignedBigInteger('process_id')->nullable();

            // The E-Mail template that will be sent.
            $table->unsignedBigInteger('template_id')->nullable();

            // The person that's involed. May be 3rd party.
            $table->unsignedBigInteger('involved_person');

            // Default timestamps.
            $table->timestamps();

            // The title of the task.
            $table->string('title');

            // The description of the task.
            $table->string('description');
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