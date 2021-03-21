<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');    // К какой группе привязано блюдо
            $table->string('name');         // Имя блюда
            $table->integer('kolvo');        // Количество
            $table->integer('weight');      // Вес блюда
            $table->integer('price');       // Цена за блюдо
            $table->integer('summ');        // Сумма блюда
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
        Schema::dropIfExists('menus');
    }
}
