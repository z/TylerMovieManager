<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('format_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('format_id')->references('id')->on('formats');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title');
            $table->integer('length');
            $table->integer('year');
            $table->integer('rating')->default(NULL);
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
        Schema::dropIfExists('movie');
        Schema::dropIfExists('format');
    }
}