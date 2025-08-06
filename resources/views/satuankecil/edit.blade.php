@extends('layouts.admin')

@section('title', 'Edit Data Satuan Kecil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data Satuan Kecil</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('satuankecil.update', $satuankecil->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="form-group">
                    <label for="nama_satuankecil">Nama </label>
                    <input type="text" name="nama_satuankecil" id="nama_satuankecil" class="form-control" placeholder="Masukkan Satuan Besar" 
                    value="{{ old('nama_satuankecil', $satuankecil->nama_satuankecil) }}" required>
                </div>

                <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" 
                value="{{ old('deskripsi', $satuankecil->deskripsi) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('satuankecil.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection