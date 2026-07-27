@extends('layouts.app')

@section('content')

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>

TP {{ $tp->nomor_tp }}

-

{{ $tp->judul_tp }}

</h4>

<small>

{{ $tp->kelas->nama_kelas }}

|

{{ $tp->mapel->nama_mapel }}

</small>

</div>

<div class="card-body">

<form action="{{ route('nilai-formatif.store') }}"

method="POST">

@csrf

<input type="hidden"

name="tp_id"

value="{{ $tp->id }}">

<table class="table table-bordered table-hover">

<thead class="table-success">

<tr>

<th>No</th>

<th>Nama Siswa</th>

<th width="90">

Tugas

</th>

<th width="90">

Kuis

</th>

<th width="90">

Praktik

</th>

<th width="110">

Presentasi

</th>

<th width="90">

Rata-rata

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

<input

type="hidden"

name="siswa_id[]"

value="{{ $siswa->id }}">

</td>

<td>

<input
type="number"
name="tugas[]"
class="form-control nilai"
min="0"
max="100"
value="{{ $siswa->tugas }}">

</td>

<td>

<input
type="number"
name="kuis[]"
class="form-control nilai"
min="0"
max="100"
value="{{ $siswa->kuis }}">

</td>

<td>

<input
type="number"
name="praktik[]"
class="form-control nilai"
min="0"
max="100"
value="{{ $siswa->praktik }}">

</td>

<td>

<input
type="number"
name="presentasi[]"
class="form-control nilai"
min="0"
max="100"
value="{{ $siswa->presentasi }}">

</td>

<td>

<strong class="rata">

{{ $siswa->rata ?? '-' }}

</strong>

</td>

</tr>

@endforeach

</tbody>

</table>

<button class="btn btn-success">

<i class="fa fa-save"></i>Simpan Semua</button>

<a href="{{ route('tujuan-pembelajaran.index') }}"
class="btn btn-secondary">Kembali</a>

</form>

</div>

</div>

@endsection

@push('scripts')

<script>

document.querySelectorAll("tbody tr").forEach(function(row){

    function hitung(){

        let total = 0;
        let jumlah = 0;

        row.querySelectorAll(".nilai").forEach(function(input){

            let v = parseFloat(input.value);

            if(!isNaN(v)){

                total += v;
                jumlah++;

            }

        });

        let rataCell = row.querySelector(".rata");

        if(jumlah == 0){

            rataCell.innerHTML = "-";
            rataCell.className = "rata";
            return;

        }

        let rata = (total / jumlah).toFixed(2);

        rataCell.innerHTML = rata;
        rataCell.className = "rata";

        if(rata >= 90){

            rataCell.classList.add("text-success");

        }else if(rata >= 80){

            rataCell.classList.add("text-primary");

        }else if(rata >= 70){

            rataCell.classList.add("text-warning");

        }else{

            rataCell.classList.add("text-danger");

        }

    }

    row.querySelectorAll(".nilai").forEach(function(input){

        input.addEventListener("keyup", hitung);
        input.addEventListener("change", hitung);

    });

    hitung();

});

</script>

@endpush