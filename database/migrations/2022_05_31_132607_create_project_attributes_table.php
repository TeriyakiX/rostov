<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->nullable()
                ->references('id')
                ->on('projects')
                ->nullOnDelete();

            $table->foreignId('attribute_item_id')
                ->nullable()
                ->references('id')
                ->on('attribute_items')
                ->nullOnDelete();

            $table->foreignId('option_item_id')
                ->nullable()
                ->references('id')
                ->on('option_items')
                ->nullOnDelete();

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
        Schema::dropIfExists('project_attributes');
    }
}
