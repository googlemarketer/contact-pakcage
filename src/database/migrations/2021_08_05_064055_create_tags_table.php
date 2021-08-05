<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('property', 100)->nullable();
            $table->string('community', 100)->nullable();
            $table->string('post', 100)->nullable();
            $table->string('article', 100)->nullable();
            $table->string('project', 100)->nullable();
            $table->string('job', 100)->nullable();
            $table->string('priority')->nullable();
            $table->unsignedBigInteger('admin_id')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('prioritylists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('priority')->default(1);
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
        Schema::dropIfExists('tags');
        Schema::dropIfExists('prioritylists');
    }
}
