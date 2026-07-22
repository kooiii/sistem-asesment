<!DOCTYPE html>
<html>
<head>
<title>Data Kelas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<h3>Data Kelas</h3>

<a href="{{ route('kelas.create') }}" class="btn btn-primary mb-3">Tambah Kelas</a>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-bordered">

<tr>
<th>No</th>
<th>Nama Kelas</th>
</tr>

@foreach($kelas as $k)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $k->nama_kelas }}</td>
</tr>
@endforeach

</table>
<a href ="/dashboard" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>