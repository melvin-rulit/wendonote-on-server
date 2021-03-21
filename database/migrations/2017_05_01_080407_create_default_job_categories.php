<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultJobCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_categories_default', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 100);
            $table->string('color', 20);
        });

       Artisan::call('db:seed', [
            '--class' => DefaultJobCategoriesSeeder::class,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_categories_default');
    }
}
