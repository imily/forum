<?php namespace Tests;

use App\Classes\Common\VerifyFormat;

class VerifyFormatTest extends TestCase
{
    /**
     * 測試日期格式是否驗證正確
     * @return void
     */
    public function testIsValidDateTime()
    {
        $date = '2011-01-01 12:12:12';
        $isValid = VerifyFormat::isValidDateTime($date);
        $this->assertTrue($isValid);

        $date = '2011-01-01 12:12:12----------';
        $isValid = VerifyFormat::isValidDateTime($date);
        $this->assertFalse($isValid);

        $date = '2011-001-01 12:12:12';
        $isValid = VerifyFormat::isValidDateTime($date);
        $this->assertFalse($isValid);
    }

    /**
     * 測試Id是否驗證正確
     * @return void
     */
    public function testIsValidId()
    {
        $id = 1;
        $isValid = VerifyFormat::isValidId($id);
        $this->assertTrue($isValid);

        $id = 01;
        $isValid = VerifyFormat::isValidId($id);
        $this->assertTrue($isValid);

        $id = '1';
        $isValid = VerifyFormat::isValidId($id);
        $this->assertTrue($isValid);

        $id = '20';
        $isValid = VerifyFormat::isValidId($id);
        $this->assertTrue($isValid);

        $id = 0;
        $isValid = VerifyFormat::isValidId($id);
        $this->assertFalse($isValid);

        $id = -1;
        $isValid = VerifyFormat::isValidId($id);
        $this->assertFalse($isValid);

        $id = '-1';
        $isValid = VerifyFormat::isValidId($id);
        $this->assertFalse($isValid);

        $id = '02';
        $isValid = VerifyFormat::isValidId($id);
        $this->assertTrue($isValid);

        $id = '非int';
        $isValid = VerifyFormat::isValidId($id);
        $this->assertFalse($isValid);

        $id = '3abfghfgh';
        $isValid = VerifyFormat::isValidId($id);
        $this->assertFalse($isValid);

        $id = '';
        $isValid = VerifyFormat::isValidId($id);
        $this->assertFalse($isValid);
    }

    /**
     * 測試Ids是否驗證正確
     * @return void
     */
    public function testIsValidIds()
    {
        $ids = array();
        $ids[] = 1;
        $ids[] = 2;
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertTrue($isValid);

        $ids = array();
        $ids[] = 1;
        $ids[] = 02;
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertTrue($isValid);

        $ids = array();
        $ids[] = '1';
        $ids[] = '2';
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertTrue($isValid);

        $ids = array();
        $ids[] = 1;
        $ids[] = '2';
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertTrue($isValid);

        $ids = array();
        $ids[] = 1;
        $ids[] = '20';
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertTrue($isValid);

        $ids = array();
        $ids[] = 1;
        $ids[] = '02';
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertTrue($isValid);

        $ids = array();
        $ids[] = 1;
        $ids[] = '非int';
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertFalse($isValid);

        $ids = array();
        $ids[] = 1;
        $ids[] = '3abfghfgh';
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertFalse($isValid);

        $ids = array();
        $isValid = VerifyFormat::isValidIds($ids);
        $this->assertFalse($isValid);
    }

    /**
     * 測試檢查輸入參數是否為正整數
     * @return void
     */
    public function testIsPositiveInteger()
    {
        $number = 1;
        $isInteger = VerifyFormat::isPositiveInteger($number);
        $this->assertTrue($isInteger);

        $number = '1';
        $isInteger = VerifyFormat::isPositiveInteger($number);
        $this->assertTrue($isInteger);

        $number = 01;
        $isInteger = VerifyFormat::isPositiveInteger($number);
        $this->assertTrue($isInteger);

        $number = 0;
        $isInteger = VerifyFormat::isPositiveInteger($number);
        $this->assertFalse($isInteger);

        $number = '01';
        $isInteger = VerifyFormat::isPositiveInteger($number);
        $this->assertTrue($isInteger);

        $number = '非int';
        $isInteger = VerifyFormat::isPositiveInteger($number);
        $this->assertFalse($isInteger);

        $number = '1abc';
        $isInteger = VerifyFormat::isPositiveInteger($number);
        $this->assertFalse($isInteger);

        $number = '';
        $isInteger = VerifyFormat::isPositiveInteger($number);
        $this->assertFalse($isInteger);
    }

    /**
     * 測試array裡的內容是否都存放正整數
     * @return void
     */
    public function testIsPositiveIntegers()
    {
        $nums = array(1,2);
        $isValid = VerifyFormat::isPositiveIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array('1','2');
        $isValid = VerifyFormat::isPositiveIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'2');
        $isValid = VerifyFormat::isPositiveIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'20');
        $isValid = VerifyFormat::isPositiveIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'02');
        $isValid = VerifyFormat::isPositiveIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'非int');
        $isValid = VerifyFormat::isPositiveIntegers($nums);
        $this->assertFalse($isValid);

        $nums = array(1,'3abfghfgh');
        $isValid = VerifyFormat::isPositiveIntegers($nums);
        $this->assertFalse($isValid);

        $nums = array();
        $isValid = VerifyFormat::isPositiveIntegers($nums);
        $this->assertFalse($isValid);
    }

    /**
     * 測試檢查輸入參數是否為整數
     * @return void
     */
    public function testIsInteger()
    {
        $number = 1;
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = '1';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = 01;
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = '01';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = 0;
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = -1;
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = '-1';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = 10;
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = '10';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = 1.5;
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertFalse($isInteger);

        $number = '1.5';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertFalse($isInteger);

        $number = 1.0;
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertTrue($isInteger);

        $number = '1.0';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertFalse($isInteger);

        $number = '非int';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertFalse($isInteger);

        $number = '1abc';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertFalse($isInteger);

        $number = '';
        $isInteger = VerifyFormat::isInteger($number);
        $this->assertFalse($isInteger);
    }

    /**
     * 測試array裡的內容是否都存放整數
     * @return void
     */
    public function testIsIntegers()
    {
        $nums = array(1,2);
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array('1','2');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'2');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,20);
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'20');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'02');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(0,1);
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,-1);
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'-1');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,1.0);
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertTrue($isValid);

        $nums = array(1,'1.0');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertFalse($isValid);

        $nums = array(1,1.5);
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertFalse($isValid);

        $nums = array(1,'1.5');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertFalse($isValid);

        $nums = array(1,'非int');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertFalse($isValid);

        $nums = array(1,'3abfghfgh');
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertFalse($isValid);

        $nums = array();
        $isValid = VerifyFormat::isIntegers($nums);
        $this->assertFalse($isValid);
    }
}
