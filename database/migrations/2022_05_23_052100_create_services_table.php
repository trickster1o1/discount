<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('is_featured')->nullable();
            $table->string('gallery_id')->nullable();
            $table->string('related_services')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('order_by')->nullable();
            $table->string('icon_class')->nullable();
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
        Schema::dropIfExists('services');
    }
}
