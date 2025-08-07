@extends('layouts.admin')

@section('title', 'Tambah Data Obat')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Data AturanPakai</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('aturanpakai.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Frekuensi Pemakaian</label>
                    <input type="text" name="frekuensi_pemakaian" id="frekuensi_pemakaian" class="form-control" placeholder="Masukkan Frekuensi Pemakaian" required>
                </div>

                <div class="form-group">
                    <label for="nama">Waktu Pemakaian</label>
                    <input type="text" name="waktu_pemakaian" id="waktu_pemakaian" class="form-control" placeholder="Masukkan Waktu Pemakaian" required>
                </div>

                <div class="form-group">
                    <label for="nama">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('aturanpakai.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
