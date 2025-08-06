@extends('layouts.admin')

@section('title', 'Edit Data Metode Pembayaran')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data metodepembayaran</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('metodepembayaran.update', $metodepembayaran->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Metode</label>
                    <input type="text" name="nama_metode" id="nama_metode" class="form-control" placeholder="Masukkan Nama Metode" 
                    value="{{ old('nama_metode', $metodepembayaran->nama_metode) }}" required>
                </div>

                <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" 
                value="{{ old('deskripsi', $metodepembayaran->deskripsi) }}" required>
                </div>


                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('metodepembayaran.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection