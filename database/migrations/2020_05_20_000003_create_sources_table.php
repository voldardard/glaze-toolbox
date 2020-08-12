<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('author');
            $table->string('description')->nullable();

            $table->unsignedBigInteger('type_id');
            $table->index('type_id');
            $table->foreign('type_id')->references('id')->on('sources_types');

            $table->unsignedBigInteger('recipes_id');
            $table->index('recipes_id');
            $table->foreign('recipes_id')->references('id')->on('recipes')->onDelete('cascade');;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
