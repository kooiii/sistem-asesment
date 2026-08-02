@extends('layouts.app')

@section('content')

<div class="container">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="fa fa-check-circle"></i>

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

            <i class="fa fa-times-circle"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>
    @endif

    {{-- Card Input TP --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                Penilaian Formatif - Tujuan Pembelajaran

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('tujuan-pembelajaran.store') }}" method="POST">

                @csrf

                <div class="alert alert-info">

                    <div class="row">

                        <div class="col-md-6">

                            <label class="fw-bold">

                                Kelas Aktif

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ optional($guru->kelas->where('id',session('kelas_aktif'))->first())->nama_kelas }}"
                                readonly>

                        </div>

                        <div class="col-md-6">

                            <label class="fw-bold">

                                Mata Pelajaran Aktif

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ optional($guru->mapel->where('id',session('mapel_aktif'))->first())->nama_mapel }}"
                                readonly>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-2">

                        <label class="form-label">

                            Nomor TP

                        </label>

                        <input
                            type="number"
                            name="nomor_tp"
                            class="form-control"
                            min="1"
                            value="{{ old('nomor_tp',$nomorTP) }}"
                            required>

                        @error('nomor_tp')

                            <small class="text-danger">

                                {{ $message }}

                            </small>

                        @enderror

                        <small class="text-muted">

                            Nomor dapat diubah jika diperlukan.

                        </small>

                    </div>

                    <div class="col-md-10">

                        <label class="form-label">

                            Judul Tujuan Pembelajaran

                        </label>

                        <input
                            type="text"
                            name="judul_tp"
                            class="form-control"
                            value="{{ old('judul_tp') }}"
                            placeholder="Contoh : Instalasi Sistem Operasi"
                            required>

                        @error('judul_tp')

                            <small class="text-danger">

                                {{ $message }}

                            </small>

                        @enderror

                    </div>

                </div>

                <div class="mt-4">

                    <button class="btn btn-primary">

                        <i class="fa fa-save"></i>

                        Simpan TP

                    </button>

                    <a
                        href="{{ route('tujuan-pembelajaran.index') }}"
                        class="btn btn-secondary">

                        <i class="fa fa-arrow-left"></i>

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

    {{-- Daftar TP --}}
    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">

                Daftar Tujuan Pembelajaran

            </h5>

        </div>

        <div class="card-body">

            @if($data->count())

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">No</th>

                        <th width="80">TP</th>

                        <th>Judul Tujuan Pembelajaran</th>

                        <th width="260">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @foreach($data as $tp)

                <tr>

                    <td>

                        {{ $loop->iteration }}

                    </td>

                    <td>

                        <strong>

                            TP {{ $tp->nomor_tp }}

                        </strong>

                    </td>

                    <td>

                        {{ $tp->judul_tp }}

                    </td>

                    <td>

                        <a
                            href="{{ route('nilai-formatif.create',['tp'=>$tp->id]) }}"
                            class="btn btn-success btn-sm">

                            <i class="fa fa-pencil"></i>

                            Input Nilai

                        </a>

                        <a
                            href="{{ route('tujuan-pembelajaran.edit',$tp->id) }}"
                            class="btn btn-warning btn-sm">

                            <i class="fa fa-edit"></i>

                            Edit

                        </a>

                        <form
                            action="{{ route('tujuan-pembelajaran.destroy',$tp->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf

                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus TP ini?')">

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

                    Belum ada Tujuan Pembelajaran yang dibuat.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection