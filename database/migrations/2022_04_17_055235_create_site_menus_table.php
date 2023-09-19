<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_menus', function (Blueprint $table) {
            $table->id();
            $table->string('link_type');
            $table->string('parent')->default(0);
            $table->string('location')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('topic')->nullable();
            $table->string('title')->nullable();
            $table->string('external_url')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('site_menus');
    }
}
