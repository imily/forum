<?php

namespace App\Models;

use App\Classes\Common\SafeSql;
use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\Errors\ErrorDB;
use Illuminate\Support\Facades\DB;
use App\Classes\User;

class UserModel
{
    /**
     * 依id取得使用者資料
     * @param int $id
     * @return User
     */
    public static function getById(int $id)
    {
        if ((int)$id <= 0) {
            return new User();
        }

        $sql = sprintf("
                SELECT * 
                FROM `User` 
                WHERE `ixUser` = '%d' 
                LIMIT 1"
                , (int)$id);

        $result = DB::SELECT($sql);
        if (count($result) > 0) {
            return new User($result[0]);
        }
        return new User();
    }

    /**
     * 依名稱取得使用者資料
     * @param string $username
     * @return User
     */
    public static function getByName(string $username)
    {
        if ($username === '') {
            return new User();
        }

        $sql = sprintf("
                SELECT * 
                FROM `User` 
                WHERE `sUsername` = '%s' 
                LIMIT 1"
            , addslashes($username));

        $result = DB::SELECT($sql);
        if (count($result) > 0) {
            return new User($result[0]);
        }
        return new User();
    }

    /**
     * 取得所有使用者清單
     * @return array
     */
    public static function getAllList()
    {
        $results = DB::select('SELECT * FROM `User`');
        $users = array();
        foreach ($results as $result) {
            $user = new User();
            $user->loadFromDbResult($result);
            $users[] = $user;
        }
        return $users;
    }
}
