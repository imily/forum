<?php namespace App\Classes\Errors;

class ErrorApi extends Error
{
    const ERROR_WRONG_HTTP_STATUS = 5001;
    const ERROR_WRONG_RESPONSE    = 5002;

    /**
     * 記錄對應的錯誤顯示內容
     *
     * @return void
     */
    public function registerError()
    {
        parent::registerError();
        $this->errorTable[static::ERROR_WRONG_HTTP_STATUS] = '狀態錯誤';
        $this->errorTable[static::ERROR_WRONG_RESPONSE] = '回應內容錯誤';
    }
}
