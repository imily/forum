<?php namespace Tests;

use App\Classes\Common\CommonDatabaseRecord;

class CommonDatabaseRecordTest extends TestCase
{
    private $content = array();

    /**
     * 測試前設定
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        //設定一組預設有效array資料
        $this->content = array();
        $this->content['sDescription'] = '描述';
        $this->content['dtCreate']     = '2015-01-01 01:01:01';
        $this->content['dtUpdate']     = '2015-01-01 01:02:01';
    }

    /**
     * 測試載入Array
     * 1. 測試各method輸出
     * 2. 測試toArray輸出。
     * @return void
     */
    public function testLoadFromDbResultByArray()
    {
        $content = $this->content;
        $commonDatabaseRecord = new CommonDatabaseRecord();
        $commonDatabaseRecord->loadFromDbResult($content);

        $this->assertEquals($content, $commonDatabaseRecord->toArray());

        $this->assertEquals($content['sDescription'], $commonDatabaseRecord->getDescription());
        $this->assertEquals($content['dtCreate']    , $commonDatabaseRecord->getDtCreate());
        $this->assertEquals($content['dtUpdate']    , $commonDatabaseRecord->getDtUpdate());
    }
}
