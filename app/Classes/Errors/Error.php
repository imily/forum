<?php namespace App\Classes\Errors;

class Error
{
    const ERROR_NONE = 0;
    const ERROR_UNKNOWN = 1;

    protected $code = Error::ERROR_UNKNOWN;
    protected $errorTable = array();

    /**
     * 建構子
     *
     * @param int $code
     */
    public function __construct(int $code)
    {
        $this->setCode($code);
        $this->registerError();
    }

    /**
     * 設定錯誤編號
     *
     * @param int $code
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }

    /**
     * 取得錯誤編號
     *
     * @return int
     */
    public function getCode():int
    {
        if (isset($this->errorTable[$this->code])) {
            return $this->code;
        }
        return static::ERROR_UNKNOWN;
    }

    /**
     * 取得確實的錯誤編號
     *
     * @return int
     */
    public function getRealErrorCode()
    {
        return (int)$this->code;
    }

    /**
     * 輸出錯誤的字串內容
     *
     * @return string
     */
    public function toString()
    {
        return $this->errorTable[$this->getCode()];
    }

    /**
     * 記錄對應的錯誤顯示內容
     *
     * @return void
     */
    protected function registerError()
    {
        $this->errorTable[static::ERROR_NONE]    = '無錯誤';
        $this->errorTable[static::ERROR_UNKNOWN] = '未知的錯誤';
    }

    /**
     * 將錯誤轉換為要顯示的陣列內容
     *
     * @return array
     */
    public function convertToDisplayArray()
    {
        $errorContent = array();
        $errorContent['error'] = $this->getCode();

        return $errorContent;
    }
}
