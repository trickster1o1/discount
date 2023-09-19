<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('banner_type')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('tag_line')->nullable();
            $table->string('primary_button_title')->nullable();
            $table->string('primary_button_link')->nullable();
            $table->string('secondary_button_title')->nullable();
            $table->string('secondary_button_link')->nullable();
            $table->integer('order_by')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
