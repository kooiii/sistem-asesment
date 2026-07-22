@extends('layouts.app')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">

    <h3>PH Pengetahuan</h3>

    <div>
        <a href="{{ url('/dashboard') }}"
            class="btn btn-secondary">
            ← Kembali</a>
        <a href="{{ route('ph.pengetahuan.create') }}"
            class="btn btn-primary">
            + Tambah Nilai</a>
    </div>

</div>

<div class="table-responsive">

<table class="table table-bordered table-striped">

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Mapel</th>

    <th>TP1</th>
    <th>TP2</th>
    <th>TP3</th>
    <th>TP4</th>
    <th>TP5</th>
    <th>TP6</th>

    <th>TP7</th>
    <th>TP8</th>
    <th>TP9</th>
    <th>TP10</th>
    <th>TP11</th>
    <th>TP12</th>

    <th>Rata-rata</th>
    <th width="150">Aksi</th>
</tr>

@foreach($data as $d)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $d->siswa->nama }}</td>

    <td>{{ $d->mapel->nama_mapel }}</td>

    <td>{{ $d->tp1 }}</td>
    <td>{{ $d->tp2 }}</td>
    <td>{{ $d->tp3 }}</td>
    <td>{{ $d->tp4 }}</td>
    <td>{{ $d->tp5 }}</td>
    <td>{{ $d->tp6 }}</td>

    <td>{{ $d->tp7 }}</td>
    <td>{{ $d->tp8 }}</td>
    <td>{{ $d->tp9 }}</td>
    <td>{{ $d->tp10 }}</td>
    <td>{{ $d->tp11 }}</td>
    <td>{{ $d->tp12 }}</td>

    <td>
        <strong>{{ $d->r2 }}</strong>
    </td>

    <td class="text-center">

        <a href="{{ route('ph.pengetahuan.edit',$d->id) }}"
           class="btn btn-warning btn-sm">

            <i class="fa fa-edit"></i>

        </a>

        <form action="{{ route('ph.pengetahuan.destroy',$d->id) }}"
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