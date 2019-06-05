<?php namespace Tests;

use App\Classes\User;

class UserTest extends TestCase
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
        $this->content['ixUser'] = 1;
        $this->content['sUsername'] = 'Name';
        $this->content['nStickerType'] = 1;
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
        $user = new User();
        $user->loadFromDbResult($this->content);

        //轉為陣列作比對，確認是否相符
        $this->assertEquals($this->content, $user->toArray());

        $this->assertEquals($this->content['ixUser'], $user->getId());
        $this->assertEquals($this->content['sUsername'], $user->getUsername());
        $this->assertEquals($this->content['nStickerType'], $user->getStickerType());
        $this->assertEquals($this->content['sDescription'], $user->getDescription());
        $this->assertEquals($this->content['dtCreate'], $user->getDtCreate());
        $this->assertEquals($this->content['dtUpdate'], $user->getDtUpdate());
    }

    /**
     * 測試由Object載入
     * @return void
     */
    public function testLoadFromDbResultByObject()
    {
        $user = new User();
        $user->loadFromDbResult((object)$this->content);

        //轉為陣列作比對，確認是否相符
        $this->assertEquals($this->content, $user->toArray());

        $this->assertEquals($this->content['ixUser'], $user->getId());
        $this->assertEquals($this->content['sUsername'], $user->getUsername());
        $this->assertEquals($this->content['nStickerType'], $user->getStickerType());
        $this->assertEquals($this->content['sDescription'], $user->getDescription());
        $this->assertEquals($this->content['dtCreate'], $user->getDtCreate());
        $this->assertEquals($this->content['dtUpdate'], $user->getDtUpdate());
    }

    /**
     * 測試有效資料
     * @return void
     */
    public function testValidData()
    {
        $content = $this->content;
        $user = new User();

        //測試有效的資料，確認結果是否符合預期
        $user->loadFromDbResult($content);
        $this->assertTrue($user->isValid());
    }

    /**
     * 測試有效資料(fail:名稱無效)
     * @return void
     */
    public function testDataNotValidByName()
    {
        $content = $this->content;
        $user = new User();

        $user->loadFromDbResult($content);
        $this->assertTrue($user->isValid());

        $user->setUsername('');
        $this->assertFalse($user->isValid());

        $user->setUsername('aaaabbbbccccddddeeeeffffyyyyyyyyyyy');
        $this->assertFalse($user->isValid());
    }

    /**
     * 測試有效資料(fail:頭像類型無效)
     * @return void
     */
    public function testDataNotValidByStickerType()
    {
        $content = $this->content;
        $user = new User();

        $user->loadFromDbResult($content);
        $this->assertTrue($user->isValid());

        $user->setStickerType(0);
        $this->assertFalse($user->isValid());

        $user->setStickerType(7);
        $this->assertFalse($user->isValid());
    }

    /**
     * 測試驗證密碼
     * @return void
     */
    public function testVerifyPassword()
    {
        $content['sPassword'] = 123;

        $queryResult = array();
        $queryResult['ixUser'] = 1;
        $queryResult['sUsername'] = 'Name';
        $queryResult['sPassword'] = '$2y$10$sFnZHfyCInA.GPqon1GmFOfb09pR5yPW5GVL8Y24TeNTxO9w2yCdW';
        $queryResult['nStickerType'] = 1;
        $queryResult['sDescription'] = '';
        $queryResult['dtCreate'] = '0000-00-00 00:00:00';
        $queryResult['dtUpdate'] = '0000-00-00 00:00:00';

        $user = new User();
        $user->loadFromDbResult($queryResult);
        $isValid = $user->verifyPassword($content['sPassword']);

        $this->assertTrue($isValid);
    }

    /**
     * 測試是否為管理員
     * @return void
     */
    public function testIsAdmin()
    {
        $user = new User();
        $user->setId(User::SUPER_USER_ID);
        $this->assertTrue($user->isAdmin());

        $user->setId(9999);
        $this->assertFalse($user->isAdmin());
    }
}
