<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function(Blueprint $table){
            $table->increments('id');
            $table->integer('seqid')->nullable();
            $table->integer('category_id')->unsigned();
            $table->integer('default_job_id')->unsigned()->nullable();
            $table->string('name', 100);
            $table->text('note');
            $table->boolean('done')->default(false);
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('job_categories')
                  ->onDelete('cascade');

            $table->foreign('default_job_id')
                  ->references('id')
                  ->on('jobs_default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }
}
