<?php namespace App\Http\Controllers\api;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;
use App\Classes\User;
use App\Models\UserModel;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
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

        $statusCode = HttpStatusCode::STATUS_201_CREATED;
        $response = array();

        $user = new User();
        $user->setStickerType($stickerType);
        $user->setUsername($account);

        list($isSuccess, $error) = UserModel::registerUser($user, $password);

        if (! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response['id'] = $user->getId();
        return response()->json($response, $statusCode);
    }
}
