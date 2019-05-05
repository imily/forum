<?php namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * 登入介面
     * @return View
     */
    public function home()
    {
        return view('index');
    }
}
