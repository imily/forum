<?php namespace Tests;

use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\User;
use App\Models\MessageModel;
use App\Classes\Message;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Repositories\Filter;

class MessageModelTest extends DatabaseTestCase
{
    private $messagesContent = array();
    private $usersContent = array();

    /**
     * 設定message比對用的資料
     * @return array
     */
    public function generateMessageContent()
    {
        $this->messagesContent = array();
        $this->messagesContent[0]['ixMessage'] = 1;
        $this->messagesContent[0]['ixUser'] = 1;
        $this->messagesContent[0]['sDescription'] = 'description01';
        $this->messagesContent[0]['dtCreate'] = '2011-11-11 00:00:00';
        $this->messagesContent[0]['dtUpdate'] = '2011-11-12 00:00:00';

        $this->messagesContent[1]['ixMessage'] = 2;
        $this->messagesContent[1]['ixUser'] = 2;
        $this->messagesContent[1]['sDescription'] = 'description02';
        $this->messagesContent[1]['dtCreate'] = '2011-11-12 00:00:00';
        $this->messagesContent[1]['dtUpdate'] = '2011-11-13 00:00:00';

        $this->messagesContent[2]['ixMessage'] = 3;
        $this->messagesContent[2]['ixUser'] = 3;
        $this->messagesContent[2]['sDescription'] = 'description03';
        $this->messagesContent[2]['dtCreate'] = '2011-11-13 00:00:00';
        $this->messagesContent[2]['dtUpdate'] = '2011-11-14 00:00:00';

        return $this->messagesContent;
    }

    /**
     * 設定user比對用的資料
     * @return array
     */
    public function generateUserContent()
    {
        $this->usersContent = array();

        $this->usersContent[0]['ixUser'] = 1;
        $this->usersContent[0]['sUsername'] = 'admin';
        $this->usersContent[0]['sPassword'] = '$2y$10$Punyvr5uKY/oIbzXqYboGOwxpkk7ENnD12FxTJ4QVw334EBx1eZZW';
        $this->usersContent[0]['nStickerType'] = 1;
        $this->usersContent[0]['sDescription'] = '管理員';
        $this->usersContent[0]['dtCreate'] = '2019-05-21 23:00:00';
        $this->usersContent[0]['dtUpdate'] = '2019-05-21 23:00:00';

        $this->usersContent[1]['ixUser'] = 2;
        $this->usersContent[1]['sUsername'] = 'imily';
        $this->usersContent[0]['sPassword'] = '$2y$10$DNFpQGfsRbY1uRMUf9sn8u2crrOMYZzk1KsuO5ZbuDEoETThuBP/W';
        $this->usersContent[1]['nStickerType'] = 3;
        $this->usersContent[1]['sDescription'] = '';
        $this->usersContent[1]['dtCreate'] = '2011-11-11 00:00:00';
        $this->usersContent[1]['dtUpdate'] = '2011-11-12 00:00:00';

        $this->usersContent[2]['ixUser'] = 3;
        $this->usersContent[2]['sUsername'] = 'Mary';
        $this->usersContent[0]['sPassword'] = '$2y$10$8zzLsN8qIlGTcBRmFIBe3Os4sKikW3ctU4FtoYGGa71mu5IhI1E62';
        $this->usersContent[2]['nStickerType'] = 1;
        $this->usersContent[2]['sDescription'] = '';
        $this->usersContent[2]['dtCreate'] = '2011-11-12 00:00:00';
        $this->usersContent[2]['dtUpdate'] = '2011-11-13 00:00:00';

        return $this->usersContent;
    }

    /**
     * 生成測試用的user物件
     * @return User[]
     */
    public function generateUsersForTest()
    {
        $usersContents = $this->generateUserContent();
        $users = array();
        foreach ($usersContents as $usersContent) {
            $users[$usersContent['ixUser']] = new User($usersContent);
        }
        return $users;
    }

    /**
     * 測試取得所有留言資料
     * @return void
     */
    public function testGetByGetAllList()
    {
        $lists = MessageModel::getAllList();

        // 取得比對用的資料
        $messageContents = $this->generateMessageContent();
        $userContents = $this->generateUsersForTest();
        $messages = array();
        foreach ($messageContents as $messageContent) {
            $message = new Message($messageContent);
            $message->setUser($userContents[$message->getIxUser()]);
            $messages[] = $message;
        }

        // 確認資料筆數是否相同
        $this->assertCount(8, $lists);

        // 確認資料內容是否相符
//        $this->assertEquals($messages, $lists);
//        $this->assertEquals($messages[1], $lists[1]);
//        $this->assertEquals($messages[2], $lists[2]);

        // 測試資料格式是否正確
        $this->assertTrue($lists[0]->isValid());
        $this->assertTrue($lists[1]->isValid());
        $this->assertTrue($lists[2]->isValid());
    }

