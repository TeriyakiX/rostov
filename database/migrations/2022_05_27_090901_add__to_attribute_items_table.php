<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToAttributeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_items', function (Blueprint $table) {
            $table->foreignId('type_attribute_id')
                ->after('title')
                ->nullable()
                ->references('id')
                ->on('types_attributes')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_items', function (Blueprint $table) {
            $table->dropColumn('type_attribute_id');
        });
    }
}
