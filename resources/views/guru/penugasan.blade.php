@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h4>Atur Penugasan Guru</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('guru.penugasan.simpan',$guru->id) }}" method="POST">

                @csrf

                <h5>Kelas Diampu</h5>

                @foreach($kelas as $k)

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="kelas[]"
                            value="{{ $k->id }}"
                            {{ $guru->kelas->contains($k->id) ? 'checked' : '' }}>

                        <label class="form-check-label">

                            {{ $k->nama_kelas }}

                        </label>

                    </div>

                @endforeach

                <hr>

                <h5>Mata Pelajaran Diampu</h5>

                @foreach($mapel as $m)

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="mapel[]"
                            value="{{ $m->id }}"
                            {{ $guru->mapel->contains($m->id) ? 'checked' : '' }}>

                        <label class="form-check-label">

                            {{ $m->nama_mapel }}

                        </label>

                    </div>

                @endforeach

                <br>

                <button class="btn btn-primary">

                    Simpan Penugasan

                </button>

                <a href="{{ route('guru.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection