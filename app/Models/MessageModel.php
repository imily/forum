<?php

namespace App\Models;

use App\Classes\Common\SafeSql;
use App\Classes\Common\VerifyFormat;
use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\Errors\ErrorDB;
use App\Repositories\Filter;
use Illuminate\Support\Facades\DB;
use App\Classes\Message;

class MessageModel
{
    /**
     * 取得所有留言清單
     * @return array
     */
    public static function getAllList()
    {
        $sql = sprintf(
            'SELECT * 
                    FROM `Message`');

        $results = DB::SELECT($sql);

        $messages= array();
        foreach ($results as $result) {
            $message = new Message();
            $message->loadFromDbResult($result);
            $message->setUser(UserModel::getById($message->getIxUser()));
            $messages[] = $message;
        }
        return $messages;
    }

    /**
     * 依範圍取得所有留言清單
     * @param Filter $filter
     * @return array
     */
    public static function getList(Filter $filter)
    {
        $sql = sprintf("
                SELECT * 
                FROM `Message`
                LIMIT %d, %d"
            , (int)$filter->getOffset()
            , (int)$filter->getLimit());

        $results = DB::select($sql);
        $messages = array();
        foreach ($results as $result) {
            $message = new Message($result);
            $message->setUser(UserModel::getById($message->getIxUser()));
            $messages[] = $message;
        }
        return $messages;
    }

    /**
     * 依照ids取得資料
     * @param array $ids
     * @return Message[]
     */
    public static function getByIds(array $ids)
    {
        if ((empty($ids)) or
            ( ! VerifyFormat::isValidIds($ids))) {
            return array();
        }
        $sql = sprintf("
                SELECT * 
                FROM `Message`
                WHERE `ixMessage` 
                IN (%s)"
            , SafeSql::transformSqlInArrayByIds($ids));

        $results = DB::SELECT($sql);
        $messages = array();
        foreach ($results as $result) {
            $message = new Message($result);
            $message->setUser(UserModel::getById($message->getIxUser()));
            $messages[] = $message;
        }
        return $messages;
    }

    /**
     * 依id取得單一留言資料
     * @param int $id
     * @return Message
     */
    public static function getById(int $id)
    {
        if ($id <= 0) {
            return new Message();
        }

        $sql = sprintf("
                SELECT *
                FROM `Message`
                WHERE `ixMessage` = '%d'
                LIMIT 1"
            , (int)$id);

        $result = DB::SELECT($sql);

        $message = new Message();
        if (count($result) > 0) {
            $message->loadFromDbResult($result[0]);
            $message->setUser(UserModel::getById($message->getIxUser()));
        }
        return $message;
    }

    /**
     * 驗證messageId是否存在
     * @param int $id
     * @return bool
     */
    public static function isExist(int $id)
    {
        if ($id <= 0){
            return false;
        }
        $sql = sprintf("
                SELECT `ixMessage`
                FROM `Message`
                WHERE `ixMessage` = '%d'
                LIMIT 1"
            , (int)$id);

        $result = DB::SELECT($sql);
        return (count($result) > 0);
    }

    /**
     * 新增單一留言
     * @param Message $message
     * @return array
     */
    public static function add(Message $message)
    {
        // 檢查資料是否有效
        if ( ! $message->isValid()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        // 檢查欄位是否為空
        if ($message->getDescription() === '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        // 檢查是否為當前使用者
        if ($message->getIxUser() !== UserModel::getCurrentLoginUser()) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
            return array(false, $error);
        }

        $sql = sprintf("
            INSERT INTO `Message`
            (`ixUser`, `sDescription`)
            VALUES ('%d', '%s')"
            , (int)$message->getIxUser()
            , addslashes($message->getDescription()));

        $isInsert = DB::insert($sql);

        $error = new ErrorDB(ErrorDB::ERROR_DB_FAILED_INSERT);
        $result = array(false, $error);
        if ($isInsert) {
            $error = new Error(Error::ERROR_NONE);
            $result = array(true, $error);
        }

        return $result;
    }

    /**
     * 修改單一留言內容
     * @param int $messageId
     * @param string $description
     * @return array
     */
    public static function modifyDescription(int $messageId, string $description)
    {
        // 檢查欄位是否為空
        if ($description === '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        // 檢查此留言 id 是否存在
        if (static::isExist($messageId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
            return array(false, $error);
        }

        $sql = sprintf("
                UPDATE `Message`
                SET `sDescription` = '%s'
                WHERE `ixMessage` = '%d'"
            , addslashes($description)
            , (int)$messageId);

        $isUpdated = DB::update($sql);

        $result = array(false, new ErrorDB(ErrorDB::ERROR_DB_FAILED_UPDATE));
        if ($isUpdated) {
            $result = array(true, new Error(Error::ERROR_NONE));
        }

        return $result;
    }
}
