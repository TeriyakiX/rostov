<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();

            $table->foreignId('parent_id')
                ->nullable()
                ->references('id')
                ->on('product_categories')
                ->nullOnDelete();

            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_text')->nullable();

            $table->timestamps();
        });

        // Belongs to many relations table
        Schema::create('product_product_category', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreignId('product_category_id')
                ->nullable()
                ->references('id')
                ->on('product_categories')
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
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_product_category');
    }
}
