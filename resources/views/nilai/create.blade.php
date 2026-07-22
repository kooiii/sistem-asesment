@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Nilai {{ $jenis }}</h3>

    <form action="{{ route('nilai.store') }}" method="POST">
        @csrf

        <!-- KELAS -->
        <div class="mb-3">
            <label>Kelas</label>
            <select id="kelas" name="kelas_id" class="form-control">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <!-- SISWA -->
        <div class="mb-3">
            <label>Siswa</label>
            <select name="siswa_id" class="form-control">
                <option value="">-- Pilih Siswa --</option>
                @foreach($siswas as $s)
                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- MAPEL -->
        <div class="mb-3">
            <label>Mapel</label>
            <select name="mapel_id" class="form-control">
                <option value="">-- Pilih Mapel --</option>
                @foreach($mapels as $m)
                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                @endforeach
            </select>
        </div>

        <!-- KATEGORI -->
        <div class="mb-3">
            <label>Kategori Penilaian</label>
            <select name="kategori"
                        id="kategori"
                        class="form-control">
                <option value="">-- Pilih Kategori --</option>
                <option value="Kuis">Kuis</option>
                <option value="Tugas">Tugas</option>
                <option value="Praktik">Praktik</option>
            </select>
        </div>

        <!-- BOBOT -->
        <div class="mb-3">
            <label>Bobot (%)</label>
            <input type="number"
                    name="bobot"
                    id="bobot"
                    class="form-control"
                    readonly>
        </div>

        <!-- NILAI -->
        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" name="nilai" class="form-control">
        </div>

        <!-- JENIS -->
        <input type="hidden" name="jenis" value="{{ $jenis }}">

        <button class="btn btn-success">Simpan</button>
    </form>
</div>

<!-- SCRIPT FILTER SISWA -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const kelasSelect = document.getElementById('kelas');
    const siswaSelect = document.querySelector('[name="siswa_id"]');

    kelasSelect.addEventListener('change', function () {
        let kelas_id = this.value;

        console.log("KELAS DIPILIH:", kelas_id);

        fetch('/get-siswa/' + kelas_id)
            .then(res => res.json())
            .then(data => {
                console.log("DATA SISWA:", data);

                siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';

                data.forEach(s => {
                    siswaSelect.innerHTML +=`<option value="${s.id}">${s.nama}</option>`;
                });
            })
            .catch(err => console.log(err));
    });

});

document.getElementById('kategori').addEventListener('change', function(){
    let kategori = this.value;
    let bobot = document.getElementById('bobot');

    if(kategori == 'Kuis'){
        bobot.value = 20;
    }
    else if(kategori == 'Tugas'){
        bobot.value = 30;
    }
    else if(kategori == 'Praktik'){
        bobot.value = 50;
    }
    else{
        bobot.value = '';
    }
    });
</script>