
@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('topbar-title', 'Dashboard Administrator')

@section('content')

<div class="page-heading">
    <h4>Dashboard Administrator</h4>
    <p>Selamat datang di halaman pengelolaan Sistem Penilaian Akademik.</p>
</div>

<div class="row g-3">

    <div class="col-xl-3 col-md-6">
        <div class="card-custom stat-card">
            <div>
                <div class="stat-label">Total Guru</div>
                <h2>{{ $totalGuru }}</h2>
                <small class="text-muted">Data guru terdaftar</small>
            </div>
            <div class="stat-icon icon-blue">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card-custom stat-card">
            <div>
                <div class="stat-label">Total Siswa</div>
                <h2>{{ $totalSiswa }}</h2>
                <small class="text-muted">Data siswa terdaftar</small>
            </div>
            <div class="stat-icon icon-green">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card-custom stat-card">
            <div>
                <div class="stat-label">Total Kelas</div>
                <h2>{{ $totalKelas }}</h2>
                <small class="text-muted">Kelas terdaftar</small>
            </div>
            <div class="stat-icon icon-orange">
                <i class="fas fa-school"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card-custom stat-card">
            <div>
                <div class="stat-label">Total Mata Pelajaran</div>
                <h2>{{ $totalMapel }}</h2>
                <small class="text-muted">Mata pelajaran terdaftar</small>
            </div>
            <div class="stat-icon icon-purple">
                <i class="fas fa-book-open"></i>
            </div>
        </div>
    </div>

</div>

<div class="row g-3 mt-2">

    <div class="col-lg-8">
        <div class="card-custom section-card h-100">

            <div class="d-flex align-items-center mb-3">
                <div class="stat-icon icon-blue me-3">
                    <i class="fas fa-school"></i>
                </div>

                <div>
                    <div class="section-title">Selamat Datang, Administrator</div>
                    <div class="section-subtitle">
                        Sistem Informasi Penilaian Akademik
                    </div>
                </div>
            </div>

            <p class="text-secondary mb-3" style="font-size:12px; line-height:2;">
                Anda berhasil masuk ke halaman administrator SMK Negeri 1
                Sungai Tebelian. Melalui halaman ini, Anda dapat mengelola
                data master sekolah dan memantau rekapitulasi hasil penilaian
                akademik siswa.
            </p>

            <div class="alert mb-0" style="background:#eaf2ff; color:#123c75; border:0; font-size:11px;">
                <i class="fas fa-circle-info me-2"></i>
                Administrator memiliki akses pengelolaan data master dan
                monitoring akademik. Penginputan serta perubahan nilai
                dilakukan oleh guru sesuai penugasannya.
            </div>

        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom section-card h-100">

            <div class="section-title mb-3">Menu Administrator</div>

            <a href="{{ route('guru.index') }}" class="btn btn-light w-100 text-start mb-2 py-3">
                <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                <span style="font-size:11px;">Kelola Data Guru</span>
            </a>

            <a href="{{ route('siswa.index') }}" class="btn btn-light w-100 text-start mb-2 py-3">
                <i class="fas fa-user-graduate text-success me-2"></i>
                <span style="font-size:11px;">Kelola Data Siswa</span>
            </a>

            <a href="{{ route('laporan.index') }}" class="btn btn-light w-100 text-start py-3">
                <i class="fas fa-chart-column text-warning me-2"></i>
                <span style="font-size:11px;">Lihat Rekap Nilai</span>
            </a>

        </div>
    </div>

</div>

@endsection
