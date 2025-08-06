@extends('layouts.admin')

@section('title', 'Edit Data Kemasan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data Kemasan</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('kemasan.update', $kemasan->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Kemasan</label>
                    <input type="text" name="nama_kemasan" id="nama_kemasan" class="form-control" placeholder="Masukkan kemasan" 
                    value="{{ old('nama_kemasan', $kemasan->nama_kemasan) }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Tanggal Produksi</label>
                    <input type="date" name="tanggal_produksi" id="tanggal_produksi" class="form-control" placeholder="Masukkan Tanggal Produksi" 
                    value="{{ old('tanggal_produksi', $kemasan->tanggal_produksi) }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Tanggal Kadaluarsa</label>
                    <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" class="form-control" placeholder="Masukkan Tanggal Kadaluarsa" 
                    value="{{ old('tanggal_kadaluarsa', $kemasan->tanggal_kadaluarsa) }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Petunjuk Penyimpanan</label>
                    <input type="text" name="petunjuk_penyimpanan" id="petunjuk_penyimpanan" class="form-control" placeholder="Masukkan Petunjuk Penyimpanan" 
                    value="{{ old('petunjuk_penyimpanan', $kemasan->petunjuk_penyimpanan) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kemasan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
