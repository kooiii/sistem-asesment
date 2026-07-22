@extends('layouts.app')

@section('content')

<div class="container">

<h3>Input Presensi & Sikap</h3>

<form action="{{ route('presensi.update', $data->id) }}" method="POST">

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
    <label>Nilai Presensi</label>

    <input type="number"
            name="presensi"
            class="form-control"
            value="{{ $data->presensi }}">
</div>

<div class="mb-3">
    <label>Nilai Sikap</label>

    <input type="number"
            name="sikap"
            class="form-control"
            value="{{ $data->sikap }}">
</div>

<button class="btn btn-success">
    Update
</button>

<a href="{{ route('presensi.index') }}"
   class="btn btn-secondary">
   Kembali
</a>

</form>

</div>

@endsection