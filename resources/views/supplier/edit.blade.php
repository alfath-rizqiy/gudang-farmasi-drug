@extends('layouts.admin')

@section('title', 'Edit Data Supplier')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data Supplier</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Supplier</label>
                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" placeholder="Masukkan Supplier" 
                    value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Telepon</label>
                    <input type="number" name="telepon" id="telepon" class="form-control" placeholder="Masukkan Telepon" 
                    value="{{ old('telepon', $supplier->telepon) }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" 
                    value="{{ old('email', $supplier->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat" 
                    value="{{ old('alamat', $supplier->alamat) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
