<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashlessPaymentDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashless_payment_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('file_path');

            $table->foreignId('order_id')
                ->nullable()
                ->references('id')
                ->on('orders')
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
        Schema::dropIfExists('cashless_payment_documents');
    }
}
