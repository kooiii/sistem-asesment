@extends('layouts.app')

@section('content')

<div class="card card-custom">

<div class="card-header d-flex justify-content-between">
<h4>Tujuan Pembelajaran</h4>
<a href="{{ route('tujuan-pembelajaran.create') }}"
class="btn btn-primary">Tambah TP</a>
</div>

<div class="card-body">

<table class="table table-bordered table-hover">

    <thead class="table-success">

    <tr>

        <th>No</th>

        <th>TP</th>

        <th>Judul TP</th>

        <th>Tugas</th>

        <th>Kuis</th>

        <th>Praktik</th>

        <th>Presentasi</th>

        <th>Rata-rata TP</th>

        <th>Aksi</th>

    </tr>

    </thead>

    <tbody>

    @foreach($data as $tp)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>TP {{ $tp->nomor_tp }}</td>

        <td>{{ $tp->judul_tp }}</td>

        <td>

            @if($tp->rata_tugas)
                {{ number_format($tp->rata_tugas,2) }}
            @else
                -
            @endif

        </td>

        <td>

            @if($tp->rata_kuis)
                {{ number_format($tp->rata_kuis,2) }}
            @else
                -
            @endif

        </td>

        <td>

            @if($tp->rata_praktik)
                {{ number_format($tp->rata_praktik,2) }}
            @else
                -
            @endif

        </td>

        <td>

            @if($tp->rata_presentasi)
                {{ number_format($tp->rata_presentasi,2) }}
            @else
                -
            @endif

        </td>

        <td>
            <span class="badge bg-success">
                {{ number_format($tp->rata_tp,2) }}
            </span>
        </td>

        <td>
            <a href="{{ route('nilai-formatif.create',['tp'=>$tp->id]) }}"
               class="btn btn-success btn-sm">Input / Edit Nilai</a>
        </td>

    </tr>

    @endforeach

    </tbody>

</table>

</div>

</div>

@endsection