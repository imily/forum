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

class PostModel
{
    /**
     * 取得所有討論主題清單
     * @return array
     */
    public static function getAllList()
    {
        $sql = sprintf(
            'SELECT * 
                    FROM `Post`');

        $results = DB::SELECT($sql);

        $posts = array();
        foreach ($results as $result) {
            $post = new Post();
            $post->loadFromDbResult($result);
            $post->setMessage(MessageModel::getByIds(json_decode($post->getMessages())));
            $post->setUser(UserModel::getByIds(json_decode($post->getLikes())));
            $post->setUserObject(UserModel::getById($post->getIxUser()));
            $posts[] = $post;
        }
        return $posts;
    }

    /**
     * 取得部分討論主題清單
     * @param Filter $postFilter
     * @param Filter $messageFilter
     * @return array
     */
    public static function getList(Filter $postFilter, Filter $messageFilter)
    {
        $sql = sprintf("
                SELECT * 
                FROM `Post`
                LIMIT %d, %d"
            , (int)$postFilter->getOffset()
            , (int)$postFilter->getLimit());

        $results = DB::SELECT($sql);
        $posts = array();
        foreach ($results as $result) {
            $post = new Post();
            $post->loadFromDbResult($result);
            $post->setMessage(MessageModel::getByIdsByFilter(json_decode($post->getMessages()), $messageFilter));
            $post->setUser(UserModel::getByIds(json_decode($post->getLikes())));
            $post->setUserObject(UserModel::getById($post->getIxUser()));
            $posts[] = $post;
        }
        return $posts;
    }

    /**
     * 依id取得全部討論主題資料
     * @param int $id
     * @param Filter $messageFilter
     * @return Post
     */
    public static function getById(int $id, Filter $messageFilter)
    {
        if ($id <= 0) {
            return new Post();
        }

        $sql = sprintf("
                SELECT * 
                FROM `Post` 
                WHERE `ixPost` = '%d' 
                LIMIT 1"
            , (int)$id);

        $result = DB::SELECT($sql);

        $post = new Post();
        if (count($result) > 0) {
            $post->loadFromDbResult($result[0]);
            $post->setMessage(MessageModel::getByIdsByFilter(json_decode($post->getMessages()), $messageFilter));
            $post->setUser(UserModel::getByIds(json_decode($post->getLikes())));
            $post->setUserObject(UserModel::getById($post->getIxUser()));
        }
        return $post;
    }

    /**
     * 依指定user id 取得全部討論主題資料
     * @param Filter $messageFilter
     * @param int $userId
     * @return array
     */
    public static function getByUserId(Filter $messageFilter, int $userId)
    {
        if ((int)$userId <= 0) {
            return [];
        }

        $sql = sprintf("
                SELECT * 
                FROM `Post` 
                WHERE `ixUser` = '%d'"
            , (int)$userId);

        $results = DB::SELECT($sql);
        $posts = array();
        foreach ($results as $result) {
            $post = new Post();
            $post->loadFromDbResult($result);
            $post->setMessage(MessageModel::getByIdsByFilter(json_decode($post->getMessages()), $messageFilter));
            $post->setUser(UserModel::getByIds(json_decode($post->getLikes())));
            $post->setUserObject(UserModel::getById($post->getIxUser()));
            $posts[] = $post;
        }
        return $posts;
    }

    /**
     * 依指定user id 取得部分討論主題資料
     * @param Filter $postFilter
     * @param Filter $messageFilter
     * @param int $userId
     * @return array
     */
    public static function getByUserIdForFilter(Filter $postFilter, Filter $messageFilter, int $userId)
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
            , (int)$postFilter->getOffset()
            , (int)$postFilter->getLimit());

        $results = DB::SELECT($sql);
        $posts = array();
        foreach ($results as $result) {
            $post = new Post();
            $post->loadFromDbResult($result);
            $post->setMessage(MessageModel::getByIdsByFilter(json_decode($post->getMessages()), $messageFilter));
            $post->setUser(UserModel::getByIds(json_decode($post->getLikes())));
            $post->setUserObject(UserModel::getById($post->getIxUser()));
            $posts[] = $post;
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
        // 檢查資料是否有效
        if ( ! $post->isValid()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        // 檢查使用者是否為當前使用者
        if ($post->getIxUser() !== UserModel::getCurrentLoginUser()->getId()) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
            return array(false, $error);
        }

        $sql = sprintf("
                INSERT INTO `Post`
                (`ixUser`, `sTopic`, `sDescription`)
                VALUE 
                ('%d', '%s', '%s')"
            , (int)$post->getIxUser()
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

    /**
     * 修改單一討論主題
     * @param Post $post
     * @return array
     */
    public static function modify(Post $post)
    {
        // 檢查資料是否有效
        if ( ! $post->isValid()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        // 檢查此留言 id 是否存在
        if ( ! static::isExist($post->getId())) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
            return array(false, $error);
        }

        // 檢查使用者是否為當前使用者
        if ($post->getIxUser() !== UserModel::getCurrentLoginUser()->getId()) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
            return array(false, $error);
        }

        $sql = sprintf("
                UPDATE `Post`
                SET `sTopic` = '%s' ,
                    `sDescription` = '%s'
                WHERE `ixPost` = '%d'"
            , addslashes($post->getTopic())
            , addslashes($post->getDescription())
            , (int)$post->getId());

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
    public static function delete(array $ids)
    {
        // 檢查 ids 是否存在
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
                WHERE `ixPost` IN (%s)"
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
     * 更新喜歡單一討論主題
     * @param $ixPost int
     * @param $userId int
     * @return array
     */
    public static function updateLikes($ixPost, $userId)
    {
        // 檢查此留言 id 是否存在
        if ( ! static::isExist($ixPost)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            return array(false, $error);
        }

        // 檢查使用者是否為當前使用者
        if ($userId !== UserModel::getCurrentLoginUser()->getId()) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
            return array(false, $error);
        }

        // 取得目前的喜歡人數
        $messageFilter = new Filter();
        $post = PostModel::getById($ixPost, $messageFilter);
        $likes = json_decode($post->getLikes());

        // 確認目前的使用者是否已存在喜歡的清單中
        $hasKey = array_search($userId, $likes);

        // 若已存在，移除清單中的使用者
        if ($hasKey > 0) {
            unset($likes[$hasKey]);
        }

        // 若不存在，新增使用者至清單
        if ($hasKey === false) {
            array_push($likes, $userId);
        }

        $newLikes = json_encode(array_values($likes));

        $sql = sprintf("
                UPDATE `Post`
                SET `sLikes` = '%s'
                WHERE `ixPost` = '%d'"
            , addslashes($newLikes)
            , (int)$post->getId());

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
