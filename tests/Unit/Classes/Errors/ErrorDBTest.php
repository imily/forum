<?php namespace Tests;

use App\Classes\Errors\ErrorDB;

class ErrorDBTest extends TestCase
{
    /**
     * 測試取得Error Code以及Error訊息
     * @return void
     */
    public function testGetCodeAndString()
    {
        $error = new ErrorDB(ErrorDB::ERROR_DB_FAILED_INSERT);
        $this->assertEquals(ErrorDB::ERROR_DB_FAILED_INSERT
            , $error->getCode());
        $this->assertEquals('DB：新增發生錯誤'
            , $error->toString());


        $error = new ErrorDB(ErrorDB::ERROR_DB_FAILED_UPDATE);
        $this->assertEquals(ErrorDB::ERROR_DB_FAILED_UPDATE
            , $error->getCode());
        $this->assertEquals('DB：編輯發生錯誤'
            , $error->toString());


        $error = new ErrorDB(ErrorDB::ERROR_DB_FAILED_DELETE);
        $this->assertEquals(ErrorDB::ERROR_DB_FAILED_DELETE
            , $error->getCode());
        $this->assertEquals('DB：刪除發生錯誤'
            , $error->toString());


        $error = new ErrorDB(ErrorDB::ERROR_DATA_DUPLICATE);
        $this->assertEquals(ErrorDB::ERROR_DATA_DUPLICATE
            , $error->getCode());
        $this->assertEquals('DB：新增錯誤,資料重複'
            , $error->toString());
    }
}
