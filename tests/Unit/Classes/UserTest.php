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
        $this->content['sUsername'] = 'admin';
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
}
