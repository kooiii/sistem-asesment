@extends('layouts.app')

@section('content')

<div class="container">

<h3>Input Nilai PAS</h3>

<form action="{{ route('pas.store') }}" method="POST">

@csrf

<div class="mb-3">
    <label>Kelas</label>

    <select id="kelas" class="form-control">

        <option value="">-- Pilih Kelas --</option>

        @foreach($kelasGuru as $kelas)

        <option value="{{ $kelas->id }}">

            {{ $kelas->nama_kelas }}

        </option>

        @endforeach

    </select>
</div>

<div class="mb-3">

    <label>Mata Pelajaran</label>

    <select name="mapel_id" class="form-control">

        @foreach($mapelGuru as $mapel)

        <option value="{{ $mapel->id }}">

            {{ $mapel->nama_mapel }}

        </option>

        @endforeach

    </select>

</div>

<div class="mb-3">

    <label>Siswa</label>

    <select name="siswa_id" id="siswa" class="form-control">

        <option value="">-- Pilih Siswa --</option>

    </select>

</div>

<div class="mb-3">

    <label>Nilai Murni (NM)</label>

    <input type="number"
           name="nm"
           class="form-control"
           required>

</div>

<div class="mb-3">

    <label>Nilai Remedial (NR)</label>

    <input type="number"
           name="nr"
           class="form-control">

</div>

<button class="btn btn-success">
    Simpan
</button>

<a href="{{ route('pas.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

<script>

document.getElementById('kelas').addEventListener('change',function(){

    let kelas = this.value;

    fetch('/get-siswa/'+kelas)

    .then(res=>res.json())

    .then(data=>{

        let siswa = document.getElementById('siswa');

        siswa.innerHTML='<option value="">-- Pilih Siswa --</option>';

        data.forEach(function(item){

            siswa.innerHTML +=
            <option value="${item.id}">${item.nama}</option>;

        });

    });

});

</script>

@endsection