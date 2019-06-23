<?php namespace Tests;

use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\Message;
use App\Classes\Post;
use App\Classes\User;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Repositories\Filter;

class PostModelTest extends DatabaseTestCase
{
    private $postsContent = array();
    private $messagesContent = array();
    private $usersContent = array();

    /**
     * 設定post比對用的資料
     * @return array
     */
    public function generatePostContent()
    {
        $this->postsContent = array();
        $this->postsContent[0]['ixPost'] = 1;
        $this->postsContent[0]['ixUser'] = 1;
        $this->postsContent[0]['sMessages'] = '[1,2,3,5]';
        $this->postsContent[0]['sTopic'] = 'topic01';
        $this->postsContent[0]['sLikes'] = '[1,2,3]';
        $this->postsContent[0]['sDescription'] = 'description01';
        $this->postsContent[0]['dtCreate'] = '2011-11-11 00:00:00';
        $this->postsContent[0]['dtUpdate'] = '2011-11-12 00:00:00';

        $this->postsContent[1]['ixPost'] = 2;
        $this->postsContent[1]['ixUser'] = 2;
        $this->postsContent[1]['sMessages'] = '[1,7,6]';
        $this->postsContent[1]['sTopic'] = 'topic02';
        $this->postsContent[1]['sLikes'] = '[1,2,3]';
        $this->postsContent[1]['sDescription'] = 'description02';
        $this->postsContent[1]['dtCreate'] = '2011-11-12 00:00:00';
        $this->postsContent[1]['dtUpdate'] = '2011-11-13 00:00:00';

        $this->postsContent[2]['ixPost'] = 3;
        $this->postsContent[2]['ixUser'] = 3;
        $this->postsContent[2]['sMessages'] = '[1,4,8]';
        $this->postsContent[2]['sTopic'] = 'topic03';
        $this->postsContent[2]['sLikes'] = '[1,2,3]';
        $this->postsContent[2]['sDescription'] = 'description03';
        $this->postsContent[2]['dtCreate'] = '2011-11-13 00:00:00';
        $this->postsContent[2]['dtUpdate'] = '2011-11-14 00:00:00';

        return $this->postsContent;
    }

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

        $this->messagesContent[3]['ixMessage'] = 4;
        $this->messagesContent[3]['ixUser'] = 1;
        $this->messagesContent[3]['sDescription'] = 'description04';
        $this->messagesContent[3]['dtCreate'] = '2011-11-14 00:00:00';
        $this->messagesContent[3]['dtUpdate'] = '2011-11-15 00:00:00';

        $this->messagesContent[4]['ixMessage'] = 5;
        $this->messagesContent[4]['ixUser'] = 2;
        $this->messagesContent[4]['sDescription'] = 'description05';
        $this->messagesContent[4]['dtCreate'] = '2011-11-15 00:00:00';
        $this->messagesContent[4]['dtUpdate'] = '2011-11-16 00:00:00';

        $this->messagesContent[5]['ixMessage'] = 6;
        $this->messagesContent[5]['ixUser'] = 3;
        $this->messagesContent[5]['sDescription'] = 'description06';
        $this->messagesContent[5]['dtCreate'] = '2011-11-16 00:00:00';
        $this->messagesContent[5]['dtUpdate'] = '2011-11-17 00:00:00';

        $this->messagesContent[6]['ixMessage'] = 7;
        $this->messagesContent[6]['ixUser'] = 1;
        $this->messagesContent[6]['sDescription'] = 'description07';
        $this->messagesContent[6]['dtCreate'] = '2011-11-17 00:00:00';
        $this->messagesContent[6]['dtUpdate'] = '2011-11-18 00:00:00';

