<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPopularToCoatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coatings', function (Blueprint $table) {
            $table->boolean('is_popular')->default(false)->after('description')->index(); // Поле для популярности
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
            $table->dropColumn('is_popular');
        });
    }
}
