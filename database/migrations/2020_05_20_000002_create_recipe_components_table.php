<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_components', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('quantity');

            $table->unsignedBigInteger('raw_id');
            $table->index('raw_id');
            $table->foreign('raw_id')->references('id')->on('raw_materials');

            $table->unsignedBigInteger('recipes_id');
            $table->index('recipes_id');
            $table->foreign('recipes_id')->references('id')->on('recipes');

            $table->unsignedBigInteger('categories_id');
            $table->index('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_components');
    }
}