        $this->messagesContent[7]['ixMessage'] = 8;
        $this->messagesContent[7]['ixUser'] = 3;
        $this->messagesContent[7]['sDescription'] = 'description08';
        $this->messagesContent[7]['dtCreate'] = '2011-11-18 00:00:00';
        $this->messagesContent[7]['dtUpdate'] = '2011-11-19 00:00:00';

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
        $this->usersContent[1]['sPassword'] = '$2y$10$DNFpQGfsRbY1uRMUf9sn8u2crrOMYZzk1KsuO5ZbuDEoETThuBP/W';
        $this->usersContent[1]['nStickerType'] = 3;
        $this->usersContent[1]['sDescription'] = '';
        $this->usersContent[1]['dtCreate'] = '2011-11-11 00:00:00';
        $this->usersContent[1]['dtUpdate'] = '2011-11-12 00:00:00';

        $this->usersContent[2]['ixUser'] = 3;
        $this->usersContent[2]['sUsername'] = 'Mary';
        $this->usersContent[2]['sPassword'] = '$2y$10$8zzLsN8qIlGTcBRmFIBe3Os4sKikW3ctU4FtoYGGa71mu5IhI1E62';
        $this->usersContent[2]['nStickerType'] = 1;
        $this->usersContent[2]['sDescription'] = '';
        $this->usersContent[2]['dtCreate'] = '2011-11-12 00:00:00';
        $this->usersContent[2]['dtUpdate'] = '2011-11-13 00:00:00';

        $this->usersContent[3]['ixUser'] = 4;
        $this->usersContent[3]['sUsername'] = 'Jessie';
        $this->usersContent[3]['sPassword'] = '$2y$10$8zzLsN8qIlGTcBRmFIBe3Os4sKikW3ctU4FtoYGGa71mu5IhI1E62';
        $this->usersContent[3]['nStickerType'] = 2;
        $this->usersContent[3]['sDescription'] = '';
        $this->usersContent[3]['dtCreate'] = '2011-11-13 00:00:00';
        $this->usersContent[3]['dtUpdate'] = '2011-11-14 00:00:00';