    /**
     * 測試取得部分留言資料
     * @return void
     */
    public function testGetList()
    {
        // 不輸入offset，limit參數，預設取得10筆
        $filter = new Filter();
        $lists = MessageModel::getList($filter);

        // 取得比對用的資料
        $messageContents = $this->generateMessageContent();
        $users = $this->generateUsersForTest();
        $messages = array();
        foreach ($messageContents as $messageContent) {
            $message = new Message($messageContent);
            $message->setUser($users[$message->getIxUser()]);
            $messages[] = $message;
        }

        // 確認資料筆數是否相同
        $this->assertCount(8, $lists);

        // 確認資料內容是否相符
//        $this->assertEquals($messages[0], $lists[0]);
//        $this->assertEquals($messages[1], $lists[1]);
//        $this->assertEquals($messages[2], $lists[2]);

        // 測試資料格式是否正確
        $this->assertTrue($lists[0]->isValid());
        $this->assertTrue($lists[1]->isValid());
        $this->assertTrue($lists[2]->isValid());

        // 設定從第1筆資料開始，取得2筆資料
        $filter->setOffset(1);
        $filter->setLimit(2);
        $lists = MessageModel::getList($filter);

        // 確認資料筆數是否相同
        $this->assertCount(2, $lists);

        // 確認資料內容是否相符
//        $this->assertEquals($messages[1], $lists[1]);
//        $this->assertEquals($messages[2], $lists[2]);
    }

    /**
     * 測試取得部分留言資料
     * (fail:offset參數輸入有誤)
     * @return void
     */
//    public function testGetListByOffsetFail()
//    {
//        // offset，不可小於0
//        $filter = new Filter();
//        $filter->setOffset(-1);
//        $lists = MessageModel::getList($filter);
//
//        // 確認回傳空陣列
//        $this->assertEquals(array(), $lists);
//    }

    /**
     * 測試取得部分留言資料
     * (fail:limit參數輸入有誤)
     * @return void
     */
    public function testGetListByLimitFail()
    {
        // limit，不可小於等於0
        $filter = new Filter();
        $filter->setLimit(0);
        $lists = MessageModel::getList($filter);

        // 確認回傳空陣列
        $this->assertEquals(array(), $lists);
    }

    /**
     * 測試依照MessageIds取得資料
     * @return void
     */
    public function testGetListByMessageIds()
    {
        $ids = array(1, 2, 3);
        $lists = MessageModel::getByIds($ids);

        // 取得比對用的資料
        $messageContents = $this->generateMessageContent();
        $users = $this->generateUsersForTest();
        $messages = array();
        foreach ($messageContents as $messageContent) {
            $message = new Message($messageContent);
            $message->setUser($users[$message->getIxUser()]);
            $messages[] = $message;
        }

        // 確認資料筆數是否相同
        $this->assertCount(3, $lists);

        // 確認資料內容是否相符
//        $this->assertEquals($messages[0], $lists[0]);
//        $this->assertEquals($messages[1], $lists[1]);
//        $this->assertEquals($messages[2], $lists[2]);

        // 測試資料格式是否正確
        $this->assertTrue($lists[0]->isValid());
        $this->assertTrue($lists[1]->isValid());
        $this->assertTrue($lists[2]->isValid());
    }

    /**
     * 測試依照MessageIds取得資料
     * (fail:ids包含錯誤參數)
     * @return void
     */
    public function testGetListByMessageIdsFail()
    {
        // 設定ids中參數包含0，確認回傳空陣列
        $ids = array(0, 1);
        $lists = MessageModel::getByIds($ids);
        $this->assertEquals(array(), $lists);

        // 設定ids中參數包含負數，確認回傳空陣列
        $ids = array(-2, 1);
        $lists = MessageModel::getByIds($ids);
        $this->assertEquals(array(), $lists);

        // 設定ids中參數包含非數字參數，確認回傳空陣列
        $ids = array(-2, '二');
        $lists = MessageModel::getByIds($ids);
        $this->assertEquals(array(), $lists);
    }

