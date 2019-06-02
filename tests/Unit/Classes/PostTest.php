<?php namespace Tests;

use App\Classes\Post;

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
        $this->content['sMessagePerson'] = '[1,2,3]';
        $this->content['sTopic']         = 'topic';
        $this->content['sLike']          = '[1,2,3]';
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
        $post = new Post();
        $post->loadFromDbResult($this->content);

        $this->assertEquals($this->content, $post->toArray());

        $this->assertEquals($this->content['ixPost'], $post->getId());
        $this->assertEquals($this->content['ixUser'], $post->getUser());
        $this->assertEquals($this->content['sMessagePerson'], $post->getMessagePerson());
        $this->assertEquals($this->content['sTopic'], $post->getTopic());
        $this->assertEquals($this->content['sLike'], $post->getLikes());
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
        $this->assertEquals($this->content['ixUser'], $post->getUser());
        $this->assertEquals($this->content['sMessagePerson'], $post->getMessagePerson());
        $this->assertEquals($this->content['sTopic'], $post->getTopic());
        $this->assertEquals($this->content['sLike'], $post->getLikes());
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
     * 測試有效資料(fail:討論主題發表人無效)
     * @return void
     */
    public function testDataNotValidByUser()
    {
        $content = $this->content;
        $post = new Post();

        $post->loadFromDbResult($content);
        $this->assertTrue($post->isValid());

        $post->setUser(0);
        $this->assertFalse($post->isValid());

        $post->setUser(-1);
        $this->assertFalse($post->isValid());
    }

    /**
     * 測試有效資料(fail:討論主題標題無效)
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
}
