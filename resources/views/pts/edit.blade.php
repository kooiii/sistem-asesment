@extends('layouts.app')

@section('content')

<div class="container">

<h3>Input Nilai PTS</h3>

<form action="{{ route('pts.update', $data->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
    <label>Siswa</label>

    <select name="siswa_id" class="form-control">

        @foreach($siswas as $s)

        <option value="{{ $s->id }}">
            {{ $data->siswa_id==$s->id?'selected':'' }}>
            {{ $s->nama }}
        </option>

        @endforeach

    </select>
</div>

<div class="mb-3">
    <label>Mata Pelajaran</label>

    <select name="mapel_id" class="form-control">

        @foreach($mapels as $m)

        <option value="{{ $m->id }}">
            {{ $data->mapel_id==$m->id?'selected':'' }}>
            {{ $m->nama_mapel }}
        </option>

        @endforeach

    </select>
</div>

<div class="mb-3">
    <label>Nilai Murni (NM)</label>
    <input type="number"
            name="nm" class="form-control"
            value="{{ $data->nm }}">
</div>

<div class="mb-3">
    <label>Nilai Remedial (NR)</label>
    <input type="number"
            name="nr" class="form-control"
            value="{{ $data->nr }}">
</div>

<button class="btn btn-success">
    Update
</button>

<a href="{{ route('pts.index') }}"
   class="btn btn-secondary">
   Kembali
</a>

</form>

</div>

@endsection