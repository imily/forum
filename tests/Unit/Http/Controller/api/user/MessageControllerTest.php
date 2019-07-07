<?php namespace Tests\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Models\MessageModel;
use Tests\ApiTestCase;

class MessageControllerTest extends ApiTestCase
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
        $this->content['id'] = 2;
        $this->content['user_name'] = "imily";
        $this->content['user_sicker_type'] = 3;
        $this->content['description'] = 'description02';
        $this->content['create_time'] = '2011-11-12 00:00:00';
        $this->content['update_time'] = '2011-11-13 00:00:00';

        //讓以下測試開始時都預先登入User
        $this->loginForTest();
    }

//    /**
//     * 測試以API取得指定Id的留言
//     * @return void
//     */
//    public function testGetMessageById()
//    {
//        $messageId = 2;
//
//        // 設定input
//        $input = array();
//
//        // 設定Header
//        $header = $this->header;
//
//        // 設定API路徑
//        $path = sprintf("/api/messages/%d", $messageId);
//
//        // 呼叫API
//        $response = $this->json('GET', $path, $input, $header);
//
//        // 確認回應的狀態碼是否正確
//        $this->assertEquals(HttpStatusCode::STATUS_200_OK, $response->getStatusCode());
//
//        // 回應的Json格式字串，轉成array後檢查內容是否符合預期
//        $contents = json_decode($response->getContent(), true);
//        $testContent = array();
//        $testContent['id'] = 2;
//        $testContent['user_name'] = "imily";
//        $testContent['user_sicker_type'] = 3;
//        $testContent['description'] = 'description02';
//        $testContent['create_time'] = '2011-11-12 00:00:00';
//        $testContent['update_time'] = '2011-11-13 00:00:00';
//        $this->assertEquals($testContent, $contents);
//    }
//
//    /**
//     * 測試以API取得指定Id的留言
//     * (Fail: 無效的Id)
//     * @return void
//     */
//    public function testGetMessageByIdForIdInvalid()
//    {
//        $messageId = -1;
//
//        // 設定input
//        $input = array();
//
//        // 設定Header
//        $header = $this->header;
//
//        // 設定API路徑
//        $path = sprintf("/api/messages/%d", $messageId);
//
//        // 呼叫API
//        $response = $this->json('GET', $path, $input, $header);
//
//        // 確認回應的狀態碼是否正確
//        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST, $response->getStatusCode());
//
//        // 回應的Json格式字串，轉成array後檢查內容是否符合預期
//        $contents = json_decode($response->getContent(), true);
//        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
//        $this->assertEquals($error->convertToDisplayArray(), $contents);
//    }

