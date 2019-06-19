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
        $postFilter = new Filter();
        $postFilter->setLimit(2);
        $postFilter->setOffset(0);

        $messageFilter = new Filter();
        $messageFilter->setLimit(1);
        $messageFilter->setOffset(0);
        dd(PostModel::getList($postFilter, $messageFilter));
    }
}
