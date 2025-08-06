@extends('layouts.admin')

@section('title', 'Tambah Data Obat')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Satuan Kecil</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('satuankecil.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Satuan Kecil</label>
                    <input type="text" name="nama_satuankecil" id="nama_satuankecil" class="form-control" placeholder="Masukkan Satuan Kecil" required>
                </div>

                <div class="form-group">
                    <label for="nama">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('satuankecil.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection