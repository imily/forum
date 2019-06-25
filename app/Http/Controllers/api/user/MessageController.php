<?php namespace App\Http\Controllers\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\MessageModel;

class MessageController extends Controller
{
    /**
     * 取得指定Id的留言
     * URI：GET /api/messages/{messageId}
     * @param $id
     * @return Response
     */
    public function searchMessageById($id)
    {
        // 設定response
        $response = array();

        // 當Id小於等於0時，回傳錯誤
        if ((int)$id <= 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        // 取得資料
        $message = MessageModel::getById($id);

        // 當取得的留言Id為0時，回傳錯誤
        if ($message->getId() == 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $user = $message->getUser();
        $response['id'] = $message->getId();
        $response['user_name'] = $user->getUsername();
        $response['user_sicker_type'] = $user->getStickerType();
        $response['description'] = $message->getDescription();
        $response['create_time'] = $message->getDtCreate();
        $response['update_time'] = $message->getDtUpdate();

        $statusCode = HttpStatusCode::STATUS_200_OK;
        return response()->json($response, $statusCode);
    }

    /**
     * 新增留言
     * URI：POST /api/message
     * @return Response
     */
    public function addMessage()
    {
        $response = array();

        $userId = (int)Input::get('user_id');
        $description = (String)Input::get('description');

        if (($userId == '') or
            ($description == '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $message = new Message();
        $message->setIxUser($userId);
        $message->setDescription($description);

        list($isSuccess, $error) = MessageModel::add($message);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $statusCode = HttpStatusCode::STATUS_201_CREATED;
        return response()->json($response, $statusCode);
    }

    /**
     * 修改留言
     * URI：POST /api/messages/{messageId}
     * @param $id
     * @return Response
     */
    public function modifyMessage($id)
    {
        $response = array();

        $description = (String)Input::get('description');

        if ((int)$id <= 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }
        if ($description == '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $message = MessageModel::getById($id);
        $message->setDescription($description);
        list($isSuccess, $error) = MessageModel::modify($message);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json($response, $statusCode);
    }
}
