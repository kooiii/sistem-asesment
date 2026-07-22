@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Data Siswa</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('siswa.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">NIS</label>
                    <input
                        type="text"
                        name="nis"
                        class="form-control"
                        value="{{ old('nis') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Siswa</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>

                    <select
                        name="kelas_id"
                        class="form-select"
                        required>

                        <option value="">-- Pilih Kelas --</option>

                        @foreach($kelas as $k)
                            <option
                                value="{{ $k->id }}"
                                {{ old('kelas_id')==$k->id?'selected':'' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="text-end">

                    <a href="{{ route('siswa.index') }}"
                        class="btn btn-secondary">
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection