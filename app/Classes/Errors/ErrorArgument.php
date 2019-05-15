<?php namespace App\Classes\Errors;

class ErrorArgument extends Error
{
    const ERROR_ARGUMENT_EMPTY_INPUT       = 3001;
    const ERROR_ARGUMENT_INVALID           = 3002;
    const ERROR_ARGUMENT_RESULT_NOT_FOUND  = 3003;
    const ERROR_ARGUMENT_OPERATION_NOT_ALLOWED  = 3004;

    /**
     * 記錄對應的錯誤顯示內容
     *
     * @return void
     */
    public function registerError()
    {
        parent::registerError();
        $this->errorTable[static::ERROR_ARGUMENT_EMPTY_INPUT] = 'Argument：輸入有空值';
        $this->errorTable[static::ERROR_ARGUMENT_INVALID] = 'Argument：無效的參數';
        $this->errorTable[static::ERROR_ARGUMENT_RESULT_NOT_FOUND] = 'Argument：查無指定參數的內容';
        $this->errorTable[static::ERROR_ARGUMENT_OPERATION_NOT_ALLOWED] = 'Argument：不允許的操作';
    }
}
