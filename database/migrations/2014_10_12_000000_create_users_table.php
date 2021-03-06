<?php

use App\Classes\User;
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
            $table->string('sUsername',32);
            $table->string('sPassword', 60);
            $table->tinyInteger('nStickerType')->default(0);
            $table->string('sDescription', 255)->default('');
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
