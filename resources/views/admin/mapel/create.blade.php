@extends('layouts.app')

@section('content')

<div class="container">

<h3>Tambah Mata Pelajaran</h3>

<form action="{{ route('mapel.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Nama Mata Pelajaran</label>

<input
type="text"
name="nama_mapel"
class="form-control"
required>

</div>

<button class="btn btn-primary">

Simpan

</button>

<a href="{{ route('mapel.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

@endsection