<?php namespace App\Http\Controllers\api\admin;

use App\Classes\Common\HttpStatusCode;
use App\Classes\Common\VerifyFormat;
use App\Classes\Errors\Error;
use App\Classes\Errors\ErrorArgument;
use App\Classes\Errors\ErrorAuth;
use App\Classes\User;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * 新增使用者
     * URL POST /api/admin/user
     * @return Response
     */
    public function createUser()
    {
        $statusCode = HttpStatusCode::STATUS_201_CREATED;
        $response = array();

        $hasStickerType = Input::has('sticker_type');
        $hasAccount = Input::has('username');
        $hasPassword = Input::has('password');

        if ((!$hasStickerType) or
            (!$hasAccount) or
            (!$hasPassword)) {
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

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $response['id'] = $user->getId();
        return response()->json($response, $statusCode);
    }

    /**
     * 取得所有使用者清單
     * URI: GET /api/admin/users
     * @return Response
     */
    public function getUsers()
    {
        $statusCode = HttpStatusCode::STATUS_200_OK;

        $users = UserModel::getAllList();
        $user = UserModel::getCurrentLoginUser()->getId();

        if ($user !== User::SUPER_USER_ID) {
            $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $userContents = array();
        foreach ($users as $user) {
            $userContent = array();
            $userContent['id'] = $user->getId();
            $userContent['sticker_type'] = $user->getStickerType();
            $userContent['username'] = $user->getUsername();
            $userContents[] = $userContent;
        }

        return response()->json($userContents, $statusCode);
    }

    /**
     * 修改使用者資訊
     * URI: PATCH /api/admin/users/{user_id}/info
     * @param $id int
     * @return Response
     */
    public function userModify($id)
    {
        if( ! VerifyFormat::isPositiveInteger($id)) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

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

        if(($newPassword) != ($confirmPassword)){
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

        $user = UserModel::getById($id);
        $user->setStickerType($stickerType);
        list($isSuccess, $error) = UserModel::modify($user, $newPassword);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json(array(), $statusCode);
    }

    /**
     * 批量刪除使用者
     * URI: DELETE /admin/users
     * @return Response
     */
    public function deleteUsers()
    {
        $ids = Input::get('ids', array());

        if (count($ids) <= 0) {
            $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        list($isSuccess, $error) = UserModel::deleteUsers($ids);

        if ( ! $isSuccess) {
            $statusCode = HttpStatusCode::STATUS_400_BAD_REQUEST;
            return response()->json($error->convertToDisplayArray(), $statusCode);
        }

        $statusCode = HttpStatusCode::STATUS_204_NO_CONTENT;
        return response()->json(array(), $statusCode);
    }
}
