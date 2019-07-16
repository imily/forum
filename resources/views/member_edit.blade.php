@extends('layouts.master_inner_page')
@section('title', '')
@section('content')
  <section>
      <div class="container">
          <div class="title">MEMBER EDIT</div>
          <ul class="member-menu">
              <li><a href="index">LOGOUT</a></li>
              <li><a href="member_post">MY POST</a></li>
              <li><a href="member_edit">INFORMATION</a></li>
          </ul>
          <article class="editor clearfix member-notice" itemprop="articleBody">
              In order to provide you with better service, <br>be sure to enter the correct information, thank you. <i class="required"></i> Required
          </article>
          <form action="" class="form-style-all">
              <div class="form-group required">
                 <label for="account">Account</label>
                 <div class="static-text">Imily</div>
               </div>
               <div class="form-group required">
                 <label for="password">New Password</label>
                 <input type="password" class="form-control" id="password">
              </div>
               <div class="form-group required">
                 <label for="password">Cofirm  Password</label>
                 <input type="password" class="form-control" id="password">
              </div>
              <button type="submit" class="btn-style-ok">SUBMIT</button>
          </form>
      </div>
  </section>
@endsection
