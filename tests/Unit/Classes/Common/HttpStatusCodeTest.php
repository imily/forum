<?php namespace Tests;

use App\Classes\Common\HttpStatusCode;

class HttpStatusCodeTest extends TestCase
{
    /**
     * 測試取得 HTTP 狀態碼
     * @return void
     */
    public function testGetCode()
    {
        $httpStatusCode = new HttpStatusCode(HttpStatusCode::STATUS_0_NONE);
        $this->assertEquals(HttpStatusCode::STATUS_0_NONE, $httpStatusCode->getCode());

        $httpStatusCode = new HttpStatusCode(HttpStatusCode::STATUS_200_OK);
        $this->assertEquals(HttpStatusCode::STATUS_200_OK, $httpStatusCode->getCode());
    }
}
