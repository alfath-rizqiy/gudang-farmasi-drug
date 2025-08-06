@extends('layouts.admin')

@section('title', 'Edit Data kategori')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data kategori</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Masukkan Kategori" 
                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                </div>

                <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" 
                value="{{ old('deskripsi', $kategori->deskripsi) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection