<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_widgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->text('to')->nullable();
            $table->text('subject')->nullable();
            $table->text('cc')->nullable();
            $table->longText('body')->nullable();
            $table->integer('rank')->nullable();
            $table->boolean('send_by_system')->nullable();
            $table->boolean('has_tokens')->nullable();
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
        Schema::dropIfExists('email_widgets');
    }
}
