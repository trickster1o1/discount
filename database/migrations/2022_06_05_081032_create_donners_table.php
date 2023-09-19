<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donners', function (Blueprint $table) {
            $table->id();
            $table->string('fullName')->nullable();
            $table->string('number')->nullable();
            $table->string('order_by')->default('0');
            $table->string('position')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('amount')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('donationProgram')->nullable();
            $table->text('remarks')->nullable();
            $table->text('attachment')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('refid')->nullable();
            table_fields($table,'inactive');
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
        Schema::dropIfExists('donners');
    }
}
