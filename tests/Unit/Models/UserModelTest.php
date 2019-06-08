<?php namespace Tests;

use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Models\UserModel;
use App\Classes\User;

class UserModelTest extends DatabaseTestCase
{
    private $content = array();

    /**
     * 設定比對用的資料
     * @return array
     */
    public function generateUserContent()
    {
        $this->content = array();

        $this->content[0]['ixUser'] = 1;
        $this->content[0]['sUsername'] = 'Admin';
        $this->content[0]['nStickerType'] = 1;
        $this->content[0]['sDescription'] = '管理員';
        $this->content[0]['dtCreate'] = '2018-11-14 14:10:27';
        $this->content[0]['dtUpdate'] = '2018-11-14 14:10:27';

        $this->content[1]['ixUser'] = 2;
        $this->content[1]['sUsername'] = 'test2';
        $this->content[1]['nStickerType'] = 2;
        $this->content[1]['sDescription'] = '';
        $this->content[1]['dtCreate'] = '2018-11-15 14:10:27';
        $this->content[1]['dtUpdate'] = '2018-11-15 14:10:27';

        $this->content[2]['ixUser'] = 3;
        $this->content[2]['sUsername'] = 'test3';
        $this->content[2]['nStickerType'] = 3;
        $this->content[2]['sDescription'] = '';
        $this->content[2]['dtCreate'] = '2018-11-16 14:10:27';
        $this->content[2]['dtUpdate'] = '2018-11-16 14:10:27';

        return $this->content;
    }

    /**
     * 測試以 id 取得使用者資料
     * @return void
     */
    public function testGetById()
    {
        $content = $this->generateUserContent();
        $user = UserModel::getById(2);
        $this->asserutEquals($content, $user->toArray());
        $this->asserutEquals($content['ixUser'], $user->getId());
        $this->asserutEquals($content['sUsername'], $user->getUsername());
        $this->asserutEquals($content['nStickerType'], $user->getStickerType());
        $this->asserutEquals($content['sDescription'], $user->getDescription());
        $this->asserutEquals($content['dtCreate'], $user->getDtCreate());
        $this->asserutEquals($content['dtUpdate'], $user->getDtUpdate());
    }

    /**
     * 測試取得使用者資料(fail:無效的id)
     * @return void
     */
    public function testGetByNotValidId()
    {
        $user = UserModel::getById(0);
        $this->assertEquals(new User(), $user);
        $user = UserModel::getById(-1);
        $this->assertEquals(new User(), $user);
    }

    /**
     * 測試取得使用者資料(fail:不存在於資料表的id)
     * @return void
     */
    public function testGetByNotExistId()
    {
        $user = UserModel::getById(99999);
        $this->assertEquals(new User(), $user);
    }

    /**
     * 測試以 username 取得使用者資料
     * @return void
     */
    public function testGetByUsername()
    {
        $content = $this->generateUserContent();
        $user = UserModel::getByName('test2');
        $this->asserutEquals($content, $user->toArray());
        $this->asserutEquals($content['ixUser'], $user->getId());
        $this->asserutEquals($content['sUsername'], $user->getUsername());
        $this->asserutEquals($content['nStickerType'], $user->getStickerType());
        $this->asserutEquals($content['sDescription'], $user->getDescription());
        $this->asserutEquals($content['dtCreate'], $user->getDtCreate());
        $this->asserutEquals($content['dtUpdate'], $user->getDtUpdate());
    }

    /**
     * 測試取得使用者資料(fail:無效的名稱)
     * @return void
     */
    public function testGetByNotValidName()
    {
        $user = UserModel::getByName('');
        $this->assertEquals(new User(), $user);
    }

    /**
     * 測試取得使用者資料(fail:無效的名稱)
     * @return void
     */
    public function testGetByNotExistName()
    {
        $user = UserModel::getByName('noexist');
        $this->assertEquals(new User(), $user);
    }

    /**
     * 測試取得所有使用者資料
     * @return void
     */
    public function testGetAllList()
    {
        $content = $this->generateUserContent();
        $user = UserModel::getAllList();
        $this->assertCount(3, $user);
        $this->assertEquals($content, $user[1]->toArray());
    }

    /**
     * 設定使用者驗證資料
     * @return User
     */
    public function generateValidUser()
    {
        $user = new User();
        $user->setUsername('test123');
        $user->setStickerType(1);
        $user->setDescription('test');
        $this->assertTrue($user->isValid());
        return $user;
    }

