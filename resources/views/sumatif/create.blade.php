@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Tambah Nilai Sumatif</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('nilai.store') }}" method="POST">
        @csrf

        <!-- KELAS -->
        <div class="mb-3">
            <label>Kelas</label>

            <select id="kelas" class="form-control">
                <option value="">-- Pilih Kelas --</option>

                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- SISWA -->
        <div class="mb-3">
            <label>Siswa</label>

            <select name="siswa_id" class="form-control">
                <option value="">-- Pilih Siswa --</option>
            </select>
        </div>

        <!-- MAPEL -->
        <div class="mb-3">
            <label>Mata Pelajaran</label>

            <select name="mapel_id" class="form-control">

                <option value="">-- Pilih Mapel --</option>

                @foreach($mapels as $m)
                    <option value="{{ $m->id }}">
                        {{ $m->nama_mapel }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>Kategori Penilaian</label>
            <select name="kategori"
                    id="kategori"
                    class="form-control">
                <option value="">-- Pilih Kategori --</option>
                <option value="STS">STS</option>
                <option value="SAS">SAS</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Bobot (%)</label>
            <input type="number"
                    name="bobot"
                    id="bobot"
                    class="form-control">
        </div>

        <!-- NILAI -->
        <div class="mb-3">
            <label>Nilai</label>

            <input type="number"
                   name="nilai"
                   class="form-control">
        </div>

        <!-- JENIS -->
        <input type="hidden"
               name="jenis"
               value="sumatif">

        <button class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('sumatif.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

<!-- FILTER SISWA -->
<script>
document.getElementById('kelas').addEventListener('change', function () {

    let kelas_id = this.value;

    fetch('/get-siswa/' + kelas_id)

        .then(response => response.json())

        .then(data => {

            let siswa = document.querySelector('[name="siswa_id"]');

            siswa.innerHTML =
                '<option value="">-- Pilih Siswa --</option>';

            data.forEach(function(s){

                siswa.innerHTML += `
                    <option value="${s.id}">
                        ${s.nama}
                    </option>
                `;
            });

        });

});

document.getElementById('kategori').addEventListener('change', function(){
    let kategori = this.value;
    let bobot = document.getElementById('bobot');

    if(kategori == 'STS'){
        bobot.value = 40;
    }
    else if(kategori == 'SAS'){
        bobot.value = 60;
    }
    else{
        bobot.value = '';
    }
    });
</script>

@endsection