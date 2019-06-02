<?php

use App\Classes\User;
use Illuminate\Database\Migrations\Migration;

class UserTableAddAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $username = 'admin';
        $password = 'messagepassword';
        $passwordHash = User::hashPassword($password);
        DB::table('User')->insert(
            array(
                'ixUser' => 1
                , 'sUsername' => $username
                , 'sPassword' => $passwordHash
                , 'nStickerType' => 1
                , 'fAdmin' => true
                , 'sDescription' => '管理員'
                , 'dtCreate' => '2019-05-21 23:00:00'
                , 'dtUpdate' => '2019-05-21 23:00:00'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM `User` WHERE `ixUser` = '1'");
    }
}
