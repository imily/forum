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

    /**
     * 測試載入object
     * 1. 測試各method輸出
     * 2. 測試toArray輸出。
     * @return void
     */
    public function testLoadFromDbResultByObject()
    {
        $content = $this->content;
        $commonDatabaseRecord = new CommonDatabaseRecord();
        //將array轉object後輸入
        $commonDatabaseRecord->loadFromDbResult((object)$content);

        $this->assertEquals($content, $commonDatabaseRecord->toArray());

        $this->assertEquals($content['sDescription'], $commonDatabaseRecord->getDescription());
        $this->assertEquals($content['dtCreate']    , $commonDatabaseRecord->getDtCreate());
        $this->assertEquals($content['dtUpdate']    , $commonDatabaseRecord->getDtUpdate());
    }

    /**
     * 測試物件中是否有無效資料
     * @return void
     */
    public function testIsValidByDtCreate()
    {
        $content = $this->content;

        $commonDatabaseRecord = new CommonDatabaseRecord();
        //先驗證目前資料有效
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());

        //輸入無效資料並驗證，驗證後復原有效資料。
        $commonDatabaseRecord->setDtCreate('2011-11-11 00:00:00 錯誤日期格式');
        $this->assertFalse($commonDatabaseRecord->isValid());
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());

        //輸入無效資料並驗證，驗證後復原有效資料。
        $commonDatabaseRecord->setDtCreate('2011-11-11 00:00');
        $this->assertFalse($commonDatabaseRecord->isValid());
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());

        //輸入無效資料並驗證，驗證後復原有效資料。
        $commonDatabaseRecord->setDtCreate('2011-11-1100:00:00');
        $this->assertFalse($commonDatabaseRecord->isValid());
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());

        //輸入無效資料並驗證，驗證後復原有效資料。
        $commonDatabaseRecord->setDtCreate('2011-11-11 0G:00:00');
        $this->assertFalse($commonDatabaseRecord->isValid());
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());
    }

    /**
     * 測試物件中是否有無效資料
     * @return void
     */
    public function testIsValidByDtUpdate()
    {
        $content = $this->content;

        $commonDatabaseRecord = new CommonDatabaseRecord();
        //先驗證目前資料有效
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());

        //輸入無效資料並驗證，驗證後復原有效資料。
        $commonDatabaseRecord->setDtUpdate('2011-11-11 00:00:00 錯誤日期格式');
        $this->assertFalse($commonDatabaseRecord->isValid());
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());

        //輸入無效資料並驗證，驗證後復原有效資料。
        $commonDatabaseRecord->setDtUpdate('2011-11-11 00:00');
        $this->assertFalse($commonDatabaseRecord->isValid());
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());

        //輸入無效資料並驗證，驗證後復原有效資料。
        $commonDatabaseRecord->setDtUpdate('2011-11-1100:00:00');
        $this->assertFalse($commonDatabaseRecord->isValid());
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());

        //輸入無效資料並驗證，驗證後復原有效資料。
        $commonDatabaseRecord->setDtUpdate('2011-11-11 0G:00:00');
        $this->assertFalse($commonDatabaseRecord->isValid());
        $commonDatabaseRecord->loadFromDbResult($content);
        $this->assertTrue($commonDatabaseRecord->isValid());
    }
}
