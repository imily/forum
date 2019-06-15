<?php namespace Tests;

use App\Classes\Errors\ErrorAuth;

class ErrorAuthTest extends TestCase
{
    /**
     * 測試取得Error Code以及Error訊息
     * @return void
     */
    public function testGetCodeAndString()
    {
        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_FAILED_LOGIN);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_FAILED_LOGIN
            , $error->getCode());
        $this->assertEquals('Auth：登入發生錯誤'
            , $error->toString());


        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_FAILED_LOGOUT);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_FAILED_LOGOUT
            , $error->getCode());
        $this->assertEquals('Auth：登出發生錯誤'
            , $error->toString());


        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_EXISTED_USERNAME);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_EXISTED_USERNAME
            , $error->getCode());
        $this->assertEquals('Auth：帳號已經存在'
            , $error->toString());

        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_PASSWORD);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_INCORRECT_PASSWORD
            , $error->getCode());
        $this->assertEquals('Auth：密碼輸入有誤'
            , $error->toString());

        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INCORRECT_STICKER_TYPE);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_INCORRECT_STICKER_TYPE
            , $error->getCode());
        $this->assertEquals('Auth：頭像類型輸入有誤'
            , $error->toString());

        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_FAILED_GET_ID);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_FAILED_GET_ID
            , $error->getCode());
        $this->assertEquals('Auth：取得 id 失敗'
            , $error->toString());

        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNAUTHORIZED);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNAUTHORIZED
            , $error->getCode());
        $this->assertEquals('Auth：未授權'
            , $error->toString());

        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNDELETABLE);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNDELETABLE
            , $error->getCode());
        $this->assertEquals('Auth：不可被刪除'
            , $error->toString());

        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_INACTIVE);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_INACTIVE
            , $error->getCode());
        $this->assertEquals('Auth：已停用'
            , $error->toString());

        $error = new ErrorAuth(ErrorAuth::ERROR_AUTH_UNCHANGEABLE);
        $this->assertEquals(ErrorAuth::ERROR_AUTH_UNCHANGEABLE
            , $error->getCode());
        $this->assertEquals('Auth：不可被修改'
            , $error->toString());
    }
}
