<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        // Belongs to many relations table
//        Schema::create('brand_product', function (Blueprint $table) {
//            $table->foreignId('product_id')
//                ->nullable()
//                ->references('id')
//                ->on('products')
//                ->cascadeOnDelete();
//
//            $table->foreignId('brand_id')
//                ->nullable()
//                ->references('id')
//                ->on('brands')
//                ->cascadeOnDelete();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
        Schema::dropIfExists('brand_product');
    }
}
