<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subservice_id');
            $table->unsignedSmallInteger('price');
            $table->unsignedTinyInteger('gst')->default(5);
            $table->unsignedSmallInteger('quantity');
            $table->unsignedMediumInteger('amount');
            $table->unsignedTinyInteger('discount')->default(10);
            $table->unsignedMediumInteger('payable_amount');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_service_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->delete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->delete('cascade');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->delete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assigned_to');
            $table->timestamp('completed_at');
            $table->longText('Remarks')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->delete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_service_user');
        Schema::dropIfExists('order_status');
    }
}
