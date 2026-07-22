@extends('layouts.app')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">

<h4>Atur Penugasan Guru</h4>

</div>

<div class="card-body">

<form method="POST"
action="{{ route('guru.penugasan.simpan',$guru->id) }}">

@csrf

<div class="mb-4">

<label>Kelas Diampu</label>

@foreach($kelas as $k)

<div class="form-check">

<input
class="form-check-input"
type="checkbox"
name="kelas[]"
value="{{ $k->id }}"
{{ $guru->kelas->contains($k->id) ? 'checked' : '' }}>

<label class="form-check-label">

{{ $k->nama_kelas }}

</label>

</div>

@endforeach

</div>

<hr>

<div class="mb-4">

<label>Mata Pelajaran Diampu</label>

@foreach($mapel as $m)

<div class="form-check">

<input
class="form-check-input"
type="checkbox"
name="mapel[]"
value="{{ $m->id }}"
{{ $guru->mapel->contains($m->id) ? 'checked' : '' }}>

<label class="form-check-label">

{{ $m->nama_mapel }}

</label>

</div>

@endforeach

</div>

<button class="btn btn-primary">

Simpan Penugasan

</button>

<a href="{{ route('guru.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection