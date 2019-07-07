<?php namespace Tests\api\admin;

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

        //讓以下測試開始時都預先登入管理員帳號
        $this->loginAdminForTest();
    }

    /**
     * 測試以API取得所有使用者清單
     * @return void
     */
    public function testGetUsers()
    {
        // 設定input
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_200_OK
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $testContents = array();
        $testContents[0]['id'] = 1;
        $testContents[0]['sticker_type'] = 1;
        $testContents[0]['username'] = 'admin';
        $testContents[1]['id'] = 2;
        $testContents[1]['sticker_type'] = 3;
        $testContents[1]['username'] = 'imily';
        $testContents[2]['id'] = 3;
        $testContents[2]['sticker_type'] = 1;
        $testContents[2]['username'] = 'Mary';
        $testContents[3]['id'] = 4;
        $testContents[3]['sticker_type'] = 2;
        $testContents[3]['username'] = 'Jessie';
        $this->assertEquals($testContents, $contents);
    }

    /**
 * 測試以API取得所有使用者清單
 * (Fail: 登入一般使用者)
 * @return void
 */
    public function testGetUsersByLoginNormalUser()
    {
        // 登出使用者
        $this->logoutForTest();

        // 改登入一般使用者
        $this->loginForTest();

        // 設定input
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API取得所有使用者清單
     * (Fail: 未登入)
     * @return void
     */
    public function testGetUsersByNotLogin()
    {
        // 登出使用者
        $this->logoutForTest();

        // 設定input
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('GET', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API新增使用者
     * @return void
     */
    public function testCreateUser()
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
        $path = sprintf("/api/admin/users");

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
     * 測試以API新增使用者
     * (fail:名字為空字串)
     * @return void
     */
    public function testCreateUserByEmptyName()
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
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        //確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認新增失敗筆數是否不變
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API新增使用者
     * (fail:密碼為空字串)
     * @return void
     */
    public function testCreateUserByEmptyPassword()
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
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        //確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認新增失敗筆數是否不變
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API新增使用者
     * (fail:無效的頭像類型)
     * @return void
     */
    public function testCreateUserByStickerTypeInvalid()
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
        $input['password'] = 1234;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        //確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_STICKER_TYPE);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認新增失敗筆數是否不變
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API新增使用者
     * (fail:使用者名稱已存在)
     * @return void
     */
    public function testCreateUserByUserNameIsExist()
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
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('POST', $path, $input, $header);

        //確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_EXISTED_USERNAME);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認新增失敗筆數是否不變
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API修改使用者資訊
     * @return void
     */
    public function testUserModify()
    {
        // 設定要修改的使用者
        $userId = 2;

        // 確認修改前資料
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));

        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users/%d/info", $userId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        // 確認是否修改成功
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), $input['sticker_type']);
        $this->assertTrue($user->verifyPassword($input['new_password']));
    }

    /**
     * 測試以API修改使用者資訊
     * (fail:不存在的ID)
     * @return void
     */
    public function testUserModifyByIdExist()
    {
        // 設定要修改的使用者，不存在的ID
        $userId = 999;

        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users/%d/info", $userId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API修改使用者資訊
     * (fail:無效的ID)
     * @return void
     */
    public function testUserModifyByIdInvalid()
    {
        // 設定要修改的使用者，無效的ID
        $userId = 0;

        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users/%d/info", $userId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);
    }

    /**
     * 測試以API修改使用者資訊
     * (fail:確認密碼有誤)
     * @return void
     */
    public function testUserModifyByUnmatched()
    {
        // 設定要修改的使用者
        $userId = 2;

        // 確認修改前資料
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));

        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 1234;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users/%d/info", $userId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNMATCHED_PASSWORD);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
     * 測試以API修改使用者資訊
     * (fail:新密碼輸入空值)
     * @return void
     */
    public function testUserModifyByEmptyPassword()
    {
        // 設定要修改的使用者
        $userId = 2;

        // 確認修改前資料
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));

        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = '';
        $input['confirm_password'] = 1234;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users/%d/info", $userId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
 * 測試以API修改使用者資訊
 * (fail:密碼確認輸入空值)
 * @return void
 */
    public function testUserModifyByEmptyConfirmPassword()
    {
        // 設定要修改的使用者
        $userId = 2;

        // 確認修改前資料
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));

        // 設定input
        $input = array();
        $input['sticker_type'] = 1;
        $input['new_password'] = 1234;
        $input['confirm_password'] = '';

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users/%d/info", $userId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
     * 測試以API修改使用者資訊
     * (fail:沒有參數)
     * @return void
     */
    public function testUserModifyByNullValue()
    {
        // 設定要修改的使用者
        $userId = 2;

        // 確認修改前資料
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));

        // 設定input，沒有參數
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users/%d/info", $userId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
     * 測試以API修改使用者資訊
     * (fail:無效的頭像類型)
     * @return void
     */
    public function testUserModifyByInvalidStickerType()
    {
        // 設定要修改的使用者
        $userId = 2;

        // 確認修改前資料
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));

        // 設定input，沒有參數
        $input = array();
        $input['sticker_type'] = 999;
        $input['new_password'] = 5678;
        $input['confirm_password'] = 5678;

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users/%d/info", $userId);

        // 呼叫API
        $response = $this->json('PATCH', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_STICKER_TYPE);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認使用者資訊是否不變
        $user = UserModel::getById($userId);
        $this->assertEquals($user->getStickerType(), 3);
        $this->assertTrue($user->verifyPassword(1234));
    }

    /**
     * 測試以API批量刪除使用者
     * @return void
     */
    public function testDeleteUsers()
    {
        // 確認刪除前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['ids'] = [2,3];

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_204_NO_CONTENT
            , $response->getStatusCode());

        // 確認刪除後筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(2, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(4, $userLists[1]->getId());
    }

    /**
     * 測試以API批量刪除使用者
     * (Fail:ids中包含管理員)
     * @return void
     */
    public function testDeleteUsersIncludeSuperUser()
    {
        // 確認刪除前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['ids'] = [1,3];

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNDELETABLE);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認刪除後筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API批量刪除使用者
     * (Fail:ids中包含無效id)
     * @return void
     */
    public function testDeleteUsersByIdInvalid()
    {
        // 確認刪除前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['ids'] = [0,3];

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認刪除後筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API批量刪除使用者
     * (Fail:ids為空值)
     * @return void
     */
    public function testDeleteUsersByIdsEmpty()
    {
        // 確認刪除前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認刪除後筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }

    /**
     * 測試以API批量刪除使用者
     * (Fail:輸入ids非數字)
     * @return void
     */
    public function testDeleteUsersByIdsIsNotInt()
    {
        // 確認刪除前筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());

        // 設定input
        $input = array();
        $input['ids'] = ['二',3];

        // 設定Header
        $header = $this->header;

        // 設定API路徑
        $path = sprintf("/api/admin/users");

        // 呼叫API
        $response = $this->json('DELETE', $path, $input, $header);

        // 確認回應的狀態碼是否正確
        $this->assertEquals(HttpStatusCode::STATUS_400_BAD_REQUEST
            , $response->getStatusCode());

        // 回應的Json格式字串，轉成array後檢查內容是否符合預期。
        $contents = json_decode($response->getContent(), true);
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals($error->convertToDisplayArray(), $contents);

        // 確認刪除後筆數
        $userLists = UserModel::getAllList();
        $this->assertCount(4, $userLists);
        $this->assertEquals(1, $userLists[0]->getId());
        $this->assertEquals(2, $userLists[1]->getId());
        $this->assertEquals(3, $userLists[2]->getId());
        $this->assertEquals(4, $userLists[3]->getId());
    }
}
