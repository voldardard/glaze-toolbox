<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fsname');
            $table->string('email', 60)->unique();
            $table->string('username', 45)->unique();
            $table->index('username');
            $table->string('password');
            $table->timestamps();
            $table->boolean('enable')->default(false);
            $table->boolean('admin')->default(false);
            $table->string('locale', 10)->default('en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
