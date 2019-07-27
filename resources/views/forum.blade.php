@extends('layouts.master_inner_page')
@section('title', '')
@section('content')
    <section>
        <form action="" class="forum-add-cotainer fancybox">
            <div class="title">ADD POST</div>
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
        <div class="container">
            <div class="title">FAN DISCUSSION</div>
            <ul class="member-menu">
                <li><a href="forum_add">ADD POST</a></li>
                <li><a href="member_post">MY POST</a></li>
            </ul>
            <div id="post-main"></div>
            {{--<div class="forum-cotainer">--}}
                {{--<div class="row clearfix">--}}
                    {{--<div class="col sticker">--}}
                        {{--<div class="pic">--}}
                            {{--<img src="images/forum/sticker01.png" alt="">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col">--}}
                        {{--<div class="main-post">--}}
                            {{--<div class="topic">Machine also identifies other perpetrators and victims of premeditated--}}
                                {{--deadly--}}
                            {{--</div>--}}
                            {{--<div class="posted-by">--}}
                                {{--<span class="user">lateralus112358</span>--}}
                                {{--<div class="time">2018-08-07</div>--}}
                            {{--</div>--}}
                            {{--<div class="main-content">--}}
                                {{--Person of Interest centers on a mysterious reclusive billionaire computer programmer--}}
                                {{--named Harold Finch (Michael Emerson), who develops a supercomputer system (known as "The--}}
                                {{--Machine") for the federal government of the United States that is capable of collating--}}
                                {{--all sources of information to predict and identify—in advance—people planning terrorist--}}
                                {{--acts. <br><br>He finds that the Machine also identifies other perpetrators and victims--}}
                                {{--of premeditated deadly intentions, but as these are considered "irrelevant" by the--}}
                                {{--government, he programs it to delete this information each night. He soon realizes the--}}
                                {{--Machine has developed into a sentient superintelligent artificial intelligence, leaving--}}
                                {{--him wrestling with questions of human control and other moral and ethical issues--}}
                                {{--resulting from the situation. <br><br>His backdoor into the Machine allows him to act--}}
                                {{--covertly on the non-terrorism cases, but to prevent abuse of information, he directs the--}}
                                {{--Machine to provide no details beyond an identity to be investigated. He recruits John--}}
                                {{--Reese (Jim Caviezel), a presumed-dead former CIA agent, and later others, to investigate--}}
                                {{--and act on the information it provides.--}}
                            {{--</div>--}}
                            {{--<a class="likes" href="#">LIKE <span class="num">2</span></a>--}}
                            {{--<ul class="message">--}}
                                {{--<li>--}}
                                    {{--<span class="user">AAAA</span>--}}
                                    {{--<p class="content">Person of Interest centers on a mysterious reclusive billionaire--}}
                                        {{--computer programmer</p>--}}
                                    {{--<div class="time">2018-7-26 19:34</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<span class="user">BBBB</span>--}}
                                    {{--<p class="content">Machine also identifies other perpetrators and victims of--}}
                                        {{--premeditated deadly intentions, but as these are considered</p>--}}
                                    {{--<div class="time">2018-7-26 19:34</div>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                            {{--<div class="comment">--}}
                                {{--<span>Comment</span>--}}
                                {{--<div class="content">--}}
                                    {{--<textarea name="" id="" cols="30" rows="10"></textarea>--}}
                                    {{--<div class="notice">4300 characters left</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<button type="submit" class="btn-style-ok">SUBMIT</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <ul class="pages">
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
            </ul>
        </div>
    </section>
    <script src="{{ URL::asset('js/app.js') }}"></script>
@endsection
