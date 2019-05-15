<?php namespace App\Classes\Errors;

class ErrorDB extends Error
{
    const ERROR_DB_FAILED_INSERT = 2001;
    const ERROR_DB_FAILED_UPDATE = 2002;
    const ERROR_DB_FAILED_DELETE = 2003;
    const ERROR_DATA_DUPLICATE   = 2004;

    /**
     * 記錄對應的錯誤顯示內容
     *
     * @return void
     */
    public function registerError()
    {
        parent::registerError();
        $this->errorTable[static::ERROR_DB_FAILED_INSERT] = 'DB：新增發生錯誤';
        $this->errorTable[static::ERROR_DB_FAILED_UPDATE] = 'DB：編輯發生錯誤';
        $this->errorTable[static::ERROR_DB_FAILED_DELETE] = 'DB：刪除發生錯誤';
        $this->errorTable[static::ERROR_DATA_DUPLICATE]   = 'DB：新增錯誤,資料重複';
    }
}
