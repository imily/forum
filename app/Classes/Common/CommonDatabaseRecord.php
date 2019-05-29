<?php namespace App\Classes\Common;

use stdClass;

class CommonDatabaseRecord
{
    //描述
    protected $sDescription = '';

    //建立時間
    protected $dtCreate = '0000-00-00 00:00:00';

    //更新時間
    protected $dtUpdate = '0000-00-00 00:00:00';

    /**
     * 建構子
     * CommonDatabaseRecord constructor.
     * @param array $content
     */
    public function __construct($content = array())
    {
        $this->loadFromDbResult($content);
    }

    /**
     * 載入從DB取得的結果
     * @param $content
     * @return void
     */
    public function loadFromDbResult($content)
    {
        if (empty($content)) {
            return;
        }
        $this->setDtCreate(data_get($content, 'dtCreate'));
        $this->setDtUpdate(data_get($content, 'dtUpdate'));
        $this->setDescription(data_get($content, 'sDescription'));
    }

    /**
     * 轉為陣列
     * @return array
     */
    public function toArray()
    {
        $content = array();
        $content['dtCreate'] = $this->getDtCreate();
        $content['dtUpdate'] = $this->getDtUpdate();
        $content['sDescription'] = $this->getDescription();
        return $content;
    }

    /**
     * 資料是否有效
     * @return bool
     */
    public function isValid()
    {
        //驗證dtCreate日期格式
        if ( ! VerifyFormat::isValidDateTime($this->dtCreate)) {
            return false;
        }

        //驗證dtUpdate日期格式
        if ( ! VerifyFormat::isValidDateTime($this->dtUpdate)){
            return false;
        }

        return true;
    }

    /**
     * 設定描述
     * @param string $sDescription
     * @return void
     */
    public function setDescription(string $sDescription)
    {
        $this->sDescription = $sDescription;
    }

    /**
     * 取得描述
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->sDescription;
    }

    /**
     * 設定建立日期
     * @param string $dtCreate
     * @return void
     */
    public function setDtCreate(string $dtCreate)
    {
        $this->dtCreate = $dtCreate;
    }

    /**
     * 取得建立日期
     * @return string
     */
    public function getDtCreate()
    {
        return (string)$this->dtCreate;
    }


    /**
     * 設定更新日期
     * @param string $dtUpdate
     * @return void
     */
    public function setDtUpdate(string $dtUpdate)
    {
        $this->dtUpdate = $dtUpdate;
    }

    /**
     * 取得更新日期
     * @return string
     */
    public function getDtUpdate()
    {
        return (string)$this->dtUpdate;
    }
}
