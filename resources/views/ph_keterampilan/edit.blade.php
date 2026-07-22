@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Input PH Keterampilan</h3>

    <form action="{{ route('ph.keterampilan.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Siswa</label>

                <select name="siswa_id" class="form-control" required>

                    <option value="{{ $s->id }}"
                        {{ $data->siswa_id==$s->id?'selected':'' }}>
                        {{ $s->nama }}
                    </option>

                                @foreach($siswas as $s)
                <option value="{{ $s->id }}">
                    {{ $s->nama }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Mata Pelajaran
        </label>

        <select name="mapel_id" class="form-control" required>

            <option value="{{ $m->id }}"
                {{ $data->mapel_id==$m->id?'selected':'' }}>
                {{ $m->nama_mapel }}
            </option>

            @foreach($mapels as $m)
                <option value="{{ $m->id }}">
                    {{ $m->nama_mapel }}
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
                        name="tp1"
                        class="form-control"
                        value="{{ $data->tp1 }}"
                        value="{{ $data->tp2 }}"
                        value="{{ $data->tp3 }}"
                        value="{{ $data->tp4 }}"
                        value="{{ $data->tp5 }}"
                        value="{{ $data->tp6 }}"
                        value="{{ $data->tp7 }}"
                        value="{{ $data->tp8 }}"
                        value="{{ $data->tp9 }}"
                        value="{{ $data->tp10 }}"
                        value="{{ $data->tp11 }}"
                        value="{{ $data->tp12 }}"
                </td>
            @endfor
        </tr>
    </tbody>

</table>

</div>

        <button class="btn btn-success">
            Simpan
        </button>

        <a href="{{ route('ph.keterampilan.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

@endsection