<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_items', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable();
            $table->string('title')->nullable();

            $table->timestamps();
        });

        Schema::create('attribute_item_option_item', function (Blueprint $table) {
            $table->foreignId('attribute_item_id')
                ->nullable()
                ->references('id')
                ->on('attribute_items')
                ->cascadeOnDelete();

            $table->foreignId('option_item_id')
                ->nullable()
                ->references('id')
                ->on('option_items')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_items');
        Schema::dropIfExists('attribute_option_items');
    }
}
