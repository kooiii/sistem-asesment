@extends('layouts.app')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">

    <h3>Data Kelas</h3>

    <a href="{{ route('kelas.create') }}" class="btn btn-primary">
        + Tambah Kelas
    </a>

</div>

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th width="70">No</th>
<th>Nama Kelas</th>
<th width="170">Aksi</th>

</tr>

</thead>

<tbody>

@foreach($data as $d)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $d->nama_kelas }}</td>

<td>

<a href="{{ route('kelas.edit',$d->id) }}"
class="btn btn-warning btn-sm">

<i class="fa fa-edit"></i>

</a>

<form action="{{ route('kelas.destroy',$d->id) }}"
method="POST"
style="display:inline;">

@csrf
@method('DELETE')

<button
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus data?')">

<i class="fa fa-trash"></i>

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection