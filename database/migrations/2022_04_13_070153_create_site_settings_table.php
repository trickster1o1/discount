<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('pri_phone')->nullable();
            $table->string('pri_email')->nullable();
            $table->string('pri_address')->nullable();
            $table->string('sec_phone')->nullable();
            $table->string('sec_email')->nullable();
            $table->string('sec_address')->nullable();
            $table->string('email_verification')->nullable();
            $table->string('primary_logo')->nullable();
            $table->string('secondary_logo')->nullable();
            $table->string('url')->nullable();
            $table->string('offline_msg')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('ig_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('viber')->nullable();
            $table->string('pintrest_link')->nullable();
            $table->string('skype_link')->nullable();
            $table->string('facebook_page_id')->nullable();
            $table->string('android')->nullable();
            $table->string('ios')->nullable();
            $table->string('loader')->nullable();
            $table->longText('google_map_html')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
}
