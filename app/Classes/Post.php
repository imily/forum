<?php namespace App\Classes;

use App\Classes\Common\CommonDatabaseRecord;

class Post extends CommonDatabaseRecord
{

    // 討論主題 id
    private $ixPost          = 0;

    // 討論主題發表人 id
    private $ixUser          = 0;

    // 討論主題留言者，欄位裡為json文字格式內容
    private $sMessagePerson  = '[]';

    // 討論主題標題
    private $sTopic          = '';

    // 討論主題喜歡者，欄位裡為json文字格式內容
    private $sLike           = '[]';

    private $user            = null;

    private $messages         = null;

    /**
     * 資料是否有效
     * @return bool
     */
    public function isValid()
    {
        // 討論主題發表人 id 是否小於等於 0
        if ($this->getUser() <= 0) {
            return false;
        }

        // 討論主題標題是否為空
        if ($this->getTopic() === '') {
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
        $this->setUser(data_get($content, 'ixUser'));
        $this->setMessagePerson(data_get($content, 'sMessagePerson'));
        $this->setTopic(data_get($content, 'sTopic'));
        $this->setLikes(data_get($content, 'sLike'));
    }

    /**
     * 轉為陣列
     * @return array
     */
    public function toArray()
    {
        $content = parent::toArray();
        $content['ixPost'] = $this->getId();
        $content['ixUser'] = $this->getUser();
        $content['sMessagePerson'] = $this->getMessagePerson();
        $content['sTopic'] = $this->getTopic();
        $content['sLike'] = $this-> getLikes();

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
     * 設定討論主題留言者們
     * @param string $messagePerson
     * @return void
     */
    public function setMessagePerson(string $messagePerson)
    {
        $this->sMessagePerson = $messagePerson;
    }

    /**
     * 取得討論主題留言者們
     * @return string
     */
    public function getMessagePerson():string
    {
        return $this->sMessagePerson;
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
        $this->sLike = $likes;
    }

    /**
     * 取得討論主題喜歡者們
     * @return string
     */
    public function getLikes():string
    {
        return $this->sLike;
    }

    /**
     * 設定message
     * @param array $messages
     * @return void
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * 取得message
     * @return array
     */
    public function getMessages():array
    {
        return $this->messages;
    }

    /**
     * 設定使用者
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * 取得使用者
     * @return User
     */
    public function getUser():User
    {
        return $this->user;
    }
}
