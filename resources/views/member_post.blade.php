@extends('layouts.master')
@section('title', '')
@section('content')
<section>
    <div class="container">
        <div class="title">MY POST</div>
        <ul class="member-menu">
            <li><a href="index">LOGOUT</a></li>
            <li><a href="member_edit">INFORMATION</a></li>
        </ul>
        <article class="editor clearfix member-notice" itemprop="articleBody">
            In order to provide you with better service, <br>be sure to enter the correct information, thank you.
        </article>
        <div class="forum-my-cotainer close">
            <div class="post-num">1</div>
            <div class="main-post">
                <div class="topic">Machine also identifies other perpetrators and victims of premeditated deadly</div>
            </div>
        </div>
        <div class="forum-my-cotainer close">
            <div class="post-num">2</div>
            <div class="main-post">
                <div class="topic">Machine also identifies other perpetrators and victims of premeditated deadly</div>
            </div>
        </div>
        <div class="forum-my-cotainer open">
            <div class="post-num">3</div>
            <div class="main-post">
                <div class="topic">Machine also identifies other perpetrators and victims of premeditated deadly</div>
                <div class="posted-by">
                    <div class="time">2018-08-07</div>
                </div>
                <div class="main-content">
                    Person of Interest centers on a mysterious reclusive billionaire computer programmer named Harold Finch (Michael Emerson), who develops a supercomputer system (known as "The Machine") for the federal government of the United States that is capable of collating all sources of information to predict and identify—in advance—people planning terrorist acts. <br><br>He finds that the Machine also identifies other perpetrators and victims of premeditated deadly intentions, but as these are considered "irrelevant" by the government, he programs it to delete this information each night. He soon realizes the Machine has developed into a sentient superintelligent artificial intelligence, leaving him wrestling with questions of human control and other moral and ethical issues resulting from the situation. <br><br>His backdoor into the Machine allows him to act covertly on the non-terrorism cases, but to prevent abuse of information, he directs the Machine to provide no details beyond an identity to be investigated. He recruits John Reese (Jim Caviezel), a presumed-dead former CIA agent, and later others, to investigate and act on the information it provides.
                </div>
                <div class="likes" href="#">ALL LIKES <span class="num">2</span></div>
                <ul class="message">
                    <li>
                        <span class="user">AAAA</span>
                        <p class="content">Person of Interest centers on a mysterious reclusive billionaire computer programmer</p>
                        <div class="time">2018-7-26 19:34</div>
                    </li>
                    <li>
                        <span class="user">BBBB</span>
                        <p class="content">Machine also identifies other perpetrators and victims of premeditated deadly intentions, but as these are considered</p>
                        <div class="time">2018-7-26 19:34</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <ul class="pages">
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
    </ul>
</section>
@endsection