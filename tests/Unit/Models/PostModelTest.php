<?php namespace Tests;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Repositories\Filter;

class PostModelTest extends DatabaseTestCase
{
    /**
     * test
     * @return void
     */
    public function testGetAllList()
    {
        session()->put('userId', 4);
        list($isSuccess, $error) = PostModel::addLike(2, 4);
        print_r(PostModel::getById(2));
    }
}
