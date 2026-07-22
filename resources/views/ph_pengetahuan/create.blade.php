@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Input PH Pengetahuan</h3>

    <form action="{{ route('ph.pengetahuan.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
        <div class="mb-3">
            <label>Kelas</label>
            <select name="kelas" class="form-control" onchange="location='?kelas='+this.value">
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelasGuru as $kelas)
            <option value="{{ $kelas->id }}"
                {{ $kelasDipilih==$kelas->id?'selected':'' }}>
                {{ $kelas->nama_kelas }}
            </option>
            @endforeach
            </select>
        </div>

        <div class="mb-3">
        <label>Mata Pelajaran</label>
        <select name="mapel_id" class="form-control" required>
            @foreach($mapelGuru as $mapel)
                <option value="{{ $mapel->id }}">
                    {{ $mapel->nama_mapel }}
                </option>
            @endforeach
        </select>
        </div>

        <div class="mb-3">
            <label>Siswa</label>
                <select name="siswa_id" class="form-control" required>
                    <option value="">-- Pilih Siswa --</option>
            @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}">
                    {{ $siswa->nama }}
                </option>
            @endforeach
        </select>
    </div>

</div>


<h5>Nilai TP 1 - TP 12</h5>

<div class="table-responsive">

<table class="table table-bordered text-center">

    <thead>
        <tr>
            @for($i = 1; $i <= 12; $i++)
                <th>TP {{ $i }}</th>
            @endfor
        </tr>
    </thead>

    <tbody>
        <tr>
            @for($i = 1; $i <= 12; $i++)
                <td>
                    <input
                        type="number"
                        name="tp{{ $i }}"
                        class="form-control"
                        min="0"
                        max="100">
                </td>
            @endfor
        </tr>
    </tbody>

</table>

</div>

        <button class="btn btn-success">
            Simpan
        </button>

        <a href="{{ route('ph.pengetahuan.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

@endsection