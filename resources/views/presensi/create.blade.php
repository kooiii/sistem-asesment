@extends('layouts.app')

@section('content')

<div class="container">

    {{-- ERROR VALIDATION --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Terdapat kesalahan pada input:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ERROR SESSION --}}
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

            <h4 class="mb-0">
                Penilaian Sikap & Presensi
            </h4>

        </div>


        <div class="card-body">

            {{-- INFORMASI --}}
            <div class="alert alert-info">

                <div class="row">

                    <div class="col-md-4">

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


                    <div class="col-md-4">

                        <strong>Tahun Ajaran</strong>

                        <br>

                        {{ $tahun->tahun_ajaran }}
                        -
                        {{ $tahun->semester }}

                    </div>

                </div>

            </div>


            {{-- FORM --}}
            <form
                action="{{ route('presensi.store') }}"
                method="POST">

                @csrf


                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                Nama Siswa
                            </th>

                            <th width="150">
                                Sikap
                            </th>

                            <th width="150">
                                Presensi
                            </th>

                            <th width="120">
                                Predikat
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($siswas as $siswa)

                            <tr>

                                <td class="text-center">
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
                                        class="form-control sikap"
                                        name="sikap[]"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        value="{{ old('sikap.' . $loop->index, $siswa->sikap) }}"
                                        required>

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        class="form-control presensi"
                                        name="presensi[]"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        value="{{ old('presensi.' . $loop->index, $siswa->presensi) }}"
                                        required>

                                </td>


                                <td class="text-center">

                                    <strong class="predikat">
                                        -
                                    </strong>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-muted">

                                    Belum ada siswa pada kelas aktif.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>


                @if($siswas->count() > 0)

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fa fa-save"></i>

                        Simpan

                    </button>

                @endif


                <a
                    href="{{ route('presensi.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

document.querySelectorAll("tbody tr").forEach(function(row) {

    const inputSikap = row.querySelector(".sikap");
    const predikat = row.querySelector(".predikat");

    if (!inputSikap || !predikat) {
        return;
    }

    function hitungPredikat() {

        let nilai = parseFloat(inputSikap.value);

        let hasil = "-";

        if (!isNaN(nilai)) {

            if (nilai >= 90) {

                hasil = "SB";

            } else if (nilai >= 80) {

                hasil = "B";

            } else if (nilai >= 70) {

                hasil = "C";

            } else {

                hasil = "K";

            }

        }

        predikat.innerHTML = hasil;
    }


    inputSikap.addEventListener(
        "keyup",
        hitungPredikat
    );

    inputSikap.addEventListener(
        "change",
        hitungPredikat
    );

    inputSikap.addEventListener(
        "input",
        hitungPredikat
    );


    hitungPredikat();

});

</script>

@endpush