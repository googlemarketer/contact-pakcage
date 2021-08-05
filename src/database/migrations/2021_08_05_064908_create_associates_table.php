<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile')->unique();
            $table->string('subcategory_id');
            $table->unsignedTinyInteger('active')->default(1);
            $table->string('password');
            $table->string('slug')->index();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('associate_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->mediumText('body');
            $table->text('excerpt')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('phone');
            $table->string('ccnumber');
            $table->string('ccemail');
            $table->string('web');
            $table->string('logo');
            $table->string('slug')->index();
            $table->unsignedBigInteger('associate_id');
            $table->foreign('associate_id')->references('id')->on('associates')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('associate_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_id');
            $table->string('subservice_id');
            $table->string('price');
            $table->unsignedTinyInteger('priority')->default(1);
            $table->unsignedBigInteger('associate_id');
            $table->foreign('associate_id')->references('id')->on('associates')->onDelete('cascade');
            $table->timestamps();
        });

        // Schema::create('associate_customers', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('title');
        //     $table->string('email');
        //     $table->string('mobile');
        //     $table->unsignedTinyInteger('active')->default(1);
        //     $table->unsignedBigInteger('customer_id');
        //     $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        //     $table->unsignedBigInteger('associate_id');
        //     $table->foreign('associate_id')->references('id')->on('associates')->onDelete('cascade');
        //     $table->timestamps();
        // });

        Schema::create('associate_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('review')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('associate_id');
            $table->foreign('associate_id')->references('id')->on('associates')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('associate_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('subject');
            $table->mediumText('message');
            $table->unsignedBigInteger('associate_id');
            $table->foreign('associate_id')->references('id')->on('associates')->onDelete('cascade');
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
        Schema::dropIfExists('associates');
        Schema::dropIfExists('associate_profiles');
        Schema::dropIfExists('associate_services');
        Schema::dropIfExists('associate_customers');
        Schema::dropIfExists('associate_reviews');
        Schema::dropIfExists('associate_messages');
    }
}
