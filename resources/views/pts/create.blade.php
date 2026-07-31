@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <h4>Penilaian Sumatif Tengah Semester (STS)</h4>

        <small>

            {{ $kelasDipilih ? $kelasGuru->where('id',$kelasDipilih)->first()->nama_kelas : '-' }}

        </small>

    </div>

    <div class="card-body">

        <form action="{{ route('pts.store') }}" method="POST">

            @csrf

            <div class="row mb-4">

                <div class="col-md-4">

                    <label>Kelas</label>

                    <select
                        name="kelas"
                        id="kelas"
                        class="form-control">

                        <option value="">Pilih Kelas</option>

                        @foreach($kelasGuru as $kelas)

                        <option
                            value="{{ $kelas->id }}"
                            {{ $kelasDipilih==$kelas->id?'selected':'' }}>
                            {{ $kelas->nama_kelas }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-4">

                    <label>Mapel</label>

                    <select
                        name="mapel_id"
                        id="mapel"
                        class="form-control">

                        @foreach($mapelGuru as $mapel)

                        <option value="{{ $mapel->id }}">
                            {{ $mapel->nama_mapel }}
                        </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <table class="table table-bordered table-hover">

                <thead class="table-primary">

                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th width="120">Nilai Murni</th>
                        <th width="120">Remedial</th>
                        <th width="120">Nilai Akhir</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($siswas as $siswa)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

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
                                name="nm[]"
                                class="form-control nm"
                                min="0"
                                max="100"
                                value="{{ optional($siswa->pts)->nm }}">

                        </td>

                        <td>

                            <input
                                type="number"
                                name="nr[]"
                                class="form-control nr"
                                min="0"
                                max="100"
                                value="{{ optional($siswa->pts)->nr }}">

                        </td>

                        <td>
                            <strong class="akhir">
                                {{ optional($siswa->pts)->n ?? '-' }}
                            </strong>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <button class="btn btn-success">

                <i class="fa fa-save"></i>

                Simpan Semua

            </button>

            <a
                href="{{ route('pts.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.querySelectorAll("tbody tr").forEach(function(row){

    function hitung(){

        let nm=parseFloat(row.querySelector(".nm").value);

        let nr=parseFloat(row.querySelector(".nr").value);

        let nilai="-";

        if(!isNaN(nr)){

            nilai=nr;

        }else if(!isNaN(nm)){

            nilai=nm;

        }

        let cell=row.querySelector(".akhir");

        cell.innerHTML=nilai;

        cell.className="akhir";

        if(nilai=="-") return;

        if(nilai>=90){

            cell.classList.add("text-success");

        }else if(nilai>=80){

            cell.classList.add("text-primary");

        }else if(nilai>=70){

            cell.classList.add("text-warning");

        }else{

            cell.classList.add("text-danger");

        }

    }

    row.querySelector(".nm").addEventListener("keyup",hitung);

    row.querySelector(".nr").addEventListener("keyup",hitung);

    row.querySelector(".nm").addEventListener("change",hitung);

    row.querySelector(".nr").addEventListener("change",hitung);

    hitung();

});

document.getElementById("kelas").addEventListener("change", reload);

document.getElementById("mapel").addEventListener("change", reload);

function reload(){

    let kelas = document.getElementById("kelas").value;

    let mapel = document.getElementById("mapel").value;

    window.location =
        "?kelas="+kelas+"&mapel_id="+mapel;

}
</script>

@endpush