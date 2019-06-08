<?php namespace App\Repositories;

class Filter
{
    protected $offset = 0;

    protected $limit = 10;

    /**
     * 設定偏移量
     * @param int $offset
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;
    }

    /**
     * 取得偏移量
     * @return int
     */
    public function getOffset():int
    {
        return $this->offset;
    }

    /**
     * 設定限制數量
     * @param int $limit
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * 取得限制數量
     * @return int
     */
    public function getLimit():int
    {
        return $this->limit;
    }

    /**
     * 驗證資料是否有效
     * @return bool
     */
    public function isValid()
    {
        if ($this->getOffset() < 0) {
            return false;
        }
        if ($this->getLimit() <= 0) {
            return false;
        }
        return true;
    }
}
