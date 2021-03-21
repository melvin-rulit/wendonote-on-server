<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactsColumnsToGuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guests', function($table){
            $table->string('contacts_cell', 100)->nullable();
            $table->string('contacts_email', 100)->nullable();
            $table->string('contacts_instagram', 100)->nullable();
            $table->string('contacts_facebook', 100)->nullable();
            $table->string('contacts_vk', 100)->nullable();
            $table->string('contacts_ok', 100)->nullable();
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
            $table->dropColumn('contacts_cell');
            $table->dropColumn('contacts_email');
            $table->dropColumn('contacts_instagram');
            $table->dropColumn('contacts_facebook');
            $table->dropColumn('contacts_vk');
            $table->dropColumn('contacts_ok');
        });
    }
}
