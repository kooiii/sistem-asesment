@extends('layouts.app')

@section('content')

<div class="card card-custom">

    <div class="card-header bg-success text-white">

        <h4>

            Input Nilai Formatif

        </h4>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>

                <th width="200">Kelas</th>

                <td>{{ $tp->kelas->nama_kelas }}</td>

            </tr>

            <tr>

                <th>Mapel</th>

                <td>{{ $tp->mapel->nama_mapel }}</td>

            </tr>

            <tr>

                <th>TP</th>

                <td>

                    TP {{ $tp->nomor_tp }}

                    -

                    {{ $tp->judul_tp }}

                </td>

            </tr>

        </table>

        <form action="{{ route('nilai-formatif.store') }}" method="POST">

            @csrf

            <input type="hidden"
                   name="tp_id"
                   value="{{ $tp->id }}">

            <div class="mb-3">

                <label>Teknik Penilaian</label>

                <select
                    name="teknik"
                    class="form-control"
                    onchange="window.location='?tp={{ $tp->id }}&teknik='+this.value">

                    <option value="Tugas"
                        {{ $teknik=='Tugas'?'selected':'' }}>Tugas</option>

                    <option value="Kuis"
                        {{ $teknik=='Kuis'?'selected':'' }}>Kuis</option>

                    <option value="Praktik"
                        {{ $teknik=='Praktik'?'selected':'' }}>Praktik</option>

                    <option value="Presentasi"
                        {{ $teknik=='Presentasi'?'selected':'' }}>Presentasi</option>

                </select>

            </div>

            <table class="table table-striped">

                <thead>

                    <tr>

                        <th width="70">No</th>

                        <th>Nama Siswa</th>

                        <th width="180">

                            Nilai

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($siswas as $siswa)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $siswa->nama }}

                        </td>

                        <td>

                            <input
                                type="hidden"
                                name="siswa_id[]"
                                value="{{ $siswa->id }}">

                            <input
                                type="number"
                                name="nilai[]"
                                class="form-control"
                                min="0"
                                max="100"
                                value="{{ $nilaiLama[$siswa->id] ?? '' }}">

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <button
                class="btn btn-success">

                Simpan Nilai

            </button>

            <a href="{{ route('tujuan-pembelajaran.index') }}"
               class="btn btn-secondary">

               Kembali

            </a>

        </form>

    </div>

</div>

@endsection