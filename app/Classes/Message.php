<?php namespace App\Classes;

use App\Classes\Common\CommonDatabaseRecord;

class Message extends CommonDatabaseRecord
{
    // 留言 id
    private $ixMessage = 1;

    // 留言者 id
    private $ixUser    = 1;

    /**
     * 資料是否有效
     * @return bool
     */
    public function isValid()
    {
        // 留言者 id 是否小於等於 0
        if ($this->getUser() <= 0) {
            return false;
        }

        return parent::isValid();
    }

    /**
     * 載入從DB取得的結果
     * @param $content
     * @return void
     */
    public function loadFromDbResult($content)
    {
        parent::loadFromDbResult($content);
        if (empty($content)) {
            return;
        }

        $this->setId(data_get($content, 'ixMessage'));
        $this->setUser(data_get($content, 'ixUser'));
    }

    /**
     * 轉為陣列
     * @return array
     */
    public function toArray()
    {
        $content = parent::toArray();
        $content['ixMessage'] = $this->getId();
        $content['ixUser'] = $this->getUser();

        return $content;
    }

    /**
     * 設定留言 id
     * @param int $messageId
     * @return void
     */
    public function setId(int $messageId)
    {
        $this->ixMessage = $messageId;
    }

    /**
     * 取得留言 id
     * @return int
     */
    public function getId():int
    {
        return $this->ixMessage;
    }

    /**
     * 設定留言者 id
     * @param int $userId
     * @return void
     */
    public function setUser(int $userId)
    {
        $this->ixUser = $userId;
    }

    /**
     * 取得留言者 id
     * @return int
     */
    public function getUser():int
    {
        return $this->ixUser;
    }
}
