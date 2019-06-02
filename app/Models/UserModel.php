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
        $sql = sprintf("
                SELECT * 
                FROM `User`");

        $results = DB::select($sql);
        $users = array();
        foreach ($results as $result) {
            $users[] = new User($result);
        }
        return $users;
    }

    /**
     * 註冊使用者
     * @param User $user
     * @param string $account
     * @param string $password
     * @return array
     */
    public static function registerUser(User $user, string $account, string $password)
    {
        // 檢查資料是否有效
        if ( ! $user->isValid()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        // 檢查欄位是否為空
        if (($account === '') or
            ($password === '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        // 檢查帳號是否重複
        if ($user->getUsername() == $account) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_EXISTED_USERNAME);
            return array(false, $error);
        }

        $sql = sprintf("
                INSERT INTO `User`
                (`sUsername`, `sPassword`, `nStickerType`, `sDescription`)
                VALUE 
                ('%s', '%s', '%n', '%s')"
            , addslashes($user->getUsername())
            , $user->hashPassword($password)
            , addslashes($user->getStickerType())
            , addslashes($user->getDescription()));
        $inserted = DB::INSERT($sql);

        $error = new ErrorDB(ErrorDB::ERROR_DB_FAILED_INSERT);
        $result = array(false, $error);
        if ($inserted) {
            $errorNone = new Error(Error::ERROR_NONE);
            $result = array(true, $errorNone);
        }

        return $result;
    }

    /**
     * 使用者登入
     * @param string $account
     * @param string $password
     * @return array
     */
    public static function login(string $account, string $password)
    {
        if (($account === '') or
            ($password === '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        $sql = sprintf("
                INSERT INTO `User`
                FROM `User`
                WHERE `sUsername` = '%s'
                LIMIT 1"
                , addslashes($account));

        $searchResult = DB::select($sql);

        // 判斷帳號是否正確，若資料筆數小於等於0則表示沒有該帳號
        if (count($searchResult) <= 0) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_USERNAME);
            $result = array(false, $error);
            return $result;
        }

        // 比對密碼是否正確
        $user = new User($searchResult[0]);
        if ( ! $user->verifyPassword($password)) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_PASSWORD);
            $result = array(false, $error);
            return $result;
        }

        // 紀錄Session
        session()->put('userId', $user->getId());
        $error = new Error(Error::ERROR_NONE);
        $result = array(true, $error);
        return $result;
    }

    /**
     * 使用者登出
     * @return void
     */
    public function logout()
    {
        session()->flush();
    }

    /**
     * 檢查使用者是否已登入
     * @return bool
     */
    public static function isLogin()
    {
        return session()->has('userId');
    }
}
