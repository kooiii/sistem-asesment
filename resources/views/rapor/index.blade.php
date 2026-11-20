
@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h3>Rapor Semester</h3>
            <small class="text-muted">
                Tahun Ajaran: {{ $tahun->tahun_ajaran }}
                - Semester {{ $tahun->semester }}
            </small>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            ← Kembali
        </a>

    </div>

    <div class="card card-custom">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($siswas as $siswa)

                            @forelse($mapels as $mapel)

                                <tr>

                                    <td>{{ $loop->parent->iteration }}</td>

                                    <td>{{ $siswa->nama }}</td>

                                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>

                                    <td>{{ $mapel->nama_mapel }}</td>

                                    <td>
                                        <a href="{{ route('rapor.show', [
                                            'rapor' => $siswa->id,
                                            'mapel_id' => $mapel->id
                                        ]) }}"
                                           class="btn btn-primary btn-sm">

                                            <i class="fa fa-file-text"></i>
                                            Lihat Rapor

                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center">
                                        Belum ada mata pelajaran.
                                    </td>
                                </tr>

                            @endforelse

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data siswa.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