        return $this->usersContent;
    }

    /**
     * 生成測試用的message物件
     * @return Message[]
     */
    public function generateMessagesForTest()
    {
        $messagesContents = $this->generateMessageContent();
        $messages = array();
        foreach ($messagesContents as $messagesContent) {
            $messages[$messagesContent['ixMessage']] = new Message($messagesContent);
        }
        return $messages;
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
     * 測試取得所有討論主題資料
     * @return void
     */
    public function testGetByGetAllList()
    {
        $lists = PostModel::getAllList();

        // 取得比對用的資料
        $postsContents = $this->generatePostContent();
        $messageContents = $this->generateMessageContent();
        $users = $this->generateUsersForTest();

        $messageLists = array();
        foreach ($messageContents as $messageContent) {
            $message = new Message($messageContent);
            $message->setUser($users[$message->getIxUser()]);
            $messageLists[] = $message;
        }

        $posts = array();
        foreach ($postsContents as $postsContent) {
            $post = new Post($postsContent);

            $userIds = json_decode($post->getLikes());
            $userLists = array();
            foreach ($userIds as $userId) {
                $userItem = $users[$userId];
                $userLists[] = $userItem;
            }
            $post->setUser($userLists);
            $post->setMessage($messageLists);
            $post->setUserObject($users[$post->getIxUser()]);

            dd($post->getMessage()[0]->getUser()->getUsername());
            $posts[] = $post;
        }

        // 確認資料筆數是否相同
        $this->assertCount(7, $lists);

        // 確認資料內容是否相符
//        $this->assertEquals($posts, $lists);
//        $this->assertEquals($posts[0], $lists[0]);
//        $this->assertEquals($posts[1], $lists[1]);

        // 測試資料格式是否正確
        $this->assertTrue($lists[0]->isValid());
        $this->assertTrue($lists[1]->isValid());
        $this->assertTrue($lists[2]->isValid());
    }

//    /**
//     * 測試取得部分留言資料
//     * @return void
//     */
//    public function testGetList()
//    {
//        // 不輸入offset，limit參數，預設取得10筆
//        $filter = new Filter();
//        $messageFilter = new Filter();
//        $lists = PostModel::getList($filter, $messageFilter);
//
//        // 取得比對用的資料
//        $postsContents = $this->generatePostContent();
//        $messageContents = $this->generateMessageContent();
//        $users = $this->generateUsersForTest();
//
//        $messageLists = array();
//        foreach ($messageContents as $messageContent) {
//            $message = new Message($messageContent);
//            $message->setUser($users[$message->getIxUser()]);
//            $messageLists[] = $message;
//        }
//
//        $posts = array();
//        foreach ($postsContents as $postsContent) {
//            $post = new Post($postsContent);
//
//            $userIds = json_decode($post->getLikes());
//            $userLists = array();
//            foreach ($userIds as $userId) {
//                $userItem = $users[$userId];
//                $userLists[] = $userItem;
//            }
//            $post->setUser($userLists);
//            $post->setMessage($messageLists);
//
//            $posts[] = $post;
//        }
//
//        // 確認資料筆數是否相同
//        $this->assertCount(7, $lists);
//
//        // 確認資料內容是否相符
////        $this->assertEquals($posts, $lists);
////        $this->assertEquals($posts[0], $lists[0]);
////        $this->assertEquals($posts[1], $lists[1]);
//
//        // 測試資料格式是否正確
//        $this->assertTrue($lists[0]->isValid());
//        $this->assertTrue($lists[1]->isValid());
//        $this->assertTrue($lists[2]->isValid());
//
//        // 設定從第1筆資料開始，取得2筆資料
//        $filter->setOffset(1);
//        $filter->setLimit(2);
//        $messageFilter->setOffset(1);
//        $messageFilter->setLimit(2);
//        $lists = PostModel::getList($filter, $messageFilter);
//
//        // 確認資料筆數是否相同
//        $this->assertCount(2, $lists);
//
//        // 確認資料內容是否相符
////        $this->assertEquals($posts[1], $lists[1]);
////        $this->assertEquals($posts[2], $lists[2]);
//    }
//
//    /**
//     * 測試取得部分留言資料
//     * (fail:offset參數輸入有誤)
//     * @return void
//     */
////    public function testGetListByOffsetFail()
////    {
////        // offset，不可小於0
////        $filter = new Filter();
////        $messageFilter = new Filter();
////        $filter->setOffset(-1);
////        $lists = PostModel::getList($filter, $messageFilter);
////
////        // 確認回傳空陣列
////        $this->assertEquals(array(), $lists);
////    }
//
//    /**
//     * 測試取得部分留言資料
//     * (fail:limit參數輸入有誤)
//     * @return void
//     */
//    public function testGetListByLimitFail()
//    {
//        // limit，不可小於等於0
//        $filter = new Filter();
//        $messageFilter = new Filter();
//        $filter->setLimit(0);
//        $lists = PostModel::getList($filter, $messageFilter);
//
//        // 確認回傳空陣列
//        $this->assertEquals(array(), $lists);
//    }
//
//    /**
//     * 測試依照PostId取得資料
//     * @return void
//     */
//    public function testGetByPostId()
//    {
//        // 不輸入offset，limit參數，預設取得10筆
//        $messageFilter = new Filter();
//
//        // 取得比對用的資料
//        $postsContents = $this->generatePostContent();
//        $messageContents = $this->generateMessageContent();
//        $users = $this->generateUsersForTest();
//
//        $messageLists = array();
//        foreach ($messageContents as $messageContent) {
//            $message = new Message($messageContent);
//            $message->setUser($users[$message->getIxUser()]);
//            $messageLists[] = $message;
//        }
//
//        $posts = array();
//        foreach ($postsContents as $postsContent) {
//            $post = new Post($postsContent);
//
//            $userIds = json_decode($post->getLikes());
//            $userLists = array();
//            foreach ($userIds as $userId) {
//                $userItem = $users[$userId];
//                $userLists[] = $userItem;
//            }
//            $post->setUser($userLists);
//            $post->setMessage($messageLists);
//
//            $posts[] = $post;
//        }
//
////        $post = PostModel::getById(1, $messageFilter);
////        $this->assertEquals($posts[0], $post);
////        $post = PostModel::getById(2, $messageFilter);
////        $this->assertEquals($posts[1], $post);
//
//        $post = PostModel::getById(999, $messageFilter);
//        $this->assertEquals(new Post(), $post);
//        $post = PostModel::getById(0, $messageFilter);
//        $this->assertEquals(new Post(), $post);
//        $post = PostModel::getById(-1, $messageFilter);
//        $this->assertEquals(new Post(), $post);
//    }
//
//    /**
//     * 測試驗證postId是否存在
//     * @return void
//     */
//    public function testIsExist()
//    {
//        $this->assertTrue(PostModel::isExist(1));
//
//        $this->assertFalse(PostModel::isExist(999));
//        $this->assertFalse(PostModel::isExist(0));
//        $this->assertFalse(PostModel::isExist(-1));
//    }
//
//    /**
//     * 測試依照UserId取得資料
//     * @return void
//     */
//    public function testGetListByUserId()
//    {
//        // 不輸入offset，limit參數，預設取得10筆
//        $messageFilter = new Filter();
//
//        $userId = 1;
//
//        // 確認資料筆數是否相同
//        $lists = PostModel::getByUserId($messageFilter, $userId);
//        $this->assertCount(2, $lists);
//
//        $lists = PostModel::getByUserId($messageFilter, 0);
//        $this->assertEquals(array(), $lists);
//    }
//
//    /**
//     * 測試依照UserId取得部分資料
//     * @return void
//     */
//    public function testGetListByUserIdForFilter()
//    {
//        // 不輸入offset，limit參數，預設取得10筆
//        $filter = new Filter();
//        $messageFilter = new Filter();
//
//        $userId = 1;
//
//        // 確認資料筆數是否相同
//        $lists = PostModel::getByUserId($messageFilter, $userId);
//        $this->assertCount(2, $lists);
//
//        $lists = PostModel::getByUserId($messageFilter, 0);
//        $this->assertEquals(array(), $lists);
//
//        // 設定從第1筆資料開始，取得1筆資料
//        $filter->setOffset(1);
//        $filter->setLimit(1);
//        $lists = PostModel::getByUserIdForFilter($filter, $messageFilter, $userId);
//
//        // 確認資料筆數是否相同
//        $this->assertCount(1, $lists);
//    }

//    /**
//     * 測試新增討論主題
//     * @return void
//     */
//    public function testAdd()
//    {
//        // 確認目前有幾筆資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認登入使用者
//        $userId = 2;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 新增第8筆要寫入的資料
//        $post = new Post();
//        $post->setId(8);
//        $post->setIxUser($userId);
//        $post->setTopic('標題');
//        $post->setDescription('描述');
//
//        // 確認新增成功
//        list($isSuccess, $error) = PostModel::add($post);
//        $this->assertTrue($isSuccess);
//        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
//
//        // 測試有正確新增第8筆資料
////        $posts = PostModel::getAllList();
////        $this->assertCount(8, $posts);
////
////        // 將輸入的資料與資料庫取出的資料轉成array
////        $inputData = $post->toArray();
////        $databaseData = $inputData[8]->toArray();
////
////        // 不比對自動生成的欄位
////        unset($inputData['dtCreate']);
////        unset($inputData['dtUpdate']);
////        unset($databaseData['dtCreate']);
////        unset($databaseData['dtUpdate']);
////
////        $this->assertEquals($inputData, $databaseData);
//    }
//
//    /**
//     * 測試新增討論主題
//     * (fail:標題欄位為空)
//     * @return void
//     */
//    public function testAddFailByEmptyTopic()
//    {
//        // 確認目前有幾筆資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認登入使用者
//        $userId = 2;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 新增第8筆要寫入的資料，設定描述欄位為空
//        $post = new Post();
//        $post->setId(8);
//        $post->setIxUser($userId);
//        $post->setTopic('');
//        $post->setDescription('描述');
//
//        // 確認新增失敗
//        list($isSuccess, $error) = PostModel::add($post);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 測試無新增資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//    }
//
//    /**
//     * 測試新增討論主題
//     * (fail:描述欄位為空)
//     * @return void
//     */
//    public function testAddFailByEmptyDescription()
//    {
//        // 確認目前有幾筆資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認登入使用者
//        $userId = 2;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 新增第8筆要寫入的資料，設定描述欄位為空
//        $post = new Post();
//        $post->setId(8);
//        $post->setIxUser($userId);
//        $post->setTopic('標題');
//        $post->setDescription('');
//
//        // 確認新增失敗
//        list($isSuccess, $error) = PostModel::add($post);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 測試無新增資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//    }
//
//    /**
//     * 測試新增討論主題
//     * (fail:未登入使用者)
//     * @return void
//     */
//    public function testAddFailByNotLogin()
//    {
//        // 確認目前有幾筆資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認未登入使用者
//        $userId = 2;
//        $this->assertFalse(UserModel::isLogin());
//
//        // 新增第8筆要寫入的資料，設定描述欄位為空
//        $post = new Post();
//        $post->setId(8);
//        $post->setIxUser($userId);
//        $post->setTopic('標題');
//        $post->setDescription('描述');
//
//        // 確認新增失敗
//        list($isSuccess, $error) = PostModel::add($post);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNAUTHORIZED, $error->getCode());
//
//        // 測試無新增資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//    }
//
//    /**
//     * 測試修改討論主題
//     * @return void
//     */
//    public function testModify()
//    {
//        // 確認修改前的資料
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//
//        // 確認登入使用者
//        $userId = 2;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $post = new Post();
//        $post->setId(2);
//        $post->setIxUser($userId);
//        $post->setTopic('修改標題');
//        $post->setDescription('修改描述');
//
//        // 確認修改成功
//        list($isSuccess, $error) = PostModel::modify($post);
//        $this->assertTrue($isSuccess);
//        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
//
//        // 測試修改後的資料
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('修改標題', $posts[1]->getTopic());
//        $this->assertEquals('修改描述', $posts[1]->getDescription());
//    }
//
//    /**
//     * 測試修改討論主題
//     * (fail:postId不存在)
//     * @return void
//     */
//    public function testModifyFailByFailedPostId()
//    {
//        // 確認修改前的資料
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//
//        // 確認登入使用者
//        $userId = 2;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $post = new Post();
//        $post->setId(999);
//        $post->setIxUser($userId);
//        $post->setTopic('修改標題');
//        $post->setDescription('修改描述');
//
//        // 確認修改成功
//        list($isSuccess, $error) = PostModel::modify($post);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND, $error->getCode());
//
//        // 測試修改後的資料無改變
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//    }
//
//    /**
//     * 測試修改討論主題
//     * (fail:標題欄位為空)
//     * @return void
//     */
//    public function testModifyFailByEmptyTopic()
//    {
//        // 確認修改前的資料
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//
//        // 確認登入使用者
//        $userId = 2;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $post = new Post();
//        $post->setId(999);
//        $post->setIxUser($userId);
//        $post->setTopic('');
//        $post->setDescription('修改描述');
//
//        // 確認修改成功
//        list($isSuccess, $error) = PostModel::modify($post);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 測試修改後的資料無改變
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//    }
//
//    /**
//     * 測試修改討論主題
//     * (fail:描述欄位為空)
//     * @return void
//     */
//    public function testModifyFailByEmptyDescription()
//    {
//        // 確認修改前的資料
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//
//        // 確認登入使用者
//        $userId = 2;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $post = new Post();
//        $post->setId(999);
//        $post->setIxUser($userId);
//        $post->setTopic('修改標題');
//        $post->setDescription('');
//
//        // 確認修改成功
//        list($isSuccess, $error) = PostModel::modify($post);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 測試修改後的資料無改變
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//    }
//
//    /**
//     * 測試修改討論主題
//     * (fail:未登入使用者)
//     * @return void
//     */
//    public function testModifyFailByNotLogin()
//    {
//
//        // 確認修改前的資料
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//
//        // 確認未登入使用者
//        $userId = 2;
//        $this->assertFalse(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $post = new Post();
//        $post->setId(2);
//        $post->setIxUser($userId);
//        $post->setTopic('修改標題');
//        $post->setDescription('修改描述');
//
//        // 確認修改成功
//        list($isSuccess, $error) = PostModel::modify($post);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNAUTHORIZED, $error->getCode());
//
//        // 測試修改後的資料無改變
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('topic02', $posts[1]->getTopic());
//        $this->assertEquals('description02', $posts[1]->getDescription());
//    }

//    /**
//     * 測試批量刪除討論主題
//     * @return void
//     */
//    public function testDelete()
//    {
//        // 確認刪除前資料筆數
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認7筆ID編號
//        $this->assertEquals(1, $posts[0]->getId());
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals(3, $posts[2]->getId());
//        $this->assertEquals(4, $posts[3]->getId());
//        $this->assertEquals(5, $posts[4]->getId());
//        $this->assertEquals(6, $posts[5]->getId());
//        $this->assertEquals(7, $posts[6]->getId());
//
//        $ids = array(2,3);
//
//        // 測試批量刪除
//        list($isSuccess, $error) = PostModel::delete($ids);
//        $this->assertTrue($isSuccess);
//        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
//
//        // 確認刪除後資料筆數
//        $posts = PostModel::getAllList();
//        $this->assertCount(5, $posts);
//
//        // 確認ID編號
//        $this->assertEquals(1, $posts[0]->getId());
//        $this->assertEquals(4, $posts[1]->getId());
//        $this->assertEquals(5, $posts[2]->getId());
//        $this->assertEquals(6, $posts[3]->getId());
//        $this->assertEquals(7, $posts[4]->getId());
//    }
//
//    /**
//     * 測試批量刪除討論主題
//     * (Fail:有無效的ID)
//     * @return void
//     */
//    public function testDeleteByIdInvalid()
//    {
//        // 確認刪除前資料筆數
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認7筆ID編號
//        $this->assertEquals(1, $posts[0]->getId());
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals(3, $posts[2]->getId());
//        $this->assertEquals(4, $posts[3]->getId());
//        $this->assertEquals(5, $posts[4]->getId());
//        $this->assertEquals(6, $posts[5]->getId());
//        $this->assertEquals(7, $posts[6]->getId());
//
//        $ids = array(0,3);
//
//        // 測試批量刪除，接收錯誤:無效的參數
//        list($isSuccess, $error) = PostModel::delete($ids);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 確認刪除後資料筆數
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認ID編號
//        $this->assertEquals(1, $posts[0]->getId());
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals(3, $posts[2]->getId());
//        $this->assertEquals(4, $posts[3]->getId());
//        $this->assertEquals(5, $posts[4]->getId());
//        $this->assertEquals(6, $posts[5]->getId());
//        $this->assertEquals(7, $posts[6]->getId());
//    }
//
//    /**
//     * 測試批量刪除討論主題
//     * (Fail:輸入空值)
//     * @return void
//     */
//    public function testDeleteByIdsIsEmpty()
//    {
//        // 確認刪除前資料筆數
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認7筆ID編號
//        $this->assertEquals(1, $posts[0]->getId());
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals(3, $posts[2]->getId());
//        $this->assertEquals(4, $posts[3]->getId());
//        $this->assertEquals(5, $posts[4]->getId());
//        $this->assertEquals(6, $posts[5]->getId());
//        $this->assertEquals(7, $posts[6]->getId());
//
//        $ids = array();
//
//        // 測試批量刪除，接收錯誤:輸入有空值
//        list($isSuccess, $error) = PostModel::delete($ids);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT, $error->getCode());
//
//        // 確認刪除後資料筆數
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認ID編號
//        $this->assertEquals(1, $posts[0]->getId());
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals(3, $posts[2]->getId());
//        $this->assertEquals(4, $posts[3]->getId());
//        $this->assertEquals(5, $posts[4]->getId());
//        $this->assertEquals(6, $posts[5]->getId());
//        $this->assertEquals(7, $posts[6]->getId());
//    }
//
//    /**
//     * 測試批量刪除討論主題
//     * (Fail:輸入id非數字)
//     * @return void
//     */
//    public function testDeleteByIdsIsNotInt()
//    {
//        // 確認刪除前資料筆數
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認7筆ID編號
//        $this->assertEquals(1, $posts[0]->getId());
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals(3, $posts[2]->getId());
//        $this->assertEquals(4, $posts[3]->getId());
//        $this->assertEquals(5, $posts[4]->getId());
//        $this->assertEquals(6, $posts[5]->getId());
//        $this->assertEquals(7, $posts[6]->getId());
//
//        $ids = array('一',2);
//
//        // 測試批量刪除，接收錯誤:無效的參數
//        list($isSuccess, $error) = PostModel::delete($ids);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 確認刪除後資料筆數
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//
//        // 確認ID編號
//        $this->assertEquals(1, $posts[0]->getId());
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals(3, $posts[2]->getId());
//        $this->assertEquals(4, $posts[3]->getId());
//        $this->assertEquals(5, $posts[4]->getId());
//        $this->assertEquals(6, $posts[5]->getId());
//        $this->assertEquals(7, $posts[6]->getId());
//    }

//    /**
//     * 測試更新喜歡單一討論主題
//     * @return void
//     */
//    public function testUpdateLike()
//    {
//        // 確認目前有幾筆資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//        $this->assertEquals('[1,2,3]', $posts[1]->getLikes());
//
//        // 確認登入使用者
//        $userId = 4;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $postId = 2;
//
//        // 確認修改成功
//        list($isSuccess, $error) = PostModel::updateLikes($postId, $userId);
//        $this->assertTrue($isSuccess);
//        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
//
//        // 測試修改後的資料
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('[1,2,3,4]', $posts[1]->getLikes());
//    }
//
//    /**
//     * 測試更新喜歡單一討論主題
//     * (清單內已含有同樣的使用者)
//     * @return void
//     */
//    public function testUpdateLikeBySameUser()
//    {
//        // 確認目前有幾筆資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//        $this->assertEquals('[1,2,3]', $posts[1]->getLikes());
//
//        // 確認登入使用者
//        $userId = 2;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $postId = 2;
//
//        // 確認修改成功
//        list($isSuccess, $error) = PostModel::updateLikes($postId, $userId);
//        $this->assertTrue($isSuccess);
//        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
//
//        // 測試修改後的資料
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('[1,3]', $posts[1]->getLikes());
//    }
//
//    /**
//     * 測試更新喜歡單一討論主題
//     * (fail:postId不存在)
//     * @return void
//     */
//    public function testUpdateLikeFailByFailedPostId()
//    {
//        // 確認目前有幾筆資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//        $this->assertEquals('[1,2,3]', $posts[1]->getLikes());
//
//        // 確認登入使用者
//        $userId = 4;
//        session()->put('userId', $userId);
//        $this->assertTrue(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $postId = 999;
//
//        // 確認修改失敗，接收錯誤:無效的參數
//        list($isSuccess, $error) = PostModel::updateLikes($postId, $userId);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID, $error->getCode());
//
//        // 測試修改後的資料無改變
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('[1,2,3]', $posts[1]->getLikes());
//    }
//
//    /**
//     * 測試更新喜歡單一討論主題
//     * (fail:未登入使用者)
//     * @return void
//     */
//    public function testUpdateLikeFailByNotLogin()
//    {
//        // 確認目前有幾筆資料
//        $posts = PostModel::getAllList();
//        $this->assertCount(7, $posts);
//        $this->assertEquals('[1,2,3]', $posts[1]->getLikes());
//
//        // 確認未登入使用者
//        $userId = 4;
//        $this->assertFalse(UserModel::isLogin());
//
//        // 設定要修改的資料
//        $postId = 2;
//
//        // 確認修改失敗，接收錯誤:無效的參數
//        list($isSuccess, $error) = PostModel::updateLikes($postId, $userId);
//        $this->assertFalse($isSuccess);
//        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNAUTHORIZED, $error->getCode());
//
//        // 測試修改後的資料無改變
//        $posts = PostModel::getAllList();
//        $this->assertEquals(2, $posts[1]->getId());
//        $this->assertEquals('[1,2,3]', $posts[1]->getLikes());
//    }
}
