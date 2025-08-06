@extends('layouts.admin')

@section('title', 'Edit Data Aturan Pakai')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data Aturan Pakai</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('aturanpakai.update', $aturanpakai->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="form-group">
                    <label for="nama">Frekuensi Pemakaian</label>
                    <input type="text" name="frekuensi_pemakaian" id="frekuensi_pemakaian" class="form-control" placeholder="Masukkan Aturan Pakai" 
                    value="{{ old('frekuensi_pemakaian', $aturanpakai->frekuensi_pemakaian) }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Waktu Pemakaian</label>
                    <input type="text" name="waktu_pemakaian" id="waktu_pemakaian" class="form-control" placeholder="Masukkan Waktu Pemakaian" 
                    value="{{ old('waktu_pemakaian', $aturanpakai->waktu_pemakaian) }}" required>
                </div>

                <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" 
                value="{{ old('deskripsi', $aturanpakai->deskripsi) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('aturanpakai.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
