<?php namespace Tests;

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
        $this->postsContent[0]['sMessages'] = '[1,2,3,8]';
        $this->postsContent[0]['sTopic'] = 'topic01';
        $this->postsContent[0]['sLikes'] = '[1,2,4]';
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

        $postsContents = $this->generatePostContent();
        $users = $this->generateUsersForTest();
        $messages = $this->generateMessagesForTest();

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

            $messageIds = json_decode($post->getMessages());
            $messageLists = array();
            foreach ($messageIds as $messageId) {
                $messageItem = $messages[$messageId];
                $messageLists[] = $messageItem;
            }
            $post->setMessage($messageLists);

            $posts[] = $post;
        }
        $this->assertCount(7, $lists);
    }
}
