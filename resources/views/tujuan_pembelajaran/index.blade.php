@extends('layouts.app')

@section('content')

<div class="row">

@foreach($data as $tp)

    <div class="col-md-6 mb-4">
    <div class="card shadow-sm border-0">
    <div class="card-header bg-success text-white">

    <h5 class="mb-0">
        TP {{ $tp->nomor_tp }}
    </h5>

    <small>
        {{ $tp->judul_tp }}
    </small>

    </div>

    <div class="card-body">

    <table class="table table-sm">

    <tr>

    <td>Tugas</td>

    <td>

    @if($tp->tugas)

    <span class="badge bg-success">✓ Sudah</span>
    @else
    <span class="badge bg-secondary">Belum</span>
    @endif

    </td>

    </tr>

    <tr>

    <td>Kuis</td>

    <td>

    @if($tp->kuis)

    <span class="badge bg-success">✓ Sudah</span>
    @else
    <span class="badge bg-secondary">Belum</span>
    @endif

    </td>

    </tr>

    <tr>

    <td>Praktik</td>

    <td>

    @if($tp->praktik)

    <span class="badge bg-success">✓ Sudah</span>

    @else

    <span class="badge bg-secondary">Belum</span>

    @endif

    </td>

    </tr>

    <tr>

    <td>Presentasi</td>

    <td>

    @if($tp->presentasi)

    <span class="badge bg-success">✓ Sudah</span>

    @else

    <span class="badge bg-secondary">Belum</span>

    @endif

    </td>

    </tr>

    </table>

    <label>Progress Penilaian</label>

    <div class="progress mb-3">

    <div class="progress-bar"

    style="width:{{ $tp->progress }}%">
        {{ $tp->progress }}%

    </div>

    </div>

    <h5>Rata-rata TP

    <span class="badge bg-primary">
        {{ number_format($tp->rata,2) }}
    </span>

    </h5>

    <a href="{{ route('nilai-formatif.create',['tp'=>$tp->id]) }}"
        class="btn btn-success w-100">Input / Edit Nilai</a>

    </div>

    </div>

    </div>

    @endforeach

</div>