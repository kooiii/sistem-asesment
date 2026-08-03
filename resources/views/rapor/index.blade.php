@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h3>Rapor Semester</h3>

        <a href="{{ route('dashboard') }}"
           class="btn btn-secondary">

            ← Kembali

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Nama Siswa</th>

                        <th>Kelas</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($siswas as $siswa)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $siswa->nama }}</td>

                        <td>{{ $siswa->kelas->nama_kelas }}</td>

                        <td>

                            <a href="{{ route('rapor.show',$siswa->id) }}"
                                class="btn btn-primary btn-sm">

                                    <i class="fa fa-file-text"></i>
                                    Lihat Rapor

                                </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection