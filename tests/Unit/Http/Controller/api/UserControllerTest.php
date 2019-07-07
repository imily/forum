<?php namespace Tests;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Models\UserModel;

class UserControllerTest extends ApiTestCase
{
    /**
     * 測試開始前先設定環境。
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * 測試以API註冊使用者
     * @return void
     */
    public function testUserRegistered()
    {
        // 確認新增前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['username'] = 'test';
        $input['sticker_type'] = 2;
        $input['password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/registered");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_201_CREATED
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $testContent = array();
        $testContent['id'] = 5;
        $this->assertEquals($testContent, $content);

        // 確認是否與輸入的值相同
        $user = UserModel::getById($testContent['id']);
        $this->assertEquals($input['username'], $user->getUsername());
        $this->assertEquals($input['sticker_type'], $user->getStickerType());
        $this->assertTrue($user->verifyPassword($input['password']));
    }

    /**
     * 測試以API註冊使用者
     * (fail:名字為空字串)
     * @return void
     */
    public function testUserRegisteredByEmptyName()
    {
        // 確認新增前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['username'] = '';
        $input['sticker_type'] = 2;
        $input['password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/registered");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        //確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $testContent = array();
        $testContent['error'] = ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT;
        $this->assertEquals($testContent, $content);

        // 確認新增失敗筆數是否不變
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API註冊使用者
     * (fail:密碼為空字串)
     * @return void
     */
    public function testUserRegisteredByEmptyPassword()
    {
        // 確認新增前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['username'] = 'test';
        $input['sticker_type'] = 2;
        $input['password'] = '';

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/registered");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        //確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $testContent = array();
        $testContent['error'] = ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT;
        $this->assertEquals($testContent, $content);

        // 確認新增失敗筆數是否不變
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API註冊使用者
     * (fail:無效的頭像類型)
     * @return void
     */
    public function testUserRegisteredByStickerTypeInvalid()
    {
        // 確認新增前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['username'] = 'test';
        $input['sticker_type'] = 999;
        $input['password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/registered");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        //確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $testContent = array();
        $testContent['error'] = ErrorAuth::ERROR_AUTH_INCORRECT_STICKER_TYPE;
        $this->assertEquals($testContent, $content);

        // 確認新增失敗筆數是否不變
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API註冊使用者
     * (fail:使用者名稱已存在)
     * @return void
     */
    public function testUserRegisteredByUserNameIsExist()
    {
        // 確認新增前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['username'] = 'imily';
        $input['sticker_type'] = 2;
        $input['password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/registered");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        //確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $testContent = array();
        $testContent['error'] = ErrorAuth::ERROR_AUTH_EXISTED_USERNAME;
        $this->assertEquals($testContent, $content);

        // 確認新增失敗筆數是否不變
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }
}
