<?php namespace App\Http\Controllers\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Common\VerifyFormat;
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
     * @param $messageId
     * @return Response
     */
    public function getMessageById($messageId)
    {
        // 設定response
        $response = array();

        // 當Id小於等於0時，回傳錯誤
        if ((int)$messageId <= 0) {
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
        $hasUserId = Input::has('user_id');
        $hasDescription = Input::has('description');

        if (( ! $hasUserId) or
            ( ! $hasDescription)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $userId = Input::get('user_id');
        $description = (String)Input::get('description');

        // 判斷 userId 是否為正整數
        if ( ! VerifyFormat::isPositiveInteger($userId)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $userId = (int)$userId;

        if (($userId == '') or
            ($description == '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response = array();

        $message = new Message();
        $message->setIxUser($userId);
        $message->setDescription($description);

        list($isSuccess, $error) = MessageModel::add($message);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error, $statusCode);
        }

        $statusCode = HttpStatusCode::STATUS_201_CREATED;
        return response()->json($response, $statusCode);
    }

    /**
     * 修改留言
     * URI：POST /api/messages/{messageId}
     * @param $messageId
     * @return Response
     */
    public function modifyMessage($messageId)
    {
        if ((int)$messageId <= 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $hasDescription = Input::has('description');

        if ( ! $hasDescription) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $description = (String)Input::get('description');

        if ($description == '') {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response = array();

        $message = MessageModel::getById($messageId);
        $message->setDescription($description);
        list($isSuccess, $error) = MessageModel::modify($message);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error, $statusCode);
        }

        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json($response, $statusCode);
    }
}
