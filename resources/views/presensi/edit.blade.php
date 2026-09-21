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

        <div class="card-header bg-warning text-dark">

            <h4 class="mb-0">
                Edit Sikap & Presensi
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

                        <strong>Nama Siswa</strong>

                        <br>

                        {{ $data->siswa->nama }}

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
                action="{{ route('presensi.update', $data->id) }}"
                method="POST">

                @csrf

                @method('PUT')


                <div class="row">

                    <div class="col-md-6">

                        <label
                            class="form-label">

                            Nilai Sikap

                        </label>

                        <input
                            type="number"
                            name="sikap"
                            id="sikap"
                            class="form-control"
                            min="0"
                            max="100"
                            step="0.01"
                            value="{{ old('sikap', $data->sikap) }}"
                            required>

                    </div>


                    <div class="col-md-6">

                        <label
                            class="form-label">

                            Nilai Presensi

                        </label>

                        <input
                            type="number"
                            name="presensi"
                            class="form-control"
                            min="0"
                            max="100"
                            step="0.01"
                            value="{{ old('presensi', $data->presensi) }}"
                            required>

                    </div>

                </div>


                {{-- PREDIKAT --}}
                <div class="row mt-4">

                    <div class="col-md-6">

                        <label
                            class="form-label">

                            Predikat Sikap

                        </label>

                        <input
                            type="text"
                            id="predikat"
                            class="form-control"
                            readonly>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-warning">

                        <i class="fa fa-save"></i>

                        Update

                    </button>


                    <a
                        href="{{ route('presensi.index') }}"
                        class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

function hitungPredikat() {

    let nilai = parseFloat(
        document.getElementById("sikap").value
    );

    let predikat = "-";

    if (!isNaN(nilai)) {

        if (nilai >= 90) {

            predikat = "SB";

        } else if (nilai >= 80) {

            predikat = "B";

        } else if (nilai >= 70) {

            predikat = "C";

        } else {

            predikat = "K";

        }

    }

    document.getElementById("predikat").value = predikat;
}


document
    .getElementById("sikap")
    .addEventListener(
        "keyup",
        hitungPredikat
    );


document
    .getElementById("sikap")
    .addEventListener(
        "input",
        hitungPredikat
    );


document
    .getElementById("sikap")
    .addEventListener(
        "change",
        hitungPredikat
    );


hitungPredikat();

</script>

@endpush