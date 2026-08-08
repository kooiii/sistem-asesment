@extends('layouts.app')

@section('content')

<div class="container">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>

Penilaian Sumatif

{{ $jenis }}

</h4>

</div>

<div class="card-body">

<form

action="{{ route('nilai-sumatif.store') }}"

method="POST">

@csrf

<input
type="hidden"
name="jenis"
value="{{ $jenis }}">

<table class="table table-bordered table-hover">

<thead class="table-primary">

<tr>

<th width="60">

No

</th>

<th>

Nama Siswa

</th>

<th width="180">

Nilai

</th>

</tr>

</thead>

<tbody>

@foreach($siswas as $siswa)

<tr>

<td>

{{ $loop->iteration }}

</td>

<td>

{{ $siswa->nama }}

<input

type="hidden"

name="siswa_id[]"

value="{{ $siswa->id }}">

</td>

<td>

<input

type="number"

name="nilai[]"

class="form-control nilai"

min="0"

max="100"

value="{{ optional($siswa->nilaiSumatif->first())->nilai }}">

</td>

</tr>

@endforeach

</tbody>

</table>

<button

class="btn btn-success">

<i class="fa fa-save"></i>

Simpan

</button>

<a

href="{{ route('nilai-sumatif.index',['jenis'=>$jenis]) }}"

class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection