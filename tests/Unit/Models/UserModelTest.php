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
        $this->content[0]['sUsername'] = 'admin';
        $this->content[0]['nStickerType'] = 1;
        $this->content[0]['sDescription'] = '管理員';
        $this->content[0]['dtCreate'] = '2019-05-21 23:00:00';
        $this->content[0]['dtUpdate'] = '2019-05-21 23:00:00';

        $this->content[1]['ixUser'] = 2;
        $this->content[1]['sUsername'] = 'imily';
        $this->content[1]['nStickerType'] = 3;
        $this->content[1]['sDescription'] = '';
        $this->content[1]['dtCreate'] = '2011-11-11 00:00:00';
        $this->content[1]['dtUpdate'] = '2011-11-12 00:00:00';

        $this->content[2]['ixUser'] = 3;
        $this->content[2]['sUsername'] = 'Mary';
        $this->content[2]['nStickerType'] = 1;
        $this->content[2]['sDescription'] = '';
        $this->content[2]['dtCreate'] = '2011-11-12 00:00:00';
        $this->content[2]['dtUpdate'] = '2011-11-13 00:00:00';
        return $this->content;
    }

    /**
     * 設定使用者驗證資料
     * @return User
     */
    protected function generateValidUser()
    {
        $user = new User();
        $user->setUsername('testUser');
        $user->setStickerType(2);
        $user->setDescription('fot test');
        $this->assertTrue($user->isValid());
        return $user;
    }

