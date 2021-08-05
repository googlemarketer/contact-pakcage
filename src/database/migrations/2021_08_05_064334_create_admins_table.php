<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile')->unique();
            $table->string('password');
            $table->string('role')->default('superadmin');
            $table->unsignedTinyInteger('active')->default(1);
            $table->string('slug')->index();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan');
            $table->longText('description');
            $table->unsignedSmallInteger('price');
            $table->unsignedTinyInteger('validity');
            $table->unsignedSmallInteger('propertycount');
            $table->unsignedSmallInteger('ordercount');
            $table->timestamp('published_at');
            $table->string('slug');
            $table->timestamp('valid_upto')->nullable();
            $table->unsignedBigInteger('admin_id')->default(1);
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('admin_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('subject');
            $table->mediumText('message');
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('admins');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('admin_messages');
    }
}
