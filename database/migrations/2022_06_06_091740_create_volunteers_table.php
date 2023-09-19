<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('fullName')->nullable();
            $table->string('number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('dob')->nullable();
            $table->string('occupation')->nullable();
            $table->string('image')->nullable();
            $table->string('attachment')->nullable();
            $table->string('message')->nullable();
            $table->string('accepted')->default('no');
            $table->string('accepted_at')->nullable();
            $table->string('accepted_by')->nullable();
            $table->integer('order_by')->nullable();
            $table->timestamps();
            table_fields($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteers');
    }
}
