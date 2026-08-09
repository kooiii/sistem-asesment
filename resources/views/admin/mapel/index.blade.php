@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Data Mata Pelajaran</h4>
        </div>

        <div class="card-body">

            {{-- Notifikasi berhasil --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                    </button>
                </div>
            @endif

            {{-- Notifikasi error --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}

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

            {{-- Tombol Tambah --}}
            <div class="mb-3">

                <a
                    href="{{ route('mapel.create') }}"
                    class="btn btn-primary"
                >
                    + Tambah Mata Pelajaran
                </a>

            </div>

            {{-- Tabel --}}
            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-primary">

                        <tr>
                            <th width="70">No</th>
                            <th>Nama Mata Pelajaran</th>
                            <th width="220">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($data as $d)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $d->nama_mapel }}
                                </td>

                                <td>

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('mapel.edit', $d->id) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>

                                    {{-- Hapus --}}
                                    <form
                                        action="{{ route('mapel.destroy', $d->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="3"
                                    class="text-center"
                                >
                                    Data mata pelajaran belum tersedia.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Kembali --}}
            <a
                href="{{ url('/dashboard') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </div>

    </div>

</div>

@endsection