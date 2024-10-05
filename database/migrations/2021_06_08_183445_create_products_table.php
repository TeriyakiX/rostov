<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('vendor_code')->nullable();

//            // 4 типа - лист, длинномерный, штука, пачка
//            $table->unsignedSmallInteger('product_type')->nullable();
//            $table->unsignedSmallInteger('count_in_pack')->nullable();

            // лист - цена за квадартный метр
            // длинномерный - за метр
            // штучный, пачка - за штуку/пачку
            $table->decimal('price',10,2)->default(0);
            $table->decimal('promo_price',10,2)->default(0);
            $table->integer('sort')->default(0);

            // promo/other
            $table->boolean('is_novelty')->default(0)->nullable();
            $table->boolean('is_promo')->default(0)->nullable();

            // text
            $table->text('description')->nullable();
            $table->string('length_list')->nullable();
            $table->string('colors_list')->nullable();

            // list type
            $table->boolean('show_calculator')->default(false)->nullable();
            $table->float('thickness')->nullable();
            $table->float('list_width_full')->nullable();
            $table->float('list_width_useful')->nullable();
            $table->float('custom_length_from')->nullable();
            $table->float('custom_length_to')->nullable();
            $table->float('min_square_meters')->nullable();

            // relations
            $table->foreignId('brand_id')
                ->nullable()
                ->references('id')
                ->on('brands')
                ->nullOnDelete();

            $table->foreignId('status_id')
                ->nullable()
                ->references('id')
                ->on('product_statuses')
                ->nullOnDelete();

            // timestamps
            $table->timestamps();
        });

        // Belongs to many relations table
        Schema::create('product_related_product', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreignId('related_product_id')
                ->nullable()
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_related_product');
    }
}
