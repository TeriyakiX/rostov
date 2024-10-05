<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectRelatedProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_related_product', function (Blueprint $table) {
            $table->foreignId('project_id')
                ->nullable()
                ->references('id')
                ->on('projects')
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
        Schema::dropIfExists('project_related_product');
    }
}
