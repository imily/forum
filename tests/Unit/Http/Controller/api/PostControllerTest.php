<?php namespace Tests;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;

class PostControllerTest extends ApiTestCase
{
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
}
