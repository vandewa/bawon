<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon_io/favicon.ico">

    <title>Pendaftaran</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap">

    <!-- Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #0080bc, #24a13b);
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-family: 'Montserrat', sans-serif;
        }

        .login-card {
            padding: 20px;
            box-sizing: border-box;
            text-align: center;
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-card .logo img {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        .login-card h2 {
            font-size: 26px;
            margin-bottom: 10px;
            color: #333;
        }

        .login-card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-field {
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        .form-field input {
            border: 1px solid #ddd;
            width: 100%;
            border-radius: 8px;
            height: 44px;
            padding: 0 16px;
            background: #f9f9f9;
            color: #333;
            outline: none;
            transition: all 0.3s;
            box-sizing: border-box;
            /* Include padding and border in width */
        }

        .form-field input::placeholder {
            color: #999;
        }

        .form-field input:focus {
            border-color: #0080bc;
            background: #fff;
        }

        button {
            background: #0080bc;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            box-sizing: border-box;
            /* Include padding and border in width */
        }

        button:hover {
            background: #005a8c;
        }

        a {
            color: #0080bc;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .login-card {
                padding: 16px;
                max-width: 90%;
            }

            .login-card h2 {
                font-size: 24px;
            }

            .login-card .logo img {
                width: 80px;
            }

            .form-field input {
                height: 40px;
                padding: 0 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="header">
            <div class="logo">
                <div><img src="{{ asset('pemda.png') }}" alt=""></div>
            </div>
            <h2>Pendaftaran</h2>
            <p>Silakan isi formulir di bawah untuk mendaftar.</p>
        </div>
        <form method="post" action="{{ route('registrasi.store') }}">
            @csrf
            <div class="form-field">
                <input type="text" placeholder="Nama Lengkap" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-field">
                <input type="number" placeholder="NIK" name="nik" value="{{ old('nik') }}" required>
                @error('nik')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-field">
                <input type="number" placeholder="Nomor WhatsApp" name="wa" value="{{ old('wa') }}" required>
                @error('wa')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-field">
                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-field">
                <input type="password" placeholder="Password" name="password" value="{{ old('password') }}" required>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-field">
                <input type="password" placeholder="Konfirmasi Password" name="password_confirmation"
                    value="{{ old('password_confirmation') }}" required>
                @error('password_confirmation')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Daftar</button>

            <div>
                <p>
                    Sudah punya akun? <a href="/login">Login Sekarang</a>
                </p>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function sweetAlert() {
            Swal.fire({
                title: "Berhasil!",
                text: "Menambahkan data user.",
                confirmButtonText: "OK",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire("Silahkan masuk di halaman login!", "", "success");
                    window.location.href = "{{ route('login') }}";
                }
            });
        }

        @if (session('status'))
            sweetAlert();
        @endif
    </script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/bb9305debb.js" crossorigin="anonymous"></script>
    <!-- Javascript Requirements -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {{-- {!! JsValidator::formRequest('App\Http\Requests\RegisterValidation') !!} --}}
</body>

</html>
