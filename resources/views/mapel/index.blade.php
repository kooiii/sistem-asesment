<!DOCTYPE html>
<html>
<head>
    <title>Data Mapel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Data Mata Pelajaran</h3>

    <a href="{{ route('mapel.create') }}" class="btn btn-primary mb-3">Tambah Mapel</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Mapel</th>
        </tr>

        @forelse($mapels as $m)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $m->nama_mapel }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2" class="text-center">Data belum ada</td>
        </tr>
        @endforelse
    </table>

    <a href="/dashboard" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>