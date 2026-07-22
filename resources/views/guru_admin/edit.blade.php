@extends('layouts.app')

@section('content')

<h3>Edit Guru</h3>

<form action="{{ route('guru.update',$guru->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Nama</label>

<input
type="text"
name="nama"
class="form-control"
value="{{ $guru->nama }}">

</div>

<div class="mb-3">

<label>NIP</label>

<input
type="text"
name="nip"
class="form-control"
value="{{ $guru->nip }}">

</div>

<div class="mb-3">

<label>Password Baru</label>

<input
type="password"
name="password"
class="form-control">

<small>Kosongkan jika tidak diubah</small>

</div>

<button class="btn btn-primary">

Update

</button>

<a href="{{ route('guru.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

@endsection