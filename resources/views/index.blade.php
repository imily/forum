<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
        <title>Person Of Interest @yield('title')</title>
    </head>
    <body>
        <div id="root"></div>
        <script src="{{ URL::asset('js/app.js') }}"></script>
    </body>
</html>
