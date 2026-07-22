@extends('layouts.app')

@section('content')

<h3>Tambah Guru</h3>

<form action="{{ route('guru.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Nama</label>

<input
type="text"
name="nama"
class="form-control">

</div>

<div class="mb-3">

<label>NIP</label>

<input
type="text"
name="nip"
class="form-control">

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control">

</div>

<button class="btn btn-success">

Simpan

</button>

<a href="{{ route('guru.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

@endsection