    /**
     * 測試依照MessageId取得部分資料
     * @return void
     */
    public function testGetListByMessageIdsForFilter()
    {
        // 不輸入offset，limit參數，預設取得10筆
        $filter = new Filter();

        $ids = array(1, 2, 3);
        $lists = MessageModel::getByIds($ids);

        // 取得比對用的資料
        $messageContents = $this->generateMessageContent();
        $users = $this->generateUsersForTest();
        $messages = array();
        foreach ($messageContents as $messageContent) {
            $message = new Message($messageContent);
            $message->setUser($users[$message->getIxUser()]);
            $messages[] = $message;
        }

//        $message = MessageModel::getById(1);
//        $this->assertEquals($messages[0], $message);
//        $message = MessageModel::getById(2);
//        $this->assertEquals($messages[1], $message);

        $message = MessageModel::getById(999);
        $this->assertEquals(new Message(), $message);
        $message = MessageModel::getById(0);
        $this->assertEquals(new Message(), $message);
        $message = MessageModel::getById(-1);
        $this->assertEquals(new Message(), $message);

        // 設定從第1筆資料開始，取得2筆資料
        $filter->setOffset(1);
        $filter->setLimit(2);
        $lists = MessageModel::getList($filter);

        // 確認資料筆數是否相同
        $this->assertCount(2, $lists);
    }

    /**
     * 測試依照MessageId取得資料
     * @return void
     */
    public function testGetById()
    {
        $messageContents = $this->generateMessageContent();
        $users = $this->generateUsersForTest();
        $messages = array();
        foreach ($messageContents as $messageContent) {
            $message = new Message($messageContent);
            $message->setUser($users[$message->getIxUser()]);
            $messages[] = $message;
        }

//        $message = MessageModel::getById(1);
//        $this->assertEquals($messages[0], $message);
//        $message = MessageModel::getById(2);
//        $this->assertEquals($messages[1], $message);

        $message = MessageModel::getById(999);
        $this->assertEquals(new Message(), $message);
        $message = MessageModel::getById(0);
        $this->assertEquals(new Message(), $message);
        $message = MessageModel::getById(-1);
        $this->assertEquals(new Message(), $message);
    }

    /**
     * 測試驗證messageId是否存在
     * @return void
     */
    public function testIsExist ()
    {
        $this->assertTrue(MessageModel::isExist(1));

        $this->assertFalse(MessageModel::isExist(999));
        $this->assertFalse(MessageModel::isExist(0));
        $this->assertFalse(MessageModel::isExist(-1));
    }

    /**
     * 測試檢查多筆資料存在於否
     * @return void
     */
    public function testIsIdsExist()
    {
        $this->assertTrue(MessageModel::isIdsExist(array(1,2,3)));

        $this->assertFalse(MessageModel::isIdsExist(array(1,2,999)));
        $this->assertFalse(MessageModel::isIdsExist(array(1,2,0)));
        $this->assertFalse(MessageModel::isIdsExist(array(1,2,-1)));
        $this->assertFalse(MessageModel::isIdsExist(array(1,2,'三')));
    }

    /**
     * 測試新增留言
     * @return void
     */
    public function testAdd()
    {
        // 確認目前有幾筆資料
        $messages = MessageModel::getAllList();
        $this->assertCount(8, $messages);

        // 確認登入使用者
        $user = new User();
        $user->setId(2);
        session()->put('userId', $user->getId());
        $this->assertTrue(UserModel::isLogin());

        // 新增第9筆要寫入的資料
        $message = new Message();
        $message->setId(9);
        $message->setIxUser($user->getId());
        $message->setDescription('測試留言');

        // 確認新增是否成功
        list($isSuccess, $error) =MessageModel::add($message);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getCode());

        // 測試是否有正確新增第9筆資料
        $messages = MessageModel::getAllList();
        $this->assertCount(9, $messages);

        // 將輸入的資料與資料庫取出的資料轉成array
        $inputData = $message->toArray();
        $databaseData = $messages[8]->toArray();

        // 不比對自動生成的欄位
        unset($inputData['dtCreate']);
        unset($inputData['dtUpdate']);
        unset($databaseData['dtCreate']);
        unset($databaseData['dtUpdate']);

