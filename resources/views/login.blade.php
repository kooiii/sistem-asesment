
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Sistem Penilaian Akademik</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            /* LOGO SEKOLAH PADA LOGIN */
            .school-logo {
                width: 58px;
                height: 58px;
                object-fit: contain;
                background: white;
                border-radius: 12px;
                padding: 4px;
                flex-shrink: 0;
            }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            min-height: 650px;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            box-shadow: 0 25px 70px rgba(15, 35, 75, 0.13);
        }

        /* BAGIAN KIRI */

        .login-left {
            position: relative;
            background: linear-gradient(145deg, #0c2852, #164b87);
            padding: 55px 48px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .login-left::before {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            top: -120px;
            right: -130px;
        }

        .login-left::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            bottom: -120px;
            left: -100px;
        }

        .school-brand,
        .left-content,
        .left-footer {
            position: relative;
            z-index: 2;
        }

        .school-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .school-icon {
            width: 55px;
            height: 55px;
            border-radius: 15px;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .school-brand h5 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .school-brand p {
            font-size: 10px;
            color: #bfdbfe;
            margin: 0;
        }

        .left-content {
            margin-top: 55px;
            margin-bottom: 55px;
        }

        .welcome-label {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 30px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            color: #dbeafe;
            font-size: 11px;
            margin-bottom: 25px;
        }

        .left-content h1 {
            font-size: 35px;
            font-weight: 800;
            line-height: 1.35;
            margin-bottom: 20px;
        }

        .left-content h1 span {
            color: #93c5fd;
        }

        .left-content > p {
            font-size: 12px;
            line-height: 2;
            color: #dbeafe;
            max-width: 420px;
        }

        .illustration {
            margin-top: 35px;
            padding: 25px;
            border-radius: 18px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.16);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .illustration-icon {
            width: 65px;
            height: 65px;
            flex-shrink: 0;
            border-radius: 16px;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #bfdbfe;
        }

        .illustration h6 {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .illustration p {
            font-size: 10px;
            color: #dbeafe;
            margin: 0;
            line-height: 1.7;
        }

        .left-footer {
            font-size: 10px;
            color: #bfdbfe;
        }

        /* BAGIAN KANAN */

        .login-right {
            padding: 65px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .back-home {
            position: absolute;
            top: 30px;
            right: 35px;
            text-decoration: none;
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
            transition: .3s;
        }

        .back-home:hover {
            color: #2563eb;
        }

        .form-heading {
            margin-bottom: 35px;
        }

        .form-heading .small-label {
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .form-heading h2 {
            font-size: 29px;
            font-weight: 700;
            color: #123c75;
            margin-bottom: 10px;
        }

        .form-heading p {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.8;
        }

        .alert {
            font-size: 11px;
            border-radius: 10px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 9px;
        }

        .input-group {
            border: 1px solid #e2e8f0;
            border-radius: 11px;
            overflow: hidden;
            transition: .3s;
            background: #f8fafc;
        }

        .input-group:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.10);
            background: white;
        }

        .input-group-text {
            border: none;
            background: transparent;
            color: #94a3b8;
            padding-left: 16px;
        }

        .form-control {
            border: none;
            background: transparent;
            padding: 14px 12px;
            font-size: 12px;
            box-shadow: none !important;
        }

        .form-control:focus {
            background: transparent;
        }

        .form-control::placeholder {
            color: #b0bac8;
        }

        .password-toggle {
            border: none;
            background: transparent;
            padding: 0 16px;
            color: #94a3b8;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: #2563eb;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(120deg, #123c75, #2563a6);
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            margin-top: 12px;
            transition: .3s;
            box-shadow: 0 8px 18px rgba(37,99,166,0.20);
        }

        .btn-login:hover {
            background: linear-gradient(120deg, #0c2852, #164b87);
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(37,99,166,0.25);
        }

        .login-note {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #94a3b8;
            line-height: 1.8;
        }

        .login-note i {
            color: #2563eb;
            margin-right: 5px;
        }

        .copyright {
            margin-top: 35px;
            text-align: center;
            font-size: 10px;
            color: #cbd5e1;
        }

        .invalid-feedback {
            display: block;
            font-size: 10px;
            padding-left: 3px;
        }

        /* RESPONSIVE */

        @media(max-width: 850px) {
            .login-wrapper {
                max-width: 520px;
                grid-template-columns: 1fr;
            }

            .login-left {
                padding: 35px;
            }

            .left-content {
                margin: 40px 0;
            }

            .left-content h1 {
                font-size: 28px;
            }

            .illustration {
                display: none;
            }

            .login-right {
                padding: 65px 40px 45px;
            }
        }

        @media(max-width: 480px) {
            body {
                padding: 12px;
            }

            .login-wrapper {
                border-radius: 17px;
            }

            .login-left {
                padding: 28px 25px;
            }

            .school-brand h5 {
                font-size: 11px;
            }

            .school-brand p {
                font-size: 9px;
            }

            .left-content {
                margin: 35px 0;
            }

            .left-content h1 {
                font-size: 25px;
            }

            .login-right {
                padding: 65px 25px 35px;
            }

            .form-heading h2 {
                font-size: 25px;
            }

            .back-home {
                top: 25px;
                right: 25px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <!-- BAGIAN KIRI -->
    <div class="login-left">

        <div class="school-brand">

            <img
                src="{{ asset('images/logo-sekolah.png') }}"
                alt="Logo SMK Negeri 1 Sungai Tebelian"
                class="school-logo">

            <div>
                <h5>SMK NEGERI 1 SUNGAI TEBELIAN</h5>
                <p>Sistem Informasi Penilaian Akademik</p>
            </div>

        </div>

        <div class="left-content">

            <div class="welcome-label">
                <i class="fas fa-shield-alt me-2"></i>
                PORTAL AKADEMIK SEKOLAH
            </div>

            <h1>
                Selamat Datang di
                <span>Sistem Penilaian Akademik</span>
            </h1>

            <p>
                Platform digital untuk mendukung pengelolaan penilaian
                hasil belajar siswa secara terstruktur, efektif,
                dan terintegrasi di SMK Negeri 1 Sungai Tebelian.
            </p>

            <div class="illustration">
                <div class="illustration-icon">
                    <i class="fas fa-chart-line"></i>
                </div>

                <div>
                    <h6>Pengelolaan Penilaian Digital</h6>
                    <p>
                        Mempermudah guru dalam mengelola penilaian
                        serta membantu sekolah memantau hasil belajar siswa.
                    </p>
                </div>
            </div>

        </div>

        <div class="left-footer">
            <i class="far fa-calendar-check me-1"></i>
            Sistem Informasi Akademik Sekolah
        </div>

    </div>


    <!-- BAGIAN KANAN -->
    <div class="login-right">

        <a href="{{ url('/') }}" class="back-home">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali ke Beranda
        </a>

        <div class="form-heading">

            <div class="small-label">
                LOGIN PENGGUNA
            </div>

            <h2>Masuk ke Sistem</h2>

            <p>
                Silakan masukkan NIP dan password Anda
                untuk melanjutkan ke halaman dashboard.
            </p>

        </div>


        <!-- NOTIFIKASI ERROR -->
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif


        <!-- FORM LOGIN -->
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <!-- NIP -->
            <div class="mb-4">

                <label class="form-label">Nomor Induk Pegawai (NIP)</label>

                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-id-card"></i>
                    </span>

                    <input
                        type="text"
                        name="nip"
                        class="form-control @error('nip') is-invalid @enderror"
                        placeholder="Masukkan NIP Anda"
                        value="{{ old('nip') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                @error('nip')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- PASSWORD -->
            <div class="mb-3">

                <label class="form-label">Password</label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan password Anda"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        id="togglePassword"
                        aria-label="Tampilkan password"
                    >
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>

                </div>

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- TOMBOL LOGIN -->
            <button type="submit" class="btn-login">
                Masuk ke Dashboard
                <i class="fas fa-arrow-right ms-2"></i>
            </button>

        </form>


        <div class="login-note">
            <i class="fas fa-lock"></i>
            Akses sistem hanya diperuntukkan bagi pengguna
            yang memiliki akun resmi.
        </div>

        <div class="copyright">
            &copy; {{ date('Y') }} SMK Negeri 1 Sungai Tebelian
        </div>

    </div>

</div>


<!-- JAVASCRIPT -->
<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
            togglePassword.setAttribute('aria-label', 'Sembunyikan password');
        } else {
            password.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
            togglePassword.setAttribute('aria-label', 'Tampilkan password');
        }

    });
</script>

</body>
</html>
