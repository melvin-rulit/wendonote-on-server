<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs_default', function(Blueprint $table){
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('name', 100);
            $table->string('link_name', 100)->default('');
            $table->string('link_href', 150)->default('#');

            $table->foreign('category_id')
                  ->references('id')
                  ->on('job_categories_default')
                  ->onDelete('cascade');
        });

        Artisan::call('db:seed', [
            '--class' => DefaultJobsSeeder::class,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs_default');
    }
}
