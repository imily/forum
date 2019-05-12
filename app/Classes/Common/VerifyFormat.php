<?php namespace App\Classes\Common;

class VerifyFormat
{
    /**
     * 檢查時間日期格式是否正確 '0000-00-00 00:00:00'
     * @param $sDateTime
     * @return bool
     */
    public static function isValidDate($sDateTime)
    {
        $format = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/i';
        $isMatch = preg_match($format, $sDateTime);

        if ($isMatch) {
            return true;
        }

        return false;
    }

    /**
     * 檢查輸入參數是否為正整數
     * 可輸入資料型態為數字或字串的內容
     * @param int|string $Id
     * @return bool
     */
    public static function isValidId($Id)
    {
        return static::isPositiveInteger($Id);
    }

    /**
     * 檢查array裡的內容是否都存放id(正整數的int)
     * 空array回應無效
     * @param array $Ids
     * @return bool
     */
    public static function isValidIds(array $Ids)
    {
        if (empty($Ids)) {
            return false;
        }

        //其中一筆id有誤，回傳Error離開
        foreach ($Ids as $id) {
            $isValidId = static::isValidId($id);
            if (!$isValidId) {
                return false;
            }
        }
        return true;
    }

    /**
     * 檢查輸入參數是否為正整數
     * 可輸入資料型態為數字或字串的內容
     * @param int|string $number
     * @return bool
     */
    public static function isPositiveInteger($number)
    {
        if ((int)$number <= 0) {
            return false;
        }

        //設定比對的規則
        $idFormat = "/^[0-9]+$/";
        if (!preg_match($idFormat, $number)) {
            return false;
        }

        return true;
    }

    /**
     * 檢查array裡的內容是否都存放正整數
     * 空array回應無效
     * @param array $numbers
     * @return bool
     */
    public static function isPositiveIntegers(array $numbers)
    {
        if (empty($numbers)) {
            return false;
        }

        //其中一筆id有誤，回傳Error離開
        foreach ($numbers as $number) {
            $isValid = static::isPositiveInteger($number);
            if (!$isValid) {
                return false;
            }
        }
        return true;
    }

    /**
     * 檢查輸入參數是否為整數
     * 可輸入資料型態為數字或字串的內容
     * @param int|string $number
     * @return bool
     */
    public static function isInteger($number)
    {
        //設定比對規則
        $intFormat = "/^[-]?[0-9]+$/";
        if ( ! preg_match($intFormat, $number)) {
            return false;
        }
        return true;
    }

    /**
     * 檢查array裡的內容是否都存放整數
     * 空array回應無效
     * @param array $numbers
     * @return bool
     */
    public static function isIntegers(array $numbers)
    {
        if (empty($numbers)) {
            return false;
        }

        //其中一筆id有誤，回傳Error離開
        foreach ($numbers as $number){
            $isValid = static::isInteger($number);
            if ( ! $isValid) {
                return false;
            }
        }
        return true;
    }
}
