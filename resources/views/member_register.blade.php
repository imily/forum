@extends('layouts.master_inner_page')
@section('title', '')
@section('content')
<section>
    <div class="container">
        <div class="title">MEMBER REGISTER</div>
        <ul class="member-menu">
            <li><a href="member_login">LOGIN</a></li>
            <li><a href="member_edit">INFORMATION</a></li>
        </ul>
        <article class="editor clearfix member-notice" itemprop="articleBody">
            In order to provide you with better service, <br>be sure to enter the correct information, thank you. <i class="required"></i> Required
        </article>
        <form action="" class="form-style-pic">
            <div class="row clearfix">
                <div class="col pic-group">
                    <a class="pic" href="#">
                        <i></i>
                        Choose Photo
                    </a>
                </div>
                <div class="col">
                  <div class="form-group required">
                    <label for="account">Account</label>
                    <input type="text" class="form-control" id="account">
                  </div>
                  <div class="form-group required">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password">
                  </div>
                  <div class="form-group required">
                    <label for="password_confirm">Password Confirm</label>
                    <input type="password" class="form-control" id="password_confirm">
                  </div>
                </div>
            </div>
            <button type="submit" class="btn-style-ok">SUBMIT</button>
        </form>
    </div>
</section>
@endsection
