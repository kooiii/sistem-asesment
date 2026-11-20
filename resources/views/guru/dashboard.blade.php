
@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('topbar-title', 'Dashboard Guru')

@section('content')

<div class="page-heading">
    <h4>Dashboard Guru</h4>
    <p>Selamat datang, {{ session('nama') }}. Berikut ringkasan aktivitas penilaian Anda.</p>
</div>

<!-- STATISTIK GURU -->
<div class="row g-3">

    <div class="col-xl-3 col-md-6">
        <div class="card-custom stat-card">
            <div>
                <div class="stat-label">Total Siswa</div>
                <h2>{{ $totalSiswa }}</h2>
                <small class="text-muted">Siswa yang diampu</small>
            </div>
            <div class="stat-icon icon-blue">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card-custom stat-card">
            <div>
                <div class="stat-label">Tujuan Pembelajaran</div>
                <h2>{{ $totalTP }}</h2>
                <small class="text-muted">TP terdaftar</small>
            </div>
            <div class="stat-icon icon-green">
                <i class="fas fa-bullseye"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card-custom stat-card">
            <div>
                <div class="stat-label">Nilai Formatif</div>
                <h2>{{ $totalFormatif }}</h2>
                <small class="text-muted">Data penilaian formatif</small>
            </div>
            <div class="stat-icon icon-orange">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card-custom stat-card">
            <div>
                <div class="stat-label">Nilai Sumatif</div>
                <h2>{{ $totalSumatif }}</h2>
                <small class="text-muted">Data penilaian sumatif</small>
            </div>
            <div class="stat-icon icon-purple">
                <i class="fas fa-file-signature"></i>
            </div>
        </div>
    </div>

</div>


<!-- INFORMASI -->
<div class="card-custom section-card mt-4">

    <div class="d-flex align-items-center gap-3 mb-3">
        <div class="stat-icon icon-blue">
            <i class="fas fa-graduation-cap"></i>
        </div>

        <div>
            <div class="section-title">Selamat Datang di Sistem Penilaian Akademik</div>
            <div class="section-subtitle">SMK Negeri 1 Sungai Tebelian</div>
        </div>
    </div>

    <p class="text-secondary mb-0" style="font-size:12px; line-height:2;">
        Melalui dashboard ini, Anda dapat mengelola tujuan pembelajaran,
        melakukan penilaian formatif dan sumatif, mencatat sikap serta
        presensi siswa, dan melihat rekapitulasi hasil penilaian sesuai
        kelas dan mata pelajaran yang menjadi tanggung jawab Anda.
    </p>

</div>


<!-- KONTEKS MENGAJAR -->
<div class="card-custom section-card mt-4">

    <div class="d-flex align-items-center gap-3 mb-4">

        <div class="stat-icon icon-green">
            <i class="fas fa-chalkboard-user"></i>
        </div>

        <div>
            <div class="section-title">Pengaturan Konteks Mengajar</div>
            <div class="section-subtitle">
                Pilih kelas dan mata pelajaran yang akan Anda kelola.
            </div>
        </div>

    </div>

    <form action="{{ route('ganti.context') }}" method="POST">
        @csrf

        <div class="row g-3 align-items-end">

            <div class="col-lg-5 col-md-5">

                <label class="form-label fw-semibold">
                    <i class="fas fa-school text-primary me-1"></i>
                    Kelas Aktif
                </label>

                <select name="kelas_id" class="form-select" required>
                    @foreach($guru->kelas as $kelas)
                        <option
                            value="{{ $kelas->id }}"
                            {{ session('kelas_aktif') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="col-lg-5 col-md-5">

                <label class="form-label fw-semibold">
                    <i class="fas fa-book text-primary me-1"></i>
                    Mata Pelajaran Aktif
                </label>

                <select name="mapel_id" class="form-select" required>
                    @foreach($guru->mapel as $mapel)
                        <option
                            value="{{ $mapel->id }}"
                            {{ session('mapel_aktif') == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="col-lg-2 col-md-2">

                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="fas fa-check me-1"></i>
                    Terapkan
                </button>

            </div>

        </div>

    </form>

    <hr class="my-4">

    <!-- KONTEKS AKTIF -->
    <div class="row g-3">

        <div class="col-md-6">

            <div class="p-3 rounded-3" style="background:#eaf2ff;">
                <small class="text-muted d-block mb-2">KELAS YANG SEDANG AKTIF</small>

                <div class="fw-bold" style="color:#123c75;">
                    <i class="fas fa-school me-2"></i>

                    {{ optional($guru->kelas->firstWhere('id', session('kelas_aktif')))->nama_kelas ?? 'Belum dipilih' }}
                </div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="p-3 rounded-3" style="background:#e6f8ef;">
                <small class="text-muted d-block mb-2">MATA PELAJARAN AKTIF</small>

                <div class="fw-bold" style="color:#166534;">
                    <i class="fas fa-book me-2"></i>

                    {{ optional($guru->mapel->firstWhere('id', session('mapel_aktif')))->nama_mapel ?? 'Belum dipilih' }}
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
