@extends('layouts.app')

@section('content')

<div class="container">

    {{-- NOTIFIKASI BERHASIL --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">

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

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

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
                Data Guru
            </h3>

            <p class="text-muted mb-0">
                Kelola data guru yang terdaftar dalam sistem.
            </p>

        </div>


        <a href="{{ route('guru.create') }}"
           class="btn btn-primary">

            <i class="fas fa-plus me-1"></i>

            Tambah Guru

        </a>

    </div>


    {{-- TABEL DATA GURU --}}
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                <i class="fas fa-users me-2"></i>

                Daftar Guru

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
                                NIP
                            </th>

                            <th>
                                Nama Guru
                            </th>

                            <th>
                                Role
                            </th>

                            <th width="260">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($data as $g)

                            <tr>

                                <td class="text-center">

                                    {{ $loop->iteration }}

                                </td>


                                <td>

                                    {{ $g->nip }}

                                </td>


                                <td>

                                    {{ $g->nama }}

                                </td>


                                <td>

                                    @if($g->role == 'admin')

                                        <span class="badge bg-danger">
                                            Admin
                                        </span>

                                    @else

                                        <span class="badge bg-primary">
                                            Guru
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    {{-- PENUGASAN --}}

                                    <a href="{{ route('guru.penugasan', $g->id) }}"
                                       class="btn btn-info btn-sm text-white">

                                        <i class="fas fa-tasks me-1"></i>

                                        Atur Penugasan

                                    </a>


                                    {{-- EDIT --}}

                                    <a href="{{ route('guru.edit', $g->id) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="fas fa-edit me-1"></i>

                                        Edit

                                    </a>


                                    {{-- HAPUS --}}

                                    <form action="{{ route('guru.destroy', $g->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini?')">

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

                                    Belum ada data guru.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- AUTO HILANGKAN NOTIFIKASI SETELAH 5 DETIK --}}
<script>

    setTimeout(function () {

        let alerts = document.querySelectorAll('.alert');

        alerts.forEach(function (alert) {

            let bsAlert = bootstrap.Alert.getOrCreateInstance(alert);

            bsAlert.close();

        });

    }, 5000);

</script>

@endsection