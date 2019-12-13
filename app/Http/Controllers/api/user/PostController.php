<?php namespace App\Http\Controllers\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Common\VerifyFormat;
use App\Classes\Errors\ErrorArgument;
use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Repositories\Filter;
use App\Classes\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    /**
     * 將Posts轉換成要顯示的陣列內容
     * @param Post[] $posts
     * @return array
     */
    private function convertToPostsDisplayArray(array $posts)
    {
        $response = array();
        foreach ($posts as $post) {
            $messages = $post->getMessage();
            $users = $post->getUser();
            $postUser = $post->getUserObject();

            $postContent = array();
            $postContent['id'] = $post->getId();
            $postContent['user_name'] = $postUser->getUsername();
            $postContent['user_sicker_type'] = $postUser->getStickerType();
            $postContent['messages']['total_amount'] = count($messages);

            $messageContents = array();
            $messageContent = array();
            foreach ($messages as $message) {
                $messageUser = $message->getUser();
                $messageContent['user_name'] = $messageUser->getUsername();
                $messageContent['description'] = $message->getDescription();
                $messageContent['update_time'] = $message->getDtUpdate();
                $messageContents[] = $messageContent;
            }

            $postContent['messages']['data'] = $messageContents;
            $postContent['topic'] = $post->getTopic();
            $postContent['description'] = $post->getDescription();

            $likeContents = array();
            $likeContent = array();
            foreach ($users as $user) {
                $likeContent['user_name'] = $user->getUsername();
                $likeContents[] = $likeContent;
            }

            $postContent['likes'] = $likeContents;
            $postContent['create_time'] = $post->getDtCreate();
            $postContent['update_time'] = $post->getDtUpdate();
            $response[] = $postContent;
        }

        return $response;
    }

    /**
     * 取得依Filter得到的資料
     * @param Filter $filter
     * @param Filter $messageFilter
     * @return Response
     */
    private function generatePostsByFilter(Filter $filter, Filter $messageFilter)
    {
        if (( ! $filter->isValid()) or
            ( ! $messageFilter->isValid())) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $posts = PostModel::getList($filter, $messageFilter);
        if ($posts == array()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $totalAmount = count($posts);
        $response = array();
        $response['total_amount'] = $totalAmount;
        $response['data'] = static::convertToPostsDisplayArray($posts);

        $statusCode = HttpStatusCode::STATUS_200_OK;
        return response()->json($response, $statusCode);
    }

    /**
     * 取得部分討論主題
     * URI: GET /api/posts
     * @return Response
     */
    public function getPost()
    {
        $offset = (int)Input::get('offset', 0);
        $limit = (int)Input::get('limit', PHP_INT_MAX);
        $messageOffset = (int)Input::get('message_offset', 0);
        $messageLimit = (int)Input::get('message_limit', PHP_INT_MAX);

        // 設定過濾器
        $filter = new Filter();
        $filter->setOffset($offset);
        $filter->setLimit($limit);
        $messageFilter = new Filter();
        $messageFilter->setOffset($messageOffset);
        $messageFilter->setLimit($messageLimit);

        return static::generatePostsByFilter($filter, $messageFilter);
    }

    /**
     * 取得單一使用者的部分討論主題
     * URI: GET /api/users/{userId}/posts
     * @param $userId
     * @return Response
     */
    public function getPostByUserId($userId)
    {
        $offset = (int)Input::get('offset', 0);
        $limit = (int)Input::get('limit', 0);
        $messageOffset = (int)Input::get('message_offset', 0);
        $messageLimit = (int)Input::get('message_limit', 0);

        if ( ! VerifyFormat::isValidId($userId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        // 設定過濾器
        $filter = new Filter();
        $filter->setOffset($offset);
        $filter->setLimit($limit);
        $messageFilter = new Filter();
        $messageFilter->setOffset($messageOffset);
        $messageFilter->setLimit($messageLimit);

        if (( ! $filter->isValid()) or
            ( ! $messageFilter->isValid())) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $posts = PostModel::getByUserIdForFilter($filter, $messageFilter, $userId);

        // 如果查無資料則回傳錯誤
        if ($posts == array()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response = array();
        $response['total_amount'] = count($posts);
        $response['data'] = static::convertToPostsDisplayArray($posts);

        $statusCode = HttpStatusCode::STATUS_200_OK;
        return response()->json($response, $statusCode);
    }

    /**
     * 取得單一討論主題
     * URI: GET /api/posts/{postId}
     * @param $postId
     * @return Response
     */
    public function getPostById($postId)
    {
        if ( ! VerifyFormat::isValidId($postId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $messageOffset = (int)Input::get('message_offset', 0);
        $messageLimit = (int)Input::get('message_limit', 10);

        // 取得資料
        $messageFilter = new Filter();
        $messageFilter->setOffset($messageOffset);
        $messageFilter->setLimit($messageLimit);
        $post = PostModel::getById($postId, $messageFilter);

        if ( ! $messageFilter->isValid()) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        // 當取得的留言Id為0時，回傳錯誤
        if ($post->getId() == 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        // 設定response
        $response = array();

        $postUser = $post->getUserObject();
        $messages = $post->getMessage();
        $users = $post->getUser();

        $response['id'] = $post->getId();
        $response['user_name'] = $postUser->getUsername();
        $response['user_sicker_type'] = $postUser->getStickerType();
        $response['messages']['total_amount'] = count($messages);

        $messageContents = array();
        $messageContent = array();
        foreach ($messages as $message) {
            $messageUser = $message->getUser();
            $messageContent['user_name'] = $messageUser->getUsername();
            $messageContent['description'] = $message->getDescription();
            $messageContent['update_time'] = $message->getDtUpdate();
            $messageContents[] = $messageContent;
        }
        $response['messages']['data'] = $messageContents;
        $response['topic'] = $post->getTopic();
        $response['description'] = $post->getDescription();

        $likeContents = array();
        $likeContent = array();
        foreach ($users as $user) {
            $likeContent['user_name'] = $user->getUsername();
            $likeContents[] = $likeContent;
        }

        $response['likes'] = $likeContents;
        $response['create_time'] = $post->getDtCreate();
        $response['update_time'] = $post->getDtUpdate();

        $statusCode = HttpStatusCode::STATUS_200_OK;
        return response()->json($response, $statusCode);
    }

    /**
     * 新增單一討論主題
     * URI: GET /api/posts
     * @return Response
     */
    public function addPost()
    {
        // 判斷有無欄位
        $hasUserId = Input::has('user_id');
        $hasTopic = Input::has('topic');
        $hasDescription = Input::has('description');

        if (( ! $hasUserId) or
            ( ! $hasTopic) or
            ( ! $hasDescription)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $userId = Input::get('user_id');
        $topic = (string)Input::get('topic');
        $description = (string)Input::get('description');

        // 判斷 userId 是否為正整數
        if ( ! VerifyFormat::isPositiveInteger($userId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $userId = (int)$userId;

        // 如果欄位為空時，回傳錯誤
        if (($topic == '') or
            ($description == '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response = array();

        $post = new Post();
        $post->setIxUser($userId);
        $post->setTopic($topic);
        $post->setDescription($description);
        list($isSuccess, $error) = PostModel::add($post);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        // 取得最新ID
        $response['id'] = $post->getId();

        $statusCode = HttpStatusCode::STATUS_201_CREATED;
        return response()->json($response, $statusCode);
    }

    /**
     * 修改單一討論主題
     * URI: GET /api/posts/{postId}
     * @param $postId
     * @return Response
     */
    public function modifyPost($postId)
    {
        // 判斷 postId 是否為正整數
        if ( ! VerifyFormat::isPositiveInteger($postId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        // 判斷有無欄位
        $hasTopic = Input::has('topic');
        $hasDescription = Input::has('description');

        if (( ! $hasTopic) or
            ( ! $hasDescription)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $topic = (string)Input::get('topic');
        $description = (string)Input::get('description');

        if (($topic == '') or
            ($description == '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }
        $response = array();

        $post = PostModel::getAllById($postId);
        $post->setTopic($topic);
        $post->setDescription($description);
        list($isSuccess, $error) = PostModel::modify($post);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json($response, $statusCode);
    }

    /**
     * 批量刪除討論主題
     * URI: GET /api/posts/postIds
     * @return Response
     */
    public function deletePosts()
    {
        // 判斷有無欄位
        $ids = Input::has('ids');

        if ( ! $ids) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $ids = Input::get('ids');

        if ( ! VerifyFormat::isValidIds($ids)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        list($isSuccess, $error) = PostModel::delete($ids);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response = array();
        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json($response, $statusCode);
    }

    /**
     * 更新喜歡單一討論主題
     * URI: GET /api/posts/{postId}/like
     * @param $postId
     * @return Response
     */
    public function updateLikesForPost($postId)
    {
        if ((int)$postId <= 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        // 判斷有無欄位
        $hasUserId = Input::has('user_id');

        if ( ! $hasUserId) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $userId = (int)Input::get('user_id');

        if ( ! VerifyFormat::isValidId($userId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        list($isSuccess, $error) = PostModel::updateLikes($postId, $userId);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response = array();
        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json($response, $statusCode);
    }
}
