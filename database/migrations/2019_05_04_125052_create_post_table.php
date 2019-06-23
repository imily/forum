<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Post', function (Blueprint $table) {
            $table->bigIncrements('ixPost');
            $table->integer('ixUser');
            $table->string('sMessages')->default('');
            $table->string('sTopic',255);
            $table->string('sDescription',255);
            $table->string('sLikes')->default('');
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
        Schema::dropIfExists('Post');
    }
}
