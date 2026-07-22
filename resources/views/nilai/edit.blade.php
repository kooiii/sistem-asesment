@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Nilai</h3>

    <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- KELAS -->
        <div class="mb-3">
            <label>Kelas</label>
            <select id="kelas" class="form-control">
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}"
                        {{ $nilai->siswa->kelas_id == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- SISWA -->
        <div class="mb-3">
            <label>Siswa</label>
            <select name="siswa_id" class="form-control">
                <option value="{{ $nilai->siswa_id }}">
                    {{ $nilai->siswa->nama }}
                </option>
            </select>
        </div>

        <!-- MAPEL -->
        <div class="mb-3">
            <label>Mapel</label>
            <select name="mapel_id" class="form-control">
                @foreach($mapels as $m)
                    <option value="{{ $m->id }}"
                        {{ $nilai->mapel_id == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- NILAI -->
        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" name="nilai" class="form-control"
                   value="{{ $nilai->nilai }}">
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection