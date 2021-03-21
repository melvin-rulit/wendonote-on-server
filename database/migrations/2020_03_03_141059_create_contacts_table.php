<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('name', 100);
            $table->string('contacts_cell', 100)->nullable();
            $table->string('contacts_email', 100)->nullable();
            $table->string('contacts_instagram', 100)->nullable();
            $table->string('contacts_facebook', 100)->nullable();
            $table->string('contacts_vk', 100)->nullable();
            $table->string('contacts_ok', 100)->nullable();
            $table->string('contacts_viber', 100)->nullable();
            $table->string('contacts_telegram', 100)->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
