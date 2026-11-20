
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard') | Sistem Penilaian Akademik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #123c75;
            --navy-dark: #0c2852;
            --blue: #2563a6;
            --blue-light: #eaf2ff;
            --body-bg: #f3f6fb;
            --text: #243247;
            --muted: #8492a6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--body-bg);
            color: var(--text);
            font-size: 13px;
        }

        /* SIDEBAR */

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            background: linear-gradient(180deg, var(--navy-dark), #123c75);
            color: white;
            overflow-y: auto;
            transition: .3s ease;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.25) transparent;
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255,255,255,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .sidebar-brand h5 {
            font-size: 12px;
            font-weight: 700;
            line-height: 1.5;
            margin: 0;
        }

        .sidebar-brand p {
            font-size: 9px;
            color: #bfdbfe;
            margin: 3px 0 0;
        }

        .sidebar-user {
            margin: 18px 15px;
            padding: 13px;
            border-radius: 12px;
            background: rgba(255,255,255,.09);
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #dbeafe;
            color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-user strong {
            display: block;
            font-size: 11px;
            color: white;
            max-width: 155px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar-user small {
            color: #bfdbfe;
            font-size: 9px;
        }

        .menu-label {
            padding: 18px 20px 8px;
            color: #9db7d9;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.3px;
        }

        .sidebar a {
            color: #dbeafe;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            margin: 3px 12px;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 500;
            transition: .2s;
        }

        .sidebar a i {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,.12);
            color: white;
        }

        .sidebar a.active {
            background: #ffffff;
            color: var(--navy);
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(0,0,0,.10);
        }

        .sidebar .submenu {
            margin-left: 32px;
            padding: 10px 15px;
            background: rgba(255,255,255,.06);
            font-size: 10px;
        }

        .sidebar .submenu.active {
            background: rgba(255,255,255,.18);
            color: white;
        }

        .sidebar .menu-arrow {
            margin-left: auto;
            font-size: 10px;
        }

        .sidebar-bottom {
            padding: 15px 0 25px;
            margin-top: 10px;
            border-top: 1px solid rgba(255,255,255,.12);
        }

        .sidebar a.logout-link {
            color: #fecaca;
        }

        .sidebar a.logout-link:hover {
            background: rgba(220,38,38,.18);
        }

        /* MAIN CONTENT */

        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            transition: .3s ease;
        }

        .topbar {
            min-height: 78px;
            background: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            box-shadow: 0 2px 12px rgba(15,35,75,.04);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar h5 {
            color: var(--navy);
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .topbar small {
            color: var(--muted);
            font-size: 10px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .role-badge {
            background: var(--blue-light);
            color: var(--navy);
            border-radius: 30px;
            padding: 8px 14px;
            font-size: 10px;
            font-weight: 700;
        }

        .topbar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--navy);
            color: white;
        }

        .content {
            padding: 28px 30px 40px;
        }

        .page-heading {
            margin-bottom: 23px;
        }

        .page-heading h4 {
            color: var(--navy);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .page-heading p {
            color: var(--muted);
            font-size: 11px;
            margin: 0;
        }

        /* CARDS */

        .card-custom {
            border: 1px solid #edf1f7;
            border-radius: 14px;
            background: white;
            box-shadow: 0 4px 16px rgba(15,35,75,.04);
        }

        .stat-card {
            padding: 20px;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            transition: .25s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(15,35,75,.09);
        }

        .stat-card .stat-label {
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .stat-card h2 {
            color: var(--navy);
            font-size: 27px;
            font-weight: 700;
            margin: 0;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .icon-blue {
            background: #eaf2ff;
            color: #2563eb;
        }

        .icon-green {
            background: #e6f8ef;
            color: #16a34a;
        }

        .icon-orange {
            background: #fff4e5;
            color: #ea8a12;
        }

        .icon-purple {
            background: #f1eafe;
            color: #8b5cf6;
        }

        .section-card {
            padding: 23px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .section-subtitle {
            color: var(--muted);
            font-size: 10px;
        }

        .btn-primary-custom {
            background: var(--navy);
            border: none;
            color: white;
            border-radius: 8px;
            padding: 10px 17px;
            font-size: 11px;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            background: var(--blue);
            color: white;
        }

        .form-control,
        .form-select {
            font-size: 12px;
            border-radius: 8px;
            border-color: #e2e8f0;
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59,130,246,.10);
        }

        .mobile-toggle {
            display: none;
            border: none;
            background: var(--blue-light);
            color: var(--navy);
            border-radius: 8px;
            width: 38px;
            height: 38px;
        }

        .sidebar-overlay {
            display: none;
        }

        /* RESPONSIVE */

        @media(max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1040;
                background: rgba(15,23,42,.45);
            }
        }

        @media(max-width: 576px) {
            .topbar {
                padding: 12px 15px;
            }

            .topbar h5 {
                font-size: 12px;
            }

            .topbar small {
                font-size: 9px;
            }

            .topbar-right .role-badge {
                display: none;
            }

            .content {
                padding: 20px 15px 30px;
            }

            .page-heading h4 {
                font-size: 17px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-card h2 {
                font-size: 23px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

@php
    $role = session('role');
    $namaPengguna = session('nama', 'Pengguna');
@endphp

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>

        <div>
            <h5>SMK NEGERI 1<br>SUNGAI TEBELIAN</h5>
            <p>Sistem Penilaian Akademik</p>
        </div>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>

        <div>
            <strong>{{ $namaPengguna }}</strong>
            <small>{{ ucfirst($role ?? 'Pengguna') }}</small>
        </div>
    </div>

    <div class="menu-label">Menu Utama</div>

    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-house"></i>
        Dashboard
    </a>

    {{-- MENU ADMIN --}}
    @if($role === 'admin')

        <div class="menu-label">Pengelolaan Data</div>

        <a href="{{ route('guru.index') }}"
           class="{{ request()->routeIs('guru.*') ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher"></i>
            Data Guru
        </a>

        <a href="{{ route('siswa.index') }}"
           class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate"></i>
            Data Siswa
        </a>

        <a href="{{ route('kelas.index') }}"
           class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}">
            <i class="fas fa-school"></i>
            Data Kelas
        </a>

        <a href="{{ route('mapel.index') }}"
           class="{{ request()->routeIs('mapel.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            Mata Pelajaran
        </a>

        <div class="menu-label">Monitoring Akademik</div>

        <a href="{{ route('laporan.index') }}"
           class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="fas fa-chart-column"></i>
            Rekap Nilai
        </a>

    {{-- MENU GURU --}}
    @elseif($role === 'guru')

        @if(isset($guru))
            <div class="mx-3 mb-3 p-3 rounded-3" style="background:rgba(255,255,255,.08)">
                <div class="small text-white-50 mb-2">KONTEKS MENGAJAR</div>

                <div class="small text-white mb-1">
                    <i class="fas fa-school me-2"></i>
                    {{ optional($guru->kelas->firstWhere('id', session('kelas_aktif')))->nama_kelas ?? 'Belum dipilih' }}
                </div>

                <div class="small text-white">
                    <i class="fas fa-book me-2"></i>
                    {{ optional($guru->mapel->firstWhere('id', session('mapel_aktif')))->nama_mapel ?? 'Belum dipilih' }}
                </div>
            </div>
        @endif

        <div class="menu-label">Penilaian</div>

        <a href="{{ route('nilai-formatif.index') }}"
   class="{{ request()->routeIs('nilai-formatif.*') ? 'active' : '' }}">
    <i class="fas fa-clipboard-list"></i>
    Penilaian Formatif
</a>

        <div class="sumatif-menu">

            <a href="#sumatifMenu"
               data-bs-toggle="collapse"
               role="button"
               aria-expanded="{{ request()->routeIs('nilai-sumatif.*') ? 'true' : 'false' }}"
               aria-controls="sumatifMenu">
                <i class="fas fa-clipboard-check"></i>
                Penilaian Sumatif
                <i class="fas fa-chevron-down menu-arrow"></i>
            </a>

            <div class="collapse {{ request()->routeIs('nilai-sumatif.*') ? 'show' : '' }}"
                 id="sumatifMenu">

                <a class="submenu {{ request()->routeIs('nilai-sumatif.*') ? 'active' : '' }}"
                   href="{{ route('nilai-sumatif.index') }}">
                    <i class="fas fa-circle-dot"></i>
                    STS / SAS
                </a>

            </div>
        </div>

        <a href="{{ route('presensi.index') }}"
           class="{{ request()->routeIs('presensi.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i>
            Presensi & Sikap
        </a>

        <div class="menu-label">Laporan Akademik</div>

        <a href="{{ route('laporan.index') }}"
           class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="fas fa-chart-column"></i>
            Rekap Nilai
        </a>

        <a href="{{ route('rapor.index') }}"
           class="{{ request()->routeIs('rapor.*') ? 'active' : '' }}">
            <i class="fas fa-file-lines"></i>
            Rapor
        </a>

    @endif

    <div class="sidebar-bottom">
        <a href="{{ route('logout') }}" class="logout-link"
           onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
            <i class="fas fa-right-from-bracket"></i>
            Logout
        </a>
    </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- MAIN -->
<div class="main-wrapper">

    <header class="topbar">

        <div class="topbar-left">

            <button type="button" class="mobile-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <div>
                <h5>@yield('topbar-title', 'Sistem Penilaian Akademik')</h5>
                <small>SMK Negeri 1 Sungai Tebelian</small>
            </div>

        </div>

        <div class="topbar-right">

            <span class="role-badge">
                <i class="fas fa-user-shield me-1"></i>
                {{ ucfirst($role ?? 'Pengguna') }}
            </span>

            <div class="topbar-avatar">
                <i class="fas fa-user"></i>
            </div>

        </div>

    </header>

    <main class="content">
        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function closeSidebar() {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
    }

    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('show');
        sidebarOverlay.classList.toggle('show');
    });

    sidebarOverlay.addEventListener('click', closeSidebar);

    document.querySelectorAll('.sidebar a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 991 && !this.hasAttribute('data-bs-toggle')) {
                closeSidebar();
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>
