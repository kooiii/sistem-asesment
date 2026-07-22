@extends('layouts.app')

@section('content')

<div class="container">

<h3>Edit Mata Pelajaran</h3>

<form action="{{ route('mapel.update',$data->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Nama Mata Pelajaran</label>

<input
type="text"
name="nama_mapel"
class="form-control"
value="{{ $data->nama_mapel }}"
required>

</div>

<button class="btn btn-success">

Update

</button>

<a href="{{ route('mapel.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

@endsection