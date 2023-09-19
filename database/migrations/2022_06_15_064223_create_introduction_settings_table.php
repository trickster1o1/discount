<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntroductionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('introduction_settings', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image')->nullable();
            $table->string('thumb_image')->nullable();
            $table->text('description')->nullable();
            $table->string('title')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('tagline')->nullable();
            $table->string('tabA_content')->nullable();
            $table->string('tabB_content')->nullable();
            $table->string('tabC_content')->nullable();
            $table->string('supporter')->nullable();
            $table->string('testimonials')->nullable();
            $table->string('second_banner_image')->nullable();
            $table->string('second_banner_title')->nullable();
            $table->string('second_banner_tagline')->nullable();
            $table->string('second_banner_button_title')->nullable();
            $table->string('second_banner_button_link')->nullable();
            $table->string('volunteer')->nullable();
            $table->string('volunteer_title')->nullable();
            $table->string('volunteer_tagline')->nullable();
            $table->string('testimonial_title')->nullable();
            $table->string('testimonial_tagline')->nullable();
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
        Schema::dropIfExists('introduction_settings');
    }
}
