<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User', function (Blueprint $table) {
            $table->increments('ixUser');
            $table->string('sUsername',32)->default('');
            $table->string('sPassword', 60)->default('');
            $table->integer('nStickerType')->default(1);
            $table->boolean('fAdmin')->default(false);
            $table->dateTime('dtCreate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('dtUpdate')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('User');
    }
}
