<?php

namespace App\Models;

use App\Classes\Common\SafeSql;
use App\Classes\Common\VerifyFormat;
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
        if ($id <= 0) {
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
     * 依照ids取得所有資料
     * @param array $ids
     * @return User[]
     */
    public static function getByIds(array $ids)
    {
        if ((empty($ids)) or
            ( ! VerifyFormat::isValidIds($ids))) {
            return array();
        }
        $sql = sprintf("
                SELECT * 
                FROM `User`
                WHERE `ixUser` 
                IN (%s)"
            , SafeSql::transformSqlInArrayByIds($ids));

        $results = DB::SELECT($sql);
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
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_EXISTED_USERNAME);
            return array(false, $error);
        }

        // 檢查頭像類型是否有效
        if ( ! User::isValidType($user->getStickerType())) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_STICKER_TYPE);
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
            $userId = DB::getPdo()->lastInsertId();
            $user->setId($userId);
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

        $user = static::getByName($account);

        // 判斷帳號是否正確，若資料筆數等於0則表示沒有該帳號
        if ($user->getId() === 0) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_USERNAME);
            return array(false, $error);
        }

        // 比對密碼是否正確
        if ( ! $user->verifyPassword($password)) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_PASSWORD);
            return array(false, $error);
        }

        // 紀錄Session
        session()->put('userId', $user->getId());
        $result = array(true, new Error(Error::ERROR_NONE));
        return $result;
    }

    /**
     * 修改使用者資訊
     * @param User $user
     * @param string $password
     * @return array
     */
    public static function modify(User $user, string $password)
    {
        // 檢查使用者是否存在
        if ( ! static::isExist($user->getId())) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
            return array(false, $error);
        }

        // 檢查資料是否有效
        if ( ! $user->isValid()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        // 檢查欄位是否為空字串
        if ($password === '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        // 檢查使用者頭像類型是否有效
        if ( ! User::isValidType($user->getStickerType())) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_STICKER_TYPE);
            return array(false, $error);
        }

        $originalUser = UserModel::getById($user->getId());

        // 修改的資料與原本資料相同則無須修改
        if (($user->getStickerType() == $originalUser->getStickerType()) and
            ($user->verifyPassword($password))) {
            return array(true, new Error(Error::ERROR_NONE));
        }

        $sql = sprintf("
                UPDATE `User`
                SET `nStickerType` = '%d',
                    `sPassword` = '%s'
                WHERE `ixUser` = '%d'"
            , (int)$user->getStickerType()
            , addslashes(user::hashPassword($password))
            , (int)$user->getId());

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
    public static function deleteUsers(array $ids)
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
            WHERE `ixUser` IN (%s)"
            , SafeSql::transformSqlInArrayByIds($ids));

        $isDeleted = DB::delete($sql);

        $error = new ErrorDB(ErrorDB::ERROR_DB_FAILED_DELETE);
        $result = array(false, $error);
        if ($isDeleted) {
            $error = new Error(Error::ERROR_NONE);
            $result = array(true, $error);
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
        if ($id <= 0) {
            return false;
        }

        $sql = sprintf("
            SELECT `ixUser` 
            FROM `User` 
            WHERE `ixUser` = '%d'"
            , (int)$id);

        $result = DB::select($sql);

        return (count($result) > 0);
    }
}
