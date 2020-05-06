<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="{{asset('css/frontend_css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/frontend_css/easyzoom.css')}}" rel="stylesheet">
    <link href="{{asset('css/frontend_css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/frontend_css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('css/frontend_css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('css/frontend_css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/frontend_css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/frontend_css/responsive.css')}}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/frontend_js/html5shiv.js"></script>
    <script src="js/frontend_js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{asset('images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('images/frontend_image/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('images/frontend_image/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('images/frontend_image/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('images/frontend_image/ico/apple-touch-icon-57-precomposed.png')}}">
</head><!--/head-->

<body>
@include('layouts.frontLayout.front_header')
@yield('content')
@include('layouts.frontLayout.front_footer')

{{--<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>--}}

<script src="{{asset('js/frontend_js/jquery.js')}}"></script>
<script src="{{asset('js/frontend_js/easyzoom.js')}}"></script>
<script src="{{asset('js/frontend_js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/frontend_js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('js/frontend_js/price-range.js')}}"></script>
<script src="{{asset('js/frontend_js/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('js/frontend_js/main.js')}}"></script>

<script>
    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();

    // Setup thumbnails example
    var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

    $('.thumbnails').on('click', 'a', function(e) {
        var $this = $(this);

        e.preventDefault();

        // Use EasyZoom's `swap` method
        api1.swap($this.data('standard'), $this.attr('href'));
    });

    // Setup toggles example
    var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

    $('.toggle').on('click', function() {
        var $this = $(this);

        if ($this.data("active") === true) {
            $this.text("Switch on").data("active", false);
            api2.teardown();
        } else {
            $this.text("Switch off").data("active", true);
            api2._init();
        }
    });
</script>
</body>
</html>
