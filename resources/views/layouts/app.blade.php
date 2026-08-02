<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Sistem Penilaian SMK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        body{
            background:#f4f6f9;
        }

        .sidebar{

            width:250px;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            background:#1f2937;
            color:white;
            overflow-y:auto;
        }

        .sidebar h4{

            padding:20px;
            text-align:center;
            border-bottom:1px solid rgba(255,255,255,.1);

        }

        .sidebar a{

            color:white;
            text-decoration:none;

            display:block;

            padding:13px 20px;

        }

        .sidebar a:hover{

            background:#2563eb;

        }

        .sidebar a.active{
            background:#2563eb;
            color:white;
            font-weight: bold;
            border-left: 5px solid #60a5fa;
        }

        .sidebar a i{
            width:20px;
        }

        .content{

            margin-left:250px;
            padding:25px;
            min-height:100vh;
            background:#f4f6f9;

        }

        .topbar{

            background:white;

            padding:15px;

            border-radius:10px;

            margin-bottom:20px;

            box-shadow:0 2px 6px rgba(0,0,0,.1);

        }

        .card-custom{

            border:none;
            border-radius:10px;
            box-shadow:0 3px 10px rgba(0,0,0,.08);

        }

    </style>

</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="sidebar">

     <h4 class="text-center py-3">
        Sistem Informasi Manajemen</h4>
        <hr class="text-secondary">

        <a href="{{ route('dashboard') }}"
        class="{{ request()->routeIs('dashboard') ?'active':'' }}">Dashboard</a>

    @if(session('role') ==='guru' && isset($guru))

<div class="px-3 mb-3">

    <label class="text-light mb-1">Kelas Diampu</label>

    <select class="form-select mb-3">
        @foreach($guru->kelas as $kelas)
            <option value="{{ $kelas->id }}">
                {{ $kelas->nama_kelas }}
            </option>
        @endforeach
    </select>

    <label class="text-light mb-1">Mapel Diampu</label>

    <select class="form-select">
        @foreach($guru->mapel as $mapel)
            <option value="{{ $mapel->id }}">
                {{ $mapel->nama_mapel }}
            </option>
        @endforeach
    </select>
</div>
@endif

    @if(session('role') ==='admin')

<a href="{{ route('guru.index') }}"
class="{{ request()->routeIs('guru.*') ?'active':'' }}">
Data Guru
</a>

<a href="{{ route('siswa.index') }}"
class="{{ request()->routeIs('siswa.*') ?'active':'' }}">
Data Siswa
</a>

<a href="{{ route('kelas.index') }}"
class="{{ request()->routeIs('kelas.*') ?'active':'' }}">
Data Kelas
</a>

<a href="{{ route('mapel.index') }}"
class="{{ request()->routeIs('mapel.*') ?'active':'' }}">
Mata Pelajaran
</a>

<a href="{{ route('logout') }}">
Logout
</a>

@else

<a href="{{ route('tujuan-pembelajaran.index') }}"
class="{{ request()->routeIs('tujuan-pembelajaran.*') ?'active':'' }}">Penilaian Formatif</a>

<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#sumatifMenu">
        <i class="fa fa-file-alt"></i>Penilaian Sumatif</a>

    <div class="collapse" id="sumatifMenu">
        <a class="nav-link ms-3"
           href="{{ route('nilai-sumatif.index') }}">STS</a>

        <a class="nav-link ms-3"
           href="{{ route('nilai-sumatif.index') }}">SAS</a>
    </div>
</li>

<a href="{{ route('presensi.index') }}"
class="{{ request()->routeIs('presensi.*') ?'active':'' }}">
Presensi & Sikap
</a>

<a href="{{ route('laporan.index') }}"
class="{{ request()->routeIs('laporan') ?'active':'' }}">
Rekap Nilai
</a>

<a href="{{ route('logout') }}">
Logout
</a>

@endif

</div>

<div class="content">

<div class="topbar d-flex justify-content-between align-items-center">

    <div>
        <h4>Sistem Informasi Manajemen SMK Negeri 1 Sungai Tebelian</h4>
        <small>Selamat datang,<strong>{{ session('nama') }}</strong></small>
    </div>

    <div>
        <span class="badge bg-primary">
            {{ session('role') }}
        </span>
    </div>
</div>
    



    @yield('content')

</div>

@stack('scripts')
</body>
</html>