<?php namespace Tests\api\auth;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use Tests\ApiTestCase;

class AuthControllerTest extends ApiTestCase
{
    /**
     * 測試以API登入使用者
     * @return void
     */
    public function testLogin()
    {
        // 設定input
        $input = array();
        $input['account'] = 'imily';
        $input['password'] = 1234;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/auth/login");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['id'] = 2;
        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API登入使用者
     * (Fail:密碼錯誤)
     * @return void
     */
    public function testLoginByIncorrectPassword()
    {
        // 測試錯誤的密碼
        $input = array();
        $input['account'] = 'imily';
        $input['password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/auth/login");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否與錯誤相符
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['error'] = ErrorAuth::ERROR_AUTH_INCORRECT_PASSWORD;
        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API登入使用者
     * (Fail:帳號錯誤)
     * @return void
     */
    public function testLoginByIncorrectAccount()
    {
        // 測試錯誤的帳號
        $input = array();
        $input['account'] = 'test';
        $input['password'] = 1234;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/auth/login");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否與錯誤相符
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['error'] = ErrorAuth::ERROR_AUTH_INCORRECT_USERNAME;
        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API登入使用者
     * (Fail:帳號為空)
     * @return void
     */
    public function testLoginByEmptyAccount()
    {
        // 測試空帳號
        $input = array();
        $input['account'] = '';
        $input['password'] = 1234;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/auth/login");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否與錯誤相符
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['error'] = ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT;
        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API登入使用者
     * (Fail:密碼為空)
     * @return void
     */
    public function testLoginByEmptyPassword()
    {
        // 測試空帳號
        $input = array();
        $input['account'] = 'imily';
        $input['password'] = '';

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/auth/login");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否與錯誤相符
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['error'] = ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT;
        $this->assertEquals($testContents, $contents);
    }

    /**
     * 測試以API登出使用者
     * (Fail:密碼為空)
     * @return void
     */
    public function testLogout()
    {
        // 先確認有無紀錄session
        $this->assertFalse(session()->has('userId'));

        // 先登入一般使用者，取得session
        $this->loginForTest();
        $this->assertTrue(session()->has('userId'));

        // 設定Header
        $header = $this->header;

        //設定input
        $input = array();

        // 設定API路徑
        $path = sprintf("/api/auth/logout");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        // 確認回應的狀態碼是否與預期相符
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        // 確定session是否已清除
        $this->assertFalse(session()->has('userId'));
    }
}
