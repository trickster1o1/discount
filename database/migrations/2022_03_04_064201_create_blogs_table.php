<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('tag_line')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('author')->nullable();
            $table->string('publish_date')->nullable();
            $table->string('tags')->nullable();
            $table->string('setting')->nullable();
            $table->integer('order_by')->nullable();
            $table->string('is_featured')->nullable();
            seo_details($table);
            table_fields($table);
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
        Schema::dropIfExists('blogs');
    }
}
