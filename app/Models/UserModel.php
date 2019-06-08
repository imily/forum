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
     * @param string $sPassword
     * @return array
     */
    public static function registerUser(User $user, string $sPassword)
    {
        // 檢查資料是否有效
        if ( ! $user->isValid()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        // 檢查欄位是否為空
        if ($sPassword === '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        // 檢查帳號是否存在
        if (static::isUsernameExist($user->getUsername())) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_USERNAME);
            return array(false, $error);
        }

        // 檢查頭像類型是否有效
        if ( ! User::isValidType($user->getStickerType())) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        $sql = sprintf("
                INSERT INTO `User`
                (`sUsername`, `sPassword`, `nStickerType`, `sDescription`)
                VALUE 
                ('%s', '%s', '%d', '%s')"
            , addslashes($user->getUsername())
            , addslashes($user->hashPassword($sPassword))
            , (int)$user->getStickerType()
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
                SELECT *
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
        $result = array(true, new Error(Error::ERROR_NONE));
        return $result;
    }

    /**
     * 修改使用者密碼
     * @param int $userId
     * @param string $password
     * @return array
     */
    public function modifyPassword(int $userId, string $password)
    {
        // 檢查欄位是否為空字串
        if ($password === '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        // 檢查使用者是否存在
        if ( ! static::isUsernameExist($userId)) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_FAILED_GET_ID);
            return array(false, $error);
        }

        $sql = sprintf("
                UPDATE `User`
                SET `sPassword` = '%s'
                WHERE `ixUser` = '%d'"
                , addslashes(user::hashPassword($password))
                , (int)$userId);

        $isUpdated = DB::update($sql);

        $result = array(false, new ErrorDB(ErrorDB::ERROR_DB_FAILED_UPDATE));
        if ($isUpdated) {
            $result = array(true, new Error(Error::ERROR_NONE));
        }

        return $result;
    }

    /**
     * 修改使用者頭像類型
     * @param int $userId
     * @param int $stickerType
     * @return array
     */
    public function modifyStickerType(int $userId, int $stickerType)
    {
        // 檢查使用者頭像類型是否有效
        if ( ! User::isValidType($stickerType)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        // 檢查使用者是否存在
        if ( ! static::isUsernameExist($userId)) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_FAILED_GET_ID);
            return array(false, $error);
        }

        $sql = sprintf("
                UPDATE `User`
                SET `nStickerType` = '%d'
                WHERE `ixUser` = '%d'"
            , (int)$stickerType
            , (int)$userId);

        $isUpdated = DB::update($sql);

        $result = array(false, new ErrorDB(ErrorDB::ERROR_DB_FAILED_UPDATE));
        if ($isUpdated) {
            $result = array(true, new Error(Error::ERROR_NONE));
        }

        return $result;
    }

    /**
     * 批量刪除使用者
     * @param array $ids
     * @return array
     */
    public function deleteUsers(array $ids)
    {
        if (count($ids) <= 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        foreach ($ids as $id) {
            if ($id <= 0) {
                $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
                return array(false, $error);
            }
            if ($id === User::SUPER_USER_ID) {
                $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNDELETABLE);
                return array(false, $error);
            }
        }

        $sql = sprintf("
                DELETE
                FROM `User`
                WHERE `ixUser` IN '%s'"
                , SafeSql::transformSqlInArrayByIds($ids));

        $isDeleted = DB::delete($sql);

        $error = new ErrorDB(ErrorDB::ERROR_DB_FAILED_DELETE);
        $result = array(false, $error->convertToDisplayArray());
        if ($isDeleted) {
            $error = new Error(Error::ERROR_NONE);
            $result = array(true, $error->convertToDisplayArray());
        }

        return $result;
    }

    /**
     * 使用者登出
     * @return void
     */
    public static function logout()
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

    /**
     * 取得當前登入的使用者
     * @return User
     */
    public static function getCurrentLoginUser()
    {
        if ( ! static::isLogin()) {
            return new User();
        }
        return static::getById(session()->get('userId'));
    }

    /**
     * 檢查使用者名稱是否存在
     * @param String $username
     * @return bool
     */
    public static function isUsernameExist(string $username)
    {
        $sql = sprintf("
            SELECT `sUsername` 
            FROM `User` 
            WHERE `sUsername` = '%s'"
            , addslashes($username));

        $result = DB::select($sql);

        return (count($result) > 0);
    }

    /**
     * 檢查該ID的使用者是否存在
     * @param Int $id
     * @return bool
     */
    public static function isExist(int $id)
    {
        if ((int)$id <= 0) {
            return false;
        }

        $sql = sprintf("
            SELECT `ixUser` 
            FROM `User` 
            WHERE `ixUser` = '%d'"
            , int($id));

        $result = DB::select($sql);

        return (count($result) > 0);
    }
}