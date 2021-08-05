<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->longText('body');
            $table->tinyInteger('vacancy')->default(1);
            $table->unsignedTinyInteger('priority')->default(0);
            $table->boolean('published')->default(false);
            $table->timestamp('published_at');
            $table->string('cover_image');
            $table->string('slug')->index();
            $table->unsignedBigInteger('admin_id')->default(1);
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('job_resumes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email_address')->unique();
            $table->string('position_applied_for');
            $table->string('last_salary_drawn');
            $table->string('expected_salary');
            $table->timestamp('joining_date');
            $table->boolean('relocate')->default(false);
            $table->string('last_organization');
            $table->mediumText('reference');
            $table->string('cover_image')->nullable();
            //$table->string('upload_resume')->default(null);
            $table->string('slug')->index();
            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('job_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('job_id')->unsigned()->index();
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->bigInteger('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_resumes');
        Schema::dropIfExists('job_tag');

    }
}
