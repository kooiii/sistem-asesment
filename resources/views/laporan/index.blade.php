@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Laporan Rekap Nilai Siswa</h3>

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                Kembali
            </a>

            <a href="{{ route('laporan.pdf') }}" class="btn btn-danger">
                Export PDF
            </a>
        </div>
    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover align-middle mb-0">

                    <thead class="table-primary text-center">

                        <tr>
                            <th width="60">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Rata-rata Formatif</th>
                            <th>Rata-rata Sumatif</th>
                            <th>Nilai Akhir</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($laporan as $l)

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $l['nama'] }}</td>
                            <td>{{ $l['kelas'] }}</td>
                            <td>{{ $l['mapel'] }}</td>
                            <td class="text-center">{{ $l['formatif'] }}</td>
                            <td class="text-center">{{ $l['sumatif'] }}</td>
                            <td class="text-center">
                                <strong>{{ $l['akhir'] }}</strong>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
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