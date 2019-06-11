<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

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
        <div class="flex-center position-ref full-height">
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
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                <img style="width:250px" src="/bower_components/admin-lte/dist/img/Cargo.png" class="img-thumbnail" alt="User Image">
                </div>
                <br>
                <div class="links">
                <a  href="{{ route('login') }}">Get Started</a>
                </div>
            </div>
        </div>
    </body>
</html>
