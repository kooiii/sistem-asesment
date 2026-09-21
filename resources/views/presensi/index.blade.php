@extends('layouts.app')

@section('content')

<div class="container">

    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fa fa-check-circle"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fa fa-times-circle"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h4 class="mb-0">
                        Data Sikap & Presensi
                    </h4>

                    <small>

                        Tahun Ajaran :

                        {{ $tahun->tahun_ajaran }}
                        -
                        {{ $tahun->semester }}

                    </small>

                </div>

                <div>

                    <a
                        href="{{ route('presensi.create') }}"
                        class="btn btn-light btn-sm">

                        <i class="fa fa-plus"></i>

                        Input Nilai

                    </a>

                    <a
                        href="{{ route('dashboard') }}"
                        class="btn btn-secondary btn-sm">

                        <i class="fa fa-arrow-left"></i>

                        Dashboard

                    </a>

                </div>

            </div>

        </div>


        <div class="card-body">

            {{-- INFORMASI KELAS --}}
            <div class="alert alert-info">

                <div class="row">

                    <div class="col-md-6">

                        <strong>Kelas Aktif</strong>

                        <br>

                        {{
                            optional(
                                $guru->kelas
                                    ->where('id', session('kelas_aktif'))
                                    ->first()
                            )->nama_kelas
                        }}

                    </div>

                    <div class="col-md-6">

                        <strong>Tahun Ajaran</strong>

                        <br>

                        {{ $tahun->tahun_ajaran }}
                        -
                        {{ $tahun->semester }}

                    </div>

                </div>

            </div>


            {{-- DATA --}}
            <table class="table table-bordered table-hover align-middle">

                <thead class="table-primary text-center">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Nama Siswa
                        </th>

                        <th width="120">
                            Sikap
                        </th>

                        <th width="120">
                            Predikat
                        </th>

                        <th width="120">
                            Presensi
                        </th>

                        <th width="170">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($data as $d)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $d->siswa->nama }}
                            </td>

                            <td class="text-center">
                                {{ number_format($d->sikap, 2) }}
                            </td>

                            <td class="text-center">

                                @if($d->predikat == 'SB')

                                    <span class="badge bg-success">
                                        SB
                                    </span>

                                @elseif($d->predikat == 'B')

                                    <span class="badge bg-primary">
                                        B
                                    </span>

                                @elseif($d->predikat == 'C')

                                    <span class="badge bg-warning text-dark">
                                        C
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        K
                                    </span>

                                @endif

                            </td>

                            <td class="text-center">
                                {{ number_format($d->presensi, 2) }}
                            </td>

                            <td class="text-center">

                                <a
                                    href="{{ route('presensi.edit', $d->id) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="fa fa-edit"></i>

                                    Edit

                                </a>


                                <form
                                    action="{{ route('presensi.destroy', $d->id) }}"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                                        <i class="fa fa-trash"></i>

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted">

                                Belum ada data Sikap & Presensi
                                untuk tahun ajaran aktif.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection