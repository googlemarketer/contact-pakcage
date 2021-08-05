<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->longText('body');
            $table->text('excerpt')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedTinyInteger('priority')->default(0);
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('slug')->index();
            $table->unsignedBigInteger('admin_id')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('subcategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->longText('body');
            $table->text('excerpt')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedTinyInteger('priority')->default(0);
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('admin_id')->default(1);
            $table->string('slug')->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->longText('body');
            $table->text('excerpt')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedTinyInteger('priority')->default(0);
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('admin_id')->default(1);
            $table->string('slug')->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('subservices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->longText('body');
            $table->string('cover_image')->nullable();
            $table->unsignedSmallInteger('price')->default(199);
            $table->unsignedTinyInteger('gst')->default(5);
            $table->unsignedTinyInteger('priority')->default(0);
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('admin_id')->default(1);
            $table->string('slug')->index();
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
        Schema::dropIfExists('services');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('services');
        Schema::dropIfExists('subservices');
    }
}
