<!DOCTYPE html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ __('messages.Sun_hotel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <!-- CSS FILES -->
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/prettyPhoto.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/selectordie.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/2035.responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/chat.css') }}">
    <script src="{{ asset('bower_components/bower/client/js/vendor/modernizr-2.8.3-respond-1.1.0.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body data-notification="{{ session('notification') }}">

<div id="wrapper">
    @include('client.layouts.header')
    @yield('content')
    @include('client.layouts.footer')
    @include('client.layouts.chat')
</div>
<script src="{{ asset('bower_components/bower/client/js/vendor/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/retina-1.1.0.min.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/jquery.flexslider-min.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/superfish.pack.1.4.1.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/jquery.prettyPhoto.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/selectordie.min.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/jquery.slicknav.min.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/jquery.parallax-1.1.3.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/main.js') }}"></script>
<script src="{{ asset('bower_components/bower/js/toastr.min.js') }}"></script>
<script src="{{ asset('bower_components/bower/js/register.js') }}"></script>
<script src="{{ asset('bower_components/bower/js/sweetalert.js') }}"></script>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/js/chat.js') }}"></script>
@yield('script')
</body>
</html>
