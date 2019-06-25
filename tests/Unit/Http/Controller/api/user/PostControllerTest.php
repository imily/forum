<?php namespace Tests;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\Error;
use App\Models\UserModel;

class PostControllerTest extends ApiTestCase
{
    private $content = array();

    /**
     * 測試開始前先設定環境。
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->content = array();
        $this->content[0]['id'] = 1;
        $this->content[0]['user_name'] = "admin";
        $this->content[0]['user_sicker_type'] = 1;
        $this->content[0]['messages']['total_amount'] = 4;
        $this->content[0]['messages']['data'][0]['user_name'] = "admin";
        $this->content[0]['messages']['data'][0]['description'] = "description01";
        $this->content[0]['messages']['data'][1]['user_name'] = "imily";
        $this->content[0]['messages']['data'][1]['description'] = "description02";
        $this->content[0]['topic'] = 'topic01';
        $this->content[0]['description'] = 'description01';
        $this->content[0]['likes'][0]['user_name'] = "admin";
        $this->content[0]['likes'][1]['user_name'] = "imily";
        $this->content[0]['likes'][2]['user_name'] = "Mary";
        $this->content[0]['create_time'] = '2011-11-11 00:00:00';
        $this->content[0]['update_time'] = '2011-11-12 00:00:00';

        //讓以下測試開始時都預先登入User
        $this->loginForTest();
    }

    /**
     * 測試以API取得部分討論主題
     * @return void
     */
    public function testGetPost()
    {
        $input = array('offset'   => 0
                      , 'limit' => 10
                      , 'message_offset' => 0
                      , 'message_limit' => 10);

        $header = $this->header;
        $path = sprintf("/api/posts");
        $response = $this->json('GET', $path, $input, $header);

        $this->assertEquals(HttpStatusCode::STATUS_200_OK, $response->getStatusCode());

        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['total_amount'] = 7;
        $testContents['data'][0] =
            array('id' => 1
                , 'user_name'        => 'admin'
                , 'user_sicker_type' => 1
                , 'messages' => array('total_amount' => 4,
                                      'data' => array(
                                       array('user_name' => "admin",
                                             'description' => "description01")
                                       ,array('user_name' => "imily",
                                              'description' => "description02")
                                       ,array('user_name' => "Mary",
                                              'description' => "description03")
                                       ,array('user_name' => "imily",
                                              'description' => "description05")))
                , 'topic' => 'topic01'
                , 'description' => 'description01'
                , 'likes' => array(array('user_name' => 'admin'),
                                   array('user_name' => 'imily'),
                                   array('user_name' => 'Mary'))
                , 'create_time' => "2011-11-11 00:00:00"
                , 'update_time' => "2011-11-12 00:00:00");
        $testContents['data'][1] =
            array('id' => 2
            , 'user_name'        => 'imily'
            , 'user_sicker_type' => 3
            , 'messages' => array('total_amount' => 3,
                'data' => array(
                    array('user_name' => "admin",
                        'description' => "description01")
                ,array('user_name' => "Mary",
                        'description' => "description06")
                ,array('user_name' => "admin",
                        'description' => "description07")))
            , 'topic' => 'topic02'
            , 'description' => 'description02'
            , 'likes' => array(array('user_name' => 'admin'),
                array('user_name' => 'imily'),
                array('user_name' => 'Mary'))
            , 'create_time' => "2011-11-12 00:00:00"
            , 'update_time' => "2011-11-13 00:00:00");
        $testContents['data'][2] =
            array('id' => 3
            , 'user_name'        => 'Mary'
            , 'user_sicker_type' => 1
            , 'messages' => array('total_amount' => 3,
                'data' => array(
                    array('user_name' => "admin",
                        'description' => "description01")
                ,array('user_name' => "admin",
                        'description' => "description04")
                ,array('user_name' => "Mary",
                        'description' => "description08")))
            , 'topic' => 'topic03'
            , 'description' => 'description03'
            , 'likes' => array(array('user_name' => 'admin'),
                array('user_name' => 'imily'),
                array('user_name' => 'Mary'))
            , 'create_time' => "2011-11-13 00:00:00"
            , 'update_time' => "2011-11-14 00:00:00");
        $testContents['data'][3] =
            array('id' => 4
            , 'user_name'        => 'imily'
            , 'user_sicker_type' => 3
            , 'messages' => array('total_amount' => 5,
                'data' => array(
                    array('user_name' => "admin",
                        'description' => "description01")
                ,array('user_name' => "imily",
                        'description' => "description02")
                ,array('user_name' => "Mary",
                        'description' => "description03")
                ,array('user_name' => "imily",
                        'description' => "description05")
                ,array('user_name' => "Mary",
                        'description' => "description08")))
            , 'topic' => 'topic04'
            , 'description' => 'description04'
            , 'likes' => array(array('user_name' => 'admin'),
                array('user_name' => 'imily'),
                array('user_name' => 'Mary'))
            , 'create_time' => "2011-11-14 00:00:00"
            , 'update_time' => "2011-11-15 00:00:00");
        $testContents['data'][4] =
            array('id' => 5
            , 'user_name'        => 'admin'
            , 'user_sicker_type' => 1
            , 'messages' => array('total_amount' => 4,
                'data' => array(
                    array('user_name' => "admin",
                        'description' => "description01")
                ,array('user_name' => "imily",
                        'description' => "description02")
                ,array('user_name' => "Mary",
                        'description' => "description03")
                ,array('user_name' => "admin",
                        'description' => "description04")))
            , 'topic' => 'topic05'
            , 'description' => 'description05'
            , 'likes' => array(
                array('user_name' => 'imily'),
                array('user_name' => 'Mary'))
            , 'create_time' => "2011-11-15 00:00:00"
            , 'update_time' => "2011-11-16 00:00:00");
        $testContents['data'][5] =
            array('id' => 6
            , 'user_name'        => 'Mary'
            , 'user_sicker_type' => 1
            , 'messages' => array('total_amount' => 3,
                'data' => array(
                    array('user_name' => "admin",
                        'description' => "description01")
                ,array('user_name' => "imily",
                        'description' => "description05")
                ,array('user_name' => "Mary",
                        'description' => "description08")))
            , 'topic' => 'topic06'
            , 'description' => 'description06'
            , 'likes' => array(
                array('user_name' => 'admin'),
                array('user_name' => 'imily'))
            , 'create_time' => "2011-11-16 00:00:00"
            , 'update_time' => "2011-11-17 00:00:00");
        $testContents['data'][6] =
            array('id' => 7
            , 'user_name'        => 'imily'
            , 'user_sicker_type' => 3
            , 'messages' => array('total_amount' => 3,
                'data' => array(
                    array('user_name' => "imily",
                        'description' => "description02")
                ,array('user_name' => "imily",
                        'description' => "description05")
                ,array('user_name' => "Mary",
                        'description' => "description06")))
            , 'topic' => 'topic07'
            , 'description' => 'description07'
            , 'likes' => array(
                array('user_name' => 'admin'),
                array('user_name' => 'imily'))
            , 'create_time' => "2011-11-17 00:00:00"
            , 'update_time' => "2011-11-18 00:00:00");

        $this->assertEquals($testContents, $contents);
    }
}
