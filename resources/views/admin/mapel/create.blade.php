@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Mata Pelajaran</h4>
        </div>

        <div class="card-body">

            {{-- Error Validasi --}}
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


            <form
                action="{{ route('mapel.store') }}"
                method="POST"
            >

                @csrf


                {{-- Nama Mata Pelajaran --}}
                <div class="mb-3">

                    <label
                        for="nama_mapel"
                        class="form-label"
                    >
                        Nama Mata Pelajaran
                    </label>

                    <input
                        type="text"
                        name="nama_mapel"
                        id="nama_mapel"
                        class="form-control @error('nama_mapel') is-invalid @enderror"
                        value="{{ old('nama_mapel') }}"
                        placeholder="Contoh: Informatika"
                        required
                    >

                    @error('nama_mapel')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Tombol --}}
                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save me-1"></i>
                    Simpan
                </button>


                <a
                    href="{{ route('mapel.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>

@endsection