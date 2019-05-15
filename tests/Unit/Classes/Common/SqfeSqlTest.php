<?php namespace Tests;

use App\Classes\Common\SafeSql;

class SafeSqlTest extends TestCase
{
    /**
     * 測試將array(string,string)內容轉換成sql語法
     * @return void
     */
    public function testTransformSqlInArray()
    {
        $items = array();
        $items[] = 'test1';
        $items[] = 'test2';
        $items[] = 'test3';

        $sqlContent = SafeSql::transformSqlInArray($items);
        $this->assertEquals("'test1','test2','test3'", $sqlContent);
    }

    /**
     * 測試將array(string,string)內容轉換成sql語法 (輸入空array)
     * @return void
     */
    public function testTransformSqlInArrayWithEmpty()
    {
        $items = array();

        $sqlContent = SafeSql::transformSqlInArray($items);
        $this->assertEquals("''", $sqlContent);
    }

    /**
     * 測試將array(string,string)內容轉換成sql語法 (有特殊字元)
     * @return void
     */
    public function testTransformSqlInArrayWithInValidItems()
    {
        $items = array();
        $items[] = 'test1';
        $items[] = "test2'";

        $sqlContent = SafeSql::transformSqlInArray($items);
        $this->assertEquals("'test1','test2\''", $sqlContent);
    }

    /**
     * 測試將array(int,int)內容轉換成sql語法
     * @return void
     */
    public function testTransformSqlInArrayByIds()
    {
        $ids = array();
        $ids[] = 1;
        $ids[] = 2;
        $ids[] = 3;
        $sqlContent = SafeSql::transformSqlInArrayByIds($ids);
        $this->assertEquals("'1','2','3'", $sqlContent);

        $ids = array();
        $ids[] = 1;
        $ids[] = '2';
        $ids[] = 3;
        $sqlContent = SafeSql::transformSqlInArrayByIds($ids);
        $this->assertEquals("'1','2','3'", $sqlContent);

        $ids = array();
        $ids[] = 1;
        $ids[] = '02';
        $ids[] = 3;
        $sqlContent = SafeSql::transformSqlInArrayByIds($ids);
        $this->assertEquals("'1','2','3'", $sqlContent);

        $ids = array();
        $ids[] = 1;
        $ids[] = '20';
        $ids[] = 3;
        $sqlContent = SafeSql::transformSqlInArrayByIds($ids);
        $this->assertEquals("'1','20','3'", $sqlContent);
    }

    /**
     * 測試將array(int,int)內容轉換成sql語法 (輸入空array)
     * @return void
     */
    public function testTransformSqlInArrayByIdsWithEmpty()
    {
        $ids = array();
        $sqlContent = SafeSql::transformSqlInArrayByIds($ids);
        $this->assertEquals("''", $sqlContent);
    }

    /**
     * 測試將array(int,int)內容轉換成sql語法  (有特殊字元)
     * @return void
     */
    public function testTransformSqlInArrayWithInValidIds()
    {
        $ids = array();
        $ids[] = ';1';
        $ids[] = 2;
        $sqlContent = SafeSql::transformSqlInArrayByIds($ids);
        $this->assertEquals("''", $sqlContent);


        $ids = array();
        $ids[] = 1;
        $ids[] = "2'";
        $sqlContent = SafeSql::transformSqlInArrayByIds($ids);
        $this->assertEquals("''", $sqlContent);


        $ids = array();
        $ids[] = 1;
        $ids[] = '2t';
        $sqlContent = SafeSql::transformSqlInArrayByIds($ids);
        $this->assertEquals("''", $sqlContent);
    }
}
