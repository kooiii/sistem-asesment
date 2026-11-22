
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-calendar-check text-primary me-2"></i>
                Data Sikap & Presensi
            </h4>

            <p class="text-muted mb-0">
                Pengelolaan penilaian sikap dan presensi siswa.
            </p>
        </div>

        <a href="{{ route('presensi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            Input Nilai
        </a>

    </div>


    {{-- NOTIFIKASI SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- NOTIFIKASI ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- INFORMASI KELAS --}}
    <div class="card card-custom mb-4">
        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-4">
                    <small class="text-muted d-block mb-1">KELAS AKTIF</small>

                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-school text-primary me-2"></i>

                        {{ optional($guru->kelas->firstWhere('id', session('kelas_aktif')))->nama_kelas ?? '-' }}
                    </h6>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block mb-1">MATA PELAJARAN AKTIF</small>

                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-book text-primary me-2"></i>

                        {{ optional($guru->mapel->firstWhere('id', session('mapel_aktif')))->nama_mapel ?? '-' }}
                    </h6>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block mb-1">TAHUN AJARAN</small>

                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>

                        {{ $tahun->tahun_ajaran }} - {{ $tahun->semester }}
                    </h6>
                </div>

            </div>

        </div>
    </div>


    {{-- TABEL DATA --}}
    <div class="card card-custom">

        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0">
                <i class="fas fa-table text-primary me-2"></i>
                Daftar Nilai Sikap & Presensi Siswa
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Siswa</th>
                            <th>Sikap</th>
                            <th>Presensi</th>
                            <th>Predikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    
                    <tbody>
                        @forelse($data as $d)
                            <tr>
                                {{-- NOMOR --}}
                                <td>{{ $loop->iteration }}</td>

                                {{-- NAMA SISWA --}}
                                <td>
                                    {{ $d->siswa->nama ?? '-' }}
                                </td>

                                {{-- NILAI SIKAP --}}
                                <td>
                                    {{ $d->sikap ?? '-' }}
                                </td>

                                {{-- NILAI PRESENSI --}}
                                <td>
                                    {{ $d->presensi ?? '-' }}
                                </td>

                                {{-- PREDIKAT --}}
                                <td>
                                    @if($d->predikat == 'SB')
                                        <span class="badge bg-success">SB</span>
                                    @elseif($d->predikat == 'B')
                                        <span class="badge bg-primary">B</span>
                                    @elseif($d->predikat == 'C')
                                        <span class="badge bg-warning text-dark">C</span>
                                    @elseif($d->predikat == 'K')
                                        <span class="badge bg-danger">K</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <a href="{{ route('presensi.edit', $d->id) }}"
                                    class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('presensi.destroy', $d->id) }}"
                                        method="POST"
                                        style="display:inline;">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">

                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada data penilaian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>

            </div>

        </div>

    </div>

</div>

@endsection
