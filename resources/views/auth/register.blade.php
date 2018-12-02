<!DOCTYPE HTML>
<html class="full">

<head>
    <title>Traveler - Login register</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Template, html, premium, themeforest">
    <meta name="description" content="Traveler - Premium template for travel companies">
    <meta name="author" content="Tsoy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/icomoon.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/mystyles.css')}}">
    <script src="{{URL::asset('js/modernizr.js')}}"></script>

    <link rel="stylesheet" href="{{URL::asset('css/switcher.css')}}">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/bright-turquoise.css')}}" title="bright-turquoise" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/turkish-rose.css')}}" title="turkish-rose" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/salem.css')}}" title="salem" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/hippie-blue.css')}}" title="hippie-blue" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/mandy.css')}}" title="mandy" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/green-smoke.css')}}" title="green-smoke" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/horizon.css')}}" title="horizon" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/cerise.css')}}" title="cerise" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/brick-red.css')}}" title="brick-red" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/de-york.css')}}" title="de-york" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/shamrock.css')}}" title="shamrock" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/studio.css')}}" title="studio" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/leather.css')}}" title="leather" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/denim.css')}}" title="denim" media="all">
    <link rel="alternate stylesheet" type="text/css" href="{{URL::asset('css/schemes/scarlet.css')}}" title="scarlet" media="all">
</head>

<body class="full">

    <!-- FACEBOOK WIDGET -->
    <div id="fb-root"></div>
    
    <!-- /FACEBOOK WIDGET -->
    <div class="global-wrap">
       
        <div class="full-page">
            <div class="bg-holder full">
                <div class="bg-mask"></div>
                <div class="bg-img" style="background-image:url({{URL::asset('img/people_on_the_beach_1280x852.jpg')}});"></div>
                <div class="bg-holder-content full text-white">
                    <a class="logo-holder" href="{{route('welcome')}}">
                        <img src="{{URL::asset('img\Yatritime.png')}}" alt="Image Alternative text" title="Image Title">
                    </a>
                    <div class="full-center">
                        <div class="container">
                            <div class="row row-wrap" data-gutter="60">
                                <div class="col-md-4">
                                    <div class="visible-lg">
                                        <h3 class="mb15">Welcome to Yatritime</h3>
                                        <p>Book hotels, vacation rental, resort, apartment, guest house or treehouse, vehicles, perfect tour packages and many more !</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="mb15">Login</h3>
                                    <form method="POST" action="{{ route('login') }}">
                                        {{csrf_field()}}
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
                                            <label>Email</label>
                                            <input class="form-control" placeholder="e.g. johndoe@gmail.com" name="email" type="email">
                                            @if ($errors->has('email'))
                                        
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                        </div>
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
                                            <label>Password</label>
                                            <input class="form-control" type="password" placeholder="my secret password" name="password">
                                            @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                        </div>
                                        <input class="btn btn-primary" type="submit" value="Sign in">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="mb15">New To Traveler?</h3>
                                    <form method="POST" action="{{ route('register') }}">
                                        {{csrf_field()}}
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
                                            <label>Full Name</label>
                                            <input class="form-control" placeholder="e.g. John Doe" type="text" name="name">
                                            @if ($errors->has('name'))
                                        }
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                        </div>
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
                                            <label>Email</label>
                                            <input class="form-control" placeholder="e.g. johndoe@gmail.com" type="email" name="email">
                                             @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                        </div>
                                        <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
                                            <label>Password</label>
                                            <input class="form-control" type="password" placeholder="my secret password" name="password">
                                            @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                        </div>
                                         <div class="form-group form-group-ghost form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
                                            <label>Confirm Password</label>
                                            <input class="form-control" type="password" placeholder="my secret password" name="password_confirmation">
                                            @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                        </div>
                                        <input class="btn btn-primary" type="submit" value="Sign up for Traveler">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="footer-links">
                        <li><a href="#">About</a>
                        </li>
                        <li><a href="#">Help</a>
                        </li>
                        <li><a href="#">Hot Deals</a>
                        </li>
                        <li><a href="#">Popular Locations</a>
                        </li>
                        <li><a href="#">Cheap Flights</a>
                        </li>
                        <li><a href="#">Business</a>
                        </li>
                        <li><a href="#">Media</a>
                        </li>
                        <li><a href="{{route('registeragent')}}">Register as Agent</a>
                        </li>
                        <li><a href="{{route('registerbusiness')}}">Register Your Business</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



        <script src="{{URL::asset('js/jquery.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap.js')}}"></script>
        <script src="{{URL::asset('js/slimmenu.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-datepicker.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-timepicker.js')}}"></script>
        <script src="{{URL::asset('js/nicescroll.js')}}"></script>
        <script src="{{URL::asset('js/dropit.js')}}"></script>
        <script src="{{URL::asset('js/ionrangeslider.js')}}"></script>
        <script src="{{URL::asset('js/icheck.js')}}"></script>
        <script src="{{URL::asset('js/fotorama.js')}}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script src="{{URL::asset('js/typeahead.js')}}"></script>
        <script src="{{URL::asset('js/card-payment.js')}}"></script>
        <script src="{{URL::asset('js/magnific.js')}}"></script>
        <script src="{{URL::asset('js/owl-carousel.js')}}"></script>
        <script src="{{URL::asset('js/fitvids.js')}}"></script>
        <script src="{{URL::asset('js/tweet.js')}}"></script>
        <script src="{{URL::asset('js/countdown.js')}}"></script>
        <script src="{{URL::asset('js/gridrotator.js')}}"></script>
        <script src="{{URL::asset('js/custom.js')}}"></script>
        <script src="{{URL::asset('js/switcher.js')}}"></script>
    </div>
</body>

</html>