    /**
     * 測試新增使用者功能
     * @return void
     */
    public function testAdd()
    {
        // 確認新增前資料筆數與編號
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $user = $this->generateValidUser();
        $sPassword = '123';

        // 確認使用者名稱是否還不存在於資料庫
        $this->assertFalse(UserModel::isUsernameExist($user->getUsername()));

        // 新增資料，確認回傳無錯誤
        list($isSuccess, $error) = UserModel::registerUser($user, $sPassword);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getCode());

        // 取得目前使用者清單與編號，已多一筆資料
        $lists = UserModel::getAllList();
        $this->assertCount(4, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());
        $this->assertEquals(4, $lists[3]->getId());

        // 比對新增資料是否相符
        $this->assertEquals($user->getUsername(), $lists[3]->getUsername());
        $this->assertEquals($user->getStickerType(), $lists[3]->getStickerType());
        $this->assertEquals($user->getDescription(), $lists[3]->getDescription());
    }

    /**
     * 測試新增使用者 (Fail:重複的使用者名稱)
     * @return void
     */
    public function testAddByDuplicateUsername()
    {
        // 確認新增前資料筆數與編號
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $user = $this->generateValidUser();

        // 設定重複的使用者名稱
        $user->setUsername('code');
        $sPassword = '123';

        // 確認使用者名稱是否還不存在於資料庫
        $this->assertFalse(UserModel::isUsernameExist($user->getUsername()));

        // 測試新增使用者，接收錯誤: 使用者名稱已經存在
        list($isSuccess, $error) = UserModel::registerUser($user, $sPassword);
        $this->assertEquals(false, $isSuccess);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_EXISTED_USERNAME, $error->getCode());

        // 取得目前使用者清單，資料沒有改變
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());
    }

    /**
     * 測試新增使用者 (Fail:使用者名稱為空)
     * @return void
     */
    public function testAddByEmptyName()
    {
        // 確認新增前資料筆數與編號
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $user = $this->generateValidUser();

        // 設定使用者名稱為空
        $user->setUsername('');
        $sPassword = '123';

        // 測試新增使用者，接收錯誤: 使用者名稱為空
        list($isSuccess, $error) = UserModel::registerUser($user, $sPassword);
        $this->assertEquals(false, $isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getCode());

        // 取得目前使用者清單，資料沒有改變
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());
    }

    /**
     * 測試新增使用者 (Fail:密碼為空)
     * @return void
     */
    public function testAddByEmptyPassword()
    {
        // 確認新增前資料筆數與編號
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $user = $this->generateValidUser();

        // 設定密碼為空
        $sPassword = '';

        // 測試新增使用者，接收錯誤: 密碼為空
        list($isSuccess, $error) = UserModel::registerUser($user, $sPassword);
        $this->assertEquals(false, $isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getCode());

        // 取得目前使用者清單，資料沒有改變
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());
    }

    /**
     * 測試新增使用者 (Fail:無效的使用者頭像類型)
     * @return void
     */
    public function testAddByEmptyStickerType()
    {
        // 確認新增前資料筆數與編號
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $user = $this->generateValidUser();

        // 設定無效的使用者頭像類型
        $user->setStickerType(8);
        $sPassword = '123';

        // 確認使用者頭像類型是否無效
        $this->assertFalse(User::isValidType($user->getStickerType()));

        // 測試新增使用者，接收錯誤: 使用者頭像類型無效
        list($isSuccess, $error) = UserModel::registerUser($user, $sPassword);
        $this->assertEquals(false, $isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());

        // 取得目前使用者清單，資料沒有改變
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());
    }

    /**
     * 測試修改使用者密碼
     * @return void
     */
    public function testModifyPassword()
    {
        // 確認新增前資料筆數與編號
        $lists = UserModel::getAllList();
        $this->assertCount(3, $lists);
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $userId = 2;
        $sPassword = '456';

        // 測試修改使用者密碼，確認回傳無錯誤
        list($isSuccess, $error) = UserModel::modifyPassword($userId, $sPassword);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getCode());

        // 比對修改後資料是否相符
        $lists = UserModel::getAllList();
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertTrue($lists[1]->verifyPassword('456'));
    }

    /**
     * 測試修改使用者密碼 (Fail:密碼為空)
     * @return void
     */
    public function testModifyPasswordByEmpty()
    {
        // 確認新增前資料筆數與編號
        $lists = UserModel::getAllList();
        $this->assertCount(1, $lists);
        $this->assertEquals(2, $lists[0]->getId());

        // 設定密碼為空字串
        $userId = 2;
        $sPassword = '';

        // 測試修改使用者密碼，接收錯誤:輸入有空值
        list($isSuccess, $error) = UserModel::modifyPassword($userId, $sPassword);
        $this->assertEquals(false, $isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getCode());

        // 取得目前使用者清單，資料沒有改變
        $lists = UserModel::getAllList();
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertTrue($lists[1]->verifyPassword('123'));
    }

    /**
     * 測試修改使用者密碼 (Fail:使用者不存在)
     * @return void
     */
    public function testModifyPasswordByExist()
    {
        // 設定無使用者的ID
        $userId = 5;
        $sPassword = '123';

        // 測試修改使用者密碼，接收錯誤:取得ID失敗
        list($isSuccess, $error) = UserModel::modifyPassword($userId, $sPassword);
        $this->assertEquals(false, $isSuccess);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_FAILED_GET_ID, $error->getCode());
    }

    /**
     * 測試批量刪除使用者功能
     * @return void
     */
    public function testDeleteUsers()
    {
        // 確認刪除前資料筆數
        $lists = UserModel::getAllList();
        $this->assertCount(2, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $ids = array(2,3);

        // 測試刪除使用者
        list($isSuccess, $error) = UserModel::deleteUsers($ids);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getCode());

        // 確認刪除後資料筆數
        $lists = UserModel::getAllList();
        $this->assertEquals(1, count($lists));

        // 確認ID編號
        $this->assertEquals(1, $lists[0]->getId());
    }

    /**
     * 測試批量刪除使用者功能 (Fail:ID中有管理員)
     * @return void
     */
    public function testDeleteUsersIncludeSuperUser()
    {
        // 確認刪除前資料筆數
        $lists = UserModel::getAllList();
        $this->assertCount(2, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $ids = array(1,3);

        // 測試刪除使用者，接收錯誤:不可被刪除
        list($isSuccess, $error) = UserModel::deleteUsers($ids);
        $this->assertTrue($isSuccess);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNDELETABLE, $error->getCode());

        // 確認刪除後資料筆數沒有改變
        $lists = UserModel::getAllList();
        $this->assertEquals(3, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getid());
        $this->assertEquals(2, $lists[1]->getid());
        $this->assertEquals(3, $lists[2]->getid());
    }

    /**
     * 測試批量刪除使用者功能 (Fail:有無效的ID)
     * @return void
     */
    public function testDeleteUsersByIdInvalid()
    {
        // 確認刪除前資料筆數
        $lists = UserModel::getAllList();
        $this->assertCount(2, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $ids = array(3,5);

        // 測試刪除使用者，接收錯誤:無效的參數
        list($isSuccess, $error) = UserModel::deleteUsers($ids);
        $this->assertTrue($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());

        // 確認刪除後資料筆數沒有改變
        $lists = UserModel::getAllList();
        $this->assertEquals(3, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getid());
        $this->assertEquals(2, $lists[1]->getid());
        $this->assertEquals(3, $lists[2]->getid());
    }

    /**
     * 測試批量刪除使用者功能 (Fail:輸入空值)
     * @return void
     */
    public function testDeleteUsersIdsIsEmpty()
    {
        // 確認刪除前資料筆數
        $lists = UserModel::getAllList();
        $this->assertCount(2, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $ids = array();

        // 測試刪除使用者，接收錯誤:輸入空值
        list($isSuccess, $error) = UserModel::deleteUsers($ids);
        $this->assertTrue($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getCode());

        // 確認刪除後資料筆數沒有改變
        $lists = UserModel::getAllList();
        $this->assertEquals(3, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getid());
        $this->assertEquals(2, $lists[1]->getid());
        $this->assertEquals(3, $lists[2]->getid());
    }

    /**
     * 測試批量刪除使用者功能 (Fail:輸入id非數字)
     * @return void
     */
    public function testDeleteUsersIdsIsNotInt()
    {
        // 確認刪除前資料筆數
        $lists = UserModel::getAllList();
        $this->assertCount(2, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getId());
        $this->assertEquals(2, $lists[1]->getId());
        $this->assertEquals(3, $lists[2]->getId());

        $ids = array('一',2);

        // 測試刪除使用者，接收錯誤:輸入空值
        list($isSuccess, $error) = UserModel::deleteUsers($ids);
        $this->assertTrue($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());

        // 確認刪除後資料筆數沒有改變
        $lists = UserModel::getAllList();
        $this->assertEquals(3, count($lists));

        // 確認三筆ID編號
        $this->assertEquals(1, $lists[0]->getid());
        $this->assertEquals(2, $lists[1]->getid());
        $this->assertEquals(3, $lists[2]->getid());
    }

    /**
     * 測試檢查使用者名稱是否存在
     * @return void
     */
    public function testUsernameIsExist()
    {
        $this->assertTrue(UserModel::isUsernameExist('test2'));
        $this->assertFalse(UserModel::isUsernameExist('noexist'));
    }

    /**
     * 測試檢查該ID的使用者是否存在
     * @return void
     */
    public function testIsExist()
    {
        $this->assertTrue(UserModel::isExist(1));
        $this->assertFalse(UserModel::isExist(0));
        $this->assertTrue(UserModel::isExist(5));
    }

    /**
     * 測試使用者登入
     * @return void
     */
    public function testLogin()
    {
        // 設定有效的資料
        $account = 'testuser';
        $password = '1234';

        // 判斷輸入的帳號是否不存在於資料庫中
        $user = UserModel::getByName($account);
        $this->assertEquals(new User(), $user);

        // 取得目前資料筆數
        $this->assertCount(3, UserModel::getAllList());

        // 登入前判斷是否尚未登入，登入後判斷是否有紀錄session
        $this->assertFalse(UserModel::isLogin());
        list($isSuccess, $error) = UserModel::login($account, $password);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getcode());
        $this->assertTrue(session()->has('userId'));
        $this->assertTrue(UserModel::isLogin());

        // 登出後再次登入
        UserModel::logout();
        $this->assertFalse(session()->has('userId'));

        list($isSuccess, $error) = UserModel::login($account, $password);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getcode());
        $this->assertTrue(session()->has('userId'));
        $this->assertTrue(UserModel::isLogin());
    }

    /**
     * 測試使用者登入 (Fail:無效的使用者名稱)
     * @return void
     */
    public function testLoginByInvalidUsername()
    {
        // 設定無效的資料 (名稱為空值)
        $account = '';
        $password = '1234';

        // 登入前判斷是否尚未登入
        $this->assertFalse(UserModel::isLogin());

        // 測試使用者登入，接收錯誤: 輸入空值'
        list($isSuccess, $error) = UserModel::login($account, $password);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getcode());

        // 確認無登入
        $this->assertFalse(UserModel::isLogin());

        // 設定無效的資料 (名稱過長)
        $account = 'fewmflmwelvmwelqvmwlqelmvvewqmfkqw';
        $password = '1234';

        // 登入前判斷是否尚未登入
        $this->assertFalse(UserModel::isLogin());

        // 測試使用者登入，接收錯誤: 無效的參數'
        list($isSuccess, $error) = UserModel::login($account, $password);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getcode());

        // 確認無登入
        $this->assertFalse(UserModel::isLogin());
    }

    /**
     * 測試使用者登入 (Fail:無效的密碼)
     * @return void
     */
    public function testLoginByInvalidPassword()
    {
        // 設定無效的資料 (密碼為空值)
        $account = 'test2';
        $password = '';

        // 登入前判斷是否尚未登入
        $this->assertFalse(UserModel::isLogin());

        // 測試使用者登入，接收錯誤: 輸入空值'
        list($isSuccess, $error) = UserModel::login($account, $password);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getcode());

        // 確認無登入
        $this->assertFalse(UserModel::isLogin());

        // 設定無效的資料 (無效的密碼)
        $account = 'test2';
        $password = '456';

        // 登入前判斷是否尚未登入
        $this->assertFalse(UserModel::isLogin());

        // 測試使用者登入，接收錯誤: 密碼輸入有誤'
        list($isSuccess, $error) = UserModel::login($account, $password);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_INCORRECT_PASSWORD, $error->getcode());

        // 確認無登入
        $this->assertFalse(UserModel::isLogin());
    }

    /**
     * 測試取得當前登入的使用者
     * @return void
     */
    public function testGetCurrentLoginUser()
    {
        // 登入前判斷是否尚未登入
        $this->assertFalse(UserModel::isLogin());

        // 取得當前使用者，無資料
        $result = UserModel::getCurrentLoginUser();
        $this->assertEquals(0, $result->getId());

        //使用者登入
        UserModel::login('test2', '123');
        $this->assertTrue(UserModel::isLogin());

        // 取得當前使用者，確認資料是否正確
        $result = UserModel::getCurrentLoginUser();
        $this->assertEquals(2, $result->getId());
        $this->assertEquals('test2', $result->getUsername());
    }
}
