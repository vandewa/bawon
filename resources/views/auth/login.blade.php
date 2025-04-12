<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>NAMA APLIKASI | Login</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Teko&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Source Sans Pro' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('style.css') }}"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon Link -->
    <link rel="icon" href="{{ asset('pemda.ico') }}" type="image/x-icon">
    {{-- <link rel="shortcut icon" href="{{ asset('pemda.ico') }}"> --}}
    {{-- <link rel="icon" href="{{ asset('pemda.ico') }}" /> --}}


    {{-- @vite([]) --}}

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Source Sans Pro', sans-serif;
            /* font-family: 'Montserrat', sans-serif; */
        }

        body {
            /* background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff); */
            background: linear-gradient(125deg, #3c2e9e -15.04%, #67cdb0 101.92%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }

        .container p {
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }

        .container span {
            font-size: 12px;
        }

        .container a {
            color: #333;
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
        }

        .container button {
            background-color: #2831a7;
            ;
            /* background-color: #512da8; */
            color: #fff;
            font-size: 12px;
            padding: 10px 45px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .container button:hover {
            background-color: #c1b208;
            /* Warna merah */
            transform: scale(1.1);
            /* Perbesar tombol saat dihover */
        }

        .container button.hidden {
            background-color: transparent;
            border-color: #fff;
        }

        .container form {
            background-color: #fff;
            display: flex;
            /* align-items: center; */
            /* justify-content: center; */
            flex-direction: column;
            padding: 0 40px;
            /* height: 100%; */
        }

        .container input {
            background-color: #eee;
            border: none;
            margin: 8px 0;
            padding: 10px 15px;
            font-size: 13px;
            border-radius: 8px;
            width: 100%;
            outline: none;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.active .sign-in {
            transform: translateX(100%);
        }

        @keyframes move {

            0%,
            49.99% {
                opacity: 0;
                z-index: 1;
            }

            50%,
            100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .toggle-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            /* border-radius: 150px 0 0 100px; */
            z-index: 1000;
        }

        .container.active .toggle-container {
            transform: translateX(-100%);
            border-radius: 0 150px 100px 0;
        }

        .toggle {
            background-color: #512da8;
            height: 100%;
            background: linear-gradient(to right, #5c6bc0, #512da8);
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .container.active .toggle {
            transform: translateX(50%);
        }

        .toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 30px;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .toggle-left {
            transform: translateX(-200%);
        }

        .container.active .toggle-left {
            transform: translateX(0);
        }

        .toggle-right {
            right: 0;
            transform: translateX(0);
            background-image: url({{ asset('kantor1.jpeg') }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            /* Center the background image */
        }

        .container.active .toggle-right {
            transform: translateX(200%);
        }

        .spannya {
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            opacity: 0.4;
            font-family: 'Source Sans Pro';
        }

        .hijau {
            /* color: #28A745; */
            color: rgb(0, 132, 255);
            font-family: 'Source Sans Pro';
            font-weight: bold;
            line-height: 32px;

            /* Animation */
            animation: moveText 3s linear infinite;
        }

        .paddingnya {
            padding: 20px 40px;
        }

        .paddingnya1 {
            padding: 0px 40px;
        }

        .kanan {
            margin-left: 10px;
        }

        /* Existing styles */


        @media only screen and (max-width: 768px) {
            body {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .container {
                width: 90%;
            }

            .form-container {
                width: 100%;
            }

            .toggle-container {
                display: none;
            }

            .toggle-panel {
                width: 100%;
            }

            .toggle-right {
                background-size: cover;
            }

            img.mobile-hide,
            span.mobile-hide {
                display: none;
            }

            img {
                max-width: 100%;
                height: auto;
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <div class="paddingnya">
                <img src="{{ asset('logobaruhitam.png') }}" alt="" style="width: 300px;">
            </div>
            <div class="paddingnya1">
                <div style="margin-bottom: 30px;margin-top:20px;">
                    <h2>Login</h2>
                </div>
            </div>

            <form action="{{ route('login') }}" method="post">
                @csrf

                <x-validation-errors class="mb-4" />

                <span class="kanan"> Email</span>
                <input type="email" placeholder="Enter your email address" name="email" autofocus required>
                <span class="kanan"> Password</span>
                <input type="password" placeholder="Enter your password" name="password" autofocus required>

                <button type="submit" style="margin-top:30px;">Login</button>
            </form>
            <div class="paddingnya1" style="margin-top: 30px;">
                <div>
                    <span style=" opacity:0.5;font-size:10px;">
                        © 2025
                        <?php if (date('Y') == 2025) {
                            echo '';
                        } else {
                            echo '- ' . date('Y');
                        }
                        ?>
                        NAMA OPD Kabupaten Wonosobo

                    </span>
                </div>
            </div>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
