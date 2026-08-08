@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Data Kelas</h4>
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
                action="{{ route('kelas.store') }}"
                method="POST"
            >

                @csrf


                {{-- Nama Kelas --}}
                <div class="mb-3">

                    <label
                        for="nama_kelas"
                        class="form-label"
                    >
                        Nama Kelas
                    </label>

                    <input
                        type="text"
                        name="nama_kelas"
                        id="nama_kelas"
                        class="form-control @error('nama_kelas') is-invalid @enderror"
                        value="{{ old('nama_kelas') }}"
                        placeholder="Contoh: X MPLB"
                        required
                    >

                    @error('nama_kelas')

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
                    href="{{ route('kelas.index') }}"
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