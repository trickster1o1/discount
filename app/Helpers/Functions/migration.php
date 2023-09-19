<?php

if (!function_exists('table_fields')) {
    function table_fields($table, $default = 'active')
    {
        if ($default == NULL) {
            $table->string('status')->nullable();
        } else {
            $table->string('status')->default($default);
        }
        $table->string('created_by')->nullable();
        $table->string('updated_by')->nullable();
    }
}
if (!function_exists('seo_details')) {
    function seo_details($table)
    {
        $table->string('meta_key')->nullable();
        $table->text('meta_description')->nullable();
        $table->string('fb_title')->nullable();
        $table->text('fb_description')->nullable();
        $table->string('fb_image')->nullable();
        $table->string('twitter_title')->nullable();
        $table->text('twitter_description')->nullable();
        $table->string('twitter_image')->nullable();
    }
}
