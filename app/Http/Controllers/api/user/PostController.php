<?php namespace App\Http\Controllers\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Common\VerifyFormat;
use App\Classes\Errors\ErrorArgument;
use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Repositories\Filter;
use App\Classes\Post;
use App\Classes\Message;
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

            $postContent['messages']['likes'] = $likeContents;
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
    private function generatePostsByFilter(Filter $filter, Filter $messageFilter){
        if ( ! $filter->isValid()) {
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
     * 取得所有討論主題
     * URI: GET /api/posts
     * @return Response
     */
    public function getPost()
    {
        $offset = (int)Input::get('offset', 0);
        $limit = (int)Input::get('limit', 0);
        $messageOffset = (int)Input::get('message_offset', 0);
        $messageLimit = (int)Input::get('message_limit', 0);

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
     * 取得單一討論主題
     * URI: GET /api/posts/{postId}
     * @return Response
     */
    public function getPostById($id)
    {
        // 設定response
        $response = array();

        $messageOffset = (int)Input::get('message_offset', 0);
        $messageLimit = (int)Input::get('message_limit', 10);

        // 當Id小於等於0時，回傳錯誤
        if ((int)$id <= 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        // 取得資料
        $messageFilter = new Filter();
        $messageFilter->setOffset($messageOffset);
        $messageFilter->setLimit($messageLimit);
        $post = PostModel::getById($id, $messageFilter);

        // 當取得的留言Id為0時，回傳錯誤
        if ($post->getId() == 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $postUser = $post->getUserObject();
        $messages = $post->getMessage();
        $users = $post->getUser();

        $response['id'] = $post->getId();
        $response['user_name'] = $postUser->getUsername();
        $response['user_sicker_type'] = $postUser->getStickerType();

        $response['messages']['total_amount'] = count($messages);
        foreach ($messages as $message) {
            $messageUser = $message->getUser();
            $response['messages']['data']['user_name'] = $messageUser->getUsername();
            $response['messages']['data']['description'] = $message->getDescription();
        }

        $response['topic'] = $post->getTopic();
        $response['description'] = $post->getDescription();

        foreach ($users as $user) {
            $response['likes']['user_name'] = $user->getUsername();
        }

        $response['create_time'] = $post->getDtCreate();
        $response['update_time'] = $post->getDtUpdate();

        $statusCode = HttpStatusCode::STATUS_200_OK;
        return response()->json($response, $statusCode);
    }
}
