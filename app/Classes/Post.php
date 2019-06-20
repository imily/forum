<?php namespace App\Classes;

use App\Classes\Common\CommonDatabaseRecord;

class Post extends CommonDatabaseRecord
{

    // 討論主題 id
    private $ixPost      = 0;

    // 討論主題發表人 id
    private $ixUser      = 0;

    // 討論主題的留言，欄位裡為json文字格式內容
    private $sMessages   = '[]';

    // 討論主題標題
    private $sTopic      = '';

    // 討論主題的喜歡者們，欄位裡為json文字格式內容
    private $sLikes      = '[]';

    private $user        = null;

    private $message     = null;

    /**
     * 建構子
     * CommonDatabaseRecord constructor.
     * @param array $content
     */
    public function __construct($content = array())
    {
        parent::__construct($content);
        $this->setUser(array());
        $this->setMessage(array());
    }

    /**
     * 資料是否有效
     * @return bool
     */
    public function isValid()
    {
        // 討論主題發表人 id 是否小於等於 0
        if ($this->getIxUser() <= 0) {
            return false;
        }

        // 討論主題標題是否為空
        if ($this->getTopic() === '') {
            return false;
        }

        // 討論主題內容是否為空
        if ($this->getDescription() === '') {
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

        $this->setId(data_get($content, 'ixPost'));
        $this->setIxUser(data_get($content, 'ixUser'));
        $this->setMessages(data_get($content, 'sMessages'));
        $this->setTopic(data_get($content, 'sTopic'));
        $this->setLikes(data_get($content, 'sLikes'));
    }

    /**
     * 轉為陣列
     * @return array
     */
    public function toArray()
    {
        $content = parent::toArray();
        $content['ixPost'] = $this->getId();
        $content['ixUser'] = $this->getIxUser();
        $content['sMessages'] = $this->getMessages();
        $content['sTopic'] = $this->getTopic();
        $content['sLikes'] = $this-> getLikes();

        return $content;
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
    public function setIxUser(int $userId)
    {
        $this->ixUser = $userId;
    }

    /**
     * 取得討論主題發表人 id
     * @return int
     */
    public function getIxUser():int
    {
        return $this->ixUser;
    }

    /**
     * 設定討論主題的留言
     * @param string $messages
     * @return void
     */
    public function setMessages(string $messages)
    {
        $this->sMessages = $messages;
    }

    /**
     * 取得討論主題的留言
     * @return string
     */
    public function getMessages():string
    {
        return $this->sMessages;
    }

    /**
     * 設定討論主題標題
     * @param string $topic
     * @return void
     */
    public function setTopic(string $topic)
    {
        $this->sTopic = $topic;
    }

    /**
     * 取得討論主題標題
     * @return string
     */
    public function getTopic():string
    {
        return $this->sTopic;
    }

    /**
     * 設定討論主題喜歡者們
     * @param string $likes
     * @return void
     */
    public function setLikes(string $likes)
    {
        $this->sLikes = $likes;
    }

    /**
     * 取得討論主題喜歡者們
     * @return string
     */
    public function getLikes():string
    {
        return $this->sLikes;
    }

    /**
     * 設定message
     * @param array $message
     * @return void
     */
    public function setMessage(array $message)
    {
        $this->message = $message;
    }

    /**
     * 取得message
     * @return array
     */
    public function getMessage():array
    {
        return $this->message;
    }

    /**
     * 設定User
     * @param array $user
     * @return void
     */
    public function setUser(array $user)
    {
        $this->user = $user;
    }

    /**
     * 取得User
     * @return array
     */
    public function getUser():array
    {
        return $this->user;
    }
}
