@extends('layouts.admin')

@section('title', 'Edit Data Satuan Besar')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data Satuan Besar</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('satuanbesar.update', $satuanbesar->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="form-group">
                    <label for="nama_satuanbesar">Nama </label>
                    <input type="text" name="nama_satuanbesar" id="nama_satuanbesar" class="form-control" placeholder="Masukkan Satuan Besar" 
                    value="{{ old('nama_satuanbesar', $satuanbesar->nama_satuanbesar) }}" required>
                </div>

                <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" 
                value="{{ old('deskripsi', $satuanbesar->deskripsi) }}" required>
                </div>

                <div class="form-group">
                    <label for="jumlah_satuankecil">Jumlah Satuan Besar </label>
                    <input type="text" name="jumlah_satuankecil" id="jumlah_satuankecil" class="form-control" placeholder="Masukkan Jumlah Satuan Besar" 
                    value="{{ old('jumlah_satuankecil', $satuanbesar->jumlah_satuankecil) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('satuanbesar.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection