@extends('layouts.admin')

@section('title', 'Tambah Data Obat')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Obat</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('metodepembayaran.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Metode</label>
                    <input type="text" name="nama_metode" id="nama_metode" class="form-control" placeholder="Masukkan Nama Metode" required>
                </div>

                <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('metodepembayaran.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection