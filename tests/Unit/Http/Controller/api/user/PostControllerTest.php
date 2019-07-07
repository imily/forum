<?php namespace Tests\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\User;
use App\Models\PostModel;
use App\Models\UserModel;
use Tests\ApiTestCase;

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
        // 設定input
        $input = array('offset'   => 0
                      , 'limit' => 10
                      , 'message_offset' => 0
                      , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK, $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期
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

    /**
     * 測試以API取得部分討論主題
     * (offset設定為5，limit設定為2)
     * @return void
     */
    public function testGetPostForOffset()
    {
        // 設定input
        $input = array('offset'   => 5
                     , 'limit' => 2
                     , 'message_offset' => 0
                     , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK, $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['total_amount'] = 2;

        $testContents['data'][0] =
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
        $testContents['data'][1] =
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

    /**
     * 測試以API取得部分討論主題
     * (Fail: offset設定無效參數)
     * @return void
     */
    public function testGetPostForOffsetInvalid()
    {
        // 設定input
        $input = array('offset'   => -1
                     , 'limit' => 2
                     , 'message_offset' => 0
                     , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST, $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得部分討論主題
     * (Fail: limit設定為0)
     * @return void
     */
    public function testGetPostForLimitInvalid()
    {
        // 設定input
        $input = array('offset'   => 0
                     , 'limit' => ''
                     , 'message_offset' => 0
                     , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST, $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得指定userId部分討論主題
     * @return void
     */
     public function testGetPostByUserId()
    {
        // 設定要取得的userId
        $userId = 1;

        // 設定input
        $input = array('offset'   => 0
                     , 'limit' => 10
                     , 'message_offset' => 0
                     , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/users/%d/posts", $userId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期
        $contents = json_decode($response->getContent(), true);

        $testContents = array();
        $testContents['total_amount'] = 2;
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

        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API取得指定userId部分討論主題
     * (offset設定為1，limit設定為1)
     * @return void
     */
    public function testGetPostByUserIdForOffset()
    {
        // 設定要取得的userId
        $userId = 1;

        // 設定input
        $input = array('offset'=> 1
                     , 'limit' => 1
                     , 'message_offset' => 1
                     , 'message_limit'  => 1);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/users/%d/posts", $userId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期
        $contents = json_decode($response->getContent(), true);

        $testContents = array();
        $testContents['total_amount'] = 1;
        $testContents['data'][0] =
            array('id' => 5
            , 'user_name'        => 'admin'
            , 'user_sicker_type' => 1
            , 'messages' => array('total_amount' => 1,
                'data' => array(
                    array('user_name' => "imily",
                        'description' => "description02")))
            , 'topic' => 'topic05'
            , 'description' => 'description05'
            , 'likes' => array(
                array('user_name' => 'imily'),
                array('user_name' => 'Mary'))
            , 'create_time' => "2011-11-15 00:00:00"
            , 'update_time' => "2011-11-16 00:00:00");

        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API取得指定userId部分討論主題
     * (Fail: offset設定無效參數)
     * @return void
     */
    public function testGetPostByUserIdForOffsetInvalid()
    {
        // 設定要取得的userId
        $userId = 1;

        // 設定input
        $input = array('offset'   => -1
        , 'limit' => 2
        , 'message_offset' => 0
        , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/users/%d/posts", $userId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        //回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得指定userId部分討論主題
     * (Fail: limit設定為0)
     * @return void
     */
    public function testGetPostByUserIdForLimitInvalid()
    {
        // 設定要取得的userId
        $userId = 1;

        // 設定input
        $input = array('offset'   => 0
        , 'limit' => ''
        , 'message_offset' => 0
        , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/users/%d/posts", $userId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST, $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得指定userId部分討論主題
     * (Fail: userId無效)
     * @return void
     */
    public function testGetPostByUserIdForUserIdInvalid()
    {
        // 設定要取得的userId
        $userId = 0;

        // 設定input
        $input = array('offset'   => 0
        , 'limit' => 10
        , 'message_offset' => 0
        , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/users/%d/posts", $userId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST, $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得指定userId部分討論主題
     * (Fail: userId輸入字串)
     * @return void
     */
    public function testGetPostByUserIdForUserIdWrongFormat()
    {
        // 設定要取得的userId
        $userId = 'abc';

        // 設定input
        $input = array('offset'   => 0
        , 'limit' => 10
        , 'message_offset' => 0
        , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/users/%d/posts", $userId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST, $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得指定userId部分討論主題
     * (Fail: userId不存在)
     * @return void
     */
    public function testGetPostByUserIdForUserINotExist()
    {
        // 設定要取得的userId
        $userId = 999;

        // 設定input
        $input = array('offset'   => 0
        , 'limit' => 10
        , 'message_offset' => 0
        , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/users/%d/posts", $userId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST, $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得單一討論主題
     * @return void
     */
    public function testGetPostById()
    {
        // 設定討論主題Id
        $postId = 1;

        // 設定input
        $input = array('message_offset' => 0
                     , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['id']               = 1;
        $testContents['user_name']        = 'admin';
        $testContents['user_sicker_type'] = 1;
        $testContents['messages']['total_amount']  = 4;
        $testContents['messages']['data'][0]['user_name']   = 'admin';
        $testContents['messages']['data'][0]['description'] = 'description01';
        $testContents['messages']['data'][1]['user_name']   = 'imily';
        $testContents['messages']['data'][1]['description'] = 'description02';
        $testContents['messages']['data'][2]['user_name']   = 'Mary';
        $testContents['messages']['data'][2]['description'] = 'description03';
        $testContents['messages']['data'][3]['user_name']   = 'imily';
        $testContents['messages']['data'][3]['description'] = 'description05';
        $testContents['topic']         = 'topic01';
        $testContents['description']   = 'description01';
        $testContents['likes'][0]['user_name']  = 'admin';
        $testContents['likes'][1]['user_name']  = 'imily';
        $testContents['likes'][2]['user_name']  = 'Mary';
        $testContents['create_time']  = '2011-11-11 00:00:00';
        $testContents['update_time']  = '2011-11-12 00:00:00';
        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API取得單一討論主題
     * (offset設定為1，limit設定為1)
     * @return void
     */
    public function testGetPostByIdForOffset()
    {
        // 設定討論主題Id
        $postId = 1;

        // 設定input
        $input = array('message_offset' => 1
        , 'message_limit' => 1);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['id']               = 1;
        $testContents['user_name']        = 'admin';
        $testContents['user_sicker_type'] = 1;
        $testContents['messages']['total_amount']  = 1;
        $testContents['messages']['data'][0]['user_name']   = 'imily';
        $testContents['messages']['data'][0]['description'] = 'description02';
        $testContents['topic']         = 'topic01';
        $testContents['description']   = 'description01';
        $testContents['likes'][0]['user_name']  = 'admin';
        $testContents['likes'][1]['user_name']  = 'imily';
        $testContents['likes'][2]['user_name']  = 'Mary';
        $testContents['create_time']  = '2011-11-11 00:00:00';
        $testContents['update_time']  = '2011-11-12 00:00:00';
        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API取得單一討論主題
     * (Fail: offset設定無效參數)
     * @return void
     */
    public function testGetPostByIdForOffsetInvalid()
    {
        // 設定討論主題Id
        $postId = 1;

        // 設定input
        $input = array('message_offset' => 0
        , 'message_limit' => 0);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        //回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得單一討論主題
     * (Fail: limit設定為0)
     * @return void
     */
    public function testGetPostByIdForLimitInvalid()
    {
        // 設定討論主題Id
        $postId = 1;

        // 設定input
        $input = array('message_offset' => -1
        , 'message_limit' => 1);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        //回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得單一討論主題
     * (postId輸入字串)
     * @return void
     */
    public function testGetPostByIdForIdIsString()
    {
        // 設定討論主題Id
        $postId = '1';

        // 設定input
        $input = array('message_offset' => 0
        , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['id']               = 1;
        $testContents['user_name']        = 'admin';
        $testContents['user_sicker_type'] = 1;
        $testContents['messages']['total_amount']  = 4;
        $testContents['messages']['data'][0]['user_name']   = 'admin';
        $testContents['messages']['data'][0]['description'] = 'description01';
        $testContents['messages']['data'][1]['user_name']   = 'imily';
        $testContents['messages']['data'][1]['description'] = 'description02';
        $testContents['messages']['data'][2]['user_name']   = 'Mary';
        $testContents['messages']['data'][2]['description'] = 'description03';
        $testContents['messages']['data'][3]['user_name']   = 'imily';
        $testContents['messages']['data'][3]['description'] = 'description05';
        $testContents['topic']         = 'topic01';
        $testContents['description']   = 'description01';
        $testContents['likes'][0]['user_name']  = 'admin';
        $testContents['likes'][1]['user_name']  = 'imily';
        $testContents['likes'][2]['user_name']  = 'Mary';
        $testContents['create_time']  = '2011-11-11 00:00:00';
        $testContents['update_time']  = '2011-11-12 00:00:00';
        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API取得單一討論主題
     * (Fail:postId無效)
     * @return void
     */
    public function testGetPostByIdForIdInvalid()
    {
        // 設定討論主題Id
        $postId = 0;

        // 設定input
        $input = array('message_offset' => 0
        , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得單一討論主題
     * (Fail:postId不存在)
     * @return void
     */
    public function testGetPostByIdForIdNotExisted()
    {
        // 設定討論主題Id
        $postId = 999;

        // 設定input
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得單一討論主題
     * (Fail:postId輸入格式錯誤)
     * @return void
     */
    public function testGetPostByIdForIdWrongFormat()
    {
        // 設定討論主題Id
        $postId = 'abc';

        // 設定input
        $input = array('message_offset' => 0
        , 'message_limit' => 10);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API新增討論主題
     * @return void
     */
    public function testAddPost()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());

        // 設定input
        $input = array('user_id' => 2
                     , 'topic' => 'topic08'
                     , 'description' => 'description08');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_201_CREATED
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $testContent = array();
        $testContent['id'] = 8;
        $this->assertEquals($testContent, $content);

        // 確認新增後有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(8, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
        $this->assertEquals(8, $posts[7]->getId());
    }

    /**
     * 測試以API新增討論主題
     * (Fail: 未登入)
     * @return void
     */
    public function testAddPostByNotLogin()
    {
        // 登出使用者
        $this->logoutForTest();

        // 設定input
        $input = array('user_id' => 2
        , 'topic' => 'topic08'
        , 'description' => 'description08');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals($error->convertToDisplayArray(), $content);
    }

    /**
     * 測試以API新增討論主題
     * (Fail: 不存在的userId)
     * @return void
     */
    public function testAddPostByUserIdNotExist()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());

        // 設定input
        $input = array('user_id' => 999
        , 'topic' => 'topic08'
        , 'description' => 'description08');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 檢查資料是否有被修改
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
    }

    /**
     * 測試以API新增討論主題
     * (Fail: userId為無效Id)
     * @return void
     */
    public function testAddPostByUserIdInvalid()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());

        // 設定input
        $input = array('user_id' => -1
        , 'topic' => ''
        , 'description' => 'description08');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 檢查資料是否有被修改
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
    }

    /**
     * 測試以API新增討論主題
     * (Fail: 標題為空)
     * @return void
     */
    public function testAddPostByEmptyTopic()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());

        // 設定input
        $input = array('user_id' => 2
                     , 'topic' => ''
                     , 'description' => 'description08');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 檢查資料是否有被修改
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
    }

    /**
     * 測試以API新增討論主題
     * (Fail: 內容為空)
     * @return void
     */
    public function testAddPostByEmptyDescription()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());

        // 設定input
        $input = array('user_id' => 2
        , 'topic' => 'topic08'
        , 'description' => '');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 檢查資料是否有被修改
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
    }

    /**
     * 測試以API修改單一討論主題
     * @return void
     */
    public function testModifyPost()
    {
        // 設定要修改的資料
        $postId = 2;

        // 檢查修改前的資料
        $post = PostModel::getAllById($postId);
        $this->assertEquals('topic02', $post->getTopic());
        $this->assertEquals('description02', $post->getDescription());

        // 設定input
        $input = array('topic' => 'topicTest'
        , 'description' => 'descriptionTest');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $post->getId());

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        // 檢查資料是否有被修改
        $post = PostModel::getAllById($postId);
        $this->assertEquals('topicTest', $post->getTopic());
        $this->assertEquals('descriptionTest', $post->getDescription());
    }

    /**
     * 測試以API修改單一討論主題
     * (Fail: 未登入)
     * @return void
     */
    public function testModifyPostByNotLogin()
    {
        // 登出使用者
        $this->logoutForTest();

        // 設定要修改的資料
        $postId = 2;

        // 設定input
        $input = array('topic' => 'topicTest'
        , 'description' => 'descriptionTest');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $postId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals($error->convertToDisplayArray(), $content);
    }

    /**
     * 測試以API修改單一討論主題
     * (Fail: 標題為空)
     * @return void
     */
    public function testModifyPostByEmptyTopic()
    {
        // 設定要修改的資料
        $postId = 2;

        // 檢查修改前的資料
        $post = PostModel::getAllById($postId);
        $this->assertEquals('topic02', $post->getTopic());
        $this->assertEquals('description02', $post->getDescription());

        // 設定input
        $input = array('topic' => ''
        , 'description' => 'descriptionTest');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $post->getId());

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 檢查資料是否有被修改
        $post = PostModel::getAllById($postId);
        $this->assertEquals('topic02', $post->getTopic());
        $this->assertEquals('description02', $post->getDescription());
    }

    /**
     * 測試以API修改單一討論主題
     * (Fail: 內容為空)
     * @return void
     */
    public function testModifyPostByEmptyDescription()
    {
        // 設定要修改的資料
        $postId = 2;

        // 檢查修改前的資料
        $post = PostModel::getAllById($postId);
        $this->assertEquals('topic02', $post->getTopic());
        $this->assertEquals('description02', $post->getDescription());

        // 設定input
        $input = array('topic' => 'topicTest'
        , 'description' => '');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d", $post->getId());

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 檢查資料是否有被修改
        $post = PostModel::getAllById($postId);
        $this->assertEquals('topic02', $post->getTopic());
        $this->assertEquals('description02', $post->getDescription());
    }

    /**
     * 測試以API批量刪除討論主題
     * @return void
     */
    public function testDeletePosts()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
        $this->assertEquals(3, $posts[2]->getId());

        // 設定input
        $input = array();
        $input['ids'] = [1,2];

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/postIds");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        //確認刪除後筆數
        $posts = PostModel::getAllList();
        $this->assertCount(5, $posts);
        $this->assertEquals(3, $posts[0]->getId());
    }

    /**
     * 測試以API批量刪除討論主題
     * (Fail:ids中包含無效id)
     * @return void
     */
    public function testDeletePostsByIdInvalid()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
        $this->assertEquals(3, $posts[2]->getId());

        // 設定input
        $input = array();
        $input['ids'] = [0,2];

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/postIds");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        //確認刪除後筆數
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
        $this->assertEquals(3, $posts[2]->getId());
    }

    /**
     * 測試以API批量刪除討論主題
     * (Fail:ids為空值)
     * @return void
     */
    public function testDeletePostsByIdsEmpty()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
        $this->assertEquals(3, $posts[2]->getId());

        // 設定input
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/postIds");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        //確認刪除後筆數
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
        $this->assertEquals(3, $posts[2]->getId());
    }

    /**
     * 測試以API批量刪除討論主題
     * (Fail:輸入ids非數字)
     * @return void
     */
    public function testDeletePostsByIdsIsNotInt()
    {
        // 確認目前有幾筆資料
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
        $this->assertEquals(3, $posts[2]->getId());

        // 設定input
        $input = array();
        $input['ids'] = ['二',3];

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/postIds");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 確認刪除後筆數
        $posts = PostModel::getAllList();
        $this->assertCount(7, $posts);
        $this->assertEquals(1, $posts[0]->getId());
        $this->assertEquals(2, $posts[1]->getId());
        $this->assertEquals(3, $posts[2]->getId());
    }

    /**
     * 測試以API更新喜歡單一討論主題
     * @return void
     */
    public function testUpdateLikesForPost()
    {
        // 設定要更新喜歡的資料
        $postId = 2;

        // 檢查更新前的資料
        $likes = PostModel::getAllById($postId)->getLikes();
        $this->assertEquals('[1,2,3]', $likes);

        // 更換使用者
        $this->logoutForTest();
        $user = new User();
        $user->setId(4);
        session()->put('userId', $user->getId());
        $this->assertTrue(UserModel::isLogin());

        // 設定input
        $input = array('user_id' => $user->getId());

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d/like", $postId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        // 檢查資料是否有被修改
        $likes = PostModel::getAllById($postId)->getLikes();
        $this->assertEquals('[1,2,3,4]', $likes);
    }

    /**
     * 測試以API更新喜歡單一討論主題
     * (目前的使用者已在喜歡列表)
     * @return void
     */
    public function testUpdateLikesForPostByUserIdExist()
    {
        // 設定要更新喜歡的資料
        $postId = 2;
        $userId = 2;

        // 檢查更新前的資料
        $likes = PostModel::getAllById($postId)->getLikes();
        $this->assertEquals('[1,2,3]', $likes);

        // 設定input
        $input = array('user_id' => $userId);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d/like", $postId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        // 檢查資料是否有被修改
        $likes = PostModel::getAllById($postId)->getLikes();
        $this->assertEquals('[1,3]', $likes);
    }

    /**
     * 測試以API更新喜歡單一討論主題
     * (Fail: 未登入)
     * @return void
     */
    public function testUpdateLikesForPostByNotLogn()
    {
        // 登出使用者
        $this->logoutForTest();

        // 設定要更新喜歡的資料
        $postId = 2;

        // 設定input
        $input = array('user_id' => 5);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d/like", $postId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals($error->convertToDisplayArray(), $content);

    }

    /**
     * 測試以API更新喜歡單一討論主題
     * (Fail: 包含無效id)
     * @return void
     */
    public function testUpdateLikesForPostByUserIdInvalid()
    {
        // 設定要更新喜歡的資料
        $postId = 2;

        // 檢查更新前的資料
        $likes = PostModel::getAllById($postId)->getLikes();
        $this->assertEquals('[1,2,3]', $likes);

        // 設定input
        $input = array('user_id' => -1);

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d/like", $postId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 檢查資料是否有被修改
        $likes = PostModel::getAllById($postId)->getLikes();
        $this->assertEquals('[1,2,3]', $likes);
    }

    /**
     * 測試以API更新喜歡單一討論主題
     * (Fail: 輸入ids非數字)
     * @return void
     */
    public function testUpdateLikesForPostByUserIdNotInt()
    {
        // 設定要更新喜歡的資料
        $postId = 2;

        // 檢查更新前的資料
        $likes = PostModel::getAllById($postId)->getLikes();
        $this->assertEquals('[1,2,3]', $likes);

        // 設定input
        $input = array('user_id' => '二');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/posts/%d/like", $postId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $content);

        // 檢查資料是否有被修改
        $likes = PostModel::getAllById($postId)->getLikes();
        $this->assertEquals('[1,2,3]', $likes);
    }
}
