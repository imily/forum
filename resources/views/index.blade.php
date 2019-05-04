@extends('layouts.master')
@section('title', '')
@section('content')
    <section class="production" id="sect1">
        <div class="container">
            <div class="title">PRODUCTION</div>
            <article class="editor clearfix" itemprop="articleBody" data-aos="zoom-in">
                <p>Person of Interest centers on a mysterious reclusive billionaire computer programmer named Harold Finch (Michael Emerson), <br>who develops a supercomputer system (known as "The Machine") for the federal government of the United States <br>that is capable of collating all sources of information to predict and identify—in advance—people planning terrorist acts. </p>
                <p>He finds that the Machine also identifies other perpetrators and victims of premeditated deadly intentions, <br>but as these are considered "irrelevant" by the government, he programs it to delete this information each night. <br>He soon realizes the Machine has developed into a sentient superintelligent artificial intelligence, <br>leaving him wrestling with questions of human control and other moral and ethical issues resulting from the situation. </p>
                <p>His backdoor into the Machine allows him to act covertly on the non-terrorism cases, but to prevent abuse of information, <br>he directs the Machine to provide no details beyond an identity to be investigated. He recruits John Reese (Jim Caviezel), <br>a presumed-dead former CIA agent, and later others, to investigate and act on the information it provides.</p>
            </article>
        </div>
    </section>
    <section class="parallax-window" data-parallax="scroll" data-image-src="{{ URL::asset('public/images/production_pic.jpg') }}"></section>
    <section class="characters" id="sect2">
        <div class="container">
            <div class="title">CHARACTERS</div>
            <ul class="characters-ul list-h">
                <li>
                    <div class="box"  data-aos="fade-up" data-aos-delay="300">
                        <figure class="pic"><img itemprop="image" src="{{ URL::asset('public/images/characters/finch.jpg') }}" alt=""></figure>
                        <p class="name">Harold Finch</p>
                        <div class="text">A reclusive, security conscious, and intensely private billionaire software engineer. </div>
                        <div class="more">MORE</div>
                    </div>
                </li>
                <li>
                    <div class="box"  data-aos="fade-up" data-aos-delay="450">
                        <figure class="pic"><img itemprop="image" src="{{ URL::asset('public/images/characters/reese.jpg') }}" alt=""></figure>
                        <p class="name">John Reese</p>
                        <div class="text">A former Army Special Forces soldier and later a CIA paramilitary operations officer in the Special Activities Division.</div>
                        <div class="more">MORE</div>
                    </div>
                </li>
                <li>
                    <div class="box"  data-aos="fade-up" data-aos-delay="600">
                        <figure class="pic"><img itemprop="image" src="{{ URL::asset('public/images/characters/carter.jpg') }}" alt=""></figure>
                        <p class="name">Joss Carter</p>
                        <div class="text">A former U.S. Army interrogation officer who passed the bar exam in 2004, but gave up practicing the law to return to police work. </div>
                        <div class="more">MORE</div>
                    </div>
                </li>
                <li>
                    <div class="box"  data-aos="fade-up" data-aos-delay="750">
                        <figure class="pic"><img itemprop="image" src="{{ URL::asset('public/images/characters/fusco.jpg') }}" alt=""></figure>
                        <p class="name">Lionel Fusco</p>
                        <div class="text">As Detective Lionel Fusco: a corrupt cop whom Reese blackmails into being a source inside the NYPD. </div>
                        <div class="more">MORE</div>
                    </div>
                </li>
                <li>
                    <div class="box"  data-aos="fade-up" data-aos-delay="900">
                        <figure class="pic"><img itemprop="image" src="{{ URL::asset('public/images/characters/shaw.jpg') }}" alt=""></figure>
                        <p class="name">Sameen Shaw</p>
                        <div class="text">An ISA assassin who worked for Special Counsel. Shaw unknowingly deals with the "relevant" numbers from the Machine.</div>
                        <div class="more">MORE</div>
                    </div>
                </li>
                <li>
                    <div class="box"  data-aos="fade-up" data-aos-delay="1050">
                        <figure class="pic"><img itemprop="image" src="{{ URL::asset('public/images/characters/root.jpg') }}" alt=""></figure>
                        <p class="name">Root</p>
                        <div class="text">A genius hacker obsessed with the Machine. Root has a keen interest in both Finch and the Machine. </div>
                        <div class="more">MORE</div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <section class="photos" id="sect3">
        <ul class="photos-ul list-h">
            <li data-aos="fade" data-aos-delay="1100"><a data-fancybox="gallery" href="{{ URL::asset('public/images/photo/01_b.jpg') }}"><div class="text"><span><strong>S01E01</strong>Pilot</span></div><img src="{{ URL::asset('public/images/photo/01_s.jpg') }}"></a></li>
            <li data-aos="fade" data-aos-delay="1200"><a data-fancybox="gallery" href="{{ URL::asset('public/images/photo/02_b.jpg') }}"><div class="text"><span><strong>S01E08</strong>Foe</span></div><img src="{{ URL::asset('public/images/photo/02_s.jpg') }}"></a></li>
            <li data-aos="fade" data-aos-delay="1300"><a data-fancybox="gallery" href="{{ URL::asset('public/images/photo/03_b.jpg') }}"><div class="text"><span><strong>S02E01</strong>The Contingency</span></div><img src="{{ URL::asset('public/images/photo/03_s.jpg') }}"></a></li>
            <li data-aos="fade" data-aos-delay="1400"><a data-fancybox="gallery" href="{{ URL::asset('public/images/photo/04_b.jpg') }}"><div class="text"><span><strong>S02E16</strong>Relevance</span></div><img src="{{ URL::asset('public/images/photo/04_s.jpg') }}"></a></li>
            <li data-aos="fade" data-aos-delay="1500"><a data-fancybox="gallery" href="{{ URL::asset('public/images/photo/05_b.jpg') }}"><div class="text"><span><strong>S02E22</strong>God Mode</span></div><img src="{{ URL::asset('public/images/photo/05_s.jpg') }}"></a></li>
            <li data-aos="fade" data-aos-delay="1600"><a data-fancybox="gallery" href="{{ URL::asset('public/images/photo/06_b.jpg') }}"><div class="text"><span><strong>S03E06</strong>Mors Praematura</span></div><img src="{{ URL::asset('public/images/photo/06_s.jpg') }}"></a></li>
        </ul>
    </section>
@endsection