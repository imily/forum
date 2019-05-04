<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title>Person Of Interest @yield('title')</title>
    <link rel="stylesheet" href="{{ URL::asset('public/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/css/basic.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/css/nivo-slider.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/themes/default/default.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ URL::asset('public/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/css/style.css') }}">
    <link href="{{ URL::asset('public/js/aos-master/dist/aos.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" rel="stylesheet">
    <script src="{{ URL::asset('public/js/jquery-3.3.1.min.js') }}"></script>
</head>
<body>
    <div class="wrap">
        @include('layouts.header')
        @yield('content')
        @include('layouts.footer')
    </div>
    <script src="{{ URL::asset('public/js/jquery.nivo.slider.pack.js') }}"></script>
    <script src="{{ URL::asset('public/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/parallax.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/aos-master/dist/aos.js') }}"></script>
    <script src="{{ URL::asset('public/js/jquery.scrollTo/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/main.js') }}"></script>
</body>
</html>