
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-1">
                Laporan Rekap Nilai Siswa
            </h3>

            <small class="text-muted">
                Tahun Ajaran :
                {{ $tahun->tahun_ajaran }} -
                Semester {{ $tahun->semester }}
            </small>
        </div>

        <div>
            <a href="{{ route('dashboard') }}"
               class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </a>

            <a href="{{ route('laporan.pdf') }}"
               class="btn btn-danger">
                <i class="fa fa-file-pdf"></i>
                Export PDF
            </a>
        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <strong>Rekapitulasi Nilai</strong>
        </div>

        <div class="card-body">

            <div class="alert alert-info">
                <strong>Bobot Penilaian:</strong>
                Formatif 50% |
                STS 15% |
                SAS 20% |
                Sikap & Presensi 15%.
                <br>
                <small>
                    Nilai Sikap dan Presensi digabung menjadi
                    satu komponen penilaian dengan bobot 15%.
                </small>
            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary text-center">

                        <tr>
                            <th rowspan="2" width="60">No</th>
                            <th rowspan="2">Nama Siswa</th>
                            <th rowspan="2">Kelas</th>
                            <th rowspan="2">Mata Pelajaran</th>

                            <th rowspan="2" width="100">
                                Formatif<br>
                                <strong>(50%)</strong>
                            </th>

                            <th rowspan="2" width="90">
                                STS<br>
                                <strong>(15%)</strong>
                            </th>

                            <th rowspan="2" width="90">
                                SAS<br>
                                <strong>(20%)</strong>
                            </th>

                            <th colspan="2">
                                Sikap & Presensi<br>
                                <strong>(15%)</strong>
                            </th>

                            <th rowspan="2" width="100">
                                Nilai Akhir
                            </th>

                            <th rowspan="2" width="90">
                                Predikat
                            </th>
                        </tr>

                        <tr>
                            <th width="90">Sikap</th>
                            <th width="90">Presensi</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($laporan as $row)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $row['nama'] }}
                            </td>

                            <td class="text-center">
                                {{ $row['kelas'] }}
                            </td>

                            <td>
                                {{ $row['mapel'] }}
                            </td>

                            <td class="text-center">
                                {{ number_format($row['formatif'], 2) }}
                            </td>

                            <td class="text-center">
                                {{ number_format($row['sts'], 2) }}
                            </td>

                            <td class="text-center">
                                {{ number_format($row['sas'], 2) }}
                            </td>

                            <td class="text-center">
                                {{ number_format($row['sikap'], 2) }}
                            </td>

                            <td class="text-center">
                                {{ number_format($row['presensi'], 2) }}
                            </td>

                            <td class="text-center">
                                <strong>
                                    {{ number_format($row['akhir'], 2) }}
                                </strong>
                            </td>

                            <td class="text-center">

                                @if($row['predikat'] == 'A')

                                    <span class="badge bg-success">A</span>

                                @elseif($row['predikat'] == 'B')

                                    <span class="badge bg-primary">B</span>

                                @elseif($row['predikat'] == 'C')

                                    <span class="badge bg-warning text-dark">C</span>

                                @else

                                    <span class="badge bg-danger">D</span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="11" class="text-center">
                                Belum ada data nilai.
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
