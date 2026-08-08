@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Siswa</h4>
        </div>

        <div class="card-body">

            {{-- Pesan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">

                @csrf
                @method('PUT')

                {{-- NIS --}}
                <div class="mb-3">

                    <label for="nis" class="form-label">
                        NIS
                    </label>

                    <input
                        type="text"
                        name="nis"
                        id="nis"
                        class="form-control @error('nis') is-invalid @enderror"
                        value="{{ old('nis', $siswa->nis) }}"
                        required
                    >

                    @error('nis')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- NAMA --}}
                <div class="mb-3">

                    <label for="nama" class="form-label">
                        Nama Siswa
                    </label>

                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $siswa->nama) }}"
                        required
                    >

                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- KELAS --}}
                <div class="mb-3">

                    <label for="kelas_id" class="form-label">
                        Kelas
                    </label>

                    <select
                        name="kelas_id"
                        id="kelas_id"
                        class="form-control @error('kelas_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Pilih Kelas --
                        </option>

                        @foreach($kelas as $k)

                            <option
                                value="{{ $k->id }}"
                                {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}
                            >
                                {{ $k->nama_kelas }}
                            </option>

                        @endforeach

                    </select>

                    @error('kelas_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- TOMBOL --}}

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fa fa-save"></i>
                    Update
                </button>

                <a
                    href="{{ route('siswa.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>

@endsection