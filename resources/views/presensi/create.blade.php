@extends('layouts.app')

@section('content')

<div class="container">

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

            <div class="alert alert-info">

                <div class="row">

                    <div class="col-md-4">

                        <strong>Kelas Aktif</strong>

                        <br>

                        {{ optional($guru->kelas->where('id',session('kelas_aktif'))->first())->nama_kelas }}

                    </div>


                    <div class="col-md-4">

                        <strong>Tahun Ajaran</strong>

                        <br>

                        {{ $tahun ? $tahun->tahun_ajaran.' - '.$tahun->semester : '-' }}

                    </div>

                </div>

            </div>

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
                                    class="form-control sikap"
                                    name="sikap[]"
                                    min="0"
                                    max="100"
                                    value="{{ $siswa->sikap }}">

                            </td>

                            <td>

                                <input
                                    type="number"
                                    class="form-control presensi"
                                    name="presensi[]"
                                    min="0"
                                    max="100"
                                    value="{{ $siswa->presensi }}">

                            </td>

                            <td>

                                <strong class="predikat">

                                    -

                                </strong>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center">

                                Belum ada siswa.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                <button class="btn btn-primary">

                    <i class="fa fa-save"></i>

                    Simpan

                </button>

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

document.querySelectorAll("tbody tr").forEach(function(row){

    function hitung(){

        let nilai = parseFloat(

            row.querySelector(".sikap").value

        );

        let predikat = "-";

        if(!isNaN(nilai)){

            if(nilai>=90){

                predikat="SB";

            }else if(nilai>=80){

                predikat="B";

            }else if(nilai>=70){

                predikat="C";

            }else{

                predikat="K";

            }

        }

        row.querySelector(".predikat").innerHTML = predikat;

    }

    row.querySelector(".sikap")

        .addEventListener("keyup",hitung);

    row.querySelector(".sikap")

        .addEventListener("change",hitung);

    hitung();

});

</script>

@endpush