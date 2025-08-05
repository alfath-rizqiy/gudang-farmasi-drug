@extends('layouts.admin')

@section('title', 'Edit Data Obat')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data Obat</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('obat.update', $obat->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Obat</label>
                    <input type="text" name="nama_obat" id="nama_obat" class="form-control" placeholder="Masukkan nama obat"
                        value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                </div>

                <!-- Tambahkan value old untuk memanggil data sebelumnya -->
                <div class="mb-4">
                <label for="supplier_id" class="block mb-1 font-semibold">Supplier</label>
                 <select name="supplier_id" id="supplier_id" class="form-control" required>
                    <option value="">Pilih Supplier</option>
                      @foreach($suppliers as $supplier)
                      <option value="{{ $supplier->id }}"
                      {{ old('supplier_id', $obat->supplier_id) == $supplier->id ? 'selected' : '' }}>
                      {{ $supplier->nama_supplier }}
                      </option>
                      @endforeach
                 </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
