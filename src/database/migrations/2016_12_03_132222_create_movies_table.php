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
        Schema::create('format', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('format_id')->unsigned();
            $table->foreign('format_id')->references('id')->on('format');
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
        Schema::dropIfExists('movies');
        Schema::dropIfExists('format');
    }
}