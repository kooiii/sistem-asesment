@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Hasil Laporan</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Nilai</th>
                <th>Jenis</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilais as $n)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $n->siswa->nama ?? '-' }}</td>
                <td>{{ $n->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $n->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ $n->nilai }}</td>
                <td>{{ $n->jenis }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection