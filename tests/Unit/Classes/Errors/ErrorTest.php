<?php namespace Tests;

use App\Classes\Errors\Error;

class ErrorTest extends TestCase
{
    /**
     * 測試取得Error Code以及Error訊息
     * @return void
     */
    public function testGetCodeAndString()
    {
        $error = new Error(Error::ERROR_NONE);
        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
        $this->assertEquals('無錯誤', $error->toString());

        $error->setCode(Error::ERROR_UNKNOWN);
        $this->assertEquals(Error::ERROR_UNKNOWN, $error->getCode());
        $this->assertEquals('未知的錯誤', $error->toString());
    }

    /**
     * 測試取得未知的Error Code以及Error訊息
     * @return void
     */
    public function testGetCodeAndStringByNotExisted()
    {
        $error = new Error(999);
        $this->assertEquals(Error::ERROR_UNKNOWN, $error->getCode());
        $this->assertEquals('未知的錯誤', $error->toString());
    }

    /**
     * 測試將錯誤轉換為要顯示的陣列內容
     * @return void
     */
    public function testConvertToDisplayArray()
    {
        $error = new Error(Error::ERROR_NONE);

        $outputArray = array();
        $outputArray['error'] = 0;
        $this->assertEquals($outputArray, $error->convertToDisplayArray());
    }
}
