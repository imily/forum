<?php namespace Tests;

use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\User;
use App\Models\MessageModel;
use App\Classes\Message;
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
        $this->messagesContent[0]['sDescription'] = 'test';
        $this->messagesContent[0]['dtCreate'] = '2018-11-14 14:10:27';
        $this->messagesContent[0]['dtUpdate'] = '2018-11-14 14:10:27';

        $this->messagesContent[1]['ixMessage'] = 2;
        $this->messagesContent[1]['ixUser'] = 2;
        $this->messagesContent[1]['sDescription'] = 'test2';
        $this->messagesContent[1]['dtCreate'] = '2018-11-15 14:10:27';
        $this->messagesContent[1]['dtUpdate'] = '2018-11-15 14:10:27';

        $this->messagesContent[2]['ixMessage'] = 3;
        $this->messagesContent[2]['ixUser'] = 3;
        $this->messagesContent[2]['sDescription'] = 'test3';
        $this->messagesContent[2]['dtCreate'] = '2018-11-16 14:10:27';
        $this->messagesContent[2]['dtUpdate'] = '2018-11-16 14:10:27';

        return $this->messagesContent;
    }

    /**
     * 設定user比對用的資料
     * @return array
     */
    public function generateUserContent()
    {
        $this->usersContent = array();

        $this->usersContent['ixUser'] = 2;
        $this->usersContent['sUsername'] = 'test2';
        $this->usersContent['nStickerType'] = 2;
        $this->usersContent['sDescription'] = '';
        $this->usersContent['dtCreate'] = '2018-11-15 14:10:27';
        $this->usersContent['dtUpdate'] = '2018-11-15 14:10:27';

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
            $users[$usersContents['ixUser']] = new User($usersContent);
        }

        return $users;
    }

    /**
     * 測試依照MessageId取得單一留言資料
     * @return void
     */
    public function testGetById()
    {
        // 取得比對用的資料
        $messageContents = $this->generateMessageContent();
        $userContents = $this->generateUserContent();

        $messages = array();
        foreach ($messageContents as $messageContent) {
            $message = new Message($messageContent);
            $message->setIxUser($message->getId());
            $message->setUser($userContents[$message->getIxUser()]);
            $message->setDescription($message->getDescription());
            $message->setDtCreate($message->getDtCreate());
            $message->setDtUpdate($message->getDtUpdate());
            $messages[] = $message;
        }

        $message = MessageModel::getById(1);
        $this->assertEquals($messages[0], $message);

        $message = MessageModel::getById(999);
        $this->assertEquals(new Message(), $message);
        $message = MessageModel::getById(0);
        $this->assertEquals(new Message(), $message);
        $message = MessageModel::getById(-1);
        $this->assertEquals(new Message(), $message);
    }

    /**
     * 測試依Id取得單一留言資訊
     * (error: 無效的留言Id，回傳Message空物件)
     * @return void
     */
    public function testGetByIdForInvalidMessageId()
    {
        //設定無效的messageId
        $ixMessage = 0;
        $message = MessageModel::getById($ixMessage);
        $this->assertEquals(new Message(), $message);

        $ixMessage = -1;
        $message = MessageModel::getById($ixMessage);
        $this->assertEquals(new Message(), $message);
    }

    /**
     * 測試依Id取得單一留言資訊
     * (error: 不存在的留言Id，回傳Message空物件)
     * @return void
     */
    public function testGetByIdForMessageIdNotExist()
    {
        //設定不存在的messageId
        $ixMessage = 999;
        $message = MessageModel::getById($ixMessage);
        $this->assertEquals(new Message(), $message);
    }

    /**
     * 測試message id是否存在
     * @return void
     */
    public function testIsExist()
    {
        // 驗證存在的 message id
        $isExist = MessageModel::isExist(1);
        $this->assertTrue($isExist);

        // 驗證不存在的 message id
        $isExist = MessageModel::isExist(0);
        $this->assertFalse($isExist);

        // 驗證不存在的 message id
        $isExist = MessageModel::isExist(-1);
        $this->assertFalse($isExist);
    }

    /**
     * 測試取得所有留言清單
     * @return void
     */
    public function testGetAllList()
    {
        // 不輸入預設取前10筆
        $filter = new Filter();
        $messages = MessageModel::getAllList($filter);

        // 測試留言清單有幾筆資料
        $this->assertCount(3, $messages);

        // 測試抓取的資料與設定的資料是否正確
        $this->assertEquals($this->messagesContent[0], $messages[0]->toArray());
        $this->assertEquals($this->messagesContent[1], $messages[1]->toArray());
        $this->assertEquals($this->messagesContent[2], $messages[2]->toArray());

        // 測試資料格式是否正確
        $this->assertTrue($messages[0]->isValid());
        $this->assertTrue($messages[1]->isValid());
        $this->assertTrue($messages[2]->isValid());

        // 設定取前2筆
        $filter = new Filter();
        $filter->setLimit(2);
        $messages = MessageModel::getAllList($filter);

        // 確認資料筆數是否相同
        $this->assertCount(2, $messages);

        // 測試抓取的資料與設定的資料是否正確
        $this->assertEquals($this->messagesContent[0], $messages[0]->toArray());
        $this->assertEquals($this->messagesContent[1], $messages[1]->toArray());

        // 設定從第2筆開始共取2筆資料
        $filter = new Filter();
        $filter->setLimit(2);
        $filter->setOffset(1);
        $messages = MessageModel::getAllList($filter);

        // 確認資料筆數是否相同
        $this->assertCount(2, $messages);

        // 測試抓取的資料與設定的資料是否正確
        $this->assertEquals($this->messagesContent[1], $messages[0]->toArray());
        $this->assertEquals($this->messagesContent[2], $messages[1]->toArray());
    }

    /**
     * 取得Message表的所有資料讓單元測試使用
     * @return Message[]
     */
    public function getAllListForTest()
    {
        $sql = sprintf("
                 SELECT *
                 FROM `Message`");
        $results = DB::SELECT($sql);

        $messages = array();
        foreach ($results as $result) {
            $messages[] = new Message($result);
        }
        return $messages;
    }

    /**
     * 測試新增留言
     * @return void
     */
    public function testAdd()
    {
        // 確認新增前的清單數
        $this->assertCount(3, $this->getAllListForTest());

        // 設定物件新增到DB
        $message = new Message();
        $message->setIxUser(1);
        $message->setDescription('test');
        list($isSuccess, $error) = MessageModel::add($message);

        // 確認回傳無錯誤
        $this->assertEquals(Error::ERROR_NONE, $error);
        $this->assertEquals(true, $isSuccess);

        // 取得以下id的資料
        $messageInDb = MessageModel::getById($message->getId());
        $this->assertEquals(3, $messageInDb->getId());
        $this->assertEquals('test', $messageInDb->getDescription());

        // 確認新增後的清單數有增加
        $this->assertCount(4, $this->getAllListForTest());
    }

    /**
     * 測試新增留言
     * (fail: 無效物件)
     * @return void
     */
    public function testAddFailByInvalidObject()
    {
        // 確認新增前的清單數
        $this->assertCount(3, $this->getAllListForTest());

        // 設定無效物件嘗試新增到DB (error: 標題為空值)
        $message = new Message();
        $message->setIxUser(1);
        $message->setDescription('');
        list($isSuccess, $error) = MessageModel::add($message);

        // 確認回傳的錯誤
        $errorCode = ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT;
        $this->assertEquals($errorCode, $error->getCode());
        $this->assertEquals(false, $isSuccess);

        // 確認以下message還沒新增到db
        $isExist = MessageModel::isExist($message->getId());
        $this->assertEquals(false, $isExist);

        // 確認新增後的清單數沒有變化
        $this->assertCount(3, $this->getAllListForTest());
    }

    /**
     * 測試修改留言內容
     * @return void
     */
    public function testModifyDescription()
    {
        // 設定要修改的MessageId與描述
        $ixMessage = 2;
        $sDescription = '修改成功';

        // 確認修改前資料
        $message = MessageModel::getById($ixMessage);
        $this->assertEquals(2, $message->getId());
        $this->assertEquals('test2', $message->getDescription());

        list($isSuccess, $error) = MessageModel::modifyDescription($ixMessage, $sDescription);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getCode());

        // 比對修改後資料是否相符
        $message = MessageModel::getById($ixMessage);
        $this->assertEquals(2, $message->getId());
        $this->assertEquals('修改成功', $message->getDescription());
    }

    /**
     * 測試修改描述
     * (Fail: ID無效，回傳error)
     * @return void
     */
    public function testModifyDescriptionByIdFail()
    {
        // 設定無效的ID
        $ixMessage = 0;
        $sDescription = '修改描述';

        // 驗證回傳的錯誤
        list($isSuccess, $error) = MessageModel::modifyDescription($ixMessage, $sDescription);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
    }

    /**
     * 測試修改描述
     * (Fail: ID不存在於資料庫，回傳error)
     * @return void
     */
    public function testModifyDescriptionByIdNotExist()
    {
        // 設定不存在的ID
        $ixMessage = 999;
        $sDescription = '修改描述';

        // 驗證回傳的錯誤
        list($isSuccess, $error) = MessageModel::modifyDescription($ixMessage, $sDescription);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
    }

    /**
     * 測試修改描述
     * (Fail: 描述無效，回傳error)
     * @return void
     */
    public function testModifyDescriptionByDescriptionFail()
    {
        $ixMessage = 2;
        //若描述字串長度大於255 ，則傳 error
        //一行50個字元總共256個字
        $sDescription = '01234567890123456789012345678901234567890123456789'.
            '01234567890123456789012345678901234567890123456789'.
            '01234567890123456789012345678901234567890123456789'.
            '01234567890123456789012345678901234567890123456789'.
            '01234567890123456789012345678901234567890123456789'.
            '012345';

        // 確認修改前資料
        $message = MessageModel::getById($ixMessage);
        $this->assertEquals(2, $message->getId());
        $this->assertEquals('test2', $message->getDescription());

        // 驗證回傳的錯誤
        list($isSuccess, $error) = MessageModel::modifyDescription($ixMessage, $sDescription);
        $this->assertFalse($isSuccess);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());

        // 確認資料修改失敗是否與修改前資料一樣
        $message = MessageModel::getById($ixMessage);
        $this->assertEquals(2, $message->getId());
        $this->assertEquals('test2', $message->getDescription());
    }
}
