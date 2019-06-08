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
     * @return array
     */
    public static function getAllList()
    {
        $sql = sprintf("
                SELECT * 
                FROM `Post`");

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
     * @param Post $post
     * @return array
     */
    public static function add(Post $post)
    {
        if ($post->isValid()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        $sql = sprintf("
                INSERT INTO `Post`
                (`ixUser`, `sTopic`, `sDescription`)
                VALUE 
                ('%d', '%s', '%s')"
            , addslashes($post->getUser())
            , addslashes($post->getTopic())
            , addslashes($post->getDescription()));

        $inserted = DB::INSERT($sql);

        $error = new ErrorDB(ErrorDB::ERROR_DB_FAILED_INSERT);
        $result = array(false, $error);
        if ($inserted) {
            $errorNone = new Error(Error::ERROR_NONE);
            $result = array(true, $errorNone);
        }

        return $result;
    }
}