        $this->assertEquals($inputData, $databaseData);
    }

    /**
     * 測試新增留言
     * (fail:描述欄位為空)
     * @return void
     */
    public function testAddFailByEmptyDescription()
    {
        // 確認目前有幾筆資料
        $messages = MessageModel::getAllList();
        $this->assertCount(8, $messages);

        // 確認登入使用者
        $user = new User();
        $user->setId(2);
        session()->put('userId', $user->getId());
        $this->assertTrue(UserModel::isLogin());

        // 新增第9筆要寫入的資料，設定描述欄位為空
        $message = new Message();
        $message->setId(9);
        $message->setIxUser($user->getId());
        $message->setDescription('');

        // 確認新增失敗
        list($isSuccess, $error) =MessageModel::add($message);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());

        // 測試無新增資料
        $messages = MessageModel::getAllList();
        $this->assertCount(8, $messages);
    }

    /**
     * 測試新增留言
     * (fail:未登入使用者)
     * @return void
     */
    public function testAddFailByNotLogin()
    {
        // 確認目前有幾筆資料
        $messages = MessageModel::getAllList();
        $this->assertCount(8, $messages);

        // 確認未登入使用者
        $user = new User();
        $user->setId(2);
        $this->assertFalse(UserModel::isLogin());

        // 新增第9筆要寫入的資料
        $message = new Message();
        $message->setId(9);
        $message->setIxUser($user->getId());
        $message->setDescription('描述');

        // 確認新增失敗
        list($isSuccess, $error) =MessageModel::add($message);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNAUTHORIZED, $error->getCode());

        // 測試無新增資料
        $messages = MessageModel::getAllList();
        $this->assertCount(8, $messages);
    }

    /**
     * 測試修改留言內容
     * @return void
     */
    public function testModify()
    {
        // 確認修改前的資料
        $messages = MessageModel::getAllList();
        $this->assertEquals(2, $messages[1]->getId());
        $this->assertEquals('description02', $messages[1]->getDescription());

        // 確認登入使用者
        $user = new User();
        $user->setId(2);
        session()->put('userId', $user->getId());
        $this->assertTrue(UserModel::isLogin());

        // 設定要修改的資料
        $message = new Message();
        $message->setId(2);
        $message->setIxUser($user->getId());
        $message->setDescription('測試留言');

        // 確認修改是否成功
        list($isSuccess, $error) =MessageModel::modify($message);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getCode());

        // 測試修改後的資料
        $messages = MessageModel::getAllList();
        $this->assertEquals(2, $messages[1]->getId());
        $this->assertEquals('測試留言', $messages[1]->getDescription());
    }

    /**
     * 測試修改留言內容
     * (fail:messageId不存在)
     * @return void
     */
    public function testModifyFailByFailedMessageId()
    {
        // 確認修改前的資料
        $messages = MessageModel::getAllList();
        $this->assertEquals(2, $messages[1]->getId());
        $this->assertEquals('description02', $messages[1]->getDescription());

        // 確認登入使用者
        $user = new User();
        $user->setId(2);
        session()->put('userId', $user->getId());
        $this->assertTrue(UserModel::isLogin());

        // 設定要修改的資料
        $message = new Message();
        $message->setId(999);
        $message->setIxUser($user->getId());
        $message->setDescription('描述');

        // 確認修改失敗
        list($isSuccess, $error) =MessageModel::modify($message);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND, $error->getCode());

        // 測試修改後的資料無改變
        $messages = MessageModel::getAllList();
        $this->assertEquals(2, $messages[1]->getId());
        $this->assertEquals('description02', $messages[1]->getDescription());
    }

    /**
     * 測試修改留言內容
     * (fail:描述欄位為空)
     * @return void
     */
    public function testModifyFailByEmptyDescription()
    {
        // 確認修改前的資料
        $messages = MessageModel::getAllList();
        $this->assertEquals(2, $messages[1]->getId());
        $this->assertEquals('description02', $messages[1]->getDescription());

        // 確認登入使用者
        $user = new User();
        $user->setId(2);
        session()->put('userId', $user->getId());
        $this->assertTrue(UserModel::isLogin());

        // 設定要修改的資料
        $message = new Message();
        $message->setId(2);
        $message->setIxUser($user->getId());
        $message->setDescription('');

        // 確認修改失敗
        list($isSuccess, $error) =MessageModel::modify($message);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());

        // 測試修改後的資料無改變
        $messages = MessageModel::getAllList();
        $this->assertEquals(2, $messages[1]->getId());
        $this->assertEquals('description02', $messages[1]->getDescription());
    }

    /**
     * 測試修改留言內容
     * (fail:未登入使用者)
     * @return void
     */
    public function testModifyFailByNotLogin()
    {
        // 確認修改前的資料
        $messages = MessageModel::getAllList();
        $this->assertEquals(2, $messages[1]->getId());
        $this->assertEquals('description02', $messages[1]->getDescription());

        // 確認未登入使用者
        $user = new User();
        $user->setId(2);
        $this->assertFalse(UserModel::isLogin());

        // 設定要修改的資料
        $message = new Message();
        $message->setId(2);
        $message->setIxUser($user->getId());
        $message->setDescription('描述');

        // 確認修改失敗
        list($isSuccess, $error) =MessageModel::modify($message);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNAUTHORIZED, $error->getCode());

        // 測試修改後的資料無改變
        $messages = MessageModel::getAllList();
        $this->assertEquals(2, $messages[1]->getId());
        $this->assertEquals('description02', $messages[1]->getDescription());
    }
}
