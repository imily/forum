<?php namespace Tests;

use Illuminate\Support\Facades\DB;
use mysqli;
use Cache;
use Config;

abstract class DatabaseTestCase extends TestCase
{
    protected static $initializated = false;
    protected static $databaseName = '';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = parent::createApplication();
        return $app;
    }

    /**
     * 建立非使用Laravel專案的DB套件功能的mysqli物件
     * 因為呼叫預設DB套件將會遇上使用了尚未定義的database錯誤
     * @return mysqli
     */
    private function getAloneMysqlConnecter()
    {
        $mysqli = new mysqli("localhost"
            , Config::get('database.connections.mysql_testing.username')
            , Config::get('database.connections.mysql_testing.password'));
        return $mysqli;
    }
    /**
     * 初始化測試專用資料庫
     *
     * @return void
     */
    private function initializeTestingDatabase()
    {
        static::$databaseName = Config::get('database.connections.mysql_testing.database');
        //呼叫獨立的Mysqli物件執行Drop和Create DATABASE指令。
        $sql = sprintf('DROP DATABASE IF EXISTS `%s`', static::$databaseName);
        $this->getAloneMysqlConnecter()->query($sql);
        $sql = sprintf('CREATE DATABASE IF NOT EXISTS `%s`', static::$databaseName);
        $this->getAloneMysqlConnecter()->query($sql);
        //建立後重載DB連線
        DB::reconnect();

        //建立migrate
        $this->artisan('migrate');
        //測試退回migrate後再重建migrate(測試退回的程式碼是否有誤)
        if ( ! static::$initializated) {
            $this->artisan('migrate:refresh');
        }
        //寫入測試用的假資料
        $this->seed('DatabaseSeeder');
    }

    /**
     * 建立
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->initializeTestingDatabase();
        static::$initializated = true;
    }

    /**
     * 拆除
     *
     * @return void
     */
    public function tearDown()
    {
        Cache::flush();
        session()->flush();
        $sql = sprintf('DROP DATABASE IF EXISTS `%s`;'
            , static::$databaseName);
        $this->getAloneMysqlConnecter()->query($sql);
        parent::tearDown();
    }
}
