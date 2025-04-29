<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Ruang Desa</title>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #ede7f6);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
            padding: 50px;
            max-width: 960px;
            margin: 50px 20px;
            animation: popIn 0.8s ease forwards;
            overflow: hidden;
        }

        .reflection {
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, rgba(255, 255, 255, 0.4) 0%, transparent 100%);
            transform: skewX(-20deg);
            animation: reflectionAnim 4s infinite;
            pointer-events: none;
        }

        @keyframes reflectionAnim {
            0% {
                left: -75%;
            }

            50% {
                left: 125%;
            }

            100% {
                left: 125%;
            }
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animation {
            flex: 1;
            min-width: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-wrapper {
            flex: 1;
            min-width: 300px;
            animation: slideIn 1s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-in-text {
            font-size: 28px;
            font-weight: 700;
            color: #4a148c;
            margin-bottom: 30px;
            text-align: center;
            opacity: 0;
            animation: fadeInText 1s 0.3s ease-out forwards;
        }

        @keyframes fadeInText {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-group input {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            color: #333;
            transition: 0.3s;
        }

        .form-group input:focus {
            outline: none;
            box-shadow: 0 0 0 3px #b388ff;
        }

        .form-group label {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            background: transparent;
            padding: 0 5px;
            color: #777;
            font-size: 15px;
            transition: 0.3s ease;
            pointer-events: none;
        }

        .form-group input:focus+label,
        .form-group input:not(:placeholder-shown)+label,
        .form-group input:-webkit-autofill+label {
            top: -10px;
            left: 10px;
            background: white;
            font-size: 12px;
            color: #6a1b9a;
        }

        input:-webkit-autofill {
            box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #333 !important;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #8e24aa, #6a1b9a);
            color: white;
            font-weight: 600;
            font-size: 16px;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.3);
            transition: all 0.3s ease;
        }

        button:hover {
            transform: scale(1.04);
            box-shadow: 0 10px 30px rgba(123, 31, 162, 0.5);
        }

        .wave-wrapper {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            /* dipendekkan dari 120px */
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }


        /* wave-back (slower, lighter color) */
        .wave-back {
            display: flex;
            width: 200%;
            height: 100%;
            animation: waveMoveBack 20s linear infinite;
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 0;
        }

        /* wave-front (faster, higher opacity) */
        .wave-front {
            display: flex;
            width: 200%;
            height: 100%;
            animation: waveMoveFront 10s linear infinite;
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 1;
        }

        .wave-wrapper svg {
            width: 100%;
            height: 100%;
            flex-shrink: 0;
        }

        @keyframes waveMoveBack {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes waveMoveFront {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 30px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="reflection"></div>

        <div class="animation">
            <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_gjmecwii.json" background="transparent"
                speed="1" style="width: 100%; height: 320px;" loop autoplay>
            </lottie-player>
        </div>

        <div class="form-wrapper">
            <div class="fade-in-text">
                <img src="logo.png" alt="Logo Ruang Desa" class="logo" width="80">
                <div class="text">
                    Selamat Datang<br>di Ruang Desa
                </div>
            </div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <x-validation-errors class="mb-4" />

                <div class="form-group">
                    <input type="email" name="email" required placeholder=" ">
                    <label>Email</label>
                </div>

                <div class="form-group">
                    <input type="password" name="password" required placeholder=" ">
                    <label>Password</label>
                </div>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <!-- WAVE PARALLAX BACKGROUND -->
    <div class="wave-wrapper">
        <!-- Wave belakang -->
        <div class="wave-back">
            <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
                <path d="M0,20 C300,60 900,-20 1200,40 L1200,60 L0,60 Z" fill="#9c27b0" fill-opacity="0.15"></path>
            </svg>
            <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
                <path d="M0,20 C300,60 900,-20 1200,40 L1200,60 L0,60 Z" fill="#9c27b0" fill-opacity="0.15"></path>
            </svg>
        </div>

        <!-- Wave depan -->
        <div class="wave-front">
            <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
                <path d="M0,15 C300,45 900,-15 1200,35 L1200,60 L0,60 Z" fill="#7b1fa2" fill-opacity="0.3"></path>
            </svg>
            <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
                <path d="M0,15 C300,45 900,-15 1200,35 L1200,60 L0,60 Z" fill="#7b1fa2" fill-opacity="0.3"></path>
            </svg>
        </div>
    </div>


</body>

</html>
