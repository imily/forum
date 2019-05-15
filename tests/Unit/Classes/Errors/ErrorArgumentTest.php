<?php namespace Tests;

use App\Classes\Errors\ErrorArgument;

class ErrorArgumentTest extends TestCase
{
    /**
     * 測試取得Error Code以及Error訊息
     * @return void
     */
    public function testGetCodeAndString()
    {
        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_EMPTY_INPUT
            , $error->getCode());
        $this->assertEquals('Argument：輸入有空值', $error->toString());


        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_INVALID);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_INVALID
            , $error->getCode());
        $this->assertEquals('Argument：無效的參數', $error->toString());


        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_RESULT_NOT_FOUND
            , $error->getCode());
        $this->assertEquals('Argument：查無指定參數的內容', $error->toString());

        $error = new ErrorArgument(ErrorArgument::ERROR_ARGUMENT_OPERATION_NOT_ALLOWED);
        $this->assertEquals(ErrorArgument::ERROR_ARGUMENT_OPERATION_NOT_ALLOWED
            , $error->getCode());
        $this->assertEquals('Argument：不允許的操作', $error->toString());
    }
}