//    /**
//     * 測試以API新增留言
//     * @return void
//     */
//    public function testAddMessage()
//    {
//        // 確認目前有幾筆資料
//        $messages = MessageModel::getAllList();
//        $this->assertCount(8, $messages);
//        $this->assertEquals(1, $messages[0]->getId());
//        $this->assertEquals(2, $messages[1]->getId());
//
//        // 設定input
//        $input = array('user_id' => 2
//                     , 'description' => 'description09');
//
//        // 設定Header
//        $header = $this->header;
//
//        // 設定API路徑
//        $path = sprintf("/api/messages");
//
//        // 呼叫API
//        $response = $this->json('POST', $path, $input, $header);
//
//        // 確認回應的狀態碼是否正確
//        $this->assertEquals(HttpStatusCode::STATUS_201_CREATED
//            , $response->getStatusCode());
//
//        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
//        $content = json_decode($response->getContent(), true);
//        $testContent = array();
//        $testContent['id'] = 9;
//        $this->assertEquals($testContent, $content);
//
//        // 確認新增後有幾筆資料
//        $messages = MessageModel::getAllList();
//        $this->assertCount(9, $messages);
//        $this->assertEquals(1, $messages[0]->getId());
//        $this->assertEquals(2, $messages[1]->getId());
//        $this->assertEquals(9, $messages[8]->getId());
//    }
//
//    /**
//     * 測試以API新增留言
//     * (Fail: 未登入)
//     * @return void
//     */
//    public function testAddMessageByNotLogin()
//    {
//        // 登出使用者
//        $this->logoutForTest();
//
//        // 設定input
//        $input = array('user_id' => 2
//        , 'description' => 'description09');
//
//        // 設定Header
//        $header = $this->header;
//
//        // 設定API路徑
//        $path = sprintf("/api/messages");
//
//        // 呼叫API
//        $response = $this->json('POST', $path, $input, $header);
//
//        // 確認回應的狀態碼是否正確
//        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
//            , $response->getStatusCode());
//
//        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
//        $content = json_decode($response->getContent(), true);
//        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
//        $this->assertEquals($error->convertToDisplayArray(), $content);
//    }
//
//    /**
//     * 測試以API新增留言
//     * (Fail: userId為無效Id)
//     * @return void
//     */
//    public function testAddMessageByUserIdInvalid()
//    {
//        // 確認目前有幾筆資料
//        $messages = MessageModel::getAllList();
//        $this->assertCount(8, $messages);
//        $this->assertEquals(1, $messages[0]->getId());
//        $this->assertEquals(2, $messages[1]->getId());
//
//        // 設定input
//        $input = array('user_id' => -1
//        , 'description' => 'description09');
//
//        // 設定Header
//        $header = $this->header;
//
//        // 設定API路徑
//        $path = sprintf("/api/messages");
//
//        // 呼叫API
//        $response = $this->json('POST', $path, $input, $header);
//
//        // 確認回應的狀態碼是否正確
//        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
//            , $response->getStatusCode());
//
//        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
//        $content = json_decode($response->getContent(), true);
//        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
//        $this->assertEquals($error->convertToDisplayArray(), $content);
//
//        // 檢查資料是否有被修改
//        $messages = MessageModel::getAllList();
//        $this->assertCount(8, $messages);
//        $this->assertEquals(1, $messages[0]->getId());
//        $this->assertEquals(2, $messages[1]->getId());
//    }
//
//    /**
//     * 測試以API新增留言
//     * (Fail: 內容為空)
//     * @return void
//     */
//    public function testAddMessageByEmptyDescription()
//    {
//        // 確認目前有幾筆資料
//        $messages = MessageModel::getAllList();
//        $this->assertCount(8, $messages);
//        $this->assertEquals(1, $messages[0]->getId());
//        $this->assertEquals(2, $messages[1]->getId());
//
//        // 設定input
//        $input = array('user_id' => 2
//        , 'description' => '');
//
//        // 設定Header
//        $header = $this->header;
//
//        // 設定API路徑
//        $path = sprintf("/api/messages");
//
//        // 呼叫API
//        $response = $this->json('POST', $path, $input, $header);
//
//        // 確認回應的狀態碼是否正確
//        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
//            , $response->getStatusCode());
//
//        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
//        $content = json_decode($response->getContent(), true);
//        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
//        $this->assertEquals($error->convertToDisplayArray(), $content);
//
//        // 檢查資料是否有被修改
//        $messages = MessageModel::getAllList();
//        $this->assertCount(8, $messages);
//        $this->assertEquals(1, $messages[0]->getId());
//        $this->assertEquals(2, $messages[1]->getId());
//    }

    /**
     * 測試以API修改單一留言
     * @return void
     */
    public function testModifyMessage()
    {
        // 設定要修改的資料
        $messageId = 2;

        // 檢查修改前的資料
        $message = MessageModel::getById($messageId);
        $this->assertEquals('description02', $message->getDescription());

        // 設定input
        $input = array('description' => 'descriptionTest');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/messages/%d", $messageId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        // 檢查資料是否有被修改
        $message = MessageModel::getById($messageId);
        $this->assertEquals('descriptionTest', $message->getDescription());
    }

    /**
     * 測試以API修改單一留言
     * (Fail: 未登入)
     * @return void
     */
    public function testModifyMessageByNotLogin()
    {
        // 登出使用者
        $this->logoutForTest();

        // 設定要修改的資料
        $messageId = 2;

        // 設定input
        $input = array('description' => 'descriptionTest');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/messages/%d", $messageId);

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
     * 測試以API修改單一留言
     * (Fail: 無效id)
     * @return void
     */
    public function testModifyMessageByIdInvalid()
    {
        // 設定要修改的資料
        $messageId = -2;

        // 設定input
        $input = array('description' => 'descriptionTest');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/messages/%d", $messageId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $content);
    }

    /**
     * 測試以API修改單一留言
     * (Fail: 內容為空)
     * @return void
     */
    public function testModifyMessageByEmptyDescription()
    {
        // 設定要修改的資料
        $messageId = 2;

        // 檢查修改前的資料
        $message = MessageModel::getById($messageId);
        $this->assertEquals('description02', $message->getDescription());

        // 設定input
        $input = array('description' => '');

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/messages/%d", $messageId);

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
        $message = MessageModel::getById($messageId);
        $this->assertEquals('description02', $message->getDescription());
    }
}
