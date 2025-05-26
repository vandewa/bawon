<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Ruang Desa</title>
    <!-- Description -->
    <meta name="description"
        content="Masuk ke Ruang Desa, platform digital terpercaya untuk layanan desa. Login untuk mengelola data dan layanan Anda.">
    <!-- Keywords -->
    <meta name="keywords" content="Login Ruang Desa, Portal Desa, Digitalisasi Desa, Sistem Informasi Desa, Admin Desa">
    <!-- Author -->
    <meta name="author" content="" />
    <!-- Preconnect untuk Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Robots -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="{{ asset('logo.ico') }}">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-light: #e0f7fa;
            --primary-mid: #b2ebf2;
            --primary-dark: #007b8a;
            --accent: #17a2b8;
            --dark-bg: #0a192f;
            --dark-card: #112240;
            --dark-text: #ccd6f6;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-mid));
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.5s ease;
        }

        .container {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
            padding: 50px;
            max-width: 960px;
            margin: 50px 20px;
            overflow: hidden;
            animation: popIn 0.8s ease forwards;
            transition: background 0.5s ease;
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
            color: var(--primary-dark);
            margin-bottom: 30px;
            text-align: center;
            opacity: 0;
            animation: fadeInText 1s 0.3s ease-out forwards;
        }

        @keyframes fadeInText {
            to {
                opacity: 1;
            }
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-group input {
            width: 100%;
            padding: 14px;
            border: 1px solid var(--accent);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            color: #333;
            transition: 0.3s;
        }

        .form-group input:focus {
            outline: none;
            box-shadow: 0 0 0 3px var(--accent);
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
        .form-group input:not(:placeholder-shown)+label {
            top: -10px;
            left: 10px;
            background: white;
            font-size: 12px;
            color: var(--primary-dark);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, var(--accent), #0097a7);
            color: white;
            font-weight: 600;
            font-size: 16px;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 151, 167, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            transform: scale(1.04);
            box-shadow: 0 10px 30px rgba(0, 151, 167, 0.5);
        }

        .loading-spinner {
            position: absolute;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.5);
            border-top: 3px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .wave-wrapper {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            overflow: hidden;
            z-index: 0;
        }

        .wave-wrapper svg path {
            fill: var(--accent);
        }

        .wave-back path {
            fill-opacity: 0.1;
        }

        .wave-front path {
            fill-opacity: 0.25;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 30px;
            }
        }

        /* DARK MODE */
        body.dark {
            background: linear-gradient(135deg, var(--dark-bg), var(--dark-card));
        }

        body.dark .container {
            background: rgba(17, 34, 64, 0.8);
        }

        body.dark .fade-in-text,
        body.dark .form-group label {
            color: var(--dark-text);
        }

        body.dark .form-group input {
            background: rgba(255, 255, 255, 0.1);
            color: var(--dark-text);
            border: 1px solid var(--accent);
        }
    </style>

    <script src="https://www.google.com/recaptcha/enterprise.js?render={{ config('app.SITE_KEY') }}"></script>

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
                <img src="logo.png" alt="Logo Ruang Desa" width="80"><br>
                Selamat Datang<br>di Ruang Desa
            </div>
            <form id="loginForm" action="{{ route('login') }}" method="POST">
                <input type="hidden" name="g-recaptcha-response" id="recaptcha_token">
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
                <button id="loginButton" class="g-recaptcha btn btn-primary" data-sitekey="{{ config('app.SITE_KEY') }}"
                    data-callback="onSubmit" data-action="submit" type="submit">
                    <span class="btn-text">Login</span>
                    <div class="loading-spinner" id="loadingSpinner"></div>
                </button>
            </form>

            <!-- Tombol Pendaftaran -->
            <div class="mt-4 text-center">
                <p>Belum punya akun? <a href="{{ route('pendaftaran') }}"
                        style="color: var(--primary-dark); font-weight: 600; text-decoration: none;">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>

    <!-- WAVE BACKGROUND -->
    <div class="wave-wrapper">
        <div class="wave-back">
            <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
                <path d="M0,20 C300,60 900,-20 1200,40 L1200,60 L0,60 Z"></path>
            </svg>
            <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
                <path d="M0,20 C300,60 900,-20 1200,40 L1200,60 L0,60 Z"></path>
            </svg>
        </div>
        <div class="wave-front">
            <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
                <path d="M0,15 C300,45 900,-15 1200,35 L1200,60 L0,60 Z"></path>
            </svg>
            <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
                <path d="M0,15 C300,45 900,-15 1200,35 L1200,60 L0,60 Z"></path>
            </svg>
        </div>
    </div>

    <script>
        // Aktifkan Dark Mode otomatis
        const hour = new Date().getHours();
        if (hour >= 18 || hour <= 6) {
            document.body.classList.add('dark');
        }
    </script>

    <script>
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const loadingSpinner = document.getElementById('loadingSpinner');

        function onSubmit(token) {
            // Tampilkan spinner & disable tombol
            loginButton.disabled = true;
            loginButton.querySelector('.btn-text').style.display = 'none';
            loadingSpinner.style.display = 'inline-block';

            // Tambahkan token ke input hidden
            const tokenInput = document.createElement("input");
            tokenInput.setAttribute("type", "hidden");
            tokenInput.setAttribute("name", "g-recaptcha-response");
            tokenInput.setAttribute("value", token);
            loginForm.appendChild(tokenInput);

            // Submit form secara manual
            loginForm.submit();
        }
    </script>

</body>

</html>
