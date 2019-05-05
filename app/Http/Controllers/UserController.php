<?php namespace App\Http\Controllers;

use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * 登入介面
     * @return View
     */
    public function login()
    {
        return view('member_login');
    }

    public function register()
    {
        return view('member_register');
    }

    public function edit()
    {
        return view('member_edit');
    }

    public function post()
    {
        return view('member_post');
    }
}
