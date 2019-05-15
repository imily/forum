<?php namespace App\Classes\Errors;

class ErrorCustom
{
    const ERROR_NONE = 0;
    const ERROR_UNKNOWN = 1;

    protected $code = Error::ERROR_UNKNOWN;
    protected $message = '';

    /**
     * 建構子
     *
     * @param int $code
     */
    public function __construct()
    {

    }

    /**
     * 設定錯誤編號
     *
     * @param int|string code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * 取得錯誤編號
     *
     * @return int|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 設定錯誤訊息內容
     * @param $message
     * @return void
     */
    public function setString(string $message)
    {
        $this->message = $message;
    }

    /**
     * 輸出錯誤的字串內容
     *
     * @return string
     */
    public function toString():string
    {
        return $this->message;
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
