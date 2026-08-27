@extends('layouts.app')

@section('content')

<div class="container">

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    {{ session('success') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>
    </div>
@endif

<div class="card shadow">

<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

    <h4 class="mb-0">

        Penilaian Sumatif

    </h4>

    <div>

        <a
            href="{{ route('nilai-sumatif.index',['jenis'=>'STS']) }}"
            class="btn {{ $jenis=='STS' ? 'btn-warning' : 'btn-light' }} btn-sm">

            STS

        </a>

        <a
            href="{{ route('nilai-sumatif.index',['jenis'=>'SAS']) }}"
            class="btn {{ $jenis=='SAS' ? 'btn-warning' : 'btn-light' }} btn-sm">

            SAS

        </a>

        <a
            href="{{ route('nilai-sumatif.create',['jenis'=>$jenis]) }}"
            class="btn btn-success btn-sm">

            <i class="fa fa-plus"></i>

            Input Nilai

        </a>

    </div>

</div>

<div class="card-body">

@if($data->count())

<table class="table table-bordered table-hover align-middle">

<thead class="table-primary">

<tr>

<th width="60">

No

</th>

<th>

Nama Siswa

</th>

<th width="120">

Jenis

</th>

<th width="120">

Nilai

</th>

<th width="160">

Aksi

</th>

</tr>

</thead>

<tbody>

@foreach($data as $d)

<tr>

<td>

{{ $loop->iteration }}

</td>

<td>

{{ $d->siswa->nama }}

</td>

<td>

<span class="badge bg-primary">

{{ $d->jenis }}

</span>

</td>

<td>

<strong>

{{ $d->nilai }}

</strong>

</td>

<td>

<form
action="{{ route('nilai-sumatif.destroy',$d->id) }}"
method="POST"
style="display:inline;">

@csrf

@method('DELETE')

<button
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus nilai ini?')">

<i class="fa fa-trash"></i>

Hapus

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

@else

<div class="alert alert-warning mb-0">

Belum ada nilai {{ $jenis }} yang diinput.

</div>

@endif

</div>

</div>

</div>

@endsection