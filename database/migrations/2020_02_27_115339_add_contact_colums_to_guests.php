<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactColumsToGuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guests', function($table){
            $table->string('contacts_viber', 100)->nullable();
            $table->string('contacts_telegram', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guests', function($table){
            $table->dropColumn('contacts_viber');
            $table->dropColumn('contacts_telegram');
        });
    }
}
