<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">

<head>


    <title>{{ config('app.name', 'Yatritime') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Book hotels, vacation rental, resort, apartment, guest house or treehouse, vehicles, perfect tour packages">
    <meta name="description" content="Book hotels, vacation rental, resort, apartment, guest house or treehouse, vehicles, perfect tour packages and many more !">
    <meta name="author" content="SNS">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/icomoon.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/mystyles.css')}}">
    <script src="{{URL::asset('/js/modernizr.js')}}"></script>


    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/bright-turquoise.css')}}" title="bright-turquoise" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/turkish-rose.css')}}" title="turkish-rose" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/salem.css')}}" title="salem" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/hippie-blue.css')}}" title="hippie-blue" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/mandy.css')}}" title="mandy" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/green-smoke.css')}}" title="green-smoke" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/horizon.css')}}" title="horizon" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/cerise.css')}}" title="cerise" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/brick-red.css')}}" title="brick-red" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/de-york.css')}}" title="de-york" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/shamrock.css')}}" title="shamrock" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/studio.css')}}" title="studio" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/leather.css')}}" title="leather" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/denim.css')}}" title="denim" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('/css/schemes/scarlet.css')}}" title="scarlet" media="all">
    <style>
        .loader {
            margin:0 auto;
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #555;
            width: 75px;
            height: 75px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loader p{
            margin:2px auto;
            background: #ffffff;
            color: #0b0b0b;
            padding: 5px;
            text-align: center;
            font-size: small;
            width:100%;
            height: 100%;
            border-radius: 50%;
        }
    </style>

</head>

<!-- FACEBOOK WIDGET -->
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- /FACEBOOK WIDGET -->
<div class="global-wrap">