@extends('layouts.app')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">

<h3>Nilai PAS</h3>
<div>
    <a href="{{ url('/dashboard') }}"
        class="btn btn-secondary">
            ← Kembali</a>
    <a href="{{ route('pas.create') }}"
        class="btn btn-primary">
            + Tambah Nilai</a>
</div>
</div>

<table class="table table-bordered">

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Mapel</th>
    <th>NM</th>
    <th>NR</th>
    <th>N</th>
    <th width="150">Aksi</th>
</tr>

@foreach($data as $d)

<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $d->siswa->nama }}</td>
    <td>{{ $d->siswa->kelas->nama_kelas }}</td>
    <td>{{ $d->mapel->nama_mapel }}</td>
    <td>{{ $d->nm }}</td>
    <td>{{ $d->nr }}</td>
    <td><strong>{{ $d->n }}</strong></td>

    <td class="text-center">

    <a href="{{ route('pas.edit',$d->id) }}"
       class="btn btn-warning btn-sm">

        <i class="fa fa-edit"></i>

    </a>

    <form action="{{ route('pas.destroy',$d->id) }}"
          method="POST"
          style="display:inline">

        @csrf
        @method('DELETE')

        <button class="btn btn-danger btn-sm"
            onclick="return confirm('Yakin ingin menghapus data ini?')">

            <i class="fa fa-trash"></i>

        </button>

    </form>

</td>

</tr>

@endforeach

</table>

</div>

@endsection