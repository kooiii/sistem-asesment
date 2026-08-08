@extends('layouts.app')

@section('content')

<div class="container">

    {{-- NOTIFIKASI BERHASIL --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="fas fa-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- NOTIFIKASI ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="fas fa-exclamation-circle me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- VALIDASI ERROR --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- HEADER --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="mb-1">
                Data Siswa
            </h3>

            <p class="text-muted mb-0">
                Kelola data siswa yang terdaftar dalam sistem.
            </p>

        </div>


        <a href="{{ route('siswa.create') }}"
           class="btn btn-primary">

            <i class="fas fa-plus me-1"></i>

            Tambah Siswa

        </a>

    </div>


    {{-- TABEL --}}

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                <i class="fas fa-user-graduate me-2"></i>

                Daftar Siswa

            </h5>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                NIS
                            </th>

                            <th>
                                Nama Siswa
                            </th>

                            <th>
                                Kelas
                            </th>

                            <th width="180">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($data as $siswa)

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>


                                <td>
                                    {{ $siswa->nis }}
                                </td>


                                <td>
                                    {{ $siswa->nama }}
                                </td>


                                <td>
                                    {{ optional($siswa->kelas)->nama_kelas ?? '-' }}
                                </td>


                                <td>

                                    {{-- EDIT --}}

                                    <a href="{{ route('siswa.edit', $siswa->id) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="fas fa-edit me-1"></i>

                                        Edit

                                    </a>


                                    {{-- HAPUS --}}

                                    <form
                                        action="{{ route('siswa.destroy', $siswa->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">

                                            <i class="fas fa-trash me-1"></i>

                                            Hapus

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-muted py-4">

                                    <i class="fas fa-info-circle me-1"></i>

                                    Belum ada data siswa.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- KEMBALI --}}

    <div class="mt-3">

        <a href="{{ url('/dashboard') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left me-1"></i>

            Kembali

        </a>

    </div>

</div>


{{-- NOTIFIKASI OTOMATIS HILANG SETELAH 5 DETIK --}}

<script>

    setTimeout(function () {

        let alerts = document.querySelectorAll('.alert');

        alerts.forEach(function (alert) {

            if (typeof bootstrap !== 'undefined') {

                let bsAlert =
                    bootstrap.Alert.getOrCreateInstance(alert);

                bsAlert.close();

            }

        });

    }, 5000);

</script>

@endsection