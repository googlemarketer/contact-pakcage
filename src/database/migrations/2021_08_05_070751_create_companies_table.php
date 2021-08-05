<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->longText('body');
            $table->text('excerpt')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('phone');
            $table->string('ccnumber');
            $table->string('ccemail');
            $table->string('web');
            $table->string('logo');
            $table->unsignedBigInteger('associate_id');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('company_service_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_service_user');
    }
}
