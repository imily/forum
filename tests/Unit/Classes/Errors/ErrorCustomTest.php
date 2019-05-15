<?php namespace Tests;

use App\Classes\Errors\ErrorCustom;

class ErrorCustomTest extends TestCase
{
    /**
     * 測試取得Error Code
     * @return void
     */
    public function testSetAndGetCode()
    {
        $error = new ErrorCustom();
        $error->setCode(199999);
        $this->assertEquals(199999, $error->getCode());

        $error = new ErrorCustom();
        $error->setCode('000');
        $this->assertEquals('000', $error->getCode());
    }

    /**
     * 測試取得Error訊息
     * @return void
     */
    public function testSetAndToString()
    {
        $error = new ErrorCustom();
        $error->setString('test錯誤');
        $this->assertEquals('test錯誤', $error->toString());
    }

    /**
     * 測試將錯誤轉換為要顯示的陣列內容
     * @return void
     */
    public function testConvertToDisplayArray()
    {
        $error = new ErrorCustom();
        $error->setCode(199999);
        $error->setString('test錯誤');
        $this->assertEquals(199999, $error->getCode());

        $outputArray = array();
        $outputArray['error'] = 199999;
        $this->assertEquals($outputArray, $error->convertToDisplayArray());
    }
}
