<?php namespace App\Classes;

use App\Classes\Common\CommonDatabaseRecord;

class Post extends CommonDatabaseRecord
{

    // 討論主題 id
    private $ixPost     = 1;

    // 討論主題發表人 id
    private $ixUser     = 1;

    // 討論主題留言者，欄位裡為array文字格式內容
    private $ixMessage  = '[]';

    // 討論主題標題
    private $sTopic     = '';

    // 討論主題喜歡者，欄位裡為array文字格式內容
    private $sLike      = '[]';

    /**
     * 資料是否有效
     * @return bool
     */
    public function isValid()
    {
    }

    /**
     * 設定討論主題 id
     * @param int $postId
     * @return void
     */
    public function setId(int $postId)
    {
        $this->ixPost = $postId;
    }

    /**
     * 取得討論主題 id
     * @return int
     */
    public function getId():int
    {
        return $this->ixPost;
    }

    /**
     * 設定討論主題發表人 id
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId)
    {
        $this->ixUser = $userId;
    }

    /**
     * 取得討論主題發表人 id
     * @return int
     */
    public function getUserId():int
    {
        return $this->ixUser;
    }

    /**
     * 設定討論主題留言者
     * @param string $messageIds
     * @return void
     */
    public function setMessageIds(string $messageIds)
    {
        $this->ixMessage = $messageIds;
    }

//    /**
//     * 取得討論主題留言者
//     * @return string
//     */
//    public function getMessageIds():string
//    {
//        return $this->ixMessage;
//    }
//
//    /**
//     * 設定討論主題留言者
//     * @param string $messageIds
//     * @return void
//     */
//    public function setMessageIds(string $messageIds)
//    {
//        $this->sTopic = $messageIds;
//    }
}
