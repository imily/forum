<?php namespace Tests;

use App\Classes\Errors\ErrorApi;

class ErrorApiTest extends TestCase
{
    /**
     * 測試取得Error Code以及Error訊息
     * @return void
     */
    public function testGetCodeAndString()
    {
        $error = new ErrorApi(ErrorApi::ERROR_WRONG_HTTP_STATUS);
        $this->assertEquals(ErrorApi::ERROR_WRONG_HTTP_STATUS
            , $error->getCode());
        $this->assertEquals('狀態錯誤', $error->toString());


        $error = new ErrorApi(ErrorApi::ERROR_WRONG_RESPONSE);
        $this->assertEquals(ErrorApi::ERROR_WRONG_RESPONSE
            , $error->getCode());
        $this->assertEquals('回應內容錯誤', $error->toString());
    }
}
