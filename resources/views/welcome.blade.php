<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
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
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .dropbtn {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                background-color: white;
                border: none;
            }

            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            .dropdown-content a:hover {background-color: #ddd;}

            .dropdown:hover .dropdown-content {display: block;}
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>

                        @guest('teacher')
                            <div class="dropdown">
                                <button class="dropbtn">Login</button>
                                <div class="dropdown-content">
                                    <a href="{{ route('teacher.login') }}">Teacher</a>
                                    <a href="#">Admin</a>
                                </div>
                            </div>

                            <!-- @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif -->
                        @endguest
                    @endauth

                    @auth('teacher')
                        <a href="{{ url('/teacher') }}">Dashboard</a>

                        @guest
                            <div class="dropdown">
                                <button class="dropbtn">Login</button>
                                <div class="dropdown-content">
                                    <a href="{{ route('login') }}">Student</a>
                                    <a href="#">Admin</a>
                                </div>
                            </div>

                            <!-- @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif -->
                        @endguest
                    @endauth

                    @unless (Auth::check() || Auth::guard('teacher')->check())
                            <div class="dropdown">
                                <button class="dropbtn">Login</button>
                                <div class="dropdown-content">
                                    <a href="{{ route('login') }}">Student</a>
                                    <a href="{{ route('teacher.login') }}">Teacher</a>
                                    <a href="#">Admin</a>
                                </div>
                            </div>

                            <a href="{{ route('register') }}">Register</a>
                    @endunless

                </div>
            
            <div class="content">
                <div class="title m-b-md">
                    Welcome to our website
                </div>

                <h1>
                    If you are new here go to register
                </h1>

                <br>

                <h3>
                    If you already have an account, you can login to explore our app
                </h3>
            </div>
        </div>
    </body>
</html>
