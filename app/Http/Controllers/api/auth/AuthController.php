<?php namespace App\Http\Controllers\api\auth;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Errors\ErrorArgument;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
    /**
     * 使用者登入
     * URL: POST /api/auth/login
     * @return Response
     */
    public function login()
    {
        $statusCode = HttpStatusCode::STATUS_200_OK;
        $hasAccount = Input::has('account');
        $hasPassword = Input::has('password');

        if (( ! $hasAccount) or
            ( ! $hasPassword)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $account = (String)Input::get('account');
        $password = (String)Input::get('password');

        if (($account == '') or
            ($password == '')) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        list($isSuccess, $error) = UserModel::login($account, $password);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response = array();
        $response['id'] = UserModel::getCurrentLoginUser()->getId();
        return response()->json($response, $statusCode);
    }

    /**
     * 使用者登出
     * URL POST /api/auth/logout
     * @return Response
     */
    public function logOut()
    {
        UserModel::logout();
        $response = array();
        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json($response, $statusCode);
    }
}
