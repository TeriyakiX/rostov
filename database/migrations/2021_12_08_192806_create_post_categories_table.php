<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');

            $table->boolean('show_in_header')->default(false)->nullable();
            $table->boolean('show_in_footer')->default(false)->nullable();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
        });

        Schema::create('post_category_post', function (Blueprint $table) {
            $table->foreignId('post_category_id')
                ->nullable()
                ->references('id')
                ->on('post_categories')
                ->cascadeOnDelete();

            $table->foreignId('post_id')
                ->nullable()
                ->references('id')
                ->on('posts')
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
        Schema::dropIfExists('post_categories');
    }
}
