<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionsToCoatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coatings', function (Blueprint $table) {
            $table->string('protective_layer_description')->after('protective_layer')->nullable();
            $table->string('metal_thickness_description')->after('protective_layer')->nullable();
            $table->string('polymer_coating_thickness_description')->after('protective_layer')->nullable();
            $table->string('guarantee_description')->after('protective_layer')->nullable();
            $table->string('light_fastness_description')->after('protective_layer')->nullable();
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
            $table->dropColumn('protective_layer_description');
            $table->dropColumn('metal_thickness_description');
            $table->dropColumn('polymer_coating_thickness_description');
            $table->dropColumn('guarantee_description');
            $table->dropColumn('light_fastness_description');
        });
    }
}
