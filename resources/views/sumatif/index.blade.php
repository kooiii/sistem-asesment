@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        
        <h3 class="mb-0">📘 Nilai Sumatif</h3>

        <div>
            <a href="{{ url('/dashboard') }}"
            class="btn btn-secondary">
            ← Kembali
        </a>

        <a href="{{ route('sumatif.create') }}"
           class="btn btn-primary">
            + Tambah Nilai
        </a>
    </div>
    </div>
</div>

    <div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped table-hover align-middle">

                <thead class="table-primary">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Kategori</th>
                        <th>Bobot</th>
                        <th>Nilai</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($nilais as $n)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $n->siswa->nama ?? '-' }}</td>
                        <td>{{ $n->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $n->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $n->kategori }}</td>
                        <td>{{ $n->bobot }}%</td>
                        <td>{{ $n->nilai }}</td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada data nilai sumatif
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection