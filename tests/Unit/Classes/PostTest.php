<?php namespace Tests;

use App\Classes\Message;
use App\Classes\Post;
use App\Classes\User;

class PostTest extends TestCase
{
    private $content = array();

    public function setUp()
    {
        parent::setUp();
        //設定一組預設有效array資料
        $this->content = array ();
        $this->content['ixPost']         = 1;
        $this->content['ixUser']         = 2;
        $this->content['sMessages']      = '[1,2,3]';
        $this->content['sTopic']         = '主題標題';
        $this->content['sLikes']         = '[1,2,3]';
        $this->content['sDescription']   = '主題內容';
        $this->content['dtCreate']       = '0000-00-00 00:00:00';
        $this->content['dtUpdate']       = '0000-00-00 00:00:00';
    }

    /**
     * 生成message陣列
     * @return array
     */
    public function generateMessages()
    {
        $messages = [];
        $message = new Message();
        $message->setId(1);
        $message->setIxUser(2);
        $message->setDescription('描述');
        $message->setDtCreate('1970-01-01 08:00:01');
        $message->setDtUpdate('1970-01-01 08:00:01');

        $messages[] = $message;
        return $messages;
    }

    /**
     * 生成User陣列
     * @return array
     */
    private function generateUsers()
    {
        $users = [];
        $user = new User();
        $user->setId(1);
        $user->setUsername('testUser');
        $user->setStickerType(2);
        $user->setDescription('描述');
        $user->setDtCreate('1970-01-01 08:00:01');
        $user->setDtUpdate('1970-01-01 08:00:01');

        $users[] = $user;
        return $users;
    }

    /**
     * 測試由陣列載入
     * @return void
     */
    public function testLoadFromDbResultByArray()
    {
        $post = new Post();
        $post->loadFromDbResult($this->content);

        $this->assertEquals($this->content, $post->toArray());

        $this->assertEquals($this->content['ixPost'], $post->getId());
        $this->assertEquals($this->content['ixUser'], $post->getIxUser());
        $this->assertEquals($this->content['sMessages'], $post->getMessages());
        $this->assertEquals($this->content['sTopic'], $post->getTopic());
        $this->assertEquals($this->content['sLikes'], $post->getLikes());
        $this->assertEquals($this->content['sDescription'], $post->getDescription());
        $this->assertEquals($this->content['dtCreate'], $post->getDtCreate());
        $this->assertEquals($this->content['dtUpdate'], $post->getDtUpdate());
    }

    /**
     * 測試由 Object 載入
     * @return void
     */
    public function testLoadFromDbResultByObject()
    {
        $post = new Post();
        $post->loadFromDbResult((object)$this->content);

        $this->assertEquals($this->content, $post->toArray());

        $this->assertEquals($this->content['ixPost'], $post->getId());
        $this->assertEquals($this->content['ixUser'], $post->getIxUser());
        $this->assertEquals($this->content['sMessages'], $post->getMessages());
        $this->assertEquals($this->content['sTopic'], $post->getTopic());
        $this->assertEquals($this->content['sLikes'], $post->getLikes());
        $this->assertEquals($this->content['sDescription'], $post->getDescription());
        $this->assertEquals($this->content['dtCreate'], $post->getDtCreate());
        $this->assertEquals($this->content['dtUpdate'], $post->getDtUpdate());
    }

    /**
     * 測試有效資料
     * @return void
     */
    public function testValidData()
    {
        $content = $this->content;
        $post = new Post();

        $post->loadFromDbResult($content);
        $this->assertTrue($post->isValid());
    }

    /**
     * 測試有效資料(fail:討論主題標題為空)
     * @return void
     */
    public function testDataNotValidByTopic()
    {
        $content = $this->content;
        $post = new Post();

        $post->loadFromDbResult($content);
        $this->assertTrue($post->isValid());

        $post->setTopic('');
        $this->assertFalse($post->isValid());
    }

    /**
     * 測試有效資料(fail:討論主題內容為空)
     * @return void
     */
    public function testDataNotValidByDescription()
    {
        $content = $this->content;
        $post = new Post();

        $post->loadFromDbResult($content);
        $this->assertTrue($post->isValid());

        $post->setDescription('');
        $this->assertFalse($post->isValid());
    }

    /**
     * 測試取得Message陣列
     * @return void
     */
    public function testGetMessages()
    {
        $post = new Post();
        // 測試放入陣列前的狀態是否為空陣列
        $this->assertEquals(array(), $post->getMessage());

        // 存入生成的陣列
        $messages = $this->generateMessages();
        $post->setMessage($messages);

        // 檢查資料是否有效
        foreach ($messages as $message) {
            $this->assertTrue($message->isValid());
        }

        // 檢查取得的資料是否符合預期
        $this->assertEquals($messages, $post->getMessage());
    }

    /**
     * 測試取得User陣列
     * @return void
     */
    public function testGetUsers()
    {
        $post = new Post();
        // 測試放入陣列前的狀態是否為空陣列
        $this->assertEquals(array(), $post->getUser());

        // 存入生成的陣列
        $users = $this->generateUsers();
        $post->setUser($users);

        // 檢查資料是否有效
        foreach ($users as $user) {
            $this->assertTrue($user->isValid());
        }

        // 檢查取得的資料是否符合預期
        $this->assertEquals($users, $post->getUser());
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
     * 測試取得User物件
     * @return void
     */
    public function testGetUser()
    {
        $post = new Post();
        // 測試放入物件前的狀態是否為空物件
        $this->assertEquals(new User(), $post->getUserObject());
        // 存入生成的物件
        $user = $this->generateUser();
        $post->setUserObject($user);
        // 檢查資料是否有效
        $this->assertTrue($post->getUserObject()->isValid());
        // 檢查取得的資料是否符合預期
        $this->assertEquals($user, $post->getUserObject());
    }
}
