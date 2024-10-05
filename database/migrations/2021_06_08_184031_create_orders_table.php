<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('delivery_type_id')->nullable();
            $table->string('payment_type_id')->nullable();
            $table->text('customer_comment')->nullable();
            $table->text('manager_comment')->nullable();
            $table->unsignedSmallInteger('status')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->boolean('is_fiz')->default(0)->nullable();
            $table->timestamps();
        });

        // Belongs to many relations table
        Schema::create('product_order', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete();

            $table->smallInteger('quantity')
                ->nullable();

            $table->json('options')->nullable(); // options_ids of selected product
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('product_order');
    }
}
