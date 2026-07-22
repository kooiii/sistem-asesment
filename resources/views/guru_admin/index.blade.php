@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">

<h3>Data Guru</h3>

<a href="{{ route('guru.create') }}"
class="btn btn-primary">

+ Tambah Guru

</a>

</div>

<table class="table table-bordered table-striped">

<tr>

<th>No</th>

<th>Nama</th>

<th>NIP</th>

<th>Role</th>

<th>Aksi</th>

</tr>

@foreach($data as $g)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $g->nama }}</td>

<td>{{ $g->nip }}</td>

<td>{{ $g->role }}</td>

<td>

<a href="{{ route('guru.penugasan',$g->id) }}"
    class="btn btn-info btn-sm">Atur Penugasan</a>    

<a href="{{ route('guru.edit',$g->id) }}"
class="btn btn-warning btn-sm">Edit</a>

<form
action="{{ route('guru.destroy',$g->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus data?')">

Hapus

</button>

</form>

</td>

</tr>

@endforeach

</table>

@endsection