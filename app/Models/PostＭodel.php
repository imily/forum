<?php

namespace App\Models;

use App\Classes\Common\SafeSql;
use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\Errors\ErrorDB;
use App\Repositories\Filter;
use Illuminate\Support\Facades\DB;
use App\Classes\Post;

class PostＭodel
{
    /**
     * 取得所有討論主題清單
     * @param Filter $filter
     * @return array
     */
    public static function getAllList(Filter $filter)
    {
        $sql = sprintf("
                SELECT * 
                FROM `Post`
                LIMIT %d, %d"
            , (int)$filter->getOffset()
            , (int)$filter->getLimit());

        $results = DB::SELECT($sql);
        $posts = array();
        foreach ($results as $result) {
            $posts[] = new Post($result);
        }
        return $posts;
    }

    /**
     * 依id取得討論主題資料
     * @param int $id
     * @return Post
     */
    public static function getById(int $id)
    {
        if ((int)$id <= 0) {
            return new Post();
        }

        $sql = sprintf("
                SELECT * 
                FROM `Post` 
                WHERE `ixPost` = '%d' 
                LIMIT 1"
            , (int)$id);

        $result = DB::SELECT($sql);

        if (count($result) > 0) {
            return new Post($result[0]);
        }

        return new Post();
    }

    /**
     * 依指定user id取得所有討論主題資料
     * @param Filter $filter
     * @param int $userId
     * @return array
     */
    public static function getByUserId(Filter $filter,  int $userId)
    {
        if ((int)$userId <= 0) {
            return [];
        }

        $sql = sprintf("
                SELECT * 
                FROM `Post` 
                WHERE `ixUser` = '%d'
                LIMIT %d, %d"
            , (int)$userId
            , (int)$filter->getOffset()
            , (int)$filter->getLimit());

        $results = DB::SELECT($sql);

        $posts = array();
        foreach ($results as $result) {
            $posts[] = new Post($result);
        }

        return $posts;
    }

    /**
     * 驗證id是否存在
     * @param int $id
     * @return bool
     */
    public static function isExist(int $id)
    {
        if ($id <= 0) {
            return false;
        }

        $sql = sprintf("
                SELECT `ixPost` 
                FROM `Post` 
                WHERE `ixPost` = '%d' 
                LIMIT 1"
            , (int)$id);

        $result = DB::SELECT($sql);

        return (count($result) > 0);
    }

    /**
     * 新增討論主題
     * @param int $userId
     * @param string $topic
     * @param string $description
     * @return array
     */
    public static function add(int $userId, string $topic, string $description)
    {
        // 檢查欄位是否為空
        if (($topic === '') or
            ($description === '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        $sql = sprintf("
                INSERT INTO `Post`
                (`ixUser`, `sTopic`, `sDescription`)
                VALUE 
                ('%d', '%s', '%s')"
            , (int)$userId
            , addslashes($topic)
            , addslashes($description));

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
     * 修改單一討論主題標題
     * @param int $postId
     * @param string $topic
     * @return array
     */
    public static function modifyPostTopic(int $postId, string $topic)
    {
        // 檢查欄位是否為空
        if ($topic === '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        // 檢查此留言 id 是否存在
        if (static::isExist($postId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
            return array(false, $error);
        }

        $sql = sprintf("
                UPDATE `Post`
                SET `sTopic` = '%s'
                WHERE `ixPost` = '%d'"
            , addslashes($topic)
            , (int)$postId);

        $isUpdated = DB::update($sql);

        $result = array(false, new ErrorDB(ErrorDB::ERROR_DB_FAILED_UPDATE));
        if ($isUpdated) {
            $result = array(true, new Error(Error::ERROR_NONE));
        }

        return $result;
    }

    /**
     * 修改單一討論主題內容
     * @param int $postId
     * @param string $description
     * @return array
     */
    public static function modifyPostDescription(int $postId, string $description)
    {
        // 檢查欄位是否為空
        if ($description === '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            return array(false, $error);
        }

        // 檢查此留言 id 是否存在
        if (static::isExist($postId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
            return array(false, $error);
        }

        $sql = sprintf("
                UPDATE `Post`
                SET `sDescription` = '%s'
                WHERE `ixPost` = '%d'"
            , addslashes($description)
            , (int)$postId);

        $isUpdated = DB::update($sql);

        $result = array(false, new ErrorDB(ErrorDB::ERROR_DB_FAILED_UPDATE));
        if ($isUpdated) {
            $result = array(true, new Error(Error::ERROR_NONE));
        }

        return $result;
    }

    /**
     * 批量刪除討論主題
     * @param array $ids
     * @return array
     */
    public static function deletePosts(array $ids)
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
        }

        $sql = sprintf("
                DELETE
                FROM `Post`
                WHERE `ixPost` IN '%s'"
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
}
