@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Atur Penugasan Guru
            </h4>
        </div>

        <div class="card-body">

            {{-- Informasi Guru --}}
            <div class="alert alert-info">

                <strong>Guru:</strong>
                {{ $guru->nama }}

                <br>

                <strong>NIP:</strong>
                {{ $guru->nip }}

            </div>


            {{-- Notifikasi berhasil --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                    </button>

                </div>

            @endif


            {{-- Error validasi --}}
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
                method="POST"
                action="{{ route('guru.penugasan.simpan', $guru->id) }}"
            >

                @csrf


                {{-- KELAS --}}
                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Kelas yang Diampu
                    </label>

                    <div class="border rounded p-3">

                        @forelse($kelas as $k)

                            <div class="form-check mb-2">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="kelas[]"
                                    value="{{ $k->id }}"
                                    id="kelas_{{ $k->id }}"
                                    {{ $guru->kelas->contains($k->id) ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label"
                                    for="kelas_{{ $k->id }}"
                                >
                                    {{ $k->nama_kelas }}
                                </label>

                            </div>

                        @empty

                            <p class="text-muted mb-0">
                                Belum ada data kelas.
                            </p>

                        @endforelse

                    </div>

                </div>


                <hr>


                {{-- MATA PELAJARAN --}}
                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Mata Pelajaran yang Diampu
                    </label>

                    <div class="border rounded p-3">

                        @forelse($mapel as $m)

                            <div class="form-check mb-2">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="mapel[]"
                                    value="{{ $m->id }}"
                                    id="mapel_{{ $m->id }}"
                                    {{ $guru->mapel->contains($m->id) ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label"
                                    for="mapel_{{ $m->id }}"
                                >
                                    {{ $m->nama_mapel }}
                                </label>

                            </div>

                        @empty

                            <p class="text-muted mb-0">
                                Belum ada data mata pelajaran.
                            </p>

                        @endforelse

                    </div>

                </div>


                {{-- TOMBOL --}}
                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save me-1"></i>
                    Simpan Penugasan
                </button>


                <a
                    href="{{ route('guru.index') }}"
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