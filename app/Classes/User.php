<?php namespace App\Classes;

use App\Classes\Common\CommonDatabaseRecord;

class User extends CommonDatabaseRecord
{
    const SUPER_USER_ID = 1 ;

    private $ixUser    = 0;
    private $sUsername = '';
    private $sPassword = '';

    /**
     * 加密使用者密碼
     * @param $password string
     * @return string
     */
    public static function hashPassword($password):string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }
}
