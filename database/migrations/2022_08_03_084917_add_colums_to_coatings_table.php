<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToCoatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coatings', function (Blueprint $table) {
            $table->string('protective_layer')->after('slug')->nullable();
            $table->string('metal_thickness')->after('slug')->nullable();
            $table->string('polymer_coating_thickness')->after('slug')->nullable();
            $table->string('guarantee')->after('slug')->nullable();
            $table->string('light_fastness')->after('slug')->nullable();
            $table->text('description')->after('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coatings', function (Blueprint $table) {
            $table->dropColumn('protective_layer');
            $table->dropColumn('metal_thickness');
            $table->dropColumn('polymer_coating_thickness');
            $table->dropColumn('guarantee');
            $table->dropColumn('light_fastness');
            $table->dropColumn('description');
        });
    }
}
