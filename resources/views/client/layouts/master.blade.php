<!DOCTYPE html>
<html class="no-js"> 

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Luxen Premium Hotel Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="shortcut icon" href="img/favicon.ico" />
    <!-- CSS FILES -->
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/prettyPhoto.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/selectordie.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/2035.responsive.css') }}">

    <script src="{{ asset('bower_components/bower/client/js/vendor/modernizr-2.8.3-respond-1.1.0.min.js') }}"></script>
</head>
<body>

    <div id="wrapper">
        @include('client.layouts.header')
        @yield('content')
        @include('client.layouts.footer')
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
</body>
</html>