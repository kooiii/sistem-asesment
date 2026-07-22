@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Nilai Sumatif</h2>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close"
        data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="d-flex gap-2 mb-3">
    <a href="/dashboard" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('nilai.create.jenis','sumatif') }}" class="btn btn-primary">
        + Tambah Nilai Sumatif
    </a>
</div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Mapel</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nilais as $n)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $n->siswa->nama ?? 'Tidak ada' }}</td>
                    <td>{{ $n->siswa->kelas->nama_kelas ?? '-' }}
                    <td>{{ $n->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $n->nilai }}</td>

                    <td>
                        <!-- EDIT -->
                        <a href="{{ route('nilai.edit', $n->id) }}"
                        class="btn btn-warning btn-sm">Edit</a>

                        <!-- DELETE -->
                        <form action="{{ route('nilai.destroy', $n->id) }}" method="POST" onsubmit="retur confirm('Yakin hapus data?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data nilai sumatif</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection