<?php namespace Tests;

use App\Classes\Message;
use App\Classes\User;

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
        $this->content['sDescription'] = '描述';
        $this->content['dtCreate'] = '0000-00-00 00:00:00';
        $this->content['dtUpdate'] = '0000-00-00 00:00:00';
    }

    /**
     * 生成User物件
     * @return User
     */
    private function generateUser()
    {
        $user = new User();
        $user->setId(1);
        $user->setUsername('testUser');
        $user->setStickerType(2);
        $user->setDescription('描述');
        $user->setDtCreate('1970-01-01 08:00:01');
        $user->setDtUpdate('1970-01-01 08:00:01');
        return $user;
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
        $this->assertEquals($this->content['ixUser'], $message->getIxUser());
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
        $this->assertEquals($this->content['ixUser'], $message->getIxUser());
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

        $message->setIxUser(0);
        $this->assertFalse($message->isValid());

        $message->setIxUser(-1);
        $this->assertFalse($message->isValid());
    }

    /**
     * 測試有效資料(fail:內容欄位為空)
     * @return void
     */
    public function testDataNotValidByDescription()
    {
        $content = $this->content;
        $message = new Message();

        $message->loadFromDbResult($content);
        $this->assertTrue($message->isValid());

        $message->setDescription('');
        $this->assertFalse($message->isValid());
    }

    /**
     * 測試取得User物件
     * @return void
     */
    public function testGetUser()
    {
        $message = new Message();
        // 測試放入物件前的狀態是否為空物件
        $this->assertEquals(new User(), $message->getUser());
        // 存入生成的物件
        $user = $this->generateUser();
        $message->setUser($user);
        // 檢查資料是否有效
        $this->assertTrue($message->getUser()->isValid());
        // 檢查取得的資料是否符合預期
        $this->assertEquals($user, $message->getUser());
    }
}
