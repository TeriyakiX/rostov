<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        // Belongs to many relations table
        Schema::create('product_product_feature', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreignId('product_feature_id')
                ->nullable()
                ->references('id')
                ->on('product_features')
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
        Schema::dropIfExists('product_features');
    }
}
