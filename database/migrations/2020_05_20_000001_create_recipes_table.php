<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('locale', 10)->default('en');

            $table->timestamps();
            $table->double('version');

            $table->unsignedBigInteger('users_id');
            $table->index('users_id');
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('categories_id');
            $table->index('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->index('parent_id');
            $table->foreign('parent_id')->references('id')->on('recipes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
