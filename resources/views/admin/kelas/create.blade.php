@extends('layouts.app')

@section('content')

<div class="container">

<h3>Tambah Data Kelas</h3>

<form action="{{ route('kelas.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Nama Kelas</label>

<input
type="text"
name="nama_kelas"
class="form-control"
required>

</div>

<button class="btn btn-primary">

Simpan

</button>

<a href="{{ route('kelas.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

@endsection