<?php namespace App\Classes\Errors;

class ErrorAuth extends Error
{
    const ERROR_AUTH_FAILED_LOGIN       = 1001;
    const ERROR_AUTH_FAILED_LOGOUT      = 1002;
    const ERROR_AUTH_EXISTED_EMAIL      = 1003;
    const ERROR_AUTH_EXISTED_USERNAME   = 1004;
    const ERROR_AUTH_INCORRECT_EMAIL    = 1005;
    const ERROR_AUTH_INCORRECT_PASSWORD = 1006;
    const ERROR_AUTH_UNMATCHED_PASSWORD = 1007;
    const ERROR_AUTH_FAILED_GET_ID      = 1008;
    const ERROR_AUTH_UNAUTHORIZED       = 1009;
    const ERROR_AUTH_UNDELETABLE        = 1010;
    const ERROR_AUTH_INACTIVE           = 1011;
    const ERROR_AUTH_UNCHANGEABLE       = 1012;

    /**
     * 記錄對應的錯誤顯示內容
     *
     * @return void
     */
    public function registerError()
    {
        parent::registerError();
        $this->errorTable[static::ERROR_AUTH_FAILED_LOGIN]       = 'Auth：登入發生錯誤';
        $this->errorTable[static::ERROR_AUTH_FAILED_LOGOUT]      = 'Auth：登出發生錯誤';
        $this->errorTable[static::ERROR_AUTH_EXISTED_EMAIL]      = 'Auth：email 已經存在';
        $this->errorTable[static::ERROR_AUTH_EXISTED_USERNAME]   = 'Auth：名稱已經存在';
        $this->errorTable[static::ERROR_AUTH_INCORRECT_EMAIL]    = 'Auth：email 輸入有誤';
        $this->errorTable[static::ERROR_AUTH_INCORRECT_PASSWORD] = 'Auth：密碼輸入有誤';
        $this->errorTable[static::ERROR_AUTH_UNMATCHED_PASSWORD] = 'Auth：兩次密碼不相符';
        $this->errorTable[static::ERROR_AUTH_FAILED_GET_ID]      = 'Auth：取得 id 失敗';
        $this->errorTable[static::ERROR_AUTH_UNAUTHORIZED]       = 'Auth：未授權';
        $this->errorTable[static::ERROR_AUTH_UNDELETABLE]        = 'Auth：不可被刪除';
        $this->errorTable[static::ERROR_AUTH_INACTIVE]           = 'Auth：已停用';
        $this->errorTable[static::ERROR_AUTH_UNCHANGEABLE]       = 'Auth：不可被修改';
    }
}
