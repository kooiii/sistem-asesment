
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penilaian Akademik | SMK Negeri 1 Sungai Tebelian</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #172554;
        }

        .navbar {
            width: 100%;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            position: relative;
            z-index: 10;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: #123c75;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .brand h3 {
            font-size: 15px;
            font-weight: 700;
            color: #123c75;
        }

        .brand p {
            font-size: 11px;
            color: #64748b;
        }

        .nav-login {
            text-decoration: none;
            background: #123c75;
            color: white;
            padding: 11px 25px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            transition: .3s;
        }

        .nav-login:hover {
            background: #0b2852;
            transform: translateY(-2px);
        }

        .hero {
            min-height: 570px;
            padding: 75px 8%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
            background:
                radial-gradient(circle at 85% 20%, rgba(96,165,250,.22), transparent 25%),
                linear-gradient(120deg, #0c2852, #164b87);
            color: white;
            overflow: hidden;
        }

        .hero-content {
            max-width: 650px;
        }

        .hero-label {
            display: inline-block;
            padding: 9px 16px;
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 30px;
            font-size: 12px;
            margin-bottom: 24px;
            color: #dbeafe;
            background: rgba(255,255,255,.08);
        }

        .hero h1 {
            font-size: clamp(30px, 4.5vw, 49px);
            line-height: 1.3;
            font-weight: 800;
            margin-bottom: 22px;
        }

        .hero h1 span {
            color: #93c5fd;
        }

        .hero-content > p {
            color: #dbeafe;
            line-height: 1.9;
            font-size: 14px;
            max-width: 570px;
            margin-bottom: 32px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-block;
            text-decoration: none;
            background: #ffffff;
            color: #123c75;
            padding: 14px 25px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            transition: .3s;
        }

        .btn-primary:hover {
            background: #dbeafe;
            transform: translateY(-3px);
        }

        .btn-secondary {
            display: inline-block;
            text-decoration: none;
            color: white;
            border: 1px solid rgba(255,255,255,.5);
            padding: 14px 25px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            transition: .3s;
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,.1);
        }

        .hero-visual {
            width: 390px;
            min-width: 300px;
            height: 340px;
            border-radius: 25px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 25px 60px rgba(0,0,0,.18);
        }

        .visual-card {
            width: 78%;
            background: white;
            color: #123c75;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0,0,0,.15);
        }

        .visual-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-bottom: 17px;
        }

        .visual-card h3 {
            font-size: 17px;
            margin-bottom: 7px;
        }

        .visual-card p {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 20px;
        }

        .visual-line {
            height: 8px;
            background: #e2e8f0;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .visual-line.short {
            width: 65%;
            background: #93c5fd;
        }

        .features {
            padding: 75px 8%;
            text-align: center;
        }

        .section-label {
            color: #2563eb;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .features h2 {
            font-size: 29px;
            margin: 12px 0;
            color: #123c75;
        }

        .section-desc {
            max-width: 600px;
            margin: 0 auto;
            font-size: 13px;
            color: #64748b;
            line-height: 1.8;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 23px;
            margin-top: 45px;
            text-align: left;
        }

        .feature-card {
            background: white;
            padding: 30px 25px;
            border-radius: 15px;
            border: 1px solid #e8eef6;
            transition: .3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(15, 45, 90, .08);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #eaf2ff;
            color: #2563eb;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 16px;
            color: #123c75;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 12px;
            line-height: 1.8;
            color: #64748b;
        }

        .cta {
            margin: 0 8% 75px;
            padding: 45px;
            border-radius: 18px;
            background: linear-gradient(120deg, #123c75, #2563a6);
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 25px;
            margin-bottom: 12px;
        }

        .cta p {
            font-size: 13px;
            color: #dbeafe;
            margin-bottom: 25px;
        }

        footer {
            padding: 25px 8%;
            text-align: center;
            background: #0c2852;
            color: #cbd5e1;
            font-size: 11px;
            line-height: 1.8;
        }

        @media(max-width: 900px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 65px;
            }

            .hero-content > p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-visual {
                width: 100%;
                max-width: 390px;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 600px) {
            .navbar {
                padding: 15px 5%;
            }

            .brand h3 {
                font-size: 12px;
            }

            .brand p {
                font-size: 9px;
            }

            .nav-login {
                padding: 10px 14px;
                font-size: 11px;
            }

            .hero {
                padding: 55px 6%;
            }

            .hero-visual {
                min-width: unset;
                height: 290px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .features {
                padding: 60px 6%;
            }

            .features h2 {
                font-size: 23px;
            }

            .cta {
                margin: 0 6% 55px;
                padding: 35px 20px;
            }

            .cta h2 {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="brand">
            <div class="brand-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>

            <div>
                <h3>SMK NEGERI 1 SUNGAI TEBELIAN</h3>
                <p>Sistem Informasi Penilaian Akademik</p>
            </div>
        </div>

        <a href="{{ url('/login') }}" class="nav-login">
            <i class="fas fa-sign-in-alt"></i> Login
        </a>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-label">
                <i class="fas fa-laptop-code"></i>
                SISTEM INFORMASI AKADEMIK SEKOLAH
            </div>

            <h1>
                Sistem Informasi
                <span>Penilaian Akademik</span>
                Siswa
            </h1>

            <p>
                Selamat datang di Sistem Informasi Penilaian Akademik
                SMK Negeri 1 Sungai Tebelian. Platform ini dirancang untuk
                membantu pengelolaan dan pemantauan hasil belajar siswa
                secara terstruktur, efektif, dan terintegrasi.
            </p>

            <div class="hero-buttons">
                <a href="{{ url('/login') }}" class="btn-primary">
                    Masuk ke Sistem
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>

                <a href="#fitur" class="btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    Pelajari Fitur
                </a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="visual-card">
                <div class="visual-icon">
                    <i class="fas fa-chart-line"></i>
                </div>

                <h3>Penilaian Akademik</h3>
                <p>Pengelolaan hasil belajar siswa secara digital.</p>

                <div class="visual-line"></div>
                <div class="visual-line short"></div>
                <div class="visual-line"></div>
                <div class="visual-line short"></div>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="features" id="fitur">
        <div class="section-label">Fitur Sistem</div>

        <h2>Pengelolaan Penilaian Lebih Mudah</h2>

        <p class="section-desc">
            Sistem menyediakan berbagai fitur untuk mendukung proses
            penilaian dan pemantauan perkembangan hasil belajar siswa.
        </p>

        <div class="feature-grid">

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Data Akademik</h3>
                <p>
                    Pengelolaan data guru, siswa, kelas, mata pelajaran,
                    dan penugasan guru.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3>Penilaian Formatif</h3>
                <p>
                    Pengelolaan penilaian formatif berdasarkan tujuan
                    pembelajaran dan proses pembelajaran siswa.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3>Penilaian Sumatif</h3>
                <p>
                    Pengelolaan nilai Sumatif Tengah Semester dan
                    Sumatif Akhir Semester.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3>Sikap dan Presensi</h3>
                <p>
                    Pencatatan penilaian sikap dan kehadiran siswa
                    sebagai bagian dari penilaian akademik.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Rekapitulasi Nilai</h3>
                <p>
                    Menampilkan rekapitulasi hasil penilaian siswa
                    secara terstruktur dan mudah dipantau.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h3>Laporan dan Rapor</h3>
                <p>
                    Menyajikan hasil penilaian dalam bentuk laporan
                    dan rapor yang dapat dicetak.
                </p>
            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <h2>Mulai Gunakan Sistem Penilaian Akademik</h2>

        <p>
            Silakan masuk menggunakan akun yang telah diberikan
            untuk mengakses fitur sesuai dengan hak akses Anda.
        </p>

        <a href="{{ url('/login') }}" class="btn-primary">
            Login ke Sistem
            <i class="fas fa-arrow-right"></i>
        </a>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>
            &copy; {{ date('Y') }} SMK Negeri 1 Sungai Tebelian.
            Sistem Informasi Penilaian Akademik.
        </p>
    </footer>

</body>
</html>
