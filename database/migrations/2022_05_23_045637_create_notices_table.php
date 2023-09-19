<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('published_date')->nullable();
            $table->string('publish_time')->nullable();
            $table->string('expiary_date')->nullable();
            $table->string('expiary_time')->nullable();
            $table->string('publish_as_popup')->nullable();
            $table->string('is_featured')->nullable();
            $table->string('order_by')->nullable();
            $table->string('attached_file_url')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('banner_image')->nullable();
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
        Schema::dropIfExists('notices');
    }
}
