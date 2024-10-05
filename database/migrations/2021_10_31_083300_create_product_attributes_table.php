<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->nullable()
                ->references('id')
                ->on('products')
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

            $table->boolean('for_cart')->default(false)->nullable();
            $table->float('price')->default(0)->nullable();

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
        Schema::dropIfExists('product_attributes');
    }
}
