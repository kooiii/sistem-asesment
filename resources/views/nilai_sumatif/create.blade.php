@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <h4>

            Input Nilai {{ $jenis }}

        </h4>

    </div>

    <div class="card-body">

        @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

        @endif

        <form action="{{ route('nilai-sumatif.store') }}" method="POST">

            @csrf

            <div class="row mb-4">

                <div class="col-md-4">

                    <label>Kelas</label>

                    <select
                        name="kelas"
                        class="form-control"
                        onchange="location='?kelas='+this.value+'&jenis={{ $jenis }}'">

                        <option value="">Pilih Kelas</option>

                        @foreach($guru->kelas as $kelas)

                        <option
                            value="{{ $kelas->id }}"
                            {{ $kelasDipilih==$kelas->id?'selected':'' }}>

                            {{ $kelas->nama_kelas }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-4">

                    <label>Mata Pelajaran</label>

                    <select
                        name="mapel_id"
                        class="form-control"
                        onchange="location='?kelas={{ $kelasDipilih }}&mapel_id='+this.value+'&jenis={{ $jenis }}'"
                        required>

                        @foreach($guru->mapel as $mapel)
                            <option
                            value="{{ $mapel->id }}"
                            {{ $mapelDipilih==$mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="col-md-4">

                    <label>Jenis Sumatif</label>
                    <select
                        name="jenis"
                        class="form-control">

                        <option
                            value="STS"
                            {{ $jenis=='STS'?'selected':'' }}>
                            STS
                        </option>

                        <option
                            value="SAS"
                            {{ $jenis=='SAS'?'selected':'' }}>
                            SAS
                        </option>

                    </select>

                </div>

            </div>

            <table class="table table-bordered table-hover">

                <thead class="table-primary">

                    <tr>

                        <th width="60">No</th>

                        <th>Nama Siswa</th>

                        <th width="150">Nilai</th>

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
                                class="form-control"
                                min="0"
                                max="100"
                                value="{{ optional($siswa->nilaiSumatif->first())->nilai }}"
                                required>
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3" class="text-center">

                            Pilih kelas terlebih dahulu.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            <button class="btn btn-success">

                <i class="fa fa-save"></i>

                Simpan Nilai

            </button>

            <a
                href="{{ route('nilai-sumatif.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection