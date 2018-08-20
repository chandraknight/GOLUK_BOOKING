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
    <link rel="stylesheet" href="css\bootstrap.css">
    <link rel="stylesheet" href="css\font-awesome.css">
    <link rel="stylesheet" href="css\icomoon.css">
    <link rel="stylesheet" href="css\styles.css">
    <link rel="stylesheet" href="css\mystyles.css">
    <script src="js\modernizr.js"></script>

    <link rel="stylesheet" href="css\switcher.css">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\bright-turquoise.css" title="bright-turquoise" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\turkish-rose.css" title="turkish-rose" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\salem.css" title="salem" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\hippie-blue.css" title="hippie-blue" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\mandy.css" title="mandy" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\green-smoke.css" title="green-smoke" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\horizon.css" title="horizon" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\cerise.css" title="cerise" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\brick-red.css" title="brick-red" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\de-york.css" title="de-york" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\shamrock.css" title="shamrock" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\studio.css" title="studio" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\leather.css" title="leather" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\denim.css" title="denim" media="all">
    <link rel="alternate stylesheet" type="text/css" href="css\schemes\scarlet.css" title="scarlet" media="all">
</head>

<body class="full">

    <!-- FACEBOOK WIDGET -->
    <div id="fb-root"></div>
    
    <!-- /FACEBOOK WIDGET -->
    <div class="global-wrap">
       
        <div class="full-page">
            <div class="bg-holder full">
                <div class="bg-mask"></div>
                <div class="bg-img" style="background-image:url(img/people_on_the_beach_1280x852.jpg);"></div>
                <div class="bg-holder-content full text-white">
                    <a class="logo-holder" href="index-2.html">
                        <img src="img\logo-white.png" alt="Image Alternative text" title="Image Title">
                    </a>
                    <div class="full-center">
                        <div class="container">
                            <div class="row row-wrap" data-gutter="60">
                                <div class="col-md-4">
                                    <div class="visible-lg">
                                        <h3 class="mb15">Welcome to Traveler</h3>
                                        <p>Est nisl facilisis consectetur eget fermentum rutrum suscipit penatibus ultrices eu bibendum mi volutpat mattis cum facilisis nunc platea tincidunt vehicula laoreet montes parturient urna magnis eu etiam eget integer</p>
                                        <p>Nullam consectetur fames erat scelerisque ac conubia orci mauris facilisi</p>
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
                        <li><a href="#">Developers</a>
                        </li>
                        <li><a href="#">Advertise</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



        <script src="js\jquery.js"></script>
        <script src="js\bootstrap.js"></script>
        <script src="js\slimmenu.js"></script>
        <script src="js\bootstrap-datepicker.js"></script>
        <script src="js\bootstrap-timepicker.js"></script>
        <script src="js\nicescroll.js"></script>
        <script src="js\dropit.js"></script>
        <script src="js\ionrangeslider.js"></script>
        <script src="js\icheck.js"></script>
        <script src="js\fotorama.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script src="js\typeahead.js"></script>
        <script src="js\card-payment.js"></script>
        <script src="js\magnific.js"></script>
        <script src="js\owl-carousel.js"></script>
        <script src="js\fitvids.js"></script>
        <script src="js\tweet.js"></script>
        <script src="js\countdown.js"></script>
        <script src="js\gridrotator.js"></script>
        <script src="js\custom.js"></script>
        <script src="js\switcher.js"></script>
    </div>
</body>

</html>



