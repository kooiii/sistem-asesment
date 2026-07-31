@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h3>Penilaian Sumatif {{ $jenis }}</h3>

        <div>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>

            <a href="{{ route('nilai-sumatif.create',['jenis'=>$jenis]) }}"
               class="btn btn-primary">

                <i class="fa fa-plus"></i>

                Input Nilai

            </a>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card shadow">

        <div class="card-header bg-primary text-white d-flex justify-content-between">

            <strong>Data Nilai Sumatif</strong>

            <div>

                <a href="{{ route('nilai-sumatif.index',['jenis'=>'STS']) }}"
                   class="btn btn-light btn-sm {{ $jenis=='STS' ? 'active' : '' }}">

                    STS

                </a>

                <a href="{{ route('nilai-sumatif.index',['jenis'=>'SAS']) }}"
                   class="btn btn-light btn-sm {{ $jenis=='SAS' ? 'active' : '' }}">

                    SAS

                </a>

            </div>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-primary">

                    <tr>

                        <th width="60">No</th>

                        <th>Nama Siswa</th>

                        <th>Kelas</th>

                        <th>Mata Pelajaran</th>

                        <th width="120">Jenis</th>

                        <th width="120">Nilai</th>

                        <th width="170">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $d)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $d->siswa->nama }}</td>

                        <td>{{ $d->siswa->kelas->nama_kelas }}</td>

                        <td>{{ $d->mapel->nama_mapel }}</td>

                        <td>

                            <span class="badge bg-info">

                                {{ $d->jenis }}

                            </span>

                        </td>

                        <td>

                            <strong>{{ $d->nilai }}</strong>

                        </td>

                        <td>

                           <td>

                            <form action="{{ route('nilai-sumatif.destroy',$d->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                                    <i class="fa fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center">

                            Belum ada data nilai {{ $jenis }}.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection