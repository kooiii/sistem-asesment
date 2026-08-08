@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Data Kelas</h4>
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

            {{-- Tombol tambah --}}
            <div class="mb-3">
                <a
                    href="{{ route('kelas.create') }}"
                    class="btn btn-primary"
                >
                    + Tambah Kelas
                </a>
            </div>

            {{-- Tabel kelas --}}
            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-primary">

                        <tr>
                            <th width="70">No</th>
                            <th>Nama Kelas</th>
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
                                    {{ $d->nama_kelas }}
                                </td>

                                <td>

                                    {{-- Tombol Edit --}}
                                    <a
                                        href="{{ route('kelas.edit', $d->id) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form
                                        action="{{ route('kelas.destroy', $d->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kelas ini?')"
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
                                    Data kelas belum tersedia.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Tombol kembali --}}
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