@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <h3>Data Siswa</h3>

    <a href="{{ route('siswa.create') }}" class="btn btn-primary">
        + Tambah Siswa
    </a>

</div>

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>No</th>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
<th width="170">Aksi</th>

</tr>

</thead>

<tbody>

@foreach($data as $d)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $d->nis }}</td>
<td>{{ $d->nama }}</td>
<td>{{ $d->kelas->nama_kelas }}</td>

<td>

<a href="{{ route('siswa.edit',$d->id) }}" class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('siswa.destroy',$d->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Hapus
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

@endsection