//    /**
//     * 測試取得使用者資料
//     * @return void
//     */
//    public function testGetById()
//    {
//        $content = $this->generateUserContent();
//        $user = UserModel::getById(1);
//        $this->assertEquals($content[0], $user->toArray());
//        $this->assertEquals($content[0]['ixUser'], $user->getId());
//        $this->assertEquals($content[0]['sUsername'], $user->getUsername());
//        $this->assertEquals($content[0]['nStickerType'], $user->getStickerType());
//        $this->assertEquals($content[0]['sDescription'], $user->getDescription());
//        $this->assertEquals($content[0]['dtCreate'], $user->getDtCreate());
//        $this->assertEquals($content[0]['dtUpdate'], $user->getDtUpdate());
//    }
//
//    /**
//     * 測試取得使用者資料
//     * (fail:無效的id)
//     * @return void
//     */
//    public function testGetByNotValidId()
//    {
//        $user = UserModel::getById(0);
//        $this->assertEquals(new User(), $user);
//
//        $user = UserModel::getById(-1);
//        $this->assertEquals(new User(), $user);
//    }
//
//    /**
//     * 測試取得使用者資料
//     * (fail:不存在於資料表的id)
//     * @return void
//     */
//    public function testGetByNotExistId()
//    {
//        $user = UserModel::getById(9999);
//        $this->assertEquals(new User(), $user);
//    }
//
//    /**
//     * 測試取得使用者資料
//     * @return void
//     */
//    public function testGetByName()
//    {
//        $content = $this->generateUserContent();
//        $user = UserModel::getByName('admin');
//        $this->assertEquals($content[0], $user->toArray());
//        $this->assertEquals($content[0]['ixUser'], $user->getId());
//        $this->assertEquals($content[0]['sUsername'], $user->getUsername());
//        $this->assertEquals($content[0]['nStickerType'], $user->getStickerType());
//        $this->assertEquals($content[0]['sDescription'], $user->getDescription());
//        $this->assertEquals($content[0]['dtCreate'], $user->getDtCreate());
//        $this->assertEquals($content[0]['dtUpdate'], $user->getDtUpdate());
//    }
//
//    /**
//     * 測試取得使用者資料
//     * (fail:無效的名稱)
//     * @return void
//     */
//    public function testGetByNotValidName()
//    {
//        $user = UserModel::getByName('');
//        $this->assertEquals(new User(), $user);
//    }
//
//    /**
//     * 測試取得使用者資料
//     * (fail:不存在於資料表的名稱)
//     * @return void
//     */
//    public function testGetByNotExistName()
//    {
//        $user = UserModel::getByName('notExist');
//        $this->assertEquals(new User(), $user);
//    }
//
//    /**
//     * 測試取得所有使用者資料
//     * @return void
//     */
//    public function testGetByGetAllList()
//    {
//        $content = $this->generateUserContent();
//        $user = UserModel::getAllList();
//        $this->assertCount(4, $user);
//        $this->assertEquals($content[0], $user[0]->toArray());
//    }
//
//    /**
//     * 測試依照userIds取得資料
//     * @return void
//     */
//    public function testGetListByIds()
//    {
//        $ids = array(1, 2, 3);
//        $lists = UserModel::getByIds($ids);
//
//        // 取得比對用的資料
//        $userContents = $this->generateUserContent();
//        $users = array();
//        foreach ($userContents as $userContent) {
//            $user = new User($userContent);
//            $users[] = $user;
//        }
//
//        // 確認資料筆數是否相同
//        $this->assertCount(3, $lists);
//
//        // 驗證密碼
//        $this->assertTrue($lists[0]->verifyPassword('messagepassword'));
//        $this->assertFalse($lists[0]->verifyPassword('123'));
//        $this->assertTrue($lists[1]->verifyPassword('1234'));
//        $this->assertFalse($lists[1]->verifyPassword('555'));
//        $this->assertTrue($lists[2]->verifyPassword('1234'));
//        $this->assertFalse($lists[2]->verifyPassword('555'));
//
//        // 確認資料內容是否相符
////        $this->assertEquals($users[0], $lists[0]);
////        $this->assertEquals($users[1], $lists[1]);
////        $this->assertEquals($users[2], $lists[2]);
//
//        //測試資料格式是否正確
//        $this->assertTrue($lists[0]->isValid());
//        $this->assertTrue($lists[1]->isValid());
//        $this->assertTrue($lists[2]->isValid());
//    }
//
//    /**
//     * 測試依照UserIds取得資料
//     * (fail:ids包含錯誤參數)
//     * @return void
//     */
//    public function testGetListByUserIdsFail()
//    {
//        // 設定ids中參數包含0
//        $ids = array(0, 1);
//        $lists = UserModel::getByIds($ids);
//        // 確認回傳空陣列
//        $this->assertEquals(array(), $lists);
//
//        // 設定ids中參數包含負數
//        $ids = array(-2, 1);
//        $lists = UserModel::getByIds($ids);
//        // 確認回傳空陣列
//        $this->assertEquals(array(), $lists);
//
//        // 設定ids中參數包含非數字參數
//        $ids = array(1, '二');
//        $lists = UserModel::getByIds($ids);
//        // 確認回傳空陣列
//        $this->assertEquals(array(), $lists);
//    }
//
//    /**
//     * 測試註冊使用者
//     * @return void
//     */
//    public function testRegisterUser()
//    {
//        // 確認新增前資料筆數與編號
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $user = $this->generateValidUser();
//        $password = '4567';
//
//        // 確認使用者名稱是否還不存在於資料庫
//        $this->assertFalse(UserModel::isUsernameExist($user->getUsername()));
//
//        // 新增資料，確認回傳無錯誤
//        list($isSuccess, $error) = UserModel::registerUser($user, $password);
//        $this->assertTrue($isSuccess);
//        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
//
//        // 取得目前使用者清單與編號，已多一筆資料
//        $lists = UserModel::getAllList();
//        $this->assertCount(5, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//        $this->assertEquals(5, $lists[4]->getId());
//
//        // 比對新增資料是否相符
//        $this->assertEquals($user->getUsername(), $lists[4]->getUsername());
//        $this->assertEquals($user->getStickerType(), $lists[4]->getStickerType());
//        $this->assertEquals($user->getDescription(), $lists[4]->getDescription());
//    }
//
//    /**
//     * 測試新增使用者
//     * (Fail:使用者名稱重複)
//     * @return void
//     */
//    public function testRegisterUserByDuplicateUsername()
//    {
//        // 確認新增前資料筆數與編號
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $user = $this->generateValidUser();
//
//        // 設定重複的使用者名稱
//        $user->setUsername('imily');
//        $password = 1234;
//
//        // 驗證輸入的信箱是否已存在於資料庫
//        $this->assertTrue(UserModel::isUsernameExist($user->getUsername()));
//
//        list($isSuccess, $error) = UserModel::registerUser($user, $password);
//        $this->assertEquals(false, $isSuccess);
//        $this->assertEquals(ErrorAuth::ERROR_AUTH_EXISTED_USERNAME, $error->getCode());
//
//        // 取得目前使用者清單，資料沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//    }
//
//    /**
//     * 測試新增使用者
//     * (Fail:username為空)
//     * @return void
//     */
//    public function testRegisterUserByEmptyUsername()
//    {
//        // 確認新增前資料筆數與編號
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $user = $this->generateValidUser();
//
//        // 設定username欄位為空字串
//        $user->setUsername('');
//        $password = 1234;
//
//        list($isSuccess, $error) = UserModel::registerUser($user, $password);
//        $this->assertEquals(false, $isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 取得目前使用者清單，資料沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//    }
//
//    /**
//     * 測試新增使用者
//     * (Fail:password為空)
//     * @return void
//     */
//    public function testRegisterUserByEmptyPassword()
//    {
//        // 確認新增前資料筆數與編號
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $user = $this->generateValidUser();
//
//        // 設定password欄位為空字串
//        $password = '';
//
//        list($isSuccess, $error) = UserModel::registerUser($user, $password);
//        $this->assertEquals(false, $isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getCode());
//
//        // 取得目前使用者清單，資料沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//    }
//
//    /**
//     * 測試新增使用者
//     * (Fail:無效的頭像類型)
//     * @return void
//     */
//    public function testRegisterUserByInvalidStickerType()
//    {
//        // 確認新增前資料筆數與編號
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $user = $this->generateValidUser();
//        // 設定錯誤的頭像類型
//        $user->setStickerType(999);
//        $password = 1234;
//
//        list($isSuccess, $error) = UserModel::registerUser($user, $password);
//        $this->assertEquals(false, $isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 取得目前使用者清單，資料沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertCount(4, $lists);
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//    }
//
//    /**
//     * 測試修改使用者資訊
//     * @return void
//     */
//    public function testModifyName()
//    {
//        // 確認修改前的資料
//        $lists = UserModel::getAllList();
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[1]->getStickerType());
//        $this->assertTrue($lists[1]->verifyPassword('1234'));
//
//        $user = $this->generateValidUser();
//        $user->setId(2);
//        // 設定新的頭像類型
//        $user->setStickerType(5);
//        // 設定新的密碼
//        $newPassword = '5678';
//
//        // 測試修改使用者，確認回傳無錯誤
//        list($isSuccess, $error) = UserModel::modify($user, $newPassword);
//        $this->assertTrue($isSuccess);
//        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
//
//        // 比對修改後資料是否相符
//        $lists = UserModel::getAllList();
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(5, $lists[1]->getStickerType());
//        $this->assertTrue($lists[1]->verifyPassword('5678'));
//    }
//
//    /**
//     * 測試修改使用者資訊
//     *  (Fail:密碼為空)
//     * @return void
//     */
//    public function testModifyByEmptyPassword()
//    {
//        // 確認修改前的資料
//        $lists = UserModel::getAllList();
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertTrue($lists[1]->verifyPassword('1234'));
//
//        $user = $this->generateValidUser();
//        $user->setId(2);
//        $user->setStickerType(5);
//        // 設定密碼為空字串
//        $newPassword = '';
//
//        // 測試修改使用者資訊，接收錯誤:輸入有空值
//        list($isSuccess, $error) = UserModel::modify($user, $newPassword);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getCode());
//
//        // 取得目前使用者清單，資料沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertTrue($lists[1]->verifyPassword('1234'));
//    }
//
//    /**
//     * 測試修改使用者資訊
//     * (Fail:使用者不存在)
//     * @return void
//     */
//    public function testModifyByUserNotExist()
//    {
//        $user = $this->generateValidUser();
//        // 設定無使用者的ID
//        $user->setId(10);
//        $user->setStickerType(5);
//        $newPassword = '5678';
//
//        // 測試修改使用者資訊，接收錯誤:取得ID失敗
//        list($isSuccess, $error) = UserModel::modify($user, $newPassword);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorAuth::ERROR_AUTH_FAILED_GET_ID, $error->getCode());
//    }
//
//    /**
//     * 測試批量刪除使用者功能
//     * @return void
//     */
//    public function testDelete()
//    {
//        // 確認刪除前資料筆數
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $ids = array(2,3);
//
//        // 測試批量刪除使用者
//        list($isSuccess, $error) = UserModel::deleteUsers($ids);
//        $this->assertTrue($isSuccess);
//        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
//
//        // 確認刪除後資料筆數
//        $lists = UserModel::getAllList();
//        $this->assertEquals(2, count($lists));
//
//        // 確認ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(4, $lists[1]->getId());
//    }
//
//    /**
//     * 測試批量刪除使用者功能
//     * (Fail:ID中有管理員)
//     * @return void
//     */
//    public function testDeleteIncludeSuperUser()
//    {
//        // 確認刪除前資料筆數
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $ids = array(1,3);
//
//        // 測試刪除使用者，接收錯誤:不可被刪除
//        list($isSuccess, $error) = UserModel::deleteUsers($ids);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNDELETABLE, $error->getCode());
//
//        // 確認刪除後資料筆數沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//    }
//
//    /**
//     * 測試批量刪除使用者功能
//     * (Fail:有無效的ID)
//     * @return void
//     */
//    public function testDeleteByIdInvalid()
//    {
//        // 確認刪除前資料筆數
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $ids = array(0,3);
//
//        // 測試刪除使用者，接收錯誤:無效的參數
//        list($isSuccess, $error) = UserModel::deleteUsers($ids);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 確認刪除後資料筆數沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//    }
//
//    /**
//     * 測試批量刪除使用者功能
//     * (Fail:輸入空值)
//     * @return void
//     */
//    public function testDeleteByIdsIsEmpty()
//    {
//        // 確認刪除前資料筆數
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $ids = array();
//
//        // 測試刪除使用者，接收錯誤:無效的參數
//        list($isSuccess, $error) = UserModel::deleteUsers($ids);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getCode());
//
//        // 確認刪除後資料筆數沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//    }
//
//    /**
//     * 測試批量刪除使用者功能
//     * (Fail:輸入id非數字)
//     * @return void
//     */
//    public function testDeleteByIdsIsNotInt()
//    {
//        // 確認刪除前資料筆數
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//
//        $ids = array('一',2);
//
//        // 測試刪除使用者，接收錯誤:無效的參數
//        list($isSuccess, $error) = UserModel::deleteUsers($ids);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 確認刪除後資料筆數沒有改變
//        $lists = UserModel::getAllList();
//        $this->assertEquals(4, count($lists));
//
//        // 確認四筆ID編號
//        $this->assertEquals(1, $lists[0]->getId());
//        $this->assertEquals(2, $lists[1]->getId());
//        $this->assertEquals(3, $lists[2]->getId());
//        $this->assertEquals(4, $lists[3]->getId());
//    }
//
//    /**
//     * 測試檢查使用者名稱是否存在
//     * @return void
//     */
//    public function testUsernameIsExist()
//    {
//        $this->assertTrue(UserModel::isUsernameExist('imily'));
//        $this->assertTrue(UserModel::isUsernameExist('Mary'));
//    }
//
//    /**
//     * 測試檢查該ID的使用者是否存在
//     * @return void
//     */
//    public function testIsExist()
//    {
//        $this->assertTrue(UserModel::isExist(1));
//        $this->assertFalse(UserModel::isExist(0));
//        $this->assertFalse(UserModel::isExist(5));
//    }
}
