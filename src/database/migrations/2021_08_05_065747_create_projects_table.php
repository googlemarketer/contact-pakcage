<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->string('title');
            $table->string('description');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });

        // Task::create([
        //     'title' => 'Weekend hookup',
        //     'description' => 'Call Helga in the afternoon',
        //     'completed' => false,
        // ]);

        // Task::create([
        //         'title' => 'Late night coding',
        //         'description' => 'Finishing coding POS API',
        //         'completed' => false,
        //     ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('tasks');
    }
}
