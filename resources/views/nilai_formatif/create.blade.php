@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Penilaian Formatif
            </h4>
        </div>

        <div class="card-body">

            {{-- INFORMASI TP --}}
            <div class="mb-4">

                <h5>
                    TP {{ $tp->nomor_tp }} -
                    {{ $tp->judul_tp }}
                </h5>

                <p class="mb-0">
                    <strong>Kelas:</strong>
                    {{ $tp->kelas->nama_kelas }}
                </p>

                <p>
                    <strong>Mata Pelajaran:</strong>
                    {{ $tp->mapel->nama_mapel }}
                </p>

            </div>

            {{-- PESAN SUCCESS --}}
            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif

            {{-- PESAN ERROR --}}
            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif

            {{-- VALIDASI ERROR --}}
            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM NILAI --}}
            <form
                action="{{ route('nilai-formatif.store') }}"
                method="POST">

                @csrf

                <input
                    type="hidden"
                    name="tp_id"
                    value="{{ $tp->id }}">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-primary">

                            <tr>

                                <th width="50">
                                    No
                                </th>

                                <th>
                                    Nama Siswa
                                </th>

                                <th width="120">
                                    Tugas
                                </th>

                                <th width="120">
                                    Kuis
                                </th>

                                <th width="120">
                                    Praktik
                                </th>

                                <th width="120">
                                    Presentasi
                                </th>

                                <th width="120">
                                    Rata-rata
                                </th>

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

                                    {{-- TUGAS --}}
                                    <td>

                                        <input
                                            type="number"
                                            name="tugas[]"
                                            class="form-control nilai-input"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            value="{{ $siswa->tugas }}">

                                    </td>

                                    {{-- KUIS --}}
                                    <td>

                                        <input
                                            type="number"
                                            name="kuis[]"
                                            class="form-control nilai-input"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            value="{{ $siswa->kuis }}">

                                    </td>

                                    {{-- PRAKTIK --}}
                                    <td>

                                        <input
                                            type="number"
                                            name="praktik[]"
                                            class="form-control nilai-input"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            value="{{ $siswa->praktik }}">

                                    </td>

                                    {{-- PRESENTASI --}}
                                    <td>

                                        <input
                                            type="number"
                                            name="presentasi[]"
                                            class="form-control nilai-input"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            value="{{ $siswa->presentasi }}">

                                    </td>

                                    {{-- RATA-RATA --}}
                                    <td>

                                        <span class="rata-rata">
                                            {{ $siswa->rata ?? '-' }}
                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center">

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

                        <i class="fa fa-save"></i>
                        Simpan Semua

                    </button>

                @endif

                <a
                    href="{{ route('tujuan-pembelajaran.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>


{{-- JAVASCRIPT RATA-RATA --}}
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(function (row) {

        const inputs = row.querySelectorAll('.nilai-input');

        const rata = row.querySelector('.rata-rata');

        function hitungRataRata() {

            let total = 0;
            let jumlah = 0;

            inputs.forEach(function (input) {

                if (input.value !== '') {

                    total += parseFloat(input.value);
                    jumlah++;

                }

            });

            if (jumlah > 0) {

                rata.textContent =
                    (total / jumlah).toFixed(2);

            } else {

                rata.textContent = '-';

            }

        }

        inputs.forEach(function (input) {

            input.addEventListener(
                'input',
                hitungRataRata
            );

        });

        hitungRataRata();

    });

});

</script>

@endpush

@endsection