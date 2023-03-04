<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('num_boscoins')->nullable();
            $table->string('description');
            $table->bigInteger('cicle_id')->unsigned()->nullable();
            $table->foreign('cicle_id')->references('id')->on('cicles');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->float('grade')->nullable();
            $table->string('imagen')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('comment')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_phone')->nullable();
            $table->unsignedTinyInteger('client_rating')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
