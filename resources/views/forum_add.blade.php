@extends('layouts.master')
@section('title', '')
@section('content')
<section>
    <div class="container">
    <div class="title">ADD POST</div>
    <ul class="member-menu">
      <li><a href="member_post">MY POST</a></li>
    </ul>
          <form action="" class="forum-add-cotainer">
      <div class="form-group required">
         <label for="topic" class="form-label">Post Topic</label>
         <input type="text" class="form-control" id="topic">
       </div>
       <div class="form-group required">
         <label for="post_content" class="form-label">Post Content</label>
         <textarea name="" id="post_content" cols="30" rows="10" class="form-control"></textarea>
      </div>
      <div class="btn-two">
        <button type="submit" class="btn-style-back">BACK</button>
        <button type="submit" class="btn-style-ok">SUBMIT</button>
      </div>
          </form>
        </div>
</section>
@endsection