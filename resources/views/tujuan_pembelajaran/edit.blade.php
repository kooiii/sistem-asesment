
@extends('layouts.app')

@section('content')

<div class="container">

    {{-- NOTIFIKASI ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDASI ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD EDIT TP --}}
    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">
                <i class="fa fa-edit"></i>
                Edit Tujuan Pembelajaran
            </h4>
        </div>

        <div class="card-body">

            {{-- INFORMASI KELAS DAN MAPEL --}}
            <div class="alert alert-info">

                <div class="row">

                    <div class="col-md-6">
                        <label class="fw-bold">
                            Kelas
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $tp->kelas->nama_kelas ?? '-' }}"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">
                            Mata Pelajaran
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $tp->mapel->nama_mapel ?? '-' }}"
                            readonly>
                    </div>

                </div>

            </div>

            {{-- FORM EDIT --}}
            <form
                action="{{ route('tujuan-pembelajaran.update', $tp->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- NOMOR TP --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label fw-bold">
                            Nomor TP
                        </label>

                        <input
                            type="number"
                            name="nomor_tp"
                            class="form-control"
                            min="1"
                            value="{{ old('nomor_tp', $tp->nomor_tp) }}"
                            required>

                        @error('nomor_tp')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- JUDUL TP --}}
                    <div class="col-md-10 mb-3">

                        <label class="form-label fw-bold">
                            Judul Tujuan Pembelajaran
                        </label>

                        <input
                            type="text"
                            name="judul_tp"
                            class="form-control"
                            value="{{ old('judul_tp', $tp->judul_tp) }}"
                            placeholder="Masukkan judul tujuan pembelajaran"
                            required>

                        @error('judul_tp')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

                {{-- TOMBOL --}}
                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fa fa-save"></i>
                        Simpan Perubahan

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

</div>

@endsection
