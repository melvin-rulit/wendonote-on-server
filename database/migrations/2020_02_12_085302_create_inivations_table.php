<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inivations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');     // К какому пользователю привязано приглашение
            $table->string('name');         // Имя приглашения
            $table->string('text');         // Текст приглашения
            $table->integer('background');  // Фон приглашения
            $table->integer('send');        // Отправлено ли приглашени (по дефолту нет - 0)
            $table->integer('status');      // Статус, отмечено ли прилашеными что они прийдут (по дефолту нет - 0)
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
        Schema::dropIfExists('inivations');
    }
}
