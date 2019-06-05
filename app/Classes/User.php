<?php namespace App\Classes;

use App\Classes\Common\CommonDatabaseRecord;

class User extends CommonDatabaseRecord
{
    // 管理員id
    const SUPER_USER_ID = 1 ;

    // 頭像類型目錄
    const STICKER_TYPE_FINCH  = 1;
    const STICKER_TYPE_REESE  = 2;
    const STICKER_TYPE_LIONEL = 3;
    const STICKER_TYPE_SHAW   = 4;
    const STICKER_TYPE_ROOT   = 5;
    const STICKER_TYPE_CARTER = 6;
    protected static $stickerTypes = array(
        User::STICKER_TYPE_FINCH  => 'Finch'
      , User::STICKER_TYPE_REESE  => 'Reese'
      , User::STICKER_TYPE_LIONEL => 'Lionel'
      , User::STICKER_TYPE_SHAW   => 'Shaw'
      , User::STICKER_TYPE_ROOT   => 'Root'
      , User::STICKER_TYPE_CARTER => 'Carter');

    // 使用者id
    private $ixUser    = 0;
    // 使用者名稱
    private $sUsername = '';
    // 使用者密碼
    private $sPassword = '';
    // 使用者頭像類型
    private $nStickerType = 0;

    /**
     * 資料是否有效
     * @return bool
     */
    public function isValid()
    {
        // 若使用者名稱長度超過16或小於等於 0，表示無效資料
        if ((strlen($this->getUsername()) > 16) or
            (strlen($this->getUsername()) <= 0)) {
            return false;
        }

        // 驗證使用者頭像類型是否有效
        if ( ! $this->isValidType($this->nStickerType)) {
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
        $this->setId(data_get($content, 'ixUser'));
        $this->setUsername(data_get($content, 'sUsername'));
        $this->setStickerType(data_get($content, 'nStickerType'));
        $this->sPassword = data_get($content, 'sPassword');
    }

    /**
     * 轉為陣列
     * @return array
     */
    public  function  toArray():array
    {
        $content = parent::toArray();
        $content['ixUser'] = $this->getId();
        $content['sUsername'] = $this->getUsername();
        $content['nStickerType'] = $this->getStickerType();
        return $content;
    }

    /**
     * 設定使用者 id
     * @param int $id
     * @return void
     */
    public function setId(int $id)
    {
        $this->ixUser = $id;
    }

    /**
     * 取得使用者 id
     * @return int
     */
    public function getId():int
    {
        return $this->ixUser;
    }

    /**
     * 設定使用者名稱
     * @param string $username
     * @return void
     */
    public  function setUsername(string $username)
    {
        $this->sUsername = $username;
    }

    /**
     * 取得使用者名稱
     * @return string
     */
    public function getUsername():string
    {
        return $this->sUsername;
    }

    /**
     * 設定使用者頭像類型
     * @param int $stickerTypeId
     * @return void
     */
    public function setStickerType(int $stickerTypeId)
    {
        $this->nStickerType = $stickerTypeId;
    }

    /**
     * 取得使用者頭像類型
     * @return int
     */
    public function getStickerType():int
    {
        return $this->nStickerType;
    }

    /**
     * 加密使用者密碼
     * @param $password string
     * @return string
     */
    public static function hashPassword($password):string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    /**
     * 驗證使用者密碼
     * @param $password
     * @return bool
     */
    public function verifyPassword($password):bool
    {
        return password_verify($password, $this->sPassword);
    }

    /**
     * 驗證使用者頭像類型是否有效
     * @param int $nStickerType
     * @return bool
     */
    public static function isValidType(int $nStickerType)
    {
        return isset(static::$stickerTypes[$nStickerType]);
    }

    /**
     * 取得使用者頭像類型文字訊息
     * @param int $nStickerType
     * @return string
     */
    public static function getStickerTypeString(int $nStickerType)
    {
        if (static::isValidType($nStickerType)) {
            return static::$stickerTypes[$nStickerType];
        }
        return '';
    }

    /**
     * 是否為管理者
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->getId() === static::SUPER_USER_ID);
    }
}
