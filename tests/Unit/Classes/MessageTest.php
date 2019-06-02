<?php namespace Tests;

use App\Classes\Message;

class MessageTest extends TestCase
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
        $this->content['ixMessage'] = 1;
        $this->content['ixUser']    = 2;
        $this->content['sDescription'] = '';
        $this->content['dtCreate'] = '0000-00-00 00:00:00';
        $this->content['dtUpdate'] = '0000-00-00 00:00:00';
    }

    /**
     * 測試由陣列載入
     * @return void
     */
    public function testLoadFromDbResultByArray()
    {
        $message = new Message();
        $message->loadFromDbResult($this->content);

        //轉為陣列作比對，確認是否相符
        $this->assertEquals($this->content, $message->toArray());

        $this->assertEquals($this->content['ixMessage'], $message->getId());
        $this->assertEquals($this->content['ixUser'], $message->getUser());
        $this->assertEquals($this->content['sDescription'], $message->getDescription());
        $this->assertEquals($this->content['dtCreate'], $message->getDtCreate());
        $this->assertEquals($this->content['dtUpdate'], $message->getDtUpdate());
    }

    /**
     * 測試由Object載入
     * @return void
     */
    public function testLoadFromDbResultByObject()
    {
        $message = new Message();
        $message->loadFromDbResult((object)$this->content);

        //轉為陣列作比對，確認是否相符
        $this->assertEquals($this->content, $message->toArray());

        $this->assertEquals($this->content['ixMessage'], $message->getId());
        $this->assertEquals($this->content['ixUser'], $message->getUser());
        $this->assertEquals($this->content['sDescription'], $message->getDescription());
        $this->assertEquals($this->content['dtCreate'], $message->getDtCreate());
        $this->assertEquals($this->content['dtUpdate'], $message->getDtUpdate());
    }

    /**
     * 測試有效資料
     * @return void
     */
    public function testValidData()
    {
        $content = $this->content;
        $message = new Message();

        $message->loadFromDbResult($content);
        $this->assertTrue($message->isValid());
    }

    /**
     * 測試有效資料(fail:留言者無效)
     * @return void
     */
    public function testDataNotValidByUser()
    {
        $content = $this->content;
        $message = new Message();

        $message->loadFromDbResult($content);
        $this->assertTrue($message->isValid());

        $message->setUser(0);
        $this->assertFalse($message->isValid());

        $message->setUser(-1);
        $this->assertFalse($message->isValid());
    }
}
