
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Penilaian Sumatif {{ $jenis }}
            </h4>
        </div>

        <div class="card-body">

            {{-- INFORMASI PENILAIAN --}}
            <div class="mb-4">
                <h5>
                    Input Nilai {{ $jenis }}
                </h5>

                <p class="mb-1">
                    <strong>Kelas:</strong>
                    {{ session('kelas_aktif')
                        ? optional($guru->kelas->firstWhere('id', session('kelas_aktif')))->nama_kelas
                        : '-' }}
                </p>

                <p class="mb-1">
                    <strong>Mata Pelajaran:</strong>
                    {{ session('mapel_aktif')
                        ? optional($guru->mapel->firstWhere('id', session('mapel_aktif')))->nama_mapel
                        : '-' }}
                </p>

            
            </div>

            {{-- NOTIFIKASI SUCCESS --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>
                </div>
            @endif

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

            {{-- FORM INPUT NILAI --}}
            <form
                action="{{ route('nilai-sumatif.store') }}"
                method="POST">

                @csrf

                <input
                    type="hidden"
                    name="jenis"
                    value="{{ $jenis }}">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-primary">
                            <tr>
                                <th width="60">No</th>
                                <th>Nama Siswa</th>
                                <th width="180">Nilai {{ $jenis }}</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($siswas as $siswa)

                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $siswa->nama }}

                                        <input
                                            type="hidden"
                                            name="siswa_id[]"
                                            value="{{ $siswa->id }}">
                                    </td>

                                    <td>
                                        <input
                                            type="number"
                                            name="nilai[]"
                                            class="form-control nilai-input"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            placeholder="Masukkan nilai"
                                            value="{{ old(
                                                'nilai.'.$loop->index,
                                                optional($siswa->nilaiSumatif->first())->nilai
                                            ) }}">
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="text-center">
                                        Belum ada siswa pada kelas ini.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if($siswas->count() > 0)

                    <button
                        type="submit"
                        class="btn btn-success">

                        <i class="fas fa-save"></i>
                        Simpan Semua

                    </button>

                @endif

                <a
                    href="{{ route('nilai-sumatif.index', ['jenis' => $jenis]) }}"
                    class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection
