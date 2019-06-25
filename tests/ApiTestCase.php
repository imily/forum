<?php namespace Tests;

use App\Classes\Errors\Error;
use App\Models\UserModel;

class ApiTestCase extends DatabaseTestCase
{
    protected $header = array();

    /**
     * 登入一般使用者
     * @return void
     */
    protected function loginForTest()
    {
        $account = 'imily';
        $password = 1234;
        list($isSuccess, $error) = UserModel::login($account, $password);
        $this->assertTrue($isSuccess);
        $this->assertEquals(Error::ERROR_NONE, $error->getCode());
    }

    /**
     * 登出使用者
     * @return void
     */
    protected function logoutForTest()
    {
        UserModel::logout();
    }
}
