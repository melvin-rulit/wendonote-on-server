<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('catalog_groups_id');
            $table->string('name');
            $table->integer('price_from');
            $table->integer('price_up_to');
            $table->text('description')->nullable();
            $table->text('youtube')->nullable();
            $table->string('photo')->nullable();
            $table->string('more_photo')->nullable();
            $table->string('tel');
            $table->string('tel_work')->nullable();
            $table->integer('position');
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
        Schema::dropIfExists('catalogs');
    }
}
