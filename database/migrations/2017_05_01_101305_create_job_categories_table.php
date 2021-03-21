<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_categories', function(Blueprint $table){
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('name', 100);
            $table->string('color', 20);
            $table->timestamps();

            $table->foreign('event_id')
                    ->references('id')
                    ->on('events')
                    ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_categories');
    }
}
