<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title>Person Of Interest @yield('title')</title>
    <link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/basic.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/nivo-slider.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('themes/default/default.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/rwd.css') }}">
    <link href="{{ URL::asset('js/aos-master/dist/aos.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" rel="stylesheet">
    <script src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
</head>
<body>
    <div class="wrap">
        <div class="header">
            @include('layouts.header')
            <div class="slider-wrapper theme-default banner">
                <div id="slider" class="nivoSlider">
                    <img src="{{ URL::asset('images/banner01.jpg') }}" data-thumb="images/banner01.jpg" alt="" />
                    <img src="{{ URL::asset('images/banner02.jpg') }}" data-thumb="images/banner02.jpg" alt="" />
                    <img src="{{ URL::asset('images/banner03.jpg') }}" data-thumb="images/banner03.jpg" alt="" />
                </div>
            </div>
        </div>
        @yield('content')
        @include('layouts.footer')
    </div>
    <script src="{{ URL::asset('js/jquery.nivo.slider.pack.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ URL::asset('js/parallax.min.js') }}"></script>
    <script src="{{ URL::asset('js/aos-master/dist/aos.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.scrollTo/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ URL::asset('js/main.js') }}"></script>
</body>
</html>