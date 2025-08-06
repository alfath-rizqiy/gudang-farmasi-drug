@extends('layouts.admin')

@section('title', 'Tambah Data Obat')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Obat</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('kemasan.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Kemasan</label>
                    <input type="text" name="nama_kemasan" id="nama_kemasan" class="form-control" placeholder="Masukkan kemasan" required>
                </div>

                <div class="form-group">
                    <label for="nama">Tanggal Produksi</label>
                    <input type="date" name="tanggal_produksi" id="tanggal_produksi" class="form-control" placeholder="Masukkan Tanggal Produksi" required>
                </div>

                <div class="form-group">
                    <label for="nama">tanggal Kadaluarsa</label>
                    <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" class="form-control" placeholder="Masukkan Tanggal Kadaluarsa" required>
                </div>

                <div class="form-group">
                    <label for="nama">Petunjuk Penyimpanan</label>
                    <input type="text" name="petunjuk_penyimpanan" id="petunjuk_penyimpanan" class="form-control" placeholder="Masukkan petunjuk_penyimpanan" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kemasan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
