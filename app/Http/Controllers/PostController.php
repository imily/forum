<?php namespace App\Http\Controllers;

use Illuminate\View\View;

class PostController extends Controller
{
    public function forum()
    {
        return view('forum');
    }

    public function addForum()
    {
        return view('forum_add');
    }
}
