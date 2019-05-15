<?php namespace App\Classes\Common;

class SafeSql
{
    /**
     * 將array(string,string)內容轉換成sql語法
     *
     * 使用addslashes轉換array裡的內容
     *
     * @param array $items
     * @return string
     */
    public static function transformSqlInArray(array $items)
    {
        $safeArray = array();
        foreach ($items as $item) {
            $safeArray[] = addslashes($item);
        }
        return sprintf("'%s'", implode("','", $safeArray));
    }

    /**
     * 將array(int,int)內容轉換成sql語法
     *
     * 使用int轉換array裡的內容
     *
     * @param array $ids
     * @return string
     */
    public static function transformSqlInArrayByIds(array $ids)
    {
        //驗證輸入是否為array(int,int,int)格式
        if ( ! VerifyFormat::isValidIds($ids)) {
            return "''";
        }

        $safeArray = array();
        foreach ($ids as $id) {
            $safeArray[] = (int)$id;
        }
        return sprintf("'%s'", implode("','", $safeArray));
    }
}
