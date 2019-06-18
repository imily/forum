<?php namespace App\Http\Controllers\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\UserModel;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
    /**
     * 使用者註冊
     * URI:PATCH /api/registered
     * @return Response
     */
    public function userRegistered()
    {
        $hasStickerType = Input::has('sticker_type');
        $hasAccount = Input::has('username');
        $hasPassword = Input::has('password');

        if (( ! $hasStickerType) or
            ( ! $hasAccount) or
            ( ! $hasPassword)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $stickerType = (String)Input::get('sticker_type');
        $account = (String)Input::get('username');
        $password = (String)Input::get('password');

        if (($stickerType == '') or
            ($account == '') or
            ($password == '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $user = new User();
        $user->setStickerType($stickerType);
        $user->setUsername($account);

        list($isSuccess, $error) = UserModel::registerUser($user, $password);

        $statusCode = HttpStatusCode::STATUS_201_CREATED;
        $response = array();

        if (! $isSuccess) {
            $error = new Error(Error::ERROR_UNKNOWN);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response['id'] = $user->getId();
        return response()->json($response, $statusCode);
    }

    /**
     * 取得目前登入的使用者
     * URI: GET /api/user/info
     * @return Response
     */
    public function getUser()
    {
        $user = UserModel::getCurrentLoginUser();

        $response = array();
        $response['id'] = $user->getId();
        $response['sicker_type'] = $user->getStickerType();
        $response['username'] = $user->getUsername();

        $statusCode = HttpStatusCode::STATUS_200_OK;
        return response()->json($response, $statusCode);
    }

    /**
     * 修改目前使用者資訊
     * URI:PATCH /api/user/info
     * @return Response
     */
    public function userModify()
    {
        $hasStickerType = Input::has('sticker_type');
        $hasNewPassword = Input::has('new_password');
        $hasConfirmPassword = Input::has('confirm_password');

        if (( ! $hasStickerType) or
            ( ! $hasNewPassword) or
            ( ! $hasConfirmPassword)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $stickerType = (String)Input::get('sticker_type');
        $newPassword = (String)Input::get('new_password');
        $confirmPassword = (String)Input::get('confirm_password');

        if (($stickerType == '') or
            ($newPassword == '') or
            ($confirmPassword == '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        if(($newPassword) != ($confirmPassword)){
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNMATCHED_PASSWORD);
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $user = UserModel::getCurrentLoginUser();
        list($isSuccess, $error) = UserModel::modify($user, $newPassword);

        $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
        $error = new Error(Error::ERROR_UNKNOWN);

        if ($isSuccess) {
            $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
            $error = new Error(Error::ERROR_NONE);
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        return response()->json($error->convertToDisplayArray(), $statusCode);
    }
}