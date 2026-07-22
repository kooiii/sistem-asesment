<!DOCTYPE html>
<html>
<head>
    <title>Data Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Data Nilai</h3>

    <a href="{{ route('nilai.create') }}" class="btn btn-primary mb-3">Tambah Nilai</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
                <th>Predikat</th>
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
                <td>
                    @if($n->nilai >= 90) A
                    @elseif($n->nilai >= 80) B
                    @elseif($n->nilai >= 70) C
                    @else D
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    <a href="/dashboard" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>