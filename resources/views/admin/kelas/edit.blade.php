@extends('layouts.app')

@section('content')

<div class="container">

<h3>Edit Data Kelas</h3>

<form action="{{ route('kelas.update',$data->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Nama Kelas</label>

<input
type="text"
name="nama_kelas"
class="form-control"
value="{{ $data->nama_kelas }}"
required>

</div>

<button class="btn btn-success">

Update

</button>

<a href="{{ route('kelas.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

@endsection