<?php namespace App\Http\Controllers\api\user;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Common\VerifyFormat;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\UserModel;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * 取得目前登入的使用者
     * URI: GET /api/user/info
     * @return Response
     */
    public function getUser()
    {
        $user = UserModel::getCurrentLoginUser();

        if ($user->getId() === 0) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

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

        $stickerType = Input::get('sticker_type');
        $newPassword = (String)Input::get('new_password');
        $confirmPassword = (String)Input::get('confirm_password');

        if (($stickerType == '') or
            ($newPassword == '') or
            ($confirmPassword == '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        if (($newPassword) != ($confirmPassword)) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNMATCHED_PASSWORD);
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $stickerType = (int)Input::get('sticker_type');

        if ( ! VerifyFormat::isPositiveInteger($stickerType)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $user = UserModel::getCurrentLoginUser();
        $user->setStickerType($stickerType);
        list($isSuccess, $error) = UserModel::modify($user, $newPassword);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json(array(), $statusCode);
    }
}
