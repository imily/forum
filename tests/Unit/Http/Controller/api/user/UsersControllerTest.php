<?php namespace Tests\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Models\UserModel;
use Tests\ApiTestCase;

class UsersControllerTest extends ApiTestCase
{
    /**
     * 測試開始前先設定環境。
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        //讓以下測試開始時都預先登入User
        $this->loginForTest();
    }

    /**
     * 測試以API取得目前登入的使用者
     * @return void
     */
    public function testGetUser()
    {
        // 設定input
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK
            , $response->getStatusCode());

        //回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContent = array();
        $testContent['id'] = 2;
        $testContent['username'] = 'imily';
        $testContent['sicker_type'] = 3;
        $this->assertEquals($testContent, $contents);
    }

    /**
     * 測試以API取得目前登入的使用者
     * (Fail: 尚未登入)
     * @return void
     */
    public function testGetUserByLogout()
    {
        // 登出使用者
        $this->logoutForTest();

        // 設定input
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals($error->convertToDisplayArray(), $content);
    }

    /**
     * 測試以API修改目前使用者資訊
     * @return void
     */
    public function testUserModify()
    {
        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        // 確認是否修改成功
        $user = UserModel::getCurrentLoginUser();
        $this->assertEquals($user->getStickerType(), $input['sticker_type']);
        $this->assertTrue($user->verifyPassword($input['new_password']));
    }

    /**
     * 測試以API修改目前使用者資訊
     * (fail:確認密碼有誤)
     * @return void
     */
    public function testUserModifyByUnmatched()
    {
        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 1234;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['error'] = ErrorAuth::ERROR_AUTH_UNMATCHED_PASSWORD;
        $this->assertEquals($testContents, $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getCurrentLoginUser();
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
     * 測試以API修改目前使用者資訊
     * (fail:新密碼輸入空值)
     * @return void
     */
    public function testUserModifyByEmptyPassword()
    {
        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = '';
        $input['confirm_password'] = 1234;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['error'] = ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT;
        $this->assertEquals($testContents, $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getCurrentLoginUser();
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
     * 測試以API修改目前使用者資訊
     * (fail:密碼確認輸入空值)
     * @return void
     */
    public function testUserModifyByEmptyConfirmPassword()
    {
        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 1234;
        $input['confirm_password'] = '';

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['error'] = ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT;
        $this->assertEquals($testContents, $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getCurrentLoginUser();
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
     * 測試以API修改目前使用者資訊
     * (fail:沒有參數)
     * @return void
     */
    public function testUserModifyByNullValue()
    {
        // 設定input，沒有參數
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents['error'] = ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT;
        $this->assertEquals($testContents, $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getCurrentLoginUser();
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
     * 測試以API修改目前使用者資訊
     * (fail:尚未登入)
     * @return void
     */
    public function testUserModifyByLogout()
    {
        // 登出使用者
        $this->logoutForTest();

        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

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
     * 測試以API修改目前使用者資訊
     * (fail:無效的頭像類型)
     * @return void
     */
    public function testUserModifyByInvalidStickerType()
    {
        // 設定input
        $input = array();
        $input['sticker_type'] = 999;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/user/info");

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $content = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_STICKER_TYPE);
        $this->assertEquals($error->convertToDisplayArray(), $content);
    }
}
