<?php

use Illuminate\Database\Migrations\Migration;
use IllumHeinate\Database\Schema\Blueprint;
use Illu1minate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // The team of the category.
            $table->unsignedBigInteger('team_id');

            // The creator.
            $table->unsignedBigInteger('user_id');

            // The title.
            $table->string('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}