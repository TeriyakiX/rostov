<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('coatings_description')->after('coatings_id')->nullable();
            $table->string('profile_type')->after('coatings_id')->nullable();
            $table->text('profile_type_description')->after('coatings_id')->nullable();
            $table->string('manufacturer')->after('coatings_id')->nullable();
            $table->text('manufacturer_description')->after('coatings_id')->nullable();
            $table->text('thickness_description')->after('thickness')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('profile_type');
            $table->dropColumn('manufacturer');
        });
    }
}
