<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('index_sliders', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('sort')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('photo_desktop')->nullable();
            $table->string('photo_mobile')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('index_sliders');
    }
}
