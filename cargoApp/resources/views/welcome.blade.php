<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
    <meta name="format-detection" content="telephone=no">
    <title>CARGO</title>
    <link rel="stylesheet" href="/">
    <link rel="stylesheet" href="/cargoApp/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/cargoApp/public/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> -->

        <!-- Styles -->
        <style>
            html, body {
                background-color: #374446;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 86x;
            }

            a:link, a:visited {
                background-color: #1eb5b9;
                color: white;
                padding: 0 25px;
                text-align: center;
                font-size: 25px;
                font-weight: 600;
                font-style: italic;
                letter-spacing: .1rem;
                text-decoration: none;
                display: inline-block;
                border-radius: 20px;

                }

                a:hover, a:active {
                   background-color: #374446;
                   transition: 0.5s;
                }


            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    <body data-spy="scroll" data-target="#spy">
    <!-- <div class="preloader js-preloader">
                <div class="preloader-wrapper">
                    <img src="img/favicon.png" alt="" class="img-responsive center-block loader-logo">
                </div>
            </div> -->

    <!-- navbar start -->
    <nav id="navbar" class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="img/logo.png" alt="Logo"></a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#get_quote" class="btn btn-secondrary" target="_blank">sign In</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- navbar end  -->
    <!-- header section start -->
    <section class="header-section">
        <div class="container">
            <div class="header-section__wrapper">
                <div class="header-section__content">
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="header-section__title text-center">
                                <div class="img">
                                    <img src="/img/app-icon.png" alt="" class="img-thumbnail">
                                </div>
                                <h1 class="app-title"> <Span class="light-blue">CARGO</Span> App</h1>
                                <p class="sub-title">
                                    Save Transfer For you
                                </p>
                                <p>
                                    An Innovative App That Designed To Help Companies To Pick And Reserve Trucks From
                                    Any Place
                                </p>
                                <h5>Download This App From</h5>
                                <div class="download-links">
                                    <a href="#"><img src="/img/app-store.png" alt=""></a>
                                    <a href="#"><img src="/img/google-store.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="header-section__mockup">
                                <img src="/img/headerMockup.png" alt="" class="img-thumbnail">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- header section end -->

    <!-- start how it works  -->

    <!-- start work end -->
    <section class="start-work section-padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h3>HOW IT <span>WORKS</span></h3>
                    <p><span>01.</span> Cargo offers a safe and transparent shipping service in an easy way, select your pickup and drop off locations. </p>
                    <p><span>02.</span>Set your order specifications and calculate your shipment cost before getting started</p>
                    <p><span>03.</span>Find your driver and car information and easily track your shipment through the maps</p>
                </div>
                <div class="offset-1 col-sm-12 col-md-5">
                    <img src="/img/Group 483.png" alt="" class="w-100">
                </div>
            </div>
        </div>
    </section>
    <!-- start-amazing-services -->
    <section class="features-section section-padding">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-sm-10 text-center">
                    <h3 class="after">EXCLUSIVE<span class="light-blue"> FEATURES</span></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3 features-items">
                    <div class="content-media">
                        <h5> <img src="/img/icons/creative.svg" alt="" class="feature-icon img-thumbnail bigIcon">
                            Creative Design </h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
                    </div>
                    <div class="content-media">
                        <h5> <img src="/img/icons/web-programming.svg" alt="" class="feature-icon img-thumbnail">
                            Clean Coded</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 order">
                    <div class="main-mockup">
                        <img src="/img/feature-mockup.png" alt="" class="mobile-mockup img-thumbnail">
                        <img src="/img/feature-mockup-mobile.png" alt=""
                            class="mobile-mockup img-thumbnail mobile-view">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 features-items">
                    <div class="content-media">
                        <h5><img src="/img/icons/cloud-computing.svg" alt="" class="feature-icon img-thumbnail">Easy
                            Download</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
                    </div>
                    <div class="content-media">
                        <h5><img src="/img/icons/diamond.svg" alt="" class="feature-icon img-thumbnail">Pure & Simple
                        </h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end-amazing-services -->
    <footer class="footer pb-0">
        <!-- start-amazing-services -->
        <div class="services-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="service-item">
                            <img src="/img/icons/cloud-computing.svg" alt="" class="img-thumbnail">
                            <h3>+20k</h3>
                            <p>DOWNLOAD STORE</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="service-item">
                            <img src="/img/hand-shake.svg" alt="" class="img-thumbnail">
                            <h3>1650</h3>
                            <p>HAPPY CLIENTS</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="service-item">
                            <img src="/img/team.svg" alt="" class="img-thumbnail">
                            <h3>105</h3>
                            <p>CARGO FAMILY</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="service-item">
                            <img src="img/save-money.svg" alt="" class="img-thumbnail">
                            <h3>+3000000 L.E</h3>
                            <p>INVESTMENT</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
        <div class="last">
                <div class="container">
                <div class="row justify-content-between py-5">
                    <div class="col-sm-7 col-md-4">
                        <p>Copy right &copy; 2019 , All Rights reserved.</p>
                    </div>
                    <div class="col-sm-5 col-md-3">
                        <p class="d-inline mr-2 px-3 follow">Follow Us</p>
                        <img src="/img/icons/facebook.svg" alt="" class="mr-2">
                        <img src="/img/icons/twitter.svg" alt="">
                    </div>
                </div>
            </div>
            </div>

    </footer>
    <!-- end-amazing-services -->
    <!-- start shm -->
    <div id="shm" class="hidden-xs">
        <div class="scroll-up">
            <i class="fa fa-arrow-up fa-3x"></i>
        </div>
    </div>
    <!-- end shm -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <!-- <script src="js/jquery.nicescroll.min.js"></script> -->
    <!-- <script src="js/preloader.js"></script> -->
    <script src="/js/script.js"></script>

        <!-- <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a style="background-color: #374446;  font-size: 20px; font-style: normal;" href="{{ url('/home') }}">Home</a>
                    @else
                        <a style="background-color: #374446;  font-size: 20px; font-style: normal;"  href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a style="background-color: #374446;  font-size: 20px; font-style: normal;"  href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div> -->
            <!-- @endif -->




                <!-- <img style="width:250px" src="/bower_components/admin-lte/dist/img/Cargo.png" class="img-thumbnail" alt="User Image"> -->

    </body>
</html>
