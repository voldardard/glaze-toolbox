<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeLabelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_labels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('recipes_id');
            $table->index('recipes_id');
            $table->foreign('recipes_id')->references('id')->on('recipes')->onDelete('cascade');

            $table->unsignedBigInteger('labels_id');
            $table->index('labels_id');
            $table->foreign('labels_id')->references('id')->on('labels');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_labels');
    }
}
