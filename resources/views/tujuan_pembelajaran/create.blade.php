@extends('layouts.app')

@section('content')

<div class="card card-custom">

    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Penilaian Formatif - Tujuan Pembelajaran</h4>
    </div>

    <div class="card-body">
        @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

        </div>

        @endif

        <form action="{{ route('tujuan-pembelajaran.store') }}" method="POST">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Kelas</label>

                    <select name="kelas_id" class="form-control" required>

                        <option value="">-- Pilih Kelas --</option>

                        @foreach($guru->kelas as $kelas)

                            <option value="{{ $kelas->id }}">
                                {{ $kelas->nama_kelas }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Mata Pelajaran</label>

                    <select name="mapel_id" class="form-control" required>

                        <option value="">-- Pilih Mata Pelajaran --</option>

                        @foreach($guru->mapel as $mapel)

                            <option value="{{ $mapel->id }}">
                                {{ $mapel->nama_mapel }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label>Nomor TP</label>

                    <input
                        type="number"
                        min="1"
                        name="nomor_tp"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-9 mb-3">

                    <label>Judul TP</label>

                    <input
                        type="number"
                        name="nomor_tp"
                        class="form-control"
                        value="{{ $nomorTP }}"
                        readonly>

                </div>

            </div>

            <button class="btn btn-primary">

                <i class="fa fa-save"></i>

                Simpan TP

            </button>

            <a href="{{ route('tujuan-pembelajaran.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

<br>

<div class="card card-custom">

    <div class="card-header">

        <h5 class="mb-0">
            Tujuan Pembelajaran yang Sudah Dibuat
        </h5>

    </div>

    <div class="card-body">

        @if($data->count())

            <table class="table table-bordered">

                <thead class="table-light">

                    <tr>

                        <th width="80">TP</th>

                        <th>Judul Tujuan Pembelajaran</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($data as $tp)

                    <tr>

                        <td>

                            <strong>

                                TP {{ $tp->nomor_tp }}

                            </strong>

                        </td>

                        <td>

                            {{ $tp->judul_tp }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="alert alert-info mb-0">

                Belum ada Tujuan Pembelajaran yang dibuat.

            </div>

        @endif

    </div>

</div>

@endsection