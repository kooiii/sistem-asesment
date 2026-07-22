<!DOCTYPE html>
<html>
<head>
<title>Tambah Kelas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<h3>Tambah Kelas</h3>

<form action="{{ route('kelas.store') }}" method="POST">

@csrf

<div class="mb-3">
<label>Nama Kelas</label>
<input type="text" name="nama_kelas" class="form-control">
</div>

<button class="btn btn-success">Simpan</button>
<a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>

</form>

</div>

</body>
</html>