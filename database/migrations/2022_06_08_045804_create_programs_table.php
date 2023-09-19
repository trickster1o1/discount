<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('tagline')->nullable();
            $table->string('slug')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('is_featured')->nullable();
            $table->string('order_by')->nullable();
            $table->string('gallery_id')->nullable();
            $table->string('attached_file_url')->nullable();
            $table->string('start_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_date')->nullable();
            $table->string('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('target_amount')->nullable();
            $table->string('donation_amount')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('organizer')->nullable();
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
        Schema::dropIfExists('programs');
    }
}
