<?php namespace Tests;

use App\Repositories\Filter;

class FilterTest extends TestCase
{
    /**
     * 測試資料是否有效
     * @return void
     */
    public function testIsValid()
    {
        $filter = new Filter();

        //offset設為0,limit設為5
        $filter->setOffset(0);
        $filter->setLimit(5);
        $this->assertTrue($filter->isValid());

        //offset設為5,limit設為10
        $filter->setOffset(5);
        $filter->setLimit(10);
        $this->assertTrue($filter->isValid());
    }

    /**
     * 測試資料是否有效(fail)
     * @return void
     */
    public function testNotValid()
    {
        $filter = new Filter();
        //offset設定小於0
        $filter->setOffset(-1);
        $filter->setLimit(5);
        $this->assertFalse($filter->isValid());

        //limit設定等於0
        $filter->setOffset(0);
        $filter->setLimit(0);
        $this->assertFalse($filter->isValid());

        //limit設定小於0
        $filter->setOffset(0);
        $filter->setLimit(-1);
        $this->assertFalse($filter->isValid());
    }
